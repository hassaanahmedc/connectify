import { timeAgo } from "../timeAgo";

export function generateCommentHtml(comment) {
    return `
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
                                <img src="${window.threeDotsSvg}" 
                                    class="cursor-pointer rotate-90 hidden group-hover:block" 
                                    x-on:click="comment_menu = true" alt="">
                                <ul x-cloak x-show="comment_menu" @click.away="comment_menu = false" 
                                    class="w-max flex flex-col absolute right-0 top-0 bg-white shadow-2xl rounded-md z-10">
                                    ${comment.can_delete ? `
                                        <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                            <button class="deleteBtn" 
                                                    x-on:click.prevent="confirm_delete = true">Delete Comment</button>
                                            <div x-cloak x-show="confirm_delete" 
                                                class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                                                <div class="bg-white p-4 rounded-md shadow-md">
                                                    <p>Are you sure you want to delete this comment?</p>
                                                    <div class="flex justify-between mt-4">
                                                        <button type="button" data-comment-id="${comment.id}" 
                                                            @click="confirm_delete = false"
                                                            class="confirmDeleteBtn bg-red-500 text-white px-4 py-2 rounded-md">
                                                            Delete</button>
                                                        <button x-on:click="confirm_delete = false" 
                                                            class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    ` : ''}
                                    ${comment.can_update ? `
                                        <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
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
        `;
} 