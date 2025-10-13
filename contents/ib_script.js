let sidebarOpen = false;

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const mainContent = document.getElementById('mainContent');

    sidebarOpen = !sidebarOpen;

    if (sidebarOpen) {
        sidebar.classList.remove('-translate-x-full');
        if (window.innerWidth >= 1024) {
            mainContent.classList.add('lg:ml-64');
        } else {
            overlay.classList.remove('hidden');
        }
    } else {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        mainContent.classList.remove('lg:ml-64');
    }
}

// BEFORE/AFTER ANIMATION
function initBeforeAfterAnimations() {
    const containers = document.querySelectorAll('.before-after-container');
    containers.forEach(container => {
        const delay = parseInt(container.dataset.delay) || 3000;
        const label = container.querySelector('.image-label');
        setInterval(() => {
            container.classList.toggle('show-after');
            if (container.classList.contains('show-after')) {
                label.textContent = 'AFTER';
            } else {
                label.textContent = 'BEFORE';
            }
        }, delay);
    });
}

window.addEventListener('load', function () {
    if (window.innerWidth >= 1024) toggleSidebar();
    initBeforeAfterAnimations();
});


// Handle window resize
window.addEventListener('resize', function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const mainContent = document.getElementById('mainContent');

    if (window.innerWidth >= 1024) {
        if (!sidebarOpen) {
            sidebar.classList.remove('-translate-x-full');
            mainContent.classList.add('lg:ml-64');
            sidebarOpen = true;
        }
        overlay.classList.add('hidden');
    } else {
        if (sidebarOpen) {
            sidebar.classList.add('-translate-x-full');
            mainContent.classList.remove('lg:ml-64');
            sidebarOpen = false;
        }
    }
});

// Handle window resize
window.addEventListener('resize', function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const mainContent = document.getElementById('mainContent');

    if (window.innerWidth >= 1024) {
        if (!sidebarOpen) {
            sidebar.classList.remove('-translate-x-full');
            mainContent.classList.add('lg:ml-64');
            sidebarOpen = true;
        }
        overlay.classList.add('hidden');
    } else {
        if (sidebarOpen) {
            sidebar.classList.add('-translate-x-full');
            mainContent.classList.remove('lg:ml-64');
            sidebarOpen = false;
        }
    }
});

// Smooth scroll for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

            // Close sidebar on mobile after clicking
            if (window.innerWidth < 1024 && sidebarOpen) {
                toggleSidebar();
            }
        }
    });
});

// Tab switching function
function switchTab(tabName) {
    // Hide all content
    const contents = ['vsd', 'hmi', 'plc', 'electrical', 'communication', 'pcb', 'fire'];
    contents.forEach(name => {
        const content = document.getElementById('content-' + name);
        const tab = document.getElementById('tab-' + name);

        if (content) content.classList.add('hidden');
        if (tab) {
            tab.classList.remove('gradient-bg', 'text-white', 'shadow-md');
            tab.classList.add('bg-gray-100', 'text-gray-700');
        }
    });

    // Show selected content
    const selectedContent = document.getElementById('content-' + tabName);
    const selectedTab = document.getElementById('tab-' + tabName);

    if (selectedContent) {
        selectedContent.classList.remove('hidden');
        selectedContent.classList.add('grid');
    }
    if (selectedTab) {
        selectedTab.classList.remove('bg-gray-100', 'text-gray-700');
        selectedTab.classList.add('gradient-bg', 'text-white', 'shadow-md');
    }
}

// Scroll tabs left/right
function scrollTabs(direction) {
    const container = document.getElementById('tabContainer');
    const scrollAmount = 200;

    if (direction === 'left') {
        container.scrollLeft -= scrollAmount;
    } else {
        container.scrollLeft += scrollAmount;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contactForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;

        // Format pesan WhatsApp
        const waMessage = `*New Contact Form Submission*%0A%0A*Name:* ${encodeURIComponent(name)}%0A*Email:* ${encodeURIComponent(email)}%0A*Message:* ${encodeURIComponent(message)}`;

        // Nomor WhatsApp tujuan (ganti dengan nomor yang diinginkan)
        const phoneNumber = '628117014004'; // Nomor Indonesia tanpa tanda +

        // Buka WhatsApp
        window.open(`https://wa.me/${phoneNumber}?text=${waMessage}`, '_blank');
    });
});
const imageContainer = document.getElementById('imageContainer');
const revealOverlay = document.getElementById('revealOverlay');
const imageContent = document.getElementById('imageContent');

let hasAnimated = false;

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !hasAnimated) {
            revealOverlay.classList.add('animate');
            imageContent.classList.add('animate');
            hasAnimated = true;
        }
    });
}, {
    threshold: 0.3
});

observer.observe(imageContainer);