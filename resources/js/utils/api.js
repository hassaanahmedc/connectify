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

    const contentType = response.headers.get('content-type');
    let data;
    if(contentType && contentType.includes('application/json')) {
        data = await response.json();
    } else {
        data = await response.text();
    }

    if (!response.ok) {
        console.error('fetchData error:', { status: response.status, data });

        return {
            success: false,
            status: response.status,
            errors: data.errors || null,
            message: data.message || `Error ${response.status}`
        }
    }
    return { success: true, ...data };
}