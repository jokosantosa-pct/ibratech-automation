<?php
require_once 'config.php';
requireLogin();

header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$jsonFile = env('BLOG_DATA_PATH', 'blogData.json');

// Load blog data
function loadBlogData($file) {
    if (!file_exists($file)) {
        return ['posts' => []];
    }
    $content = file_get_contents($file);
    return json_decode($content, true) ?? ['posts' => []];
}

// Save blog data
function saveBlogData($file, $data) {
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($file, $json) !== false;
}

// Generate slug
function generateSlug($title) {
    $slug = strtolower($title);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

// Handle upload image
function handleImageUpload() {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $uploadDir = env('UPLOAD_PATH', 'uploads/images/');
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $file = $_FILES['image'];
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($extension, $allowedExtensions)) {
        return null;
    }

    $fileName = uniqid() . '_' . time() . '.' . $extension;
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $targetPath;
    }

    return null;
}

// ACTIONS
switch ($action) {
    case 'list':
        $data = loadBlogData($jsonFile);
        echo json_encode(['success' => true, 'posts' => $data['posts']]);
        break;

    case 'get':
        $slug = $_GET['slug'] ?? '';
        $data = loadBlogData($jsonFile);
        $post = null;
        foreach ($data['posts'] as $p) {
            if ($p['slug'] === $slug) {
                $post = $p;
                break;
            }
        }
        echo json_encode(['success' => true, 'post' => $post]);
        break;

    case 'save':
        $data = loadBlogData($jsonFile);
        
        // Debug: Check if file is writable
        if (!is_writable($jsonFile)) {
            echo json_encode(['success' => false, 'message' => 'JSON file is not writable. Check permissions.', 'file' => $jsonFile]);
            break;
        }
        
        // Debug: Check if directory is writable
        $dir = dirname($jsonFile);
        if (!is_writable($dir)) {
            echo json_encode(['success' => false, 'message' => 'Directory is not writable. Check permissions.', 'dir' => $dir]);
            break;
        }
        
        $isEdit = !empty($_POST['old_slug']);
        $slug = generateSlug($_POST['title']);
        
        // Handle image
        $imageValue = '';
        $imageType = $_POST['image_type'] ?? 'gradient';
        
        if ($imageType === 'upload' && isset($_FILES['image'])) {
            $uploadedPath = handleImageUpload();
            if ($uploadedPath) {
                $imageValue = $uploadedPath;
                $imageType = 'url';
            }
        } elseif ($imageType === 'url') {
            $imageValue = $_POST['image_url'] ?? '';
        } elseif ($imageType === 'gradient') {
            $imageValue = $_POST['image_gradient'] ?? '';
        }

        $categories = isset($_POST['categories']) ? json_decode($_POST['categories'], true) : [];
        $tags = isset($_POST['tags']) ? explode(',', $_POST['tags']) : [];
        $tags = array_map('trim', $tags);
        $tags = array_filter($tags);

        $postData = [
            'id' => $isEdit ? $_POST['id'] : (string)(time() . rand(1000, 9999)),
            'title' => $_POST['title'],
            'slug' => $slug,
            'category' => $categories,
            'date' => $_POST['date'],
            'author' => $_POST['author'],
            'excerpt' => $_POST['excerpt'],
            'content' => $_POST['content'],
            'image' => $imageValue,
            'imageType' => $imageType,
            'readTime' => $_POST['read_time'],
            'tags' => $tags
        ];

        if ($isEdit) {
            $oldSlug = $_POST['old_slug'];
            $found = false;
            foreach ($data['posts'] as $key => $post) {
                if ($post['slug'] === $oldSlug) {
                    $data['posts'][$key] = $postData;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                echo json_encode(['success' => false, 'message' => 'Post not found']);
                exit;
            }
        } else {
            array_unshift($data['posts'], $postData);
        }

        $saveResult = saveBlogData($jsonFile, $data);
        
        if ($saveResult) {
            echo json_encode(['success' => true, 'message' => $isEdit ? 'Article updated' : 'Article created', 'slug' => $slug]);
        } else {
            // Debug: Get last error
            $error = error_get_last();
            echo json_encode(['success' => false, 'message' => 'Failed to save', 'error' => $error, 'file' => $jsonFile]);
        }
        break;

    case 'delete':
        $slug = $_POST['slug'] ?? '';
        $data = loadBlogData($jsonFile);
        
        $newPosts = [];
        foreach ($data['posts'] as $post) {
            if ($post['slug'] !== $slug) {
                $newPosts[] = $post;
            }
        }
        
        $data['posts'] = $newPosts;
        
        if (saveBlogData($jsonFile, $data)) {
            echo json_encode(['success' => true, 'message' => 'Article deleted']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
?>