function toggleEditForm(commentId) {
    var form = document.getElementById("edit-form-" + commentId);
    form.style.display = form.style.display === "none" ? "block" : "none";
}

const postCategory = document.querySelector(".post_category");

postCategory.addEventListener("click", function () {
    let category = postCategory.dataset.category;
    goToCategoryPage(category);
});

function goToCategoryPage(categoryName) {
    window.location.href = `/posts/category/${categoryName}`;
}
