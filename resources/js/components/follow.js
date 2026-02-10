import { fetchData } from "../utils/api";
import { API_ENDPOINTS } from "../config/constants.js";

export default (userId, initialStatus) => ({
    isFollowing: initialStatus,
    followCount: null,
    error: '',
    isHovering: false,
    loading: false,
    

    async toggleFollow() {
        if (this.loading) return;
        this.loading = true;

        try {
            const response = await fetchData(API_ENDPOINTS.followUser(userId), {
                method: 'POST', 
                body: JSON.stringify({ user_id: userId })
            });

            const data = await response;
            if (!data.success) this.error = 'Request failed, please try again.';
            this.isFollowing = data.following;
            this.followCount = data.followers_count;

        } catch(error) {
            this.error = 'unable to follow user at the moment, please try again later.';

        } finally {
            this.loading = false;
        }
    } 
})