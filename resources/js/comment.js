import { fetchData } from "./utils/api.js";
import { toggleButtonState } from "./utils/ui.js";
import { generateCommentHtml } from "./utils/templete.js";

// ===== CONSTANTS =====
const SELECTORS = {
    commentBtn: '.comment-btn',
    loadMoreBtn: '.load-more-comments',
    textarea: (postId) => `.comment-textarea[data-post-id="${postId}"]`,
    count: (postId) => `.comment-count[data-post-id="${postId}"]`,
    container: (postId) => `.comments-container[data-post-id="${postId}"]`,
    comment: (commentId) => `[data-comment-id="${commentId}"]`,
};

const API_ENDPOINTS = {
    createComment: (postId) => `/post/${postId}/comment`,
    loadComments: (postId, offset) => `/post/${postId}/viewcomments?offset=${offset}&limit=10`,
    deleteComment: (commentId) => `/post/${commentId}/delete`,
    updateComment: (commentId) => `/post/${commentId}/update`,
};

// ===== UI FUNCTIONS =====
function toggleEditMode(commentId, enableEdit) {
    const commentElement = document.querySelector(SELECTORS.comment(commentId));
    if (!commentElement) return;
    
    const viewSection = commentElement.querySelector('.comment-content');
    const editSection = commentElement.querySelector('.edit-form');
    
    if (!viewSection || !editSection) return;

    if (enableEdit) {
        viewSection.style.display = 'none';
        editSection.style.display = 'block';
        const textarea = editSection.querySelector('textarea');
        if (textarea) {
            textarea.focus();
            textarea.style.height = '31px';
            textarea.style.height = `${Math.min(textarea.scrollHeight, 150)}px`;
        }
    } else {
        viewSection.style.display = 'inline';
        editSection.style.display = 'none';
    }
}

function closeAllMenus() {
    document.querySelectorAll('.comment-menu:not(.hidden)').forEach(menu => {
        menu.classList.add('hidden');
    });
}

function closeAllModals() {
    document.querySelectorAll('.delete-comment-modal:not(.hidden)').forEach(modal => {
        modal.classList.add('hidden');
    });
}

function toggleCommentMenu(commentId, show) {
    closeAllMenus();
    if (!show) return;
    
    const commentElement = document.querySelector(SELECTORS.comment(commentId));
    if (!commentElement) return;
    
    const menu = commentElement.querySelector('.comment-menu');
    if (!menu) return;
    
    menu.classList.remove('hidden');
}

function toggleDeleteModal(commentId, show) {
    closeAllModals();
    if (!show) return;
    
    const commentElement = document.querySelector(SELECTORS.comment(commentId));
    if (!commentElement) return;
    
    const modal = commentElement.querySelector('.delete-comment-modal');
    if (!modal) return;
    
    modal.classList.remove('hidden');
    
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    }, { once: true });
}

function handleTextareaInput(event) {
    const textarea = event.target;
    textarea.style.height = "31px";
    textarea.style.height = `${Math.min(textarea.scrollHeight, 150)}px`;

    const postId = textarea.dataset.postId;
    const commentButton = document.querySelector(`${SELECTORS.commentBtn}[data-post-id="${postId}"]`);
    toggleButtonState(commentButton, textarea.value.trim() === "");
}

// ===== API FUNCTIONS =====
async function createComment(event) {
    const button = event.target;
    const { postId, userId } = button.dataset;
    const textarea = document.querySelector(SELECTORS.textarea(postId));
    const content = textarea.value.trim();
    
    if (!content) return;

    toggleButtonState(button, true);
    
    try {
        const data = await fetchData(API_ENDPOINTS.createComment(postId), {
            method: "POST",
            body: JSON.stringify({ posts_id: postId, user_id: userId, content }),
        });

        if (!data.success || !data.comment) {
            console.log(data.error || "Unable to comment");
            return;
        }

        // Update UI
        const commentCount = document.querySelector(SELECTORS.count(postId));
        commentCount.textContent = parseInt(commentCount.textContent, 10) + 1;
        
        textarea.value = "";
        
        const commentsContainer = document.querySelector(SELECTORS.container(postId));
        commentsContainer.insertAdjacentHTML('afterbegin', generateCommentHtml(data.comment));
    } catch (error) {
        console.error("Error adding comment:", error);
    } finally {
        toggleButtonState(button, false);
    }
}

