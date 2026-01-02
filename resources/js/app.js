import "./bootstrap";
import { fetchData } from "./utils/api.js";
import Alpine from "alpinejs";

window.Alpine = Alpine;

window.fetchData = fetchData;

document.addEventListener("alpine:init", () => {
    console.log("Initializing post modals");
  
    const imageUtils = {
      addImages(displayImages, event) {
        console.log("Adding images");
        try {
          const files = Array.from(event.target.files);
          files.forEach((file) => {
            if (!file.type.startsWith("image/")) return;
            const url = URL.createObjectURL(file);
            displayImages.push({ url, file, tempId: Date.now() + Math.random() });
          });
          event.target.value = "";
        } catch (error) {
          console.error("Error adding images:", error);
        }
      },
      removeImage(displayImages, image, nextTick) {
        console.log(
          "Removing image:",
          image,
          "from displayImages:",
          displayImages,
        );
        try {
          const index = displayImages.findIndex(
            (img) =>
              (img.tempId && img.tempId === image.tempId) ||
              (img.id && img.id === image.id) ||
              img.url === image.url,
          );
          if (index !== -1) {
            const removedImage = displayImages.splice(index, 1)[0];
            if (removedImage.url.startsWith("blob:"))
              URL.revokeObjectURL(removedImage.url);
            if (nextTick)
              nextTick(() =>
                console.log("After removal, displayImages:", displayImages),
              );
          } else {
            console.warn("Image not found in displayImages:", image);
          }
        } catch (error) {
          console.error("Error removing image:", error);
        }
      },
      prepareFormData(
        content,
        displayImages,
        postId = null,
        removedImageIds = [],
      ) {
        const formData = new FormData();
        formData.append("content", content);
        if (postId) {
          formData.append("_method", "PUT");
          formData.append("postId", postId);
          // Send removed image IDs to the server
          if (removedImageIds.length) {
            formData.append("removedImageIds", JSON.stringify(removedImageIds));
          }
        }
        displayImages.forEach((image, i) => {
          if (image.file) formData.append(`images[${i}]`, image.file);
        });
        return formData;
      },
    };
  
    Alpine.data("createPostModal", (modalName = "create_post") => ({
      content: "",
      displayImages: [],
      error: "",
      isSubmitting: false,
      init() {
        console.log("Initializing create post modal");
      },
      addImages(event) {
        imageUtils.addImages(this.displayImages, event);
      },
      removeImage(image) {
        imageUtils.removeImage(
          this.displayImages,
          image,
          this.$nextTick.bind(this),
        );
      },
      closeModal() {
        console.log("Closing create modal");
        this.displayImages.forEach(
          (img) => img.url.startsWith("blob:") && URL.revokeObjectURL(img.url),
        );
        this.content = "";
        this.displayImages = [];
        this.error = "";
        this.isSubmitting = false;
        this.$dispatch("close-modal", { modal: modalName }); // Updated
      },
      async submit() {
        if (!this.content && !this.displayImages.length) {
          this.error = "Add content or images";
          return;
        }
        this.isSubmitting = true;
        this.error = "";
        try {
          const formData = imageUtils.prepareFormData(
            this.content,
            this.displayImages,
          );
          const url = "/post/store";
          const response = await fetch(url, {
            method: "POST",
            body: formData,
            headers: {
              Accept: "application/json",
              "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
            },
          });
          if (!response.ok)
            throw new Error(`HTTP error! Status: ${response.status}`);
          const data = await response.json();
          const newsfeed = document.querySelector("#newsfeed");
          if (newsfeed && data.postHtml) {
            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = data.postHtml;
            const newNode = tempDiv.firstChild;
            newsfeed.prepend(newNode);
            try {
              // Use requestAnimationFrame to ensure DOM is ready before Alpine initialization
              requestAnimationFrame(() => {
                Alpine.initTree(newNode);
              });
            } catch (initError) {
              console.error("Error initializing new post:", initError);
            }
          }
        } catch (error) {
          this.error = error.message || "Failed to save post";
        } finally {
          this.isSubmitting = false;
          this.closeModal(); // Moved here
        }
      },
    }));
  
    // Edit Post Modal
    Alpine.data(
      "editPostModal",
      (post = null, initialImages = [], modalName = "edit_post") => ({
        postId: post?.id || null,
        content: post?.content || "",
        displayImages: initialImages.map((img) => ({
          url: img.path ? `/storage/${img.path}` : "",
          id: img.id || Date.now() + Math.random(),
          file: null,
        })),
        removedImageIds: [], // Track removed image IDs
        error: "",
        isSubmitting: false,
        init() {
          console.log(
            `Initializing edit post modal for post ID: ${this.postId}`,
            this.displayImages,
          );
        },
        addImages(event) {
          imageUtils.addImages(this.displayImages, event);
        },
        removeImage(image) {
          // Track removed image IDs (only for existing images with an id)
          if (image.id && !image.tempId) {
            this.removedImageIds.push(image.id);
          }
          imageUtils.removeImage(
            this.displayImages,
            image,
            this.$nextTick.bind(this),
          );
        },
        closeModal() {
          console.log("Closing edit modal");
          this.displayImages.forEach(
            (img) => img.url.startsWith("blob:") && URL.revokeObjectURL(img.url),
          );
          this.content = "";
          this.error = "";
          this.isSubmitting = false;
          this.removedImageIds = []; // Reset removed IDs
          this.displayImages = this.displayImages.filter(
            (img) => !img.url.startsWith("blob:"),
          );
          this.$dispatch("close-modal", { modal: modalName });
        },
        async submit() {
          if (!this.content && !this.displayImages.length) {
            this.error = "Add content or images";
            return;
          }
          this.isSubmitting = true;
          this.error = "";
          try {
            const formData = imageUtils.prepareFormData(
              this.content,
              this.displayImages,
              this.postId,
              this.removedImageIds,
            );
            const response = await fetch(`/post/${this.postId}/update`, {
              method: "POST",
              body: formData,
              headers: {
                Accept: "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                  .content,
              },
            });
            if (!response.ok)
              throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();
            const newsfeed = document.querySelector("#newsfeed");
            if (newsfeed && data.postHtml) {
              const tempDiv = document.createElement("div");
              tempDiv.innerHTML = data.postHtml;
              const existingPost = newsfeed.querySelector(
                `[data-post-id="${this.postId}"]`,
              );
              if (existingPost) existingPost.replaceWith(tempDiv.firstChild);
              else newsfeed.prepend(tempDiv.firstChild);
              Alpine.initTree(tempDiv.firstChild);
            }
            this.closeModal();
          } catch (error) {
            this.error = error.message || "Failed to save post";
          } finally {
            this.isSubmitting = false;
          }
        },
      }),
    );
  });
  
  window.asset = function (path) {
    return path;
  };
  
  window.EventBus = {
      dispatch(event, detail) {
          window.dispatchEvent(new CustomEvent(event, { detail }));
      }
  };

Alpine.start();

