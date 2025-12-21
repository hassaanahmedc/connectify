export const API_ENDPOINTS = {
  // comments
  createComment: (postId) => `/post/${postId}/comment`,
  loadComments: (postId, offset) =>`/post/${postId}/viewcomments?offset=${offset}&limit=10`,
  deleteComment: (commentId) => `/post/${commentId}/delete`,
  updateComment: (commentId) => `/post/${commentId}/update`,
  // post
  likePost: (postId) => `/post/${postId}/like`,
  followUser : (userId) => `/user/${userId}/follow`,
  // user profile
  uploadProfilePictureReq: `/profile/upload-picture`
};

export const state = {
  query: '',
  filters: [],
  results: [],
  activeState: '',
  isLoading: false,
  error: null,
}

export const searchFilters = ['all', 'users', 'posts', 'near'];
export const IMAGE_ALLOWED_TYPES = ["image/jpeg", "image/png", "image/webp"]
export const IMAGE_MAX_SIZE = 5 * 1024 * 1024;
export const IMAGE_MAX_COUNT = 10;
export const QUERY_MIN_LENGTH = 2;
export const SEARCH_ROUTE = "/search/results";
export const CACHE_LIMIT = 50;
export const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');