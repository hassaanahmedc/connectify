import { API_ENDPOINTS } from '../config/constants';
import { fetchData } from '../utils/api';
import {
    createImagePreviews,
    prepareImages, 
    formatImageErrors,
    revokeImagePreviews
} from '../utils/imageUploader';

export default (object = null) => ({
    editPreviewId: object.id,
    editPreviewUrlL: object.url,
    content: '',
    selectedTopics: [],
    topicButtonToggle: false,
    loading: false,
    previewImages: [],
    removeImages: [],
    previewErrors: [],

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
                revokeImagePreviews(image.url)
                return false;
            }
            return true;
        });
    },

    async submitPostModal() {
        if (this.loading === true) return;
        this.loading = true;

        try {
            const formData = new FormData();
            formData.append("content", this.content);

            if (this.previewImages.length) {
                this.previewImages.forEach(image => formData.append('images[]', image.file));
            }

            if (this.selectedTopics.length) {
                this.selectedTopics.forEach(topic => formData.append('topics[]', topic.id));
            }

            const response = await fetchData(API_ENDPOINTS.createPost, { method: 'POST', body: formData });
            if (response.postHtml) {
                const newsfeed = document.querySelector("#newsfeed");
                if (newsfeed && response.postHtml) {
                    newsfeed.insertAdjacentHTML('afterbegin', response.postHtml);
                }

            }
            
        } catch (error) {
            console.error("something went wrong try again");
        } finally {
            this.previewImages.forEach(image => revokeImagePreviews(image.url));
            this.content = '';
            this.previewImages = [];
            this.previewErrors = [];
            this.removeImages = [];
            this.selectedTopics = [];
            this.topicButtonToggle = false;
            this.loading = false;
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'create_post' }));
        }
    }
})