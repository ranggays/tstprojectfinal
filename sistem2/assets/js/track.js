
fetch('http://localhost/sistem2/service/api.php/tracking/check', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({ id: 1 }) // Kirim data dalam format URL-encoded
})
.then(response => response.json())
.then(data => {
    console.log('Response:', data);
})
.catch(error => console.error('Error:', error));
