import { fetchData } from "./utils/api.js";
import { toggleButtonState } from "./utils/ui.js";
import { generateCommentHtml } from "./utils/templete.js";

const SELECTORS = {
  commentBtn: ".comment-btn",
  loadMoreBtn: ".load-more-comments",
  textarea: ".comment-textarea",
  count: ".comment-count",
  container: ".comments-container",
  comment: (commentId) => `[data-comment-id="${commentId}"]`,
};

const API_ENDPOINTS = {
  createComment: (postId) => `/post/${postId}/comment`,
  loadComments: (postId, offset) =>
    `/post/${postId}/viewcomments?offset=${offset}&limit=10`,
  deleteComment: (commentId) => `/post/${commentId}/delete`,
  updateComment: (commentId) => `/post/${commentId}/update`,
};

// UI Functions
function toggleEditMode(commentId, enableEdit) {
  const commentElement = document.querySelector(SELECTORS.comment(commentId));
  if (!commentElement) return;
  const viewSection = commentElement.querySelector(".comment-content");
  const editSection = commentElement.querySelector(".edit-form");
  if (!viewSection || !editSection) return;
  if (enableEdit) {
    viewSection.style.display = "none";
    editSection.style.display = "block";
    const textarea = editSection.querySelector("textarea");
    if (textarea) {
      textarea.focus();
      textarea.style.height = "31px";
      textarea.style.height = `${Math.min(textarea.scrollHeight, 150)}px`;
    }
  } else {
    viewSection.style.display = "inline";
    editSection.style.display = "none";
  }
}

function closeAllMenus() {
  document.querySelectorAll(".comment-menu:not(.hidden)").forEach((menu) => {
    menu.classList.add("hidden");
  });
}

function closeAllModals() {
  document
    .querySelectorAll(".delete-comment-modal:not(.hidden)")
    .forEach((modal) => {
      modal.classList.add("hidden");
    });
}

function toggleCommentMenu(commentId, show) {
  closeAllMenus();
  if (!show) return;
  const commentElement = document.querySelector(SELECTORS.comment(commentId));
  if (!commentElement) return;
  const menu = commentElement.querySelector(".comment-menu");
  if (!menu) return;
  menu.classList.remove("hidden");
}

function toggleDeleteModal(commentId, show) {
  closeAllModals();
  if (!show) return;
  const commentElement = document.querySelector(SELECTORS.comment(commentId));
  if (!commentElement) return;
  const modal = commentElement.querySelector(".delete-comment-modal");
  if (!modal) return;
  modal.classList.remove("hidden");
  modal.addEventListener(
    "click",
    (e) => {
      if (e.target === modal) {
        modal.classList.add("hidden");
      }
    },
    { once: true },
  );
}

function handleTextareaInput(event) {
  const textarea = event.target;
  textarea.style.height = "31px";
  textarea.style.height = `${Math.min(textarea.scrollHeight, 150)}px`;
  const postId = textarea.dataset.postId;
  const commentButton = document.querySelector(
    `${SELECTORS.commentBtn}[data-post-id="${postId}"]`,
  );
  toggleButtonState(commentButton, textarea.value.trim() === "");
}

// API Functions
async function createComment(event) {
  const button = event.target.closest(SELECTORS.commentBtn);
  if (!button) return;
  const { postId, userId } = button.dataset;
  const textarea = document.querySelector(
    `${SELECTORS.textarea}[data-post-id="${postId}"]`,
  );
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
    const commentCount = document.querySelector(
      `${SELECTORS.count}[data-post-id="${postId}"]`,
    );
    commentCount.textContent = parseInt(commentCount.textContent, 10) + 1;
    textarea.value = "";
    const commentsContainer = document.querySelector(
      `${SELECTORS.container}[data-post-id="${postId}"]`,
    );
    commentsContainer.insertAdjacentHTML(
      "afterbegin",
      generateCommentHtml(data.comment),
    );
  } catch (error) {
    console.error("Error adding comment:", error);
  } finally {
    toggleButtonState(button, false);
  }
}

async function loadMoreComments(event) {
  const button = event.target.closest(SELECTORS.loadMoreBtn);
  if (!button || button.hasAttribute("disabled")) return;
  const postId = button.dataset.postId;
  const offset = parseInt(button.dataset.offset, 10) || 0;
  toggleButtonState(button, true);
  try {
    const response = await fetchData(
      API_ENDPOINTS.loadComments(postId, offset),
    );
    const comments = response.success || [];
    const hasMoreComments = response.hasMoreComments || false;
    if (!comments || !comments.length) {
      button.classList.add("hidden");
      return;
    }
    const commentsContainer = document.querySelector(
      `${SELECTORS.container}[data-post-id="${postId}"]`,
    );
    const existingCommentIds = Array.from(
      commentsContainer.querySelectorAll("[data-comment-id]"),
    ).map((el) => el.dataset.commentId);
    const uniqueComments = comments.filter(
      (comment) => !existingCommentIds.includes(comment.id.toString()),
    );
    if (uniqueComments.length === 0) {
      if (!hasMoreComments) {
        button.classList.add("hidden");
      } else {
        button.dataset.offset = offset + comments.length;
      }
      return;
    }
    const commentsHTML = uniqueComments
      .map((comment) => generateCommentHtml(comment))
      .join("");
    commentsContainer.insertAdjacentHTML("beforeend", commentsHTML);
    button.dataset.offset = offset + comments.length;
    if (!hasMoreComments) {
      button.classList.add("hidden");
    }
  } catch (error) {
    console.error("Error loading comments:", error);
  } finally {
    toggleButtonState(button, false);
  }
}

