import { timeAgo } from "./timeAgo";

const commentButton = document.querySelectorAll(".comment-btn");

const loadMoreCommentsBtn = document.querySelectorAll(".load-more-comments");
const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

document.querySelectorAll(".comment-textarea").forEach((textarea) => {
    textarea.addEventListener("input", function () {
        this.style.height = "31px";
        this.style.height = `${Math.min(this.scrollHeight, 150)}px`;

        const postId = this.dataset.postId;
        const commentButton = document.querySelector(
            `.comment-btn[data-post-id="${postId}"]`
        );

        if (this.value.trim() !== "") {
            commentButton.disabled = false;
            commentButton.classList.remove("text-gray-400");
            commentButton.classList.add("text-lightMode-blueHighlight");
        } else {
            commentButton.disabled = true;
            commentButton.classList.remove("text-lightMode-blueHighlight");
            commentButton.classList.add("text-gray-400");
        }
    });
});

const makeComment = async function (event) {
    const button = event.target;
    const postId = this.dataset.postId;
    const userId = this.dataset.userId;
    const textarea = document.querySelector(`.comment-textarea[data-post-id="${postId}"]`);
    const commentCount = document.querySelector(`.comment-count[data-post-id="${postId}"]`);

    const content = textarea.value.trim();
    if (!content) return;

    try {
        const response = await fetch(`/post/${postId}/comment`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            credentials: "include",
            body: JSON.stringify({
                posts_id: postId,
                user_id: userId,
                content: textarea.value.trim(),
            }),
        });

        const data = await response.json();
        if (!data || !data.comment) {
            console.log(data.error || 'unable to comment');
            button.disabled = false;
            button.classList.remove("text-gray-400");
            button.classList.add("text-lightMode-blueHighlight");
            return;
        };

        const comment = data.comment;
        commentCount.textContent = parseInt(commentCount.textContent) + 1;
        textarea.value = "";

        const commentsContainer = document.querySelector(`.comments-container[data-post-id="${postId}"]`);
        commentsContainer.insertAdjacentHTML('beforeend', `
            <div class="py-2" data-commentId="${comment.id}">
                <div class="flex gap-2">
                    <div class="w-8 h-8 flex-shrink-0">
                        <img src="https://placewaifu.com/image/200" 
                            class="bg-gray-200 rounded-full object-cover w-full h-full" loading="lazy" alt="">
                    </div>
                    <div class="group relative bg-gray-100 flex-1 rounded-lg px-3 py-2">
                        <span class="text-sm font-bold">${comment.user.fname} ${comment.user.lname}</span>
                        <span class="text-sm">${comment.content}</span>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500 mt-2">${timeAgo(comment.created_at)}</span>
                            <div x-data="{ comment_menu: false, edit_comment: false, confirm_delete: false }" 
                                class="relative">
                                <img src="${window.threeDotsSvg}" class="cursor-pointer rotate-90 hidden group-hover:block"
                                    x-on:click="comment_menu = true" alt="">
                                <ul x-cloak x-show="comment_menu" @click.away="comment_menu = false"
                                    class="w-max flex flex-col absolute right-0 top-0 bg-white shadow-2xl rounded-md z-10">
                                    ${comment.can_delete ? `
                                        <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                            <button class="deleteBtn" x-on:click.prevent="confirm_delete = true">
                                                Delete Comment</button>   
                                            <div x-cloak x-show="confirm_delete" 
                                                class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                                                <div class="bg-white p-4 rounded-md shadow-md">
                                                    <p>Are you sure you want to delete this comment?</p>
                                                    <div class="flex justify-between mt-4">
                                                        <button type="button" data-comment-id="${comment.id}" @click="confirm_delete = false"
                                                            class="confirmDeleteBtn bg-red-500 text-white px-4 py-2 rounded-md">
                                                            Delete</button>
                                                        <button x-on:click="confirm_delete = false" 
                                                        class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    `: ''}  
                                    ${comment.can_update ? `
                                        <li class="editBtn py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                            <a href="#" id="editBtn" x-on:click.prevent="edit_comment = true">Edit Comment</a>
                                        </li>
                                    ` : ''}
                                    <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                        <a href="#" x-on:click="edit_comment = false">Pin this comment</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);
        button.disabled = false;
        button.classList.remove("text-gray-400");
        button.classList.add("text-lightMode-blueHighlight");

    } catch (error) {
        console.log("An error occurred", error);
        button.disabled = false;
        button.classList.remove("text-gray-400");
        button.classList.add("text-lightMode-blueHighlight");
    }
};

document.querySelectorAll('.comment-btn').forEach(button => {
    button.addEventListener("click", makeComment);
});

const loadMoreComments = async function () {
    const postId = this.dataset.postId;
    let offset = parseInt(this.dataset.offset, 10);

    try {
        const response = await fetch(`/post/${postId}/viewcomments?offset=${offset}`);
        const data = await response.json();
        const comments = data.success;
        const hasMoreComments = data.hasMoreComments;
        if (comments.length > 0) {
            const commentsContainer = document.querySelector(`.comments-container[data-post-id="${postId}"]`);
            comments.forEach((comment) => {
                commentsContainer.insertAdjacentHTML('beforeend', `
                    <div class="py-2" data-commentId="${comment.id}">
                        <div class="flex gap-2">
                            <div class="w-8 h-8 flex-shrink-0">
                                <img src="https://placewaifu.com/image/200" 
                                    class="bg-gray-200 rounded-full object-cover w-full h-full" loading="lazy" alt="">
                            </div>
                            <div class="group relative bg-gray-100 flex-1 rounded-lg px-3 py-2">
                                <span class="text-sm font-bold">${comment.user.fname} ${comment.user.lname}</span>
                                <span class="text-sm">${comment.content}</span>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500 mt-2">${timeAgo(comment.created_at)}</span>
                                    <div x-data="{ comment_menu: false, edit_comment: false, confirm_delete: false }" 
                                        class="relative">
                                        <img src="${window.threeDotsSvg}" class="cursor-pointer rotate-90 hidden group-hover:block"
                                            x-on:click="comment_menu = true" alt="">
                                        <ul x-cloak x-show="comment_menu" @click.away="comment_menu = false"
                                            class="w-max flex flex-col absolute right-0 top-0 bg-white shadow-2xl rounded-md z-10">
                                            ${comment.can_delete ? `
                                                <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                                    <button class="deleteBtn" x-on:click.prevent="confirm_delete = true">
                                                        Delete Comment</button>   
                                                    <div x-cloak x-show="confirm_delete" 
                                                        class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                                                        <div class="bg-white p-4 rounded-md shadow-md">
                                                            <p>Are you sure you want to delete this comment?</p>
                                                            <div class="flex justify-between mt-4">
                                                                <button type="button" data-comment-id="${comment.id}" @click="confirm_delete = false"
                                                                    class="confirmDeleteBtn bg-red-500 text-white px-4 py-2 rounded-md">
                                                                    Delete</button>
                                                                <button x-on:click="confirm_delete = false" 
                                                                class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            `: ''}  
                                            ${comment.can_update ? `
                                                <li class="editBtn py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                                    <a href="#" id="editBtn" x-on:click.prevent="edit_comment = true">Edit Comment</a>
                                                </li>
                                            ` : ''}
                                            <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                                <a href="#" x-on:click="edit_comment = false">Pin this comment</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);

            });
            this.dataset.offset = offset + comments.length;
            if (!hasMoreComments) {
                this.style.display = "none";
            }
        } else {
            console.log(comments.error || "No more Commetns to laod");
        }
    } catch (error) {
        console.log("An error occured", error);
    }
};

loadMoreCommentsBtn.forEach((button) => {
    button.addEventListener("click", loadMoreComments);
});

document.addEventListener("DOMContentLoaded", () => {
    document.body.addEventListener("click", async (event) => {
        const button = event.target.closest(".confirmDeleteBtn");
        if (!button || !button.dataset.commentId) return;

        try {
            const response = await fetch(
                `/post/${button.dataset.commentId}/delete`,
                {
                    method: "DELETE",
                    headers: {
                        "content-type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    credentials: "include",
                }
            );

            const data = await response.json();
            if (!response.ok || !data.success) {
                console.log("Failed to delete comment:", data.error || response.status);
                return;
            }

            const commentElement = document.querySelector(`[data-commentId="${button.dataset.commentId}"]`);
            if (commentElement) {
                const postId = commentElement.closest(".comments-container")?.dataset.postId;
                if (postId) {
                    const count = document.querySelector(`.comment-count[data-post-id="${postId}"]`);
                    if (count) count.textContent = Math.max(0, parseInt(count.textContent) - 1);
                }
                commentElement.remove();
            }
        } catch (error) {
            console.error("Error deleting comment:", error);
        }
    });
});
