import { timeAgo } from "./formatters";
import { escapeHtml } from "./formatters";

export function generateCommentHtml(comment) {
    return `
    <div class="py-2" data-comment-id="${comment.id}" x-data="{ showDeleteModal: false }">
        <div class="flex gap-2">
            <div class="w-8 h-8 flex-shrink-0">
                <img src="https://placewaifu.com/image/200" class="bg-gray-200 rounded-full object-cover w-full h-full" loading="lazy" alt="">
            </div>
            <div class="group relative bg-gray-100 flex-1 rounded-lg px-3 py-2">
                <span class="text-sm font-bold">${comment.user.fname} ${comment.user.lname}</span>
                
                <!-- Comment content display -->
                <div class="comment-container">
                    <span class="text-sm comment-content">${comment.content || ""}</span>
                    
                    <!-- Inline edit form (hidden by default) -->
                    <div class="edit-form mt-1" style="display: none;">
                        <textarea id="content-${comment.id}" class="w-full p-1 border rounded-md text-sm">${comment.content || ""}</textarea>
                        <div class="flex justify-end mt-1 space-x-2">
                            <button type="button" 
                                class="cancel-edit-btn text-xs px-2 py-1 bg-gray-200 rounded hover:bg-gray-300"
                                data-comment-id="${comment.id}">
                                Cancel
                            </button>
                            <button type="button" 
                                class="save-comment-btn text-xs px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700"
                                data-comment-id="${comment.id}">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500 mt-2">${timeAgo(comment.created_at)}</span>
                    <div class="relative">
                        <img src="${window.threeDotsSvg}" class="cursor-pointer rotate-90 hidden group-hover:block three-dots" data-comment-id="${comment.id}" alt="">
                        <ul class="comment-menu hidden w-max flex flex-col absolute right-0 top-0 bg-white shadow-2xl rounded-md z-10">
                            ${comment.can_delete ? `
                                <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                    <button class="delete-comment-btn" data-comment-id="${comment.id}" @click="showDeleteModal = true">Delete Comment</button>
                                </li>
                            ` : ''}
                            ${comment.can_update ? `
                                <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                    <button class="edit-comment-btn" data-comment-id="${comment.id}">Edit Comment</button>
                                </li>
                            ` : ''}
                            <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                <a href="#" class="pin-comment-btn">Pin this comment</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Use the confirm-alert component for delete confirmation -->
        ${comment.can_delete ? `
        <div x-show="showDeleteModal" class="delete-comment-modal fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-4 rounded-md shadow-md">
                <p>Are you sure you want to delete this comment?</p>
                <div class="flex justify-between mt-4">
                    <button type="button"
                        data-comment-id="${comment.id}"
                        x-on:click="showDeleteModal = false"
                        class="confirm-delete-btn bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
                    <button x-on:click="showDeleteModal = false"
                        class="cancel-delete-btn bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
                </div>
            </div>
        </div>
        ` : ''}
    </div>
    `;
} 

export function generateSearchDropdownHtml(data) {
      return `
            <li>
                <a href="${escapeHtml(data.url ?? "#")}" class="flex gap-4 px-4 py-2 text-gray-500 hover:bg-lightMode-background">
                    <figure>
                        <img src="${data.avatar ?? "https://placewaifu.com/image/200"}" 
                            class="bg-gray-200 w-9 h-auto rounded-full object-cover">
                    </figure>
                    <div>
                        <div class="font-medium text-base">${escapeHtml(data.title ?? data.snipped ?? "")}</div>
                        <div class="text-xs text-gray-500">${escapeHtml(data.type ?? "")}</div>
                    </div>
                </a>
            </li>`;
}

export function generateLoadingHtml() {
    return `<li class="p-2 text-gray-500">Loading…</li>`;
}

export function generateNoResultsHtml() {
    return `<li class="p-2 text-gray-500">No results found</li>`;
}