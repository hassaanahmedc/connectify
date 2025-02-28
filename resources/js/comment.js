import { fetchData } from "./utils/api";
import { generateCommentHtml } from "./utils/templete";
import { toggleButtonState } from "./utils/ui";

const SELECTORS = {
    commentBtn: '.comment-btn',
    loadMoreCommentsBtn: '.load-more-comments',
    textarea: (postId) => `.comment-textarea[data-post-id="${postId}"]`,
    count: (postId) => `.comment-count[data-post-id="${postId}"]`,
    container: (postId) => `.comments-container[data-post-id="${postId}"]`,
    comment: (commentId) => `[data-commentId="${commentId}"]`,
};

const API_ENDPOINTS = {
    createComment: (postId) => `/post/${postId}/comment`,
    deleteComment: (postId) => `/post/${postId}/delete`,
    updateComment: (postId) => ``,
    loadComments: (postId, offset) => `/post/${postId}/viewcomments?offset=${offset}`,
};

async function makeComment(event) {
    const button = event.target;
    const { postId, userId } = button.dataset;
    const textarea = document.querySelector(SELECTORS.textarea(postId));
    const commentCount = document.querySelector(SELECTORS.count(postId));
    const commentsContainer = document.querySelector(SELECTORS.container(postId));

    const content = textarea.value.trim();
    if (!content) return;
    
    toggleButtonState(button, true);
    try {
        const data = await fetchData(API_ENDPOINTS.createComment(postId), {
            method: 'POST',
            body: JSON.stringify({ posts_id: postId, user_id: userId, content }),
        });
        console.log("API Response:", data);

        if (!data.success || !data.comment) {
            console.log(data.error || 'unable to comment');
            toggleButtonState(button, false)
            return;
        }

        const comment = data.comment;
        commentCount.textContent = parseInt(commentCount.textContent) + 1;
        textarea.value = "";
        commentsContainer.insertAdjacentHTML('beforeend', generateCommentHtml(comment));
        toggleButtonState(button, false);

    } catch (error) {
        console.log("An error occurred", error);
        toggleButtonState(button, false);
    }
};

async function loadMoreComments(event) {
    const button = event.target;
    const postId = button.dataset.postId;
    const offset = parseInt(this.dataset.offset, 10) || 0;

    try {
        const data = await fetchData(API_ENDPOINTS.loadComments(postId, offset));
        const comments = data.success;
        const hasMoreComments = data.hasMoreComments;

        if (!comments || !comments.length) {
            console.log(comments.error || "No more Commetns to laod");
        }

        const commentsContainer = document.querySelector(SELECTORS.container(postId));
        comments.forEach(comment => {
            commentsContainer.insertAdjacentHTML('beforeend', generateCommentHtml(comment));
        })
        button.dataset.offset = offset + comments.length;
        if (!hasMoreComments) button.style.display = "none";

    } catch (error) {
        console.log("An error occured", error);
    }
};

async function deleteComment(event) {
    const button = event.target.closest(".confirmDeleteBtn");
    if (!button || !button.dataset.commentId) return;

    try {
        const data = await fetchData(API_ENDPOINTS.deleteComment(button.dataset.commentId), {
            method: "Delete",
        });

        if(!data.success) {
            console.log("Failed to delete comment:", data.error || "Unknown error");
            return;
        }

        const commentElement = document.querySelector(SELECTORS.comment(button.dataset.commentId));
        if (commentElement) {
            const postId = commentElement.closest(".comments-container")?.dataset.postId;
            if (postId) {
                const count = document.querySelector(SELECTORS.count(postId));
                if (count) count.textContent = Math.max(0, parseInt(count.textContent) - 1);
            }
            commentElement.remove();
        }
    } catch (error) {
        console.error("Error deleting comment:", error);
    }
};

function textAreaInput(event) {
    const textarea = event.target;
    textarea.style.height = "31px";
    textarea.style.height = `${Math.min(textarea.scrollHeight, 150)}px`;

    const postId = textarea.dataset.postId;
    const commentButton = document.querySelector(`${SELECTORS.commentBtn}[data-post-id="${postId}"]`);
    const isEmpty = textarea.value.trim() === "";
    toggleButtonState(commentButton, isEmpty);
};

document.querySelectorAll(SELECTORS.textarea()).forEach(textarea => {
    textarea.addEventListener("input", textAreaInput);
});

document.querySelectorAll(SELECTORS.commentBtn).forEach(button => {
    button.addEventListener("click", makeComment);
});

document.querySelectorAll(SELECTORS.loadMoreCommentsBtn).forEach(button => {
    button.addEventListener("click", loadMoreComments);
});

document.addEventListener("DOMContentLoaded", () => {
    document.body.addEventListener("click", deleteComment);
});