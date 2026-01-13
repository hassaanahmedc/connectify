import { API_ENDPOINTS } from '../../config/constants';
import { fetchData } from '../../utils/api';

function setupCoverPhotoDeleter() {
    async function handleDelete() {
        try {
            const response = await fetchData(API_ENDPOINTS.deleteCoverPictureReq, {
                method: 'delete'
            });

            if (response.status === 'success') {
                document.querySelectorAll('.profile-cover-display').forEach(img => img.src = response.path);
                EventBus.dispatch('show-notification', { message: 'Cover photo removed successfully', type: 'success' });
            } else {    
                console.error('Failed to delete cover photo')
                EventBus.dispatch('show-notification', { message: 'Failed to delete cover photo', type: 'error' });
            }
        } catch (error) {
            console.error('Error deleting cover picture: ', error)
            EventBus.dispatch('show-notification', { message: 'Error deleting cover picture, please try again', type: 'error' });
        }
    }
    window.addEventListener('execute-confirmed-action', (event) => { 
        const actionType = event.detail.actionType;
        if (actionType !== 'cover_photo') {
            console.log('not cover photo');
            return;
        }
        handleDelete();
    })
}

setupCoverPhotoDeleter();