/**
 * This file manages API response and UI updates for deleting user's cover photo.
 * 
 * @summary This scripts acts as a speciofic handle for 'execute-confirmed-action' 
 * global event. If it indicates a 'cover_photo' deletion, it makes an API call
 * to the baceknd and updates UI. 
 */

import { API_ENDPOINTS } from '../../config/constants';
import { fetchData } from '../../utils/api';

function setupCoverPhotoDeleter() {
    
    /**
     * In this function we are executing the API call to delete the cover photo.
     * Update the UI to defualt avatar.
     * And finally we dispatch a notification based on the API response.
     */
    async function handleDelete() {
        try {
            const response = await fetchData(API_ENDPOINTS.deleteCoverPictureReq, {
                method: 'delete'
            });

            if (response.status === 'success') {
                // Updates the cover image element on the page to render default cover path.
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

    /**
     * Listens for generic 'execute-confirmed-action' event from confirmation modal.
     * Then we check for 'actionType' in event detail if it matches with 'cover_photo'
     * before processing with the deletion.
     */
    window.addEventListener('execute-confirmed-action', (event) => { 
        const actionType = event.detail.actionType;
        if (actionType !== 'cover_photo') return;
        handleDelete();
    })
}

setupCoverPhotoDeleter();