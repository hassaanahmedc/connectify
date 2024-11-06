// Select all like buttons
const likeButtons = document.querySelectorAll('.like-btn');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Function to handle like/unlike post
const likePost = async function () {
    const postId = this.dataset.postId;
    const userId = this.dataset.userId;
    const likeCount = this.querySelector('.like-count'); // No need to use closest() here
    const likeIcon = this.querySelector('.like-icon');
    
    try {
        const response = await fetch(`/post/${postId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'credentials' : 'include',
                'X-CSRF-TOKEN' : csrfToken,
            },
            body: JSON.stringify({
                posts_id: postId,
                user_id: userId,
            }),
        });

        const result = await response.json();

        // Toggle the 'liked' state
        if (result.liked) {
            likeCount.textContent = parseInt(likeCount.textContent) + 1;
            likeIcon.classList.remove('default-svg-color');
            likeIcon.classList.add('liked-icon');
        } else {
            likeCount.textContent = parseInt(likeCount.textContent) - 1;
            likeIcon.classList.remove('liked-icon');
            likeIcon.classList.add('default-svg-color');
        }
    } catch (error) {
        console.log('An error occurred', error);
    }
};

likeButtons.forEach(button => {
    button.addEventListener('click', likePost); 
});
