document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('fileInput');
    const imagePreview = document.getElementById('imgPreview');
    const imageSelectorSvg = document.getElementById('imageSelectorSvg');

    function previewImg(event) {
        imagePreview.innerHTML = "";
        const files = event.target.files;

        for (let file of files) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('w-full', 'aspect-square', 'object-cover', 'rounded-2xl');
                imagePreview.appendChild(img);
            }
            reader.readAsDataURL(file)
        }
    }
    imageSelectorSvg.addEventListener('click', () => {
        fileInput.click();
    })  
    fileInput.addEventListener('change', previewImg)

})