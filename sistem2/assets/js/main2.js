document.getElementById('generateButton').addEventListener('click', async function () {
    const id = document.getElementById('id').value;
    if (!id) {
        alert("Masukkan ID checkout.");
        return;
    }

    // Kirim permintaan AJAX ke server
    const response = await fetch('getResi.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&ajax=true`
    });

    const data = await response.json();

    if (data.resi) {
        document.querySelector('.demo').innerText = `Nomor Resi: ${data.resi}`;
        // Simpan tombol jika perlu
    } else {
        alert(data.message);
    }
});

document.getElementById('saveButton').addEventListener('click', async function () {
    const resi = document.querySelector('.demo').innerText.split(": ")[1];
    const id = document.getElementById('id').value;

    if (!resi || !id) {
        alert("Nomor resi belum dihasilkan.");
        return;
    }

    // Kirim permintaan penyimpanan
    const response = await fetch('saveResi.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&resi=${resi}`
    });

    const data = await response.json();
    alert(data.message);
});

