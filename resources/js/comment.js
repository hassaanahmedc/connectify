const textarea = document.querySelector('.comment-textarea');
const postBtn = document.querySelector('.postButton');

textarea.addEventListener('input', function () {
    this.style.height = '31px'; // Reset height to auto
    this.style.height = `${Math.min(this.scrollHeight, 150)}px`; // Grow up to max height

    if (textarea.value.trim() !== '') {
        postBtn.disabled = false;
        postBtn.classList.remove('text-gray-400');
        postBtn.classList.add('text-lightMode-blueHighlight');
    } else {
        postBtn.disabled = true;
        postBtn.classList.remove('text-lightMode-blueHighlight');
        postBtn.classList.add('text-gray-400');
    };

});

