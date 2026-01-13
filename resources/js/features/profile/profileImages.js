import { API_ENDPOINTS } from '../../config/constants';
import {
    createImagePreviews,
    prepareImages, 
    formatImageErrors,
    uploadImages,
    displayAlerts,
    disableButton,
    enableButton,
    revokeImagePreviews
} from '../../utils/imageUploader';

function setupProfileImageUploader() {
    let state = {
        filesToUpload: [],
        currentPreviews: [],
        errorsToDispatch: [],
    }

    const elements = {
        uploadProfilePicture: document.getElementById('upload-profile-picture'),
        selectProfilePicture: document.getElementById('select-profile-picture'),
        profilePicture: document.getElementById("profile-picture"),
        saveProfilePicture: document.getElementById('save-upload-button'),
        profileErrors: document.getElementById('profile-error'),
        previewContainer: document.getElementById('image-upload-preview-container'),
        errorContainer: document.getElementById('error-container')
    }

    function handleProfileImage(e) {
        if (state.currentPreviews.length > 0) {
            revokeImagePreviews(state.currentPreviews);
        }
        const files = Array.from(e.target.files || []);
        const { validatedImages, errors } = prepareImages(files);

        if (errors.length > 0) {
            const formattedErrorMessages = formatImageErrors(errors);

            state.filesToUpload = [];
            state.currentPreviews = [];
            state.errorsToDispatch = formattedErrorMessages;

        } else {
            state.filesToUpload = validatedImages;
            state.currentPreviews = createImagePreviews(validatedImages);
        }

        window.dispatchEvent(new CustomEvent ('open-image-preview', {
            detail: {
                previewUrl: state.currentPreviews,
                profileErrors: state.errorsToDispatch,
                title: 'Upload Profile Picture',
                previewClass: 'w-64 h-64',
                tryAgainId: 'try-again-button-profile',
            }
        }));

        window.dispatchEvent(new CustomEvent ('open-modal', { detail: 'image-upload-preview' }));

        state.errorsToDispatch = [];
    }

    async function handleUplaod() {
        if (state.filesToUpload.length === 0) return;
        disableButton(elements.saveProfilePicture, 'Saving...')
        
        try {
            const result = await uploadImages(state.filesToUpload, API_ENDPOINTS.uploadProfilePictureReq, 'profile_picture');

            if (result.ok) {
                elements.profilePicture.src = result.data;

                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'image-upload-preview' }));
                window.dispatchEvent(new CustomEvent('show-notification', {
                    detail: { message: 'Profile picture updated!', type: 'success' }
                }));

            } else {
                const errorMessages = result.error ? formattedErrorMessages(
                    [result.error]) : ['Upload failed, Please try again.']

                window.dispatchEvent(new CustomEvent('open-image-preview', { detail: { profileErrors: errorMessages } }));
            }

        } catch (error) {
            window.dispatchEvent(new CustomEvent('open-image-preview', {
                detail: { profileErrors: ['A network error occured, Please try again.'] }
            }));
            
        } finally {
            enableButton(elements.saveProfilePicture, 'Save')
            if (state.currentPreviews.length > 0) {
                revokeImagePreviews(state.currentPreviews)
            }
            state.filesToUpload = []
            state.currentPreviews = [];
        }
    }

    elements.uploadProfilePicture.addEventListener('click', () => elements.selectProfilePicture.click())
    elements.selectProfilePicture.addEventListener('change', handleProfileImage)
    elements.saveProfilePicture.addEventListener('click', handleUplaod)
}

setupProfileImageUploader();