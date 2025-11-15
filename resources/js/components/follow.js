import { fetchData } from "../utils/api";
import { API_ENDPOINTS } from "../config/constants.js";

const followBtn = document.getElementById('follow-btn');
const followerCount = document.getElementById('follower-count');
const userId = followBtn.dataset.userId;

const followUser = async () => {
    try {
        const response = await fetchData(API_ENDPOINTS.followUser(userId), {
            method: 'POST', 
            body: JSON.stringify({ user_id: userId })
        });
        
        const data = await response;

        if (!data.success) throw new Error('Request Failed');

        followBtn.textContent = data.following ? 'Unfollow' : 'Follow';
        followerCount.textContent = `${data.followers_count}`;

    } catch (error) {
        console.log('unable to follow user at the moment, please try again later...', error)
    }
}

followBtn.addEventListener('click', followUser);