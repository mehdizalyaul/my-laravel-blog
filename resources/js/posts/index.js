document.addEventListener("DOMContentLoaded", function () {
    // Initialize the Owl Carousel when the DOM is fully loaded
    $(".category-carousel").owlCarousel({
        loop: true, // Set to true for infinite scrolling
        margin: 5,
        nav: true, // Show navigation buttons
        dots: false, // Hide dots below the carousel
        navText: ["❮", "❯"], // Custom left/right arrows
        responsive: {
            0: { items: 1 },
            600: { items: 3 },
            1000: { items: 6 },
            1200: { items: 9 }, // Show up to 12 items on larger screens
        },
    });

    // Click event for categories using addEventListener
    const categoryItems = document.querySelectorAll(".category-item");
    categoryItems.forEach((item) => {
        item.addEventListener("click", function () {
            categoryItems.forEach((el) => el.classList.remove("active"));
            this.classList.add("active");
            let category = item.dataset.category;
            goToCategoryPage(category);
        });
    });

    function goToCategoryPage(categoryName) {
        window.location.href = `/posts/category/${categoryName}`;
    }
});
