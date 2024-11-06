let token = localStorage.getItem('authToken');

if (!token) {
    fetch('api/getToken', {
        method : 'GET',
        credentials: 'include',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        console.log('Token: ', data.token);
        localStorage.setItem('authToken', data.token);
    })

    .catch(error => console.error('Error:', error ));

} else {
    console.log('Using cached Token', token);
}