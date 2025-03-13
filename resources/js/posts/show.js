const editCommentButtons = document.querySelectorAll(".edit_comment_btn");

editCommentButtons.forEach((editCommentButton) => {
    editCommentButton.addEventListener("click", () => {
        let commentId = editCommentButton.dataset.commentId;
        let form = document.getElementById("edit-form-" + commentId);
        form.style.display = form.style.display === "none" ? "block" : "none";
    });
});

const replyCommentButtons = document.querySelectorAll(".reply_comment_btn");

replyCommentButtons.forEach((replyCommentButton) => {
    replyCommentButton.addEventListener("click", () => {
        let commentId = replyCommentButton.dataset.commentId;
        let form = document.getElementById("reply-form-" + commentId);
        form.style.display = form.style.display === "none" ? "block" : "none";
    });
});

const postCategory = document.querySelector(".post_category");

postCategory.addEventListener("click", function () {
    let category = postCategory.dataset.category;
    goToCategoryPage(category);
});

function goToCategoryPage(categoryName) {
    window.location.href = `/posts/category/${categoryName}`;
}
