const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

export async function fetchData(url, options = {}) {

    const response = await fetch(url, {
        headers: {
            "content-type" : "application/json",
            "X-CSRF-TOKEN" : CSRF_TOKEN,
        },
        credentials : "include",
        ...options,
    });
    if(!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
    return response.json();
}