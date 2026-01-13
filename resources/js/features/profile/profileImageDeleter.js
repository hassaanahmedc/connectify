import { API_ENDPOINTS } from '../../config/constants';
import { fetchData } from '../../utils/api';

function setupProfilePictureDeletor() {
    async function handleDelete() {
        try {
            const result = await fetchData(API_ENDPOINTS.deleteProfilePictureReq, {
                method: 'delete',
            });

            if (result.status === 'success') {
                document.querySelectorAll('.profile-picture-display').forEach(img => img.src = result.path)
                EventBus.dispatch('show-notification', { message: 'Profile Picture removed successfully', type: 'success' });
            } else {
                console.error('Failed to delete profile picture')
                EventBus.dispatch('show-notification', { message: 'Failed to delete profile picture', type: 'error' });
            }
        } catch (error) {
            console.error('Error deleting profile picture: ', error)
            EventBus.dispatch('show-notification', { message: 'Error deleting profile picture, please try again', type: 'error' });
        }
    }
    window.addEventListener('execute-confirmed-action', (event) => { 
        const actionType = event.detail.actionType;
        if (actionType !== 'profile_picture') {
         console.log('not profile picture');
         return;   
        }
        handleDelete();
    })
}

setupProfilePictureDeletor()