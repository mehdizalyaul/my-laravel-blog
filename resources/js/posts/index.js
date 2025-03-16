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

    const postCategories = document.querySelectorAll(".post_category");

    postCategories.forEach((postCategory) => {
        postCategory.addEventListener("click", function () {
            let category = postCategory.dataset.category;
            goToCategoryPage(category);
        });
    });

    function goToCategoryPage(categoryName) {
        window.location.href = `/posts/category/${categoryName}`;
    }

    const likeButtons = document.querySelectorAll(".like-btn");
    likeButtons.forEach((likeButton) => {
        likeButton.addEventListener("click", function () {
            if (this.classList.contains("liked")) {
                this.classList.remove("liked");
                let postID = this.dataset.postId;
                UnLikePost(likeButton, postID);
            } else {
                this.classList.add("liked");
                let postID = this.dataset.postId;
                likePost(likeButton, postID);
            }
        });
    });

    function likePost(likeButton, likeId) {
        fetch(`http://127.0.0.1:8000/posts/${likeId}/like`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ likeable_type: "post" }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    const likeCount = likeButton.querySelector(".like-count");

                    likeCount.textContent = data.likes_count;
                    window.location.href = "/posts";
                }
            })
            .catch((error) => console.error("Error:", error));
    }

    function UnLikePost(likeButton, likeId) {
        fetch(`http://127.0.0.1:8000/posts/${likeId}/like`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ likeable_type: "post" }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    const likeCount = likeButton.querySelector(".like-count");

                    likeCount.textContent = data.likes_count;
                    window.location.href = "/posts";
                }
            })
            .catch((error) => console.error("Error:", error));
    }

    const postItems = document.querySelectorAll(".post_item");

    postItems.forEach((post) => {
        post.addEventListener("click", () => {
            let postID = post.dataset.postId;
            window.location.href = `/posts/${postID}`;
        });
    });
});
