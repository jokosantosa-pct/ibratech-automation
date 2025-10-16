<?php
require_once 'config.php';
requireLogin();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IBRATECH AUTOMATION - Advanced Electrical Solutions</title>
    <link rel="icon" href="../asset/favicon.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="contents/ib_styles.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

</head>

<body class="bg-gray-50">
    <!-- Sidebar -->
    <div id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-white shadow-2xl z-50 sidebar-transition -translate-x-full">
        <div class="p-6 border-b border-gray-100">
            <img src="../asset/logo-ibratech.png" alt="IBRATECH" class="h-12 object-contain">
            <p class="text-sm text-gray-500 mt-2">Automation Solutions</p>
        </div>

        <nav class="p-4">
            <a href="../#home" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg mb-2 transition">
                <i class="fas fa-home w-5"></i>
                <span class="ml-3">Home</span>
            </a>
            <a href="../#services" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg mb-2 transition">
                <i class="fas fa-project-diagram w-5"></i>
                <span class="ml-3">Services</span>
            </a>
            <a href="../#system-expertise" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg mb-2 transition">
                <i class="fas fa-network-wired w-5"></i>
                <span class="ml-3">System Expertise</span>
            </a>
            <a href="../#tools" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg mb-2 transition">
                <i class="fas fa-toolbox w-5"></i>
                <span class="ml-3">Products</span>
            </a>
            <a href="../#contact" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg mb-2 transition">
                <i class="fas fa-envelope w-5"></i>
                <span class="ml-3">Contact</span>
            </a>
            <a href="https://wa.me/628117014004?text=Hi%20Ibratech%20Automation%20..."" target=" _blank" class="flex items-center px-4 py-3 text-white bg-red-600 hover:bg-red-500 rounded-lg mb-2 transition">
                <i class="fas fa-phone w-5"></i>
                <span class="ml-3">24/7 Response</span>
            </a>
            <hr>
            <a href="../blog/#all" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg mb-2 transition">
                <i class="fas fa-blog w-5"></i>
                <span class="ml-3">Blog</span>
            </a>
        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-100">
            <div class="flex space-x-3 justify-center">
                <a href="#" class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <div id="mainContent" class="min-h-screen transition-all duration-300">
        <!-- Top Bar -->
        <div class="bg-white shadow-sm sticky top-0 z-30">
            <div class="px-6 py-4 flex items-center justify-between">
                <button onclick="toggleSidebar()" class="text-gray-700 hover:text-blue-600 transition">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

                <div class="flex items-center space-x-4 ml-auto">
                    <span class="text-sm text-gray-600 hidden md:block">
                        <i class="fas fa-phone-alt text-blue-600 mr-2"></i>
                        Contact: <a href="mailto:contact@ibratech-automation.com" class="text-blue-600 hover:underline">contact@ibratech-automation.com</a>
                    </span>
                    <span class="text-sm text-gray-600">👤 <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                    <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">Logout</a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Success/Error Message -->
            <div id="message" class="hidden mb-6 px-4 py-3 rounded-lg"></div>

            <!-- Main Content -->
            <div id="app"></div>
        </div>
        <script src="../contents/ib_script.js"></script>
        <script>
            let currentCategories = [];
            let quillEditor = null;

            // Show message
            const showMessage = (message, type = 'success') => {
                const el = document.getElementById('message');
                el.textContent = message;
                el.className = `mb-6 px-4 py-3 rounded-lg ${type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'}`;
                el.classList.remove('hidden');
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                setTimeout(() => el.classList.add('hidden'), 3000);
            };

            // Category management
            const renderCategoryTags = () => {
                const container = document.getElementById('categoryTags');
                if (!container) return;

                container.innerHTML = currentCategories.map(cat => `
                <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                    ${cat}
                    <button type="button" onclick="removeCategory('${cat.replace(/'/g, "\\'")}') " class="text-blue-700 hover:text-blue-900">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
            `).join('');
            };

            const addCategory = (category) => {
                const trimmed = category.trim();
                if (trimmed && !currentCategories.includes(trimmed)) {
                    currentCategories.push(trimmed);
                    renderCategoryTags();
                }
            };

            const removeCategory = (category) => {
                currentCategories = currentCategories.filter(c => c !== category);
                renderCategoryTags();
            };

            // Toggle image type
            const toggleImageType = () => {
                const imageType = document.querySelector('input[name="image_type"]:checked')?.value;
                const gradientDiv = document.getElementById('gradientDiv');
                const urlDiv = document.getElementById('urlDiv');
                const uploadDiv = document.getElementById('uploadDiv');

                if (!gradientDiv || !urlDiv || !uploadDiv) return;

                gradientDiv.classList.add('hidden');
                urlDiv.classList.add('hidden');
                uploadDiv.classList.add('hidden');

                if (imageType === 'gradient') {
                    gradientDiv.classList.remove('hidden');
                } else if (imageType === 'url') {
                    urlDiv.classList.remove('hidden');
                } else if (imageType === 'upload') {
                    uploadDiv.classList.remove('hidden');
                }
            };

            // Load articles list
            const loadList = async () => {
                const response = await fetch('api.php?action=list');
                const data = await response.json();

                if (data.success) {
                    renderList(data.posts);
                }
            };

            // Render list
            const renderList = (posts) => {
                document.getElementById('app').innerHTML = `
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Manage Articles</h2>
                        <button onclick="navigateToAdd()" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                            + Add New Article
                        </button>
                    </div>
                    
                    ${posts.length === 0 ? `
                        <p class="text-gray-600 text-center py-8">No articles yet. Add your first article!</p>
                    ` : `
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-3 px-4">Title</th>
                                        <th class="text-left py-3 px-4">Category</th>
                                        <th class="text-left py-3 px-4">Author</th>
                                        <th class="text-left py-3 px-4">Date</th>
                                        <th class="text-left py-3 px-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${posts.map(post => `
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3 px-4 font-medium">${post.title}</td>
                                            <td class="py-3 px-4">
                                                ${Array.isArray(post.category) 
                                                    ? post.category.map(cat => `<span class="inline-block px-2 py-1 bg-blue-100 text-blue-600 text-xs rounded mr-1 mb-1">${cat}</span>`).join('')
                                                    : `<span class="inline-block px-2 py-1 bg-blue-100 text-blue-600 text-xs rounded">${post.category}</span>`
                                                }
                                            </td>
                                            <td class="py-3 px-4">${post.author}</td>
                                            <td class="py-3 px-4">${post.date}</td>
                                            <td class="py-3 px-4">
                                                <button onclick="navigateToEdit('${post.slug}')" class="text-blue-600 hover:text-blue-800 mr-3">Edit</button>
                                                <button onclick="deleteArticle('${post.slug}', '${post.title.replace(/'/g, "\\'")}') " class="text-red-600 hover:text-red-800">Delete</button>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `}
                </div>
            `;
            };

            // Render form
            const renderForm = async (slug = null) => {
                let post = null;
                currentCategories = [];

                if (slug) {
                    const response = await fetch(`api.php?action=get&slug=${slug}`);
                    const data = await response.json();
                    if (data.success && data.post) {
                        post = data.post;
                        currentCategories = Array.isArray(post.category) ? [...post.category] : [post.category];
                    }
                }

                const isEdit = post !== null;

                document.getElementById('app').innerHTML = `
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">${isEdit ? 'Edit Article' : 'Add New Article'}</h2>
                        <button onclick="navigateToList()" class="text-gray-600 hover:text-blue-600 font-medium">
                            ← Back to List
                        </button>
                    </div>
                    
                    <form id="articleForm" class="space-y-6" enctype="multipart/form-data">
                        <input type="hidden" name="old_slug" value="${isEdit ? post.slug : ''}">
                        <input type="hidden" name="id" value="${isEdit ? post.id : ''}">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                            <input type="text" name="title" required value="${isEdit ? post.title : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categories (press Enter to add) *</label>
                            <div class="relative">
                                <div id="categoryTags" class="flex flex-wrap gap-2 mb-2"></div>
                                <input type="text" id="categoryInput" placeholder="Type and press Enter..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Author *</label>
                            <input type="text" name="author" required value="${isEdit ? post.author : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                                <input type="date" name="date" required value="${isEdit ? post.date : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Read Time *</label>
                                <input type="text" name="read_time" placeholder="e.g., 5 min read" required value="${isEdit ? post.readTime : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                            <div class="space-y-3">
                                <div class="flex gap-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="image_type" value="gradient" checked class="mr-2" onchange="toggleImageType()">
                                        <span>Gradient</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="image_type" value="url" class="mr-2" onchange="toggleImageType()">
                                        <span>URL</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="image_type" value="upload" class="mr-2" onchange="toggleImageType()">
                                        <span>Upload</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="image_type" value="none" class="mr-2" onchange="toggleImageType()">
                                        <span>None</span>
                                    </label>
                                </div>
                                
                                <div id="gradientDiv">
                                    <select name="image_gradient" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Select Gradient</option>
                                        <option value="gradient-blue">Blue</option>
                                        <option value="gradient-green">Green</option>
                                        <option value="gradient-red">Red</option>
                                        <option value="gradient-purple">Purple</option>
                                        <option value="gradient-orange">Orange</option>
                                        <option value="gradient-indigo">Indigo</option>
                                        <option value="gradient-teal">Teal</option>
                                    </select>
                                </div>
                                
                                <div id="urlDiv" class="hidden">
                                    <input type="url" name="image_url" placeholder="https://example.com/image.jpg" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                
                                <div id="uploadDiv" class="hidden">
                                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <p class="text-xs text-gray-500 mt-1">Supported: JPG, PNG, GIF, WebP (Max 5MB)</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tags (comma separated) *</label>
                            <input type="text" name="tags" placeholder="e.g., PLC, Automation, Industry" required value="${isEdit ? post.tags.join(', ') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt / Summary *</label>
                            <textarea name="excerpt" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">${isEdit ? post.excerpt : ''}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Brief summary that appears in blog cards (1-2 sentences)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                            <div id="editor" class="bg-white border border-gray-300 rounded-lg" style="min-height: 400px;"></div>
                            <input type="hidden" name="content" id="contentInput">
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                ${isEdit ? 'Update Article' : 'Save Article'}
                            </button>
                            <button type="button" onclick="navigateToList()" class="bg-gray-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-600 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            `;

                // Initialize after DOM is ready
                setTimeout(() => {
                    // Category input handler
                    const categoryInput = document.getElementById('categoryInput');
                    if (categoryInput) {
                        categoryInput.addEventListener('keydown', (e) => {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                addCategory(e.target.value);
                                e.target.value = '';
                            }
                        });
                    }

                    renderCategoryTags();

                    // Initialize Quill editor
                    quillEditor = new Quill('#editor', {
                        theme: 'snow',
                        placeholder: 'Write your article content here...',
                        modules: {
                            toolbar: [
                                [{
                                    'header': [1, 2, 3, 4, 5, 6, false]
                                }],
                                ['bold', 'italic', 'underline', 'strike'],
                                ['blockquote', 'code-block'],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                [{
                                    'indent': '-1'
                                }, {
                                    'indent': '+1'
                                }],
                                [{
                                    'color': []
                                }, {
                                    'background': []
                                }],
                                [{
                                    'align': []
                                }],
                                ['link', 'image'],
                                ['clean']
                            ]
                        }
                    });

                    // Set content if editing
                    if (isEdit && post.content) {
                        quillEditor.root.innerHTML = post.content;
                    }

                    // Form submit handler
                    const form = document.getElementById('articleForm');
                    form.addEventListener('submit', handleSubmit);

                    // Set image type if editing
                    if (isEdit && post.image) {
                        if (post.image.startsWith('http') || post.image.startsWith('uploads/')) {
                            document.querySelector('input[name="image_type"][value="url"]').checked = true;
                            setTimeout(() => {
                                document.querySelector('input[name="image_url"]').value = post.image;
                            }, 100);
                        } else if (post.image.startsWith('gradient-')) {
                            document.querySelector('input[name="image_type"][value="gradient"]').checked = true;
                            setTimeout(() => {
                                document.querySelector('select[name="image_gradient"]').value = post.image;
                            }, 100);
                        } else if (!post.image) {
                            document.querySelector('input[name="image_type"][value="none"]').checked = true;
                        }
                        toggleImageType();
                    }
                }, 100);
            };

            // Handle form submit
            const handleSubmit = async (e) => {
                e.preventDefault();

                if (currentCategories.length === 0) {
                    alert('Please add at least one category!');
                    return;
                }

                // Get content from Quill
                const content = quillEditor.root.innerHTML;
                document.getElementById('contentInput').value = content;

                const formData = new FormData(e.target);
                formData.append('action', 'save');
                formData.append('categories', JSON.stringify(currentCategories));

                try {
                    const response = await fetch('api.php', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        showMessage(data.message, 'success');
                        setTimeout(() => navigateToList(), 1500);
                    } else {
                        showMessage(data.message, 'error');
                    }
                } catch (error) {
                    showMessage('An error occurred', 'error');
                }
            };

            // Delete article
            const deleteArticle = async (slug, title) => {
                if (!confirm(`Are you sure you want to delete "${title}"?`)) {
                    return;
                }

                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('slug', slug);

                try {
                    const response = await fetch('api.php', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        showMessage(data.message, 'success');
                        loadList();
                    } else {
                        showMessage(data.message, 'error');
                    }
                } catch (error) {
                    showMessage('An error occurred', 'error');
                }
            };

            // Navigation
            const navigateToList = () => {
                window.location.hash = '';
            };

            const navigateToAdd = () => {
                window.location.hash = 'add';
            };

            const navigateToEdit = (slug) => {
                window.location.hash = `edit/${slug}`;
            };

            // Handle routing
            const handleRoute = () => {
                const hash = window.location.hash.slice(1);

                if (!hash) {
                    loadList();
                } else if (hash === 'add') {
                    renderForm();
                } else if (hash.startsWith('edit/')) {
                    const slug = hash.replace('edit/', '');
                    renderForm(slug);
                } else {
                    navigateToList();
                }
            };

            // Global functions
            window.navigateToList = navigateToList;
            window.navigateToAdd = navigateToAdd;
            window.navigateToEdit = navigateToEdit;
            window.deleteArticle = deleteArticle;
            window.removeCategory = removeCategory;
            window.toggleImageType = toggleImageType;

            // Listen for hash changes
            window.addEventListener('hashchange', handleRoute);

            // Initialize
            handleRoute();
        </script>
</body>

</html>
