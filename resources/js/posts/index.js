let categoriesContainer = document.querySelector(
    ".categories-carousel__container"
);

let categories = Array.from(categoriesContainer.children);
let rightButton = document.querySelector(".right-btn");
let leftButton = document.querySelector(".left-btn");

let start = 0;
let end = 12;
let current = 0;

function displayCategories() {
    categories.forEach((category) => {
        let index = Number(category.dataset.index);
        if (index >= start && index <= end) {
            category.classList.remove("hidden");
        } else {
            category.classList.add("hidden");
        }
    });
}
displayCategories();
rightButton.addEventListener("click", () => {
    // get active category
    let activeCategory = categories.find(
        (category) => !category.classList.contains("inactive")
    );

    if (activeCategory) {
        current = Number(activeCategory.dataset.index);
        ++current;
        // Add "inactive" to the current active category
        activeCategory.classList.add("inactive");

        // If the next category exists, remove "inactive" from it
        if (categories[current]) {
            categories[current].classList.remove("inactive");
        }

        if (current == end && current <= categories.length) {
            ++start;
            ++end;
            displayCategories();
        }
        console.log(current);

        toggleDisableArrows(current);
    }
});

leftButton.addEventListener("click", () => {
    // Find the first category that doesn't have the "inactive" class
    let activeCategory = categories.find(
        (category) => !category.classList.contains("inactive")
    );

    if (activeCategory) {
        current = Number(activeCategory.dataset.index); // Ensure index is a number
        --current;
        // Add "inactive" to the current active category
        activeCategory.classList.add("inactive");

        // If the next category exists, remove "inactive" from it
        if (categories[current]) {
            categories[current].classList.remove("inactive");
        }

        if (current == start && current > 0) {
            --start;
            --end;
            displayCategories();
        }

        toggleDisableArrows(current);
    }
});

function toggleDisableArrows(current) {
    let lastIndex = categories.length - 1;

    // Left button
    if (current > 0) {
        leftButton.classList.remove("disable");
    } else {
        leftButton.classList.add("disable");
    }

    // Right button
    if (current >= lastIndex) {
        rightButton.classList.add("disable");
    } else {
        rightButton.classList.remove("disable");
    }
}
