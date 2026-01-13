import { API_ENDPOINTS } from "../../config/constants";
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

 function setupCoverimageUplaoder() {
    let state = {
        filesToUpload: [],
        currentPreviews: [],
        errorsToDispatch: [],
    }

    let elements = {
        uploadCoverPicture: document.getElementById('upload-cover-picture'),
        selectCoverPicture: document.getElementById('select-cover-picture'),
        coverPicture: document.getElementById("cover-picture"),
        saveCoverPicture: document.getElementById('save-upload-button'),
        profileErrors: document.getElementById('profile-error'),
        previewContainer: document.getElementById('image-upload-preview-container'),
        errorContainer: document.getElementById('error-container')
    }

    function handleCoverImage(e) {
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
                title: 'Upload Cover Picture',
                previewClass: 'w-full aspect-video',
                tryAgainId: 'try-again-button-cover',
            }
        }));

        window.dispatchEvent(new CustomEvent ('open-modal', { detail: 'image-upload-preview' } ));

        state.errorsToDispatch = [];
    }

    async function handleUplaod() {
        if (state.filesToUpload.length === 0) return;
        disableButton(elements.saveCoverPicture, 'Saving...')
        
        try {
            const result = await uploadImages(state.filesToUpload, API_ENDPOINTS.uploadCoverPictureReq, 'cover_photo');

            if (result.ok) {
                elements.coverPicture.src = result.data;

                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'image-upload-preview' }));
                window.dispatchEvent(new CustomEvent('show-notification', {
                    detail: { message: 'Profile picture updated!', type: 'success' }
                }));

            } else {
                const errorMessages = result.error ? formatImageErrors(
                    [result.error]) : ['Upload failed, Please try again.']

                window.dispatchEvent(new CustomEvent('open-image-preview', { 
                    detail: { 
                        previewUrl: state.currentPreviews,
                        profileErrors: errorMessages,
                        title: 'Upload Cover Picture',
                        previewClass: 'w-full aspect-video'
                    } }));
                console.log("try block error: ", result.error)
                enableButton(elements.saveCoverPicture)
            }

        } catch (error) {
            window.dispatchEvent(new CustomEvent('open-image-preview', {
                detail: { 
                    previewUrl: null,
                    profileErrors: ['A network error occured, Please try again.'],
                    title: 'Upload Cover Picture',
                    previewClass: 'w-full aspect-video'
                } }));
            console.log("try catch error: ", error)
        } finally {
            enableButton(elements.saveCoverPicture, 'Save')
            if (state.currentPreviews.length > 0) {
                revokeImagePreviews(state.currentPreviews)
            }
            state.filesToUpload = []
            state.currentPreviews = [];
        }
    }

    elements.uploadCoverPicture.addEventListener('click', () => elements.selectCoverPicture.click());
    elements.selectCoverPicture.addEventListener('change', handleCoverImage);
    elements.saveCoverPicture.addEventListener('click', handleUplaod);
 };

 setupCoverimageUplaoder();