import { API_ENDPOINTS } from '../config/constants';
import { fetchData } from '../utils/api';

export default (postId) => ({
    postId: postId,
    showComments: false,
    hasMoreComments: true,
    loadMore: false,
    content: '',
    editComment: false,
    commentId: null,
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

    createComment() {
        
    }, 

    updateComment() {

    },

    deleteComment() {

    },
})