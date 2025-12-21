import { API_ENDPOINTS } from '../../config/constants';
import { 
    createImagePreviews, 
    prepareImages, formatImageErrors, 
    uploadImages, 
    displayAlerts, 
    disableButton, 
    enableButton, 
    revokeImagePreviews
 } from '../../utils/imageUploader';

const deleteProfilePicture = document.getElementById('delete-profile-picture');
const viewProfilePicture = document.getElementById('view-profile-picture');
const profilePreview = document.getElementById('upload-profile-preview');

function setupProfileImageUploader() {
    let state = {
        filesToUpload: [],
        currentPreviews: []
    }

    const elements = {
        uploadProfilePicture: document.getElementById('upload-profile-picture'),
        selectProfilePicture: document.getElementById('select-profile-picture'),
        profilePicture: document.getElementById("profile-picture"),
        saveProfilePicture: document.getElementById('save-profile-picture'),
        profileErrors: document.getElementById('profile-error'),
        tryAgainButton: document.getElementById('try-again-button'),
        previewContainer: document.getElementById('preview-container'),
        errorContainer: document.getElementById('error-container')
    }

    function handleProfileImage(e) {
        if (state.currentPreviews.length > 0) {
            revokeImagePreviews(state.currentPreviews);
        }
        const files = Array.from(e.target.files || []);
        const {validatedImages, errors} = prepareImages(files);
        
        if (errors.length > 0) {
            elements.previewContainer.classList.add('hidden')
            elements.errorContainer.classList.remove('hidden')

            const formattedErrorMessages = formatImageErrors(errors)
            displayAlerts(elements.profileErrors, formattedErrorMessages, 'error')
            disableButton(elements.saveProfilePicture, 'save')

            state.filesToUpload = [];
            state.currentPreviews = [];
        } else {
            elements.previewContainer.classList.remove('hidden')
            elements.errorContainer.classList.add('hidden')

            state.filesToUpload = validatedImages;
            state.currentPreviews = createImagePreviews(validatedImages);
            enableButton(elements.saveProfilePicture, 'Save')

        }
        window.dispatchEvent(new CustomEvent('profile-image-selected', {
            detail: { previewImage: state.currentPreviews }
        }));
    }

    async function handleUplaod() {
        if (state.filesToUpload.length === 0) return;

        disableButton(elements.saveProfilePicture, 'Saving...')
        try {
            const result = await uploadImages(state.filesToUpload, API_ENDPOINTS.uploadProfilePictureReq);
            if (result.ok) {
                elements.profilePicture.src = result.data;
                window.dispatchEvent(new CustomEvent("close-profile-modal"));
            } else {
                const errorMessages = results.error ? formattedErrorMessages([result.error]) : ['Upload failed, Please try again.']
                displayAlerts(elements.profileErrors, errorMessages, 'error');
            }
        } catch (error) {
            displayAlerts(elements.profileErrors, ['A network error occured, Please try again.'], 'error')
            console.error("Upload failed: ", error)
        } finally {
            enableButton(elements.saveProfilePicture, 'Save')
            if (state.currentPreviews.length > 0) {
                revokeImagePreviews(state.currentPreviews)
            }
            state.filesToUpload = []
            state.currentPreviews = [];
        }
    }
    
    elements.uploadProfilePicture.addEventListener('click', () => elements.selectProfilePicture.click() )
    elements.tryAgainButton.addEventListener('click', () => elements.selectProfilePicture.click())
    elements.selectProfilePicture.addEventListener('change', handleProfileImage)
    elements.saveProfilePicture.addEventListener('click', handleUplaod )
}

setupProfileImageUploader();