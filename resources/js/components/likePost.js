import { fetchData } from "../utils/api";
import { toggleButtonState } from "../utils/ui.js";
import { API_ENDPOINTS } from "../config/constants.js"

const SELECTORS = {
  likeBtns: ".like-btn",
  likeCount: ".like-count",
  likeIcon: ".like-icon",
};

const LIKE_STATES = {
  likedClass: "liked-icon",
  defaultClass: "default-svg-color",
};

async function likePost(event) {
  const button = event.currentTarget;
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

    const currentCount = parseInt(likeCount.textContent, 10);
    likeCount.textContent = (isNaN(currentCount) ? 0 : currentCount) + (data.liked ? 1 : -1);
    likeIcon.classList.toggle(LIKE_STATES.likedClass, data.liked);
    likeIcon.classList.toggle(LIKE_STATES.defaultClass, !data.liked);
    toggleButtonState(button, false);
  } catch (error) {
    console.error("Error liking post:", error.message);
    toggleButtonState(button, false);
  }
}

document.querySelectorAll(SELECTORS.likeBtns).forEach((button) => {
  button.addEventListener("click", likePost);
});
