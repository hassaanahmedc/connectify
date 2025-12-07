import { fetchData } from '../../utils/api';
import { IMAGE_ALLOWED_TYPES, IMAGE_MAX_SIZE, IMAGE_MAX_COUNT } from '../../config/constants';
const uploadProfilePicture = document.getElementById('upload-profile-picture');
const selectProfilePicture = document.getElementById('select-profile-picture');
const deleteProfilePicture = document.getElementById('delete-profile-picture');
const profilePicture = document.getElementById("profile-picture");
const saveProfilePicture = document.getElementById('save-profile-picture');
const viewProfilePicture = document.getElementById('view-profile-picture');
const profilePreview = document.getElementById('upload-profile-preview');
const profileErrors = document.getElementById('profile-error');

let currentValidatedFiles = [];
let currentPreviewUrls = [];
let currentErrors = [];

uploadProfilePicture.addEventListener('click', () => { selectProfilePicture.click() })

selectProfilePicture.addEventListener('change', (e) => {
    const files = Array.from(e.target.files || []);
    const {validatedImages, previewImage, errors} = prepareImages(files);
    
    window.dispatchEvent(new CustomEvent('profile-image-selected', {
        detail: { previewImage, errors }
    }));
    
    currentValidatedFiles = validatedImages;
    currentPreviewUrls = previewImage;
    currentErrors = errors;
    console.log(errors)
})

saveProfilePicture.addEventListener('click', async () => {
    if (!currentValidatedFiles.length) {
        alert('Please select an image')
        return;   
    }

    saveProfilePicture.disabled = true;
    saveProfilePicture.textContent = 'Saving...'

    if (currentValidatedFiles.length > 0) {
        const profileRequest = new FormData();
        currentValidatedFiles.forEach(img => { profileRequest.append('profile_picture', img) });

        try {
            const response = await fetchData('/profile/upload-picture', {
                method: "POST",
                body: profileRequest,
            });

            if (response.status === 'success') {
                profilePicture.src = response.path;
                window.dispatchEvent(new CustomEvent("close-profile-modal"));

                currentPreviewUrls.forEach(img => { URL.revokeObjectURL(img) })

                currentPreviewUrls = [];
                currentValidatedFiles = [];
                currentErrors = [];
                selectProfilePicture.value = '';
                saveProfilePicture.disabled = false;
                saveProfilePicture.textContent = 'Save';
                return;
            } 
            
            if (response.status === 'error') {
                alert('Upload failed, please try again!')
                saveProfilePicture.disabled = false;
                saveProfilePicture.textContent = 'Save';
            }

        } catch (error) {
            console.log('upload fail', error, currentErrors);
            SuccessOrErrorMessage(profileErrors, currentErrors.join(', '));
            saveProfilePicture.disabled = false;
            saveProfilePicture.textContent = 'Save';
        }
    }
}) 

function prepareImages(files) {
    let validatedImages = [];
    let previewImage = [];
    let errors = [];

    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        if (validatedImages.length >= IMAGE_MAX_COUNT) break;

        if (!IMAGE_ALLOWED_TYPES.includes(file.type)) {
            errors.push(`${file.name} is not a valid image type.`)
            continue;
        }

        if (file.size > IMAGE_MAX_SIZE) {
            errors.push(`Image should be under ${IMAGE_MAX_SIZE / (1024*1024)} MB` )
            continue;
        }

        validatedImages.push(file);
    }
    previewImage = validatedImages.map(img => URL.createObjectURL(img));

    return  {validatedImages, previewImage, errors};
}

function SuccessOrErrorMessage(el, msg) {
    const element = el;
    if (!element) return;
    const span = document.createElement('span'); 
    span.classList.add('bg-red-100', 'border', 'border-red-400', 'text-red-700', 'px-4', 'py-3', 'rounded', 'relative', 'z-10');
    element.innerHTML = msg;
    element.appendChild(span);
}