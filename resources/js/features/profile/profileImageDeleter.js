/**
 * This file manages API response and UI updates for deleting user's profile picture.
 * 
 * @summary This scripts acts as a speciofic handle for 'execute-confirmed-action' 
 * global event. If it indicates a 'profile_picture' deletion, it makes an API call
 * to the baceknd and updates UI. 
 */

import { API_ENDPOINTS } from '../../config/constants';
import { fetchData } from '../../utils/api';

function setupProfilePictureDeletor() {

    /**
     * In this function we are executing the API call to delete the profile picture.
     * Update the UI to defualt avatar.
     * And finally we dispatch a notification based on the API response.
     */
    async function handleDelete() {
        try {
            const result = await fetchData(API_ENDPOINTS.deleteProfilePictureReq, {
                method: 'delete',
            });

            if (result.status === 'success') {
                // Updates the profile image element on the page to render default avatar path.
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

    /**
     * Listens for generic 'execute-confirmed-action' event from confirmation modal.
     * Then we check for 'actionType' in event detail if it matches with 'profile_picture'
     * before processing with the deletion.
     */
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