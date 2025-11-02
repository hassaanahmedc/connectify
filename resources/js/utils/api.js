import { CSRF_TOKEN } from "../config/constants"

export async function fetchData(url, options = {}) {
    const defaultHeaders = {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': CSRF_TOKEN,
    };

    const headers = {
        ...defaultHeaders,
        ...(options.headers || {}),
    };

    // Only set content-type for non-FormData bodies
    if (!(options.body instanceof FormData)) {
        headers['Content-Type'] = 'application/json';
    }

    const response = await fetch(url, {
        credentials: 'include',
        ...options,
        headers,
    });

    if (!response.ok) {
        console.error('fetchData error:', {
            status: response.status,
            statusText: response.statusText,
            url,
        });
        throw new Error(`HTTP error! Status: ${response.status}`);
    }
    
    const contentType = response.headers.get('content-type');
    if (contentType && contentType.includes('application/json')) {
        return response.json();
    } else {
        return response.text(); // fallback for HTML
    }
}