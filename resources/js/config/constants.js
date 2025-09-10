export const API_ENDPOINTS = {
  // comments
  createComment: (postId) => `/post/${postId}/comment`,
  loadComments: (postId, offset) =>`/post/${postId}/viewcomments?offset=${offset}&limit=10`,
  deleteComment: (commentId) => `/post/${commentId}/delete`,
  updateComment: (commentId) => `/post/${commentId}/update`,
  // post
  likePost: (postId) => `/post/${postId}/like`,
};

export const QUERY_MIN_LENGTH = 2;
export const SEARCH_ROUTE = "/search/results";
export const CACHE_LIMIT = 50;
export const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');