async function updateComment(event) {
  const button = event.target.closest(".save-comment-btn");
  if (!button) return;
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
    const commentContent = commentElement.querySelector(".comment-content");
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
  const button = event.target.closest(".confirm-delete-btn");
  if (!button) return;
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
    const postId = commentElement.closest(".comments-container")?.dataset
      .postId;
    if (postId) {
      const count = document.querySelector(
        `${SELECTORS.count}[data-post-id="${postId}"]`,
      );
      if (count)
        count.textContent = Math.max(0, parseInt(count.textContent) - 1);
    }
    commentElement.remove();
  } catch (error) {
    console.error("Error deleting comment:", error);
  }
}

async function deleteCommentById(commentId) {
  const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
  if (!commentElement) return;
  try {
    const data = await fetchData(API_ENDPOINTS.deleteComment(commentId), {
      method: "DELETE",
    });
    if (!data.success) {
      console.log("Failed to delete comment:", data.error || "Unknown error");
      return;
    }
    const postId = commentElement.closest(".comments-container")?.dataset.postId;
    if (postId) {
      const count = document.querySelector(
        `${SELECTORS.count}[data-post-id="${postId}"]`,
      );
      if (count)
        count.textContent = Math.max(0, parseInt(count.textContent) - 1);
    }
    commentElement.remove();
  } catch (error) {
    console.error("Error deleting comment:", error);
  }
}

function initCommentHandlers(container) {
  container.addEventListener("click", async (event) => {
    const target = event.target;
    const commentId = target.dataset.commentId;

    if (target.closest(SELECTORS.commentBtn)) {
      await createComment(event);
    } else if (target.closest(SELECTORS.loadMoreBtn)) {
      await loadMoreComments(event);
    } else if (target.matches(".three-dots") && commentId) {
      event.stopPropagation();
      closeAllMenus();
      const menu = target.nextElementSibling;
      if (menu?.classList.contains("comment-menu")) {
        menu.classList.remove("hidden");
      }
    } else if (target.matches(".edit-comment-btn") && commentId) {
      toggleEditMode(commentId, true);
      closeAllMenus();
    } else if (target.matches(".save-comment-btn") && commentId) {
      await updateComment(event);
    } else if (target.matches(".cancel-edit-btn") && commentId) {
      toggleEditMode(commentId, false);
    } else if (target.matches(".delete-comment-btn") && commentId) {
      event.stopPropagation();
      toggleDeleteModal(commentId, true);
      closeAllMenus();
    } else if (target.matches(".confirm-delete-btn") && commentId) {
      event.stopPropagation();
      closeAllModals();
      await deleteComment(event);
    } else if (
      target.matches(".cancel-delete-comment-btn, .cancel-delete-btn") &&
      commentId
    ) {
      event.stopPropagation();
      closeAllModals();
    }
  });

  container.addEventListener("input", (event) => {
    if (event.target.matches(SELECTORS.textarea)) {
      handleTextareaInput(event);
    }
  });
}

// Event Delegation
document.addEventListener("DOMContentLoaded", () => {
  const newsfeed = document.querySelector("#newsfeed");
  if (!newsfeed) {
    // For pages that don't have a newsfeed container but have comments
    document.querySelectorAll(".comments-container").forEach(container => {
      initCommentHandlers(container);
    });
    return;
  }
  
  newsfeed.addEventListener("click", async (event) => {
    const target = event.target;
    const commentId = target.dataset.commentId;

    if (target.closest(SELECTORS.commentBtn)) {
      await createComment(event);
    } else if (target.closest(SELECTORS.loadMoreBtn)) {
      await loadMoreComments(event);
    } else if (target.matches(".three-dots") && commentId) {
      event.stopPropagation();
      closeAllMenus();
      const menu = target.nextElementSibling;
      if (menu?.classList.contains("comment-menu")) {
        menu.classList.remove("hidden");
      }
    } else if (target.matches(".edit-comment-btn") && commentId) {
      toggleEditMode(commentId, true);
      closeAllMenus();
    } else if (target.matches(".save-comment-btn") && commentId) {
      await updateComment(event);
    } else if (target.matches(".cancel-edit-btn") && commentId) {
      toggleEditMode(commentId, false);
    } else if (target.matches(".delete-comment-btn") && commentId) {
      event.stopPropagation();
      toggleDeleteModal(commentId, true);
      closeAllMenus();
    } else if (target.matches(".confirm-delete-btn") && commentId) {
      event.stopPropagation();
      closeAllModals();
      await deleteComment(event);
    } else if (
      target.matches(".cancel-delete-comment-btn, .cancel-delete-btn") &&
      commentId
    ) {
      event.stopPropagation();
      closeAllModals();
    }
  });

  newsfeed.addEventListener("input", (event) => {
    if (event.target.matches(SELECTORS.textarea)) {
      handleTextareaInput(event);
    }
  });

  document.addEventListener("click", (event) => {
    if (
      !event.target.closest(".three-dots") &&
      !event.target.closest(".comment-menu")
    ) {
      closeAllMenus();
    }
  });

  document.addEventListener("comment-delete-confirmed", async (event) => {
    const commentId = event.detail.commentId;
    if (commentId) {
      console.log("Comment delete confirmed for ID:", commentId);
      await deleteCommentById(commentId);
    }
  });
});

window.toggleEditMode = toggleEditMode;
window.toggleCommentMenu = toggleCommentMenu;
window.updateComment = updateComment;
