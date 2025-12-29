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
            } else {
                console.error('Failed to delete profile picture')
            }
        } catch (error) {
            console.error('Error deleting profile picture: ', error)
        }
    }
    window.addEventListener('confirm-picture-deletion', handleDelete)
}

setupProfilePictureDeletor()