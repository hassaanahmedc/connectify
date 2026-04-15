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
                console.log(event.detail)
                this.hydrateModal(event.detail);
        })
    },

    hydrateModal(data) {
        this.isEdit = data.isEdit || false;
        this.content = data.content || '';
        this.postId = data.id || null;

        if (data.images) {
            this.previewImages = data.images.map(image => ({
                id: image.id,
                url: image.url,
                file: null,
            }));
        }
        if (data.topics) {
            this.selectedTopics = data.topics.map(topic => ({id: topic.id}));
        }
    },

    toggleTopic(topic) {
        const index = this.selectedTopics.findIndex(t => t.id === topic.id);
        if (index > -1) {
            this.selectedTopics.splice(index, 1);
        } else {
            this.selectedTopics.push(topic);
        }
    },

    handleFileSelect(event) {
        const files = Array.from(event.target.files || []);
        if (!files.length) return;

        console.log("Files selected:", files);

        const { validatedImages, errors } = prepareImages(files);
        
        if (errors.length > 0) {
          const formattedErrorMessages = formatImageErrors(errors);
          this.previewErrors.push(formattedErrorMessages);
        
        } else {
            const obj = validatedImages.map(image => {
                return {
                    id: Date.now() + Math.random(),
                    url: createImagePreviews(image),
                    file: image,
                }
            })
            this.previewImages.push(...obj)
            console.log(this.previewImages)
        }
    },

    removePreview(id) {
        this.previewImages = this.previewImages.filter(image => {
            if (image.id === id) {
                if (!image.file) {
                    this.removeImages.push(image.id)
                    console.log("Ddatabse image marked for deletion: ", image,id)
                }
                revokeImagePreviews(image.url)
                return false;
            }
            return true;
        });
    },

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

    async submitPostModal() {
        if (this.loading === true) return;
        this.loading = true;

        try {
            const formData = new FormData();
            formData.append("content", this.content);
            
            this.previewImages.forEach(img => {
                if (img.file) formData.append('images[]', img.file);
            })

            if (this.removeImages.length > 0) {
                this.removeImages.forEach(id => formData.append('removedImageIds[]', id));
            }

            if (this.selectedTopics.length) {
                this.selectedTopics.forEach(topic => formData.append('topics[]', topic.id));
            }

            let response;

            if (this.isEdit) {
                response = await this.updatePost(formData);
            } else {
                response = await this.createPost(formData);
            }

            if (response.postHtml) {
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
                        newsfeed.insertAdjacentHTML('afterbegin', response.postHtml);
                    }
                }
            }
            
        } catch (error) {
            console.error("Submission Error:", error);
        } finally {
            this.previewImages.forEach(image => revokeImagePreviews(image.url));
            this.content = '';
            this.previewImages = [];
            this.previewErrors = [];
            this.removeImages = [];
            this.selectedTopics = [];
            this.topicButtonToggle = false;
            this.loading = false;
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'post-modal' }));
        }
    }
})