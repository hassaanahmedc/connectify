import { CSRF_TOKEN } from "../config/constants"

export async function fetchData(url, options = {}) {
    const headers = {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': CSRF_TOKEN,
        ...options.headers,
    };

    // Only set content-type for non-FormData bodies
    if (!(options.body instanceof FormData)) {
        headers['Content-Type'] = 'application/json';
    }

    const response = await fetch(url, {
        headers,
        credentials: 'include',
        ...options,
    });

    const text = await response.text();
    console.log('fetchData raw response:', { status: response.status, text });

    if (!response.ok) {
        console.error('fetchData error:', {
            status: response.status,
            statusText: response.statusText,
            responseText: text,
        });
        throw new Error(`HTTP error! Status: ${response.status}, Response: ${text}`);
    }

    try {
        return JSON.parse(text);
    } catch (error) {
        console.error('JSON parse error:', error, { responseText: text });
        throw error;
    }
}