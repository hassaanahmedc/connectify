import { API_ENDPOINTS } from '../config/constants';
import { fetchData } from '../utils/api';
import {
    createImagePreviews,
    prepareImages, 
    formatImageErrors,
    revokeImagePreviews
} from '../utils/imageUploader';

export default () => ({
    isEdit: false,
    subHeading: 'Creating Post...',
    postId: null,
    content: '',
    selectedTopics: [],
    topicButtonToggle: false,
    loading: false,
    previewImages: [],
    removeImages: [],
    previewErrors: [],

    init() {
        window.addEventListener('fill-post-data', (event) => {
                this.hydrateModal(event.detail);
        })
    },

    // This is reusable util to set modal properties to default.
    resetModalState() {
        this.content = '';
        this.subHeading = 'Creating Post...';
        this.previewImages = [];
        this.previewErrors = [];
        this.removeImages = [];
        this.selectedTopics = [];
        this.topicButtonToggle = false;
        this.loading = false;
        this.previewImages.forEach(image => {
            if (image.file && image.url) {
                revokeImagePreviews(image.url);
            }
        });
    },

    /**
     * This function is responsible for populating modal with post data.
     * If user clicks on edit post, we receive the post data from the event
     * and populate modal with that data in this function.
     */
    hydrateModal(data) {
        // Resting the modal's initial state to prevent state persistant bug.
        this.resetModalState();
        this.isEdit = data.isEdit || false;
        this.content = data.content || '';
        this.postId = data.id || null;

        if (data.isEdit) {
            this.subHeading = "Editing Post..."
        }

        // If we get images from the post we make the object in preview images array with necesarry data.
        if (data.images) {
            this.previewImages = data.images.map(image => ({
                id: image.id,
                url: image.url,
                file: null, // setting this null to distinguish between server and user selected preview.
            }));
        }
        if (data.topics) {
            this.selectedTopics = data.topics.map(topic => ({...topic}));
        }
    },

    // this method helps user select and unselect topics on while working on post. 
    toggleTopic(topic) {
        const index = this.selectedTopics.findIndex(t => t.id === topic.id);
        if (index > -1) {
            this.selectedTopics.splice(index, 1);
        } else {
            this.selectedTopics.push(topic);
        }
    },

    /**
     * This function is responsible for handling file selection.
     * We are filtering selected images with our helper functions and 
     * if valdation is passed, we generete image previews.
     * Finally we return an image object on validated images containing
     * dynamically cerated image id, preview url and file oject then push 
     * the object to preview image array.
     */
    handleFileSelect(event) {
        // clearing any previous errors and locking the submit button.
        this.previewErrors = [];
        this.loading = false;

        const files = Array.from(event.target.files || []);
        if (!files.length) return;

        // Validatinng images with our util function returning an object of valided files and errors. 
        const { validatedImages, errors } = prepareImages(files);
        
        if (errors.length > 0) {
          const formattedErrorMessages = formatImageErrors(errors);
          this.loading = true;
          this.previewErrors.push(...formattedErrorMessages);
        
        } else { 
            // Creating image object containing id, url and file object
            const obj = validatedImages.map(image => {
                return {
                    id: Date.now() + Math.random(),
                    url: createImagePreviews(image),
                    file: image,
                }
            })
            this.previewImages.push(...obj)
        }   
    },

    /**
     * This function is responsible for removing image previews from the modal.
     * we are using filter function on previewImages to look for server rendered and
     * user selected images.
     * if the image has file object (user selected image) we revoke the URL otherwise we 
     * pass the image id for API call.
     */
    removePreview(id) {
        this.previewImages = this.previewImages.filter(image => {
            if (image.id === id) {
                if (!image.file) {  
                    this.removeImages.push(image.id)
                } else {
                    revokeImagePreviews(image.url)
                }
                return false;
            }
            return true;
        });
    },

    // Reusable API methods for create and edit post.
    async createPost(formData) {
        return await fetchData(API_ENDPOINTS.createPost, { 
            method: 'POST', 
            body: formData 
        });
    },

    async updatePost(formData) {
        formData.append("_method", "PUT");
        return await fetchData(API_ENDPOINTS.updatePost(this.postId), {     
            method: 'POST', 
            body: formData 
        });
    },

    /**
     * This function is responsible for executing API calls for Create and update post.
     * we are building form data and keeping track of Images or topics user wants to delete form post.
     * Updates the UI and notfies user for error and success,
     * And finally we dispatch a notification based on the API response.
     */
    async submitPostModal() {
        // Preventing accidental clicks / guard against multiple submits requests at once. 
        if (this.loading === true) return;
        this.loading = true;
        this.previewErrors = [];

        try {
            // Preparing FormData
            const formData = new FormData();
            formData.append("content", this.content);

            // Appending new images for uplaod
            this.previewImages.forEach(img => {
                if (img.file) formData.append('images[]', img.file);
            })

            // Sending IDs of images and topics the user wants to remove.
            if (this.removeImages.length > 0) {
                this.removeImages.forEach(id => formData.append('removedImageIds[]', id));
            }

            if (this.selectedTopics.length) {
                this.selectedTopics.forEach(topic => formData.append('topics[]', topic.id));
            }

            // Executing API calls for Create and Update post
            let response;
            if (this.isEdit) {
                response = await this.updatePost(formData);
            } else {
                response = await this.createPost(formData);
            }

            // Handling Success Response
            if (response.success && response.postHtml) {
                // Updating UI on Success (Edit Post)
                const newsfeed = document.querySelector("#newsfeed");
                if (this.isEdit) {
                    const existingDiv = newsfeed.querySelector(`[data-post-id="${this.postId}"]`);
                    if (existingDiv) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = response.postHtml.trim();
                        const newPostElement = tempDiv.firstElementChild;
                        existingDiv.replaceWith(newPostElement);
                    }
                } else {
                    if (newsfeed && response.postHtml) {
                        // Updating UI on Success (Create Post)
                        newsfeed.insertAdjacentHTML('afterbegin', response.postHtml);
                    }                    
                }
                // Notifying User and clearing State on success 
                EventBus.dispatch('show-notification', { 
                    message: this.isEdit ? 'Changes saved.' : 'Post Created.', 
                    type: 'success' 
                });

                this.resetModalState();
                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'post-modal' }));

            } else {
                // Handling Server Validation Errors
                this.previewErrors = [];
                if (response.errors) this.previewErrors = Object.values(response.errors).flat();
                else this.previewErrors = [response.message || "Could not save post."];
            }
        } catch (error) {   
            // Catching network timeouts or unexpected crashses
            this.previewErrors = ["A connection error occurred. Please try again."];
            EventBus.dispatch('show-notification', { message: 'Something went wrong.', type: 'error' });
        } finally {
            this.loading = false;


        }
    }
})