import { fetchData } from './api';
import { IMAGE_ALLOWED_TYPES, IMAGE_MAX_SIZE, IMAGE_MAX_COUNT, state } from '../config/constants';

export const ErrorMessages = {
    NO_FILES: () => 'Please select at least one image.',
    INVALID_TYPE: (meta) => `${meta.fileName} is not a supported image type.`,
    TOO_LARGE: (meta) => `${meta.fileName} is too large (${meta.sizeMB}MB). Max ${meta.maxMB}MB.`,
    UPLOAD_FAILED: () => 'Upload failed. Please try again.',
    NETWORK: () => 'Network error. Check your connection.',
  };
  
export function prepareImages(files) {
    let validatedImages = [];
    let errors = [];

    if (!files || files.length === 0) {
        errors.push({ code: 'NO_FILE', meta: {} });
        return  {validatedImages, errors};
    }

    const maxMB = IMAGE_MAX_SIZE / (1024 * 1024);

    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        if (validatedImages.length >= IMAGE_MAX_COUNT) break;

        if (!IMAGE_ALLOWED_TYPES.includes(file.type)) {
            errors.push({ code: 'INVALID_TYPE', meta: { fileName: file.name, type: file.type} })
            continue;
        }
        const sizeMB = file.size / (1024 * 1024);

        if (sizeMB > maxMB) {
            errors.push({ 
                code: 'TOO_LARGE', 
                meta: { 
                    fileName: file.name, 
                    sizeMB: sizeMB.toFixed(2), 
                    maxMB: maxMB.toFixed(2) } })
            continue;
        }

        validatedImages.push(file);
    }

    return  {validatedImages, errors};
}

export async function uploadImages(files, route) {
    if (!files.length) {
        return ({ ok:false, error: { code: 'NO_FILE', meta: {} }});
    } 

    const profileRequest = new FormData();
    files.forEach(img => { profileRequest.append('profile_picture', img) });

    try {
        const response = await fetchData(route, {
            method: "POST",
            body: profileRequest,
        });

        if (response && response.status === 'success') return ({ ok: true, data: response.path })

        if (response.status === 'error') return ({ ok: false, error: { code: 'UPLOAD_FAILED', meta: { server: response }} })

    } catch (error) {
        return ({ ok: false, error: { code: 'NETWORK', meta: { message: error.message }} })
    }
}

export function displayAlerts(container, messages, style='error') {
    if (!container) {
        console.warn('displayAlerts: A valid container was not found');
        return;
    }

    container.innerHTML = '';

    if (!messages || messages.length === 0) return;

    const styleClasses = {
       error: 'bg-red-100 border border-red-400 text-red-700',
       success: 'bg-green-100 border border-green-400 text-green-700'
    };

    messages.forEach(msg => {
        const span = document.createElement('div');

        span.className = `px-4 py-3 rounded relative ${styleClasses[style]}`;
        span.textContent = msg;
        container.appendChild(span);
    })
}
export function formatImageErrors(errors) {
    if (!errors || errors.length === 0) return [];

    return errors.map(error => {
        const messageTemplate = ErrorMessages[error.code]
        if (messageTemplate) return messageTemplate(error.meta);
        return 'An unknown error occured.';
    });
}
export function enableButton(button, text = 'Save') {
    button.disabled = false;
    button.classList.remove('opacity-50', 'cursor-not-allowed')
    button.textContent = text;
} 

export function disableButton(button, text = 'Saving...') {
    button.disabled = true;
    button.classList.add('opacity-50', 'cursor-not-allowed')
    button.textContent = text;
} 

export function createImagePreviews(files) {
    return files.map(img => URL.createObjectURL(img));
}

export function revokeImagePreviews(files) {
    files.map(img => URL.revokeObjectURL(img));
}
