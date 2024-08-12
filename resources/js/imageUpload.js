document.addEventListener('DOMContentLoaded', () => {
    const fileInputs = document.querySelectorAll('.fileInput');
    const imagePreviews = document.querySelectorAll('.imgPreview');
    const imageSelectorSvgs = document.querySelectorAll('.imageSelectorSvg');

    function previewImg(event, previewElement) {
        previewElement.innerHTML = "";  // Clear any existing preview images
        const files = event.target.files;

        for (let file of files) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('aspect-square', 'object-cover', 'rounded-2xl', 'h-2/4');
                previewElement.appendChild(img);  // Append to the specific preview element
            };
            reader.readAsDataURL(file);
        }
    }

    imageSelectorSvgs.forEach((imageSelectorSvg, index) => {
        if (fileInputs[index]) {
            imageSelectorSvg.addEventListener('click', () => {
                fileInputs[index].click();
            });
        } else {
            console.error(`No matching fileInput for imageSelectorSvg at index ${index}`);
        }
    });

    fileInputs.forEach((fileInput, index) => {
        if (imagePreviews[index]) {
            fileInput.addEventListener('change', (event) => {
                previewImg(event, imagePreviews[index]);  // Pass the correct preview element
            });
        } else {
            console.error(`No matching imagePreview for fileInput at index ${index}`);
        }
    });
});
