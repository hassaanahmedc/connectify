/**
 * This file manages the entire workflow for uploading cover picture.
 * 
 * @summary this script handles user interaction for cover picture upload.
 * It listens for click on 'upload-cover-picture' button and triggers the file input.
 * Validates the selected files, then dispatches events to the global image preview modal
 * to display the image or erros if validation failed.
 * Then finally it makes API request to the server to update the file. 
 */

import { API_ENDPOINTS } from "../../config/constants";
import { 
    createImagePreviews, 
    prepareImages, 
    formatImageErrors, 
    uploadImages, 
    disableButton, 
    enableButton, 
    revokeImagePreviews
 } from '../../utils/imageUploader';

 function setupCoverimageUplaoder() {

    // A privatestate for this scpecifc function.
    let state = {
        filesToUpload: [],
        currentPreviews: [],
        errorsToDispatch: [],
    }

    // A central place to gather all DOM elements this script interacts with,
    let elements = {
        uploadCoverPicture: document.getElementById('upload-cover-picture'),
        selectCoverPicture: document.getElementById('select-cover-picture'),
        coverPicture: document.getElementById("cover-picture"),
        saveCoverPicture: document.getElementById('save-upload-button'),
        profileErrors: document.getElementById('profile-error'),
        previewContainer: document.getElementById('image-upload-preview-container'),
        errorContainer: document.getElementById('error-container')
    }

    /**
     * Handles the change event from hidden file input.
     * This is the entry point for preview and validation logic,
     * It validates selected files and and dispatchs the event to UI.
     * @param {Event} - the file input change,
     * 
     */
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

    /**
     * Handles click event from 'Save' button from preview modal.
     * It takes validated file stored within the 'state', uploads it to the server.
     * and handles success and error responses by dispatching events,
     */
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

    // Ataches initial event listeners to the SOM elements.
    elements.uploadCoverPicture.addEventListener('click', () => elements.selectCoverPicture.click());
    elements.selectCoverPicture.addEventListener('change', handleCoverImage);
    elements.saveCoverPicture.addEventListener('click', handleUplaod);
 };

 setupCoverimageUplaoder();