async function loadMoreComments(event) {
    const button = event.target;
    const postId = button.dataset.postId;
    const offset = parseInt(button.dataset.offset, 10) || 0;
    
    toggleButtonState(button, true);
    
    try {
        const response = await fetchData(API_ENDPOINTS.loadComments(postId, offset));
        const comments = response.success || [];
        const hasMoreComments = response.hasMoreComments || false;
        
        if (!comments || !comments.length) {
            button.classList.add('hidden');
            return;
        }
        
        const commentsContainer = document.querySelector(SELECTORS.container(postId));
        
        // Filter out duplicate comments
        const existingCommentIds = Array.from(
            commentsContainer.querySelectorAll('[data-comment-id]')
        ).map(el => el.dataset.commentId);
        
        const uniqueComments = comments.filter(comment => 
            !existingCommentIds.includes(comment.id.toString())
        );
        
        if (uniqueComments.length === 0) {
            if (!hasMoreComments) {
                button.classList.add('hidden');
            } else {
                button.dataset.offset = offset + comments.length;
            }
            return;
        }

        // Add comments to DOM
        const commentsHTML = uniqueComments.map(comment => generateCommentHtml(comment)).join('');
        commentsContainer.insertAdjacentHTML('beforeend', commentsHTML);

        // Update offset for next load
        button.dataset.offset = offset + comments.length;
        if (!hasMoreComments) {
            button.classList.add('hidden');
        }
    } catch (error) {
        console.error("Error loading comments:", error);
    } finally {
        toggleButtonState(button, false);
    }
}

async function updateComment(event) {
    const button = event.target;
    const commentId = button.dataset.commentId;
    const commentElement = document.querySelector(SELECTORS.comment(commentId));
    if (!commentElement) return;
    
    const textarea = document.querySelector(`#content-${commentId}`);
    const content = textarea.value.trim();

    if (!content) return;

    toggleButtonState(button, true);
    
    try {
        const data = await fetchData(API_ENDPOINTS.updateComment(commentId), {
            method: "PATCH",
            body: JSON.stringify({ content }),
        });
        
        if (!data.success || !data.comment) {
            console.log("Unable to update comment");
            return;
        }

        const commentContent = commentElement.querySelector('.comment-content');
        if (commentContent) {
            commentContent.textContent = data.comment.content;
        }
        toggleEditMode(commentId, false);
    } catch (error) {
        console.error("Error updating comment:", error);
    } finally {
        toggleButtonState(button, false);
    }
}

async function deleteComment(event) {
    const button = event.target;
    const commentId = button.dataset.commentId;
    const commentElement = document.querySelector(SELECTORS.comment(commentId));
    if (!commentElement) return;

    try {
        const data = await fetchData(API_ENDPOINTS.deleteComment(commentId), {
            method: "DELETE",
        });

        if (!data.success) {
            console.log("Failed to delete comment:", data.error || "Unknown error");
            return;
        }

        // Update comment count
        const postId = commentElement.closest(".comments-container")?.dataset.postId;
        if (postId) {
            const count = document.querySelector(SELECTORS.count(postId));
            if (count) count.textContent = Math.max(0, parseInt(count.textContent) - 1);
        }
        
        // Remove comment from DOM
        commentElement.remove();
    } catch (error) {
        console.error("Error deleting comment:", error);
    }
}

// ===== EVENT LISTENERS =====
document.addEventListener("DOMContentLoaded", () => {
    // Setup input handlers
    document.querySelectorAll(SELECTORS.textarea()).forEach(textarea => {
        textarea.addEventListener("input", handleTextareaInput);
    });

    // Setup button handlers
    document.querySelectorAll(SELECTORS.commentBtn).forEach(button => {
        button.addEventListener("click", createComment);
    });

    document.querySelectorAll(SELECTORS.loadMoreBtn).forEach(button => {
        button.addEventListener("click", function(event) {
            if (!this.hasAttribute('disabled')) {
                loadMoreComments(event);
            }
        });
    });

    // Close menus when clicking outside
    document.addEventListener('click', (event) => {
        if (!event.target.closest('.three-dots') && !event.target.closest('.comment-menu')) {
            closeAllMenus();
        }
    });

    // Event delegation for dynamic elements
    document.body.addEventListener("click", async (event) => {
        const target = event.target;
        const commentId = target.dataset.commentId;

        // Comment Menu Toggle (Three Dots)
        if (target.classList.contains("three-dots")) {
            event.stopPropagation();
            if (commentId) {
                closeAllMenus();
                const menu = target.nextElementSibling;
                if (menu?.classList.contains('comment-menu')) {
                    menu.classList.remove('hidden');
                }
            }
        }
        // Edit Comment
        else if (target.matches(".edit-comment-btn") && commentId) {
            toggleEditMode(commentId, true);
            closeAllMenus();
        }
        // Save Edit
        else if (target.matches(".save-comment-btn") && commentId) {
            await updateComment(event);
        }
        // Cancel Edit
        else if (target.matches(".cancel-edit-btn") && commentId) {
            toggleEditMode(commentId, false);
        }
        // Delete Comment Toggle
        else if (target.matches(".delete-comment-btn") && commentId) {
            event.stopPropagation();
            toggleDeleteModal(commentId, true);
            closeAllMenus();
        }
        // Confirm Delete
        else if (target.matches(".confirm-delete-comment-btn") && commentId) {
            event.stopPropagation();
            closeAllModals();
            await deleteComment(event);
        }
        // Cancel Delete
        else if (target.matches(".cancel-delete-comment-btn") && commentId) {
            event.stopPropagation();
            closeAllModals();
        }
    });
});

// Expose functions for external use
window.toggleEditMode = toggleEditMode;
window.toggleCommentMenu = toggleCommentMenu;
window.updateComment = updateComment;