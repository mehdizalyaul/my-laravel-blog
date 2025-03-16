function editComment() {
    const editCommentButtons = document.querySelectorAll(".edit_comment_btn");

    editCommentButtons.forEach((editCommentButton) => {
        editCommentButton.addEventListener("click", () => {
            let commentId = editCommentButton.dataset.commentId;
            let form = document.getElementById("edit-form-" + commentId);
            form.style.display =
                form.style.display === "none" ? "block" : "none";
        });
    });
}
function replyToComment() {
    const replyCommentButtons = document.querySelectorAll(".reply_comment_btn");

    replyCommentButtons.forEach((replyCommentButton) => {
        replyCommentButton.addEventListener("click", () => {
            let commentId = replyCommentButton.dataset.commentId;
            let form = document.getElementById("reply-form-" + commentId);
            form.style.display =
                form.style.display === "none" ? "block" : "none";
        });
    });
}

function handleCategoryClick(postCategory) {
    postCategory.addEventListener("click", function () {
        let category = postCategory.dataset.category;
        goToCategoryPage(category);
    });
}

function goToCategoryPage(categoryName) {
    window.location.href = `/posts/category/${categoryName}`;
}

function editReply() {
    const editReplyButtons = document.querySelectorAll(".edit_reply_btn");

    editReplyButtons.forEach((editReplyButton) => {
        editReplyButton.addEventListener("click", () => {
            let replyId = editReplyButton.dataset.replyId;
            let form = document.getElementById("edit-form-" + replyId);
            form.style.display =
                form.style.display === "none" ? "block" : "none";
        });
    });
}

function likeComment(likeButton, likeId) {
    fetch(`http://127.0.0.1:8000/comments/${likeId}/like`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ likeable_type: "comment" }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                const likeCount = likeButton.querySelector(".like-count");

                likeCount.textContent = data.likes_count;
                //   window.location.href = "/comments";
            }
        })
        .catch((error) => console.error("Error:", error));
}

function UnLikeComment(likeButton, likeId) {
    fetch(`http://127.0.0.1:8000/comments/${likeId}/like`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ likeable_type: "comment" }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                const likeCount = likeButton.querySelector(".like-count");

                likeCount.textContent = data.likes_count;
                //window.location.href = "/comments";
            }
        })
        .catch((error) => console.error("Error:", error));
}

function handleLikeAndUnlikeComment() {
    const commentLikeButtons = document.querySelectorAll(".comment_like_btn");

    commentLikeButtons.forEach((commentLikeButton) => {
        commentLikeButton.addEventListener("click", function () {
            let commentId = commentLikeButton.dataset.commentId;
            console.log(this.classList);
            if (this.classList.contains("liked")) {
                this.classList.remove("liked");
                UnLikeComment(commentLikeButton, commentId);
            } else {
                this.classList.add("liked");
                likeComment(commentLikeButton, commentId);
            }
        });
    });
}

function main() {
    const postCategory = document.querySelector(".post_category");

    handleCategoryClick(postCategory);
    handleLikeAndUnlikeComment();
    editComment();
    replyToComment();
    editReply();
}

main();
