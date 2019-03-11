"use strict";
var $sidebarToggle = $(".menu-toggle");
var $sidebarLeft = $(".sidebar-left");
var $sidebarLeftSecondary = $(".sidebar-left-secondary");
var $sidebarOverlay = $(".sidebar-overlay");
var $mainContentWrap = $(".main-content-wrap");
var $sideNavItem = $(".nav-item");
var $searchInput = $(".search-bar input");
var $searchCloseBtn = $(".search-close");

function openSidebar() {
    $sidebarLeft.addClass("open");
    $mainContentWrap.addClass("sidenav-open");
}
function closeSidebar() {
    $sidebarLeft.removeClass("open");
    $mainContentWrap.removeClass("sidenav-open");
}
function openSidebarSecondary() {
    $sidebarLeftSecondary.addClass("open");
    $sidebarOverlay.addClass("open");
}
function closeSidebarSecondary() {
    $sidebarLeftSecondary.removeClass("open");
    $sidebarOverlay.removeClass("open");
}
function openSidebarOverlay() {
    $sidebarOverlay.addClass("open");
}
function closeSidebarOverlay() {
    $sidebarOverlay.removeClass("open");
}
function navItemToggleActive($activeItem) {
    var $navItem = $(".nav-item");
    $navItem.removeClass("active");
    $activeItem.addClass("active");
}
function isMobile() {
    return window && window.matchMedia("(max-width: 767px)").matches;
}

function initLayout() {
    // Makes secondary menu selected on page load
    $sideNavItem.each(function (index) {
        let $item = $(this);
        if ($item.hasClass("active")) {
            let dataItem = $item.data("item");
            $sidebarLeftSecondary.find(`[data-parent="${dataItem}"]`).show();
        }
    });
    if (isMobile()) {
        closeSidebar();
        closeSidebarSecondary();
    }
}

$(window).on("resize", function (event) {
    if (isMobile()) {
        closeSidebar();
        closeSidebarSecondary();
    }
    // console.log("desktop")
});

initLayout();

// Show Secondary menu area on hover on side menu item;
$sidebarLeft.find(".nav-item").on("mouseenter", function (event) {
    let $navItem = $(event.currentTarget);
    let dataItem = $navItem.data("item");

    if (dataItem) {
        navItemToggleActive($navItem);
        openSidebarSecondary();
    } else {
        closeSidebarSecondary();
    }
    $sidebarLeftSecondary.find(".childNav").hide();
    $sidebarLeftSecondary.find(`[data-parent="${dataItem}"]`).show();
});

// Hide secondary menu on click on overlay
$sidebarOverlay.on("click", function (event) {
    if (isMobile()) {
        closeSidebar();
    }
    closeSidebarSecondary();
});

// Toggle menus on click on header toggle icon
$sidebarToggle.on("click", function (event) {
    let isSidebarOpen = $sidebarLeft.hasClass("open");
    let isSidebarSecOpen = $sidebarLeftSecondary.hasClass("open");
    if (isSidebarOpen && isSidebarSecOpen && isMobile()) {
        closeSidebar();
        closeSidebarSecondary();
    } else if (isSidebarOpen && isSidebarSecOpen) {
        closeSidebarSecondary();
    } else if (isSidebarOpen) {
        closeSidebar();
    } else if (!isSidebarOpen && !isSidebarSecOpen) {
        openSidebar();
        openSidebarSecondary();
    }
});

// Search toggle
var $searchUI = $(".search-ui");
$searchInput.on("focus", function () {
    $searchUI.addClass("open");
});
$searchCloseBtn.on("click", function () {
    $searchUI.removeClass("open");
});

// Perfect scrollbar
$('.perfect-scrollbar, [data-perfect-scrollbar]').each(function (index) {
    var $el = $(this);
    var ps = new PerfectScrollbar(this, {
        suppressScrollX: $el.data('suppress-scroll-x'),
        suppressScrollY: $el.data('suppress-scroll-y')
    });
});

// Full screen
function cancelFullScreen(el) {
    var requestMethod = el.cancelFullScreen||el.webkitCancelFullScreen||el.mozCancelFullScreen||el.exitFullscreen;
    if (requestMethod) { // cancel full screen.
        requestMethod.call(el);
    } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
    }
}

function requestFullScreen(el) {
    // Supports most browsers and their versions.
    var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

    if (requestMethod) { // Native full screen.
        requestMethod.call(el);
    } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
    }
    return false
}

function toggleFullscreen() {
    var elem = document.body;
    var isInFullScreen = (document.fullScreenElement && document.fullScreenElement !== null) ||  (document.mozFullScreen || document.webkitIsFullScreen);

    if (isInFullScreen) {
        cancelFullScreen(document);
    } else {
        requestFullScreen(elem);
    }
    return false;
}
$('[data-fullscreen]').on('click', toggleFullscreen);