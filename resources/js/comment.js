const commentButton = document.querySelectorAll('.comment-btn');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.querySelectorAll('.comment-textarea').forEach(textarea => {
    textarea.addEventListener('input', function () {
        this.style.height = '31px';
        this.style.height = `${Math.min(this.scrollHeight, 150)}px`;

        const postId = this.dataset.postId;
        const commentButton = document.querySelector(`.comment-btn[data-post-id="${postId}"]`);

        if (this.value.trim() !== '') {
            commentButton.disabled = false;
            commentButton.classList.remove('text-gray-400');
            commentButton.classList.add('text-lightMode-blueHighlight');
        } else {
            commentButton.disabled = true;
            commentButton.classList.remove('text-lightMode-blueHighlight');
            commentButton.classList.add('text-gray-400');
        }
    });
});

const makeComment = async function () {
    const postId = this.dataset.postId;
    const userId = this.dataset.userId;
    const textarea = document.querySelector(`.comment-textarea[data-post-id="${postId}"]`);
    const commentCount = document.querySelector(`.comment-count[data-post-id="${postId}"]`);
    if (!textarea) {
        console.log(`Textarea for post ID ${postId} not found`);
        return;
    }

    console.log(`Tried to make a comment on post id: ${postId}`);

    try {
        const response = await fetch(`/post/${postId}/comment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            credentials: 'include',
            body: JSON.stringify({
                posts_id: postId,
                user_id: userId,
                content: textarea.value.trim(),
            }),
        });

        const result = await response.json();
        if (result.success) {
            commentCount.textContent = parseInt(commentCount.textContent) + 1;
            textarea.value = ''; // Clear textarea after posting
            // commentButton.forEach(button => {
            this.disabled = true;
            this.classList.remove('text-lightMode-blueHighlight');
            this.classList.add('text-gray-400');
            // });
        } else {
            console.log(result.error || 'Unable to comment');
        }
    } catch (error) {
        console.log('An error occurred', error);
    }
};

commentButton.forEach(button => {
    button.addEventListener('click', makeComment);
});

// const loadMoreComments = async function () {
//     try {
//         const response = await fetch(`/post/${postId}/viewcomments?offset=${offset}`);
//         const comments = await response.json();

        

//     } catch (error) {
//         console.log('An error occured', error);
//     }
// }