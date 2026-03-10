// Mobile Menu Toggle
var hamburger = document.getElementById('hamburger');
var navLinks = document.getElementById('navLinks');
if (hamburger && navLinks) {
    hamburger.addEventListener('click', function () {
        hamburger.classList.toggle('active');
        navLinks.classList.toggle('active');
    });
}

// Sticky Navbar
var navbar = document.getElementById('navbar');
if (navbar) {
    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
}

// Scroll to Top
var scrollTopBtn = document.getElementById('scrollTop');
if (scrollTopBtn) {
    window.addEventListener('scroll', function () {
        if (window.scrollY > 400) {
            scrollTopBtn.classList.add('visible');
        } else {
            scrollTopBtn.classList.remove('visible');
        }
    });
    scrollTopBtn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// Quantity Selector
var qtyMinus = document.getElementById('qtyMinus');
var qtyPlus = document.getElementById('qtyPlus');
var qtyInput = document.getElementById('qtyInput');
if (qtyMinus && qtyPlus && qtyInput) {
    qtyMinus.addEventListener('click', function () {
        var val = parseInt(qtyInput.value) || 1;
        if (val > 1) qtyInput.value = val - 1;
    });
    qtyPlus.addEventListener('click', function () {
        var val = parseInt(qtyInput.value) || 1;
        qtyInput.value = val + 1;
    });
}

// Product Tabs
var tabBtns = document.querySelectorAll('.tab-btn');
tabBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
        var tabId = btn.getAttribute('data-tab');
        tabBtns.forEach(function (b) { b.classList.remove('active'); });
        document.querySelectorAll('.tab-pane').forEach(function (p) { p.classList.remove('active'); });
        btn.classList.add('active');
        var pane = document.getElementById('tab-' + tabId);
        if (pane) pane.classList.add('active');
    });
});

// Password Toggle
document.querySelectorAll('.password-toggle').forEach(function (toggle) {
    toggle.addEventListener('click', function () {
        var input = toggle.parentElement.querySelector('input');
        var icon = toggle.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});

// Filter Sidebar Toggle (Mobile)
var filterToggle = document.getElementById('filterToggle');
var filterSidebar = document.getElementById('filterSidebar');
var filterClose = document.getElementById('filterClose');
if (filterToggle && filterSidebar) {
    filterToggle.addEventListener('click', function () {
        filterSidebar.classList.add('active');
    });
    if (filterClose) {
        filterClose.addEventListener('click', function () {
            filterSidebar.classList.remove('active');
        });
    }
}
