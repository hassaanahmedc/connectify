import "./bootstrap";
import { fetchData } from "./utils/api.js";
import followButton from "./components/follow.js";
import imagePreviewer from "./components/imgPreview.js";
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
  Alpine.data('imagePreviewer', imagePreviewer);

Alpine.start();

