document.addEventListener('DOMContentLoaded', () => {
    const fileInputs = document.querySelectorAll('.fileInput');
    const imagePreviews = document.querySelectorAll('.imgPreview');
    const imageSelectorSvgs = document.querySelectorAll('.imageSelectorSvg');
    const editBtn = document.querySelectorAll('.editBtn');

    editBtn.forEach((trigger) => {
        trigger.addEventListener('click', () => {
          setTimeout(() => {
            renderPostImages(document.getElementById('imgPreview'));
          }, 100); // adjust the timeout value as needed
        });
      })

     function renderPostImages(previewElement) {
        previewElement.innerHTML = '';
        const postedImages = previewElement.closest('#post-form').querySelector('#postedImages') ? JSON.parse(previewElement.closest('#post-form').querySelector('#postedImages').value) : [];
        console.log('postedImages:', postedImages);
        console.log('previewElement:', previewElement);
        if (postedImages.length > 0) {
            postedImages.forEach(image => {
                const img = document.createElement('img');
                img.src = `/storage/${image.path}`;
                img.classList.add('aspect-square', 'object-cover', 'rounded-2xl', 'h-2/4');
                previewElement.appendChild(img);
            });
        }
    };

    function previewImg(event, previewElement) {
        previewElement.innerHTML = '';
        renderPostImages(previewElement)
        const files = event.target.files;
        for (let file of files) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('aspect-square', 'object-cover', 'rounded-2xl', 'h-2/4');
                previewElement.appendChild(img);
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
                previewImg(event, imagePreviews[index]);
            });
        } else {
            console.error(`No matching imagePreview for fileInput at index ${index}`);
        }
    });

});