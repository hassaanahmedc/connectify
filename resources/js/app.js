import "./bootstrap";
import "./components/likePost.js";
import "./components/notifications.js";
import "./components/locations.js";
import "./features/profile/coverImage.js";
import "./features/profile/coverImageDeleter.js";
import "./features/profile/profileImageDeleter.js";
import "./features/profile/profileImages.js";
import "./features/search/index.js";
import "./components/notifications.js";
import { fetchData } from "./utils/api.js";
import followButton from "./components/follow.js";
import postModal from "./components/postModal.js";
import comments from "./components/comments.js";
import infiniteScroll from "./components/infiniteScroll.js";
import shareUrl from "./components/share.js";
import Alpine from "alpinejs";

window.Alpine = Alpine;

window.fetchData = fetchData;

  window.asset = function (path) {
    return path;
  };
  
  window.EventBus = {
      dispatch(event, detail) {
          window.dispatchEvent(new CustomEvent(event, { detail }));
      }
  };
  Alpine.data('followButton', followButton);
  Alpine.data('postModal', postModal);
  Alpine.data('comments', comments);
  Alpine.data('infiniteScroll', infiniteScroll);
  Alpine.data('shareUrl', shareUrl);
  
Alpine.start();

