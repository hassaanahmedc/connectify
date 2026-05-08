import { API_ENDPOINTS } from '../config/constants';
import { fetchData } from '../utils/api';

export default (postId, initialCount) => ({
    postId: postId,
    commentCount: initialCount,
    showComments: false,
    hasMoreComments: true,
    loadMore: false,
    content: '',
    loading: false,
    errors: [],

    async loadMoreComments() {
        this.loading = true;
        this.hasMoreComments = false;
        const currentOffset = this.$refs.commentsList.children.length;
        try {
            const response = await fetchData(API_ENDPOINTS.loadComments(this.postId, currentOffset));
            if (response.success && response.commentHtml) {
                this.$refs.commentsList.insertAdjacentHTML('beforeend', response.commentHtml);
                this.hasMoreComments = response.hasMoreComments;
            }
        } catch (error) {
            this.errors = ["Failed to load more comments."];
        } finally {
            this.loading = false;
        }
    },

    async createComment() {
        this.loading = true;

        const formData = new FormData();
        formData.append('content', this.content);

        try {
            const response = await fetchData(API_ENDPOINTS.createComment(this.postId), {
                method: 'POST',
                body: formData,
            });

            if (response.success && response.commentHtml) {
                this.commentCount++;
                this.$refs.commentsList.insertAdjacentHTML('afterbegin', response.commentHtml);
            }

        } catch (error) {
            this.errors = ["Failed to add comment."];
        } finally {
            this.loading = false;
            this.content = '';
        }
    }, 

    async updateComment(id, oldContent, newContent) {
        if (oldContent.trim() === newContent.trim()) return;
        else {
            this.loading = true;

            const formData = new FormData();
            formData.append('content', newContent.trim());
            formData.append("_method", "PATCH");

            try {
                const response  = await fetchData(API_ENDPOINTS.updateComment(id), {
                    method: 'POST', 
                    body: formData,
                })

                if (response.success && response.content) {
                    const newContent = response.content
                    window.dispatchEvent(new CustomEvent('comment-updated', { detail: {id, newContent } }));

                } else {
                this.errors = [];
                if (response.errors) this.errors = Object.values(response.errors).flat();
                else this.errors = [response.message || "Could not save post."];
            }
            } catch (error) {
                this.errors = ["A connection error occurred. Please try again."];
                EventBus.dispatch('show-notification', { message: 'Something went wrong.', type: 'error' });

            } finally {
                this.loading = false;
            }
        }

    },

    async deleteComment(id) {
        try {
            const response = await fetchData(API_ENDPOINTS.deleteComment(id), { method: 'DELETE' } );
            if (response.success) {
                this.commentCount--;
                window.dispatchEvent(new CustomEvent('comment-deleted', { detail: {id: id } }));
                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'confirm-action-modal' }));
            }
        } catch (error) {
            this.errors = ["A connection error occurred. Please try again."];
            EventBus.dispatch('show-notification', { message: 'Something went wrong.', type: 'error' });
        }
    },
})