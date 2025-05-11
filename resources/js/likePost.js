import { fetchData } from "./utils/api.js";
import { toggleButtonState } from "./utils/ui.js";

const SELECTORS = {
  likeBtn: ".like-btn",
  likeCount: ".like-count",
  likeIcon: ".like-icon",
};

const LIKE_STATES = {
  likedClass: "liked-icon",
  defaultClass: "default-svg-color",
};

const API_ENDPOINTS = {
  likePost: (postId) => `/post/${postId}/like`,
};

async function likePost(event) {
  const button = event.target.closest(SELECTORS.likeBtn);
  if (!button) return;
  const { postId, userId } = button.dataset;
  const likeCount = button.querySelector(SELECTORS.likeCount);
  const likeIcon = button.querySelector(SELECTORS.likeIcon);

  if (!postId || !userId) {
    console.log("Missing postId or userId");
    return;
  }
  toggleButtonState(button, true);
  try {
    const data = await fetchData(API_ENDPOINTS.likePost(postId), {
      method: "POST",
      body: JSON.stringify({ posts_id: postId, user_id: userId }),
    });

    if (!data.liked && data.liked !== false) {
      console.error("Invalid like response:", data.error || "Unknown error");
      toggleButtonState(button, false);
      return;
    }

    likeCount.textContent =
      parseInt(likeCount.textContent, 10) + (data.liked ? 1 : -1);
    likeIcon.classList.toggle(LIKE_STATES.likedClass, data.liked);
    likeIcon.classList.toggle(LIKE_STATES.defaultClass, !data.liked);
    toggleButtonState(button, false);
  } catch (error) {
    console.error("Error liking post:", error.message);
    toggleButtonState(button, false);
  }
}

// Event delegation
document.addEventListener("DOMContentLoaded", () => {
  const newsfeed = document.querySelector("#newsfeed");
  if (newsfeed) {
    newsfeed.addEventListener("click", likePost);
  }
});
