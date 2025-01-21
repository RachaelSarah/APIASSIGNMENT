// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", function () {
    console.log("Summer 21 website loaded successfully!");

    // Smooth scrolling for navigation links
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    smoothScrollLinks.forEach((link) => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const targetId = this.getAttribute("href").substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: "smooth" });
            }
        });
    });

    // Product Buy Now button interactions
    const buyNowButtons = document.querySelectorAll(".btn-custom");
    buyNowButtons.forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            alert("Thank you for your interest! This feature is coming soon.");
        });
    });

    // Toggle password visibility in forms
    const passwordToggles = document.querySelectorAll(".toggle-password");
    passwordToggles.forEach((toggle) => {
        toggle.addEventListener("click", function () {
            const passwordField = this.previousElementSibling;
            if (passwordField.type === "password") {
                passwordField.type = "text";
                this.innerText = "Hide";
            } else {
                passwordField.type = "password";
                this.innerText = "Show";
            }
        });
    });
});
