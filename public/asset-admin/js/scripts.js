/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
// 
// Scripts
// 
window.addEventListener('DOMContentLoaded', event => {

    // Detect if the user is accessing from an Android or iOS device
    const isAndroid = navigator.userAgent.toLowerCase().indexOf("android") > -1;
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
    console.log("Is Android:", isAndroid);
    console.log("Is iOS:", isIOS);

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
            console.log("Sidebar Toggled:", document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

    // Check if the current page URL matches the specified pattern
    const currentPageURL = window.location.href;
    const regexPattern = /\/bpk-detail\/([^\/]+)$/;

    if (regexPattern.test(currentPageURL)) {
        document.body.classList.add('sb-sidenav-toggled');
        console.log("Page URL Matched. Class Added:", document.body.classList.contains('sb-sidenav-toggled'));
    }else{
        document.body.classList.remove('sb-sidenav-toggled');
        console.log("Page URL Not Matched. Class Removed:", document.body.classList.contains('sb-sidenav-toggled'));
    }

    // If the user is not accessing from an Android or iOS device, add 'sb-sidenav-toggled' class to body
    if ((isAndroid || isIOS) && regexPattern.test(currentPageURL)) {
        document.body.classList.remove('sb-sidenav-toggled');
        console.log("Android or iOS. Class Removed:", document.body.classList.contains('sb-sidenav-toggled'));
    }
});
