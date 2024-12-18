let shippingCost = 0; // Biaya pengiriman

// Mengambil harga produk dari DOM dan menyimpannya dalam objek
const productPrices = {};
document.querySelectorAll('.counter-container').forEach(container => {
    const row = container.closest('tr');
    const productId = row.querySelector(".number").id.replace('count', '');
    const priceText = row.querySelector('td:nth-child(4) span').textContent; // Ambil harga dari elemen span
    const price = parseInt(priceText.replace(/[^0-9]/g, '')); // Menghapus karakter non-numeric
    productPrices[productId] = price; // Simpan ke dalam objek
});



function updateTotalPrice() {
    const subtotalElement = document.querySelector(".checkout span:nth-child(2)");
    const feeElement = document.querySelector(".checkout span:nth-child(4)");
    const totalElement = document.querySelector(".checkout span:nth-child(6)");

    let subtotal = 0;
    for (let id in productPrices) {
        const count = parseInt(document.getElementById(`count${id}`).textContent) || 0;
        subtotal += productPrices[id] * count;
    }

    // let subtotal = 0;
    // counts.forEach((count, index) => {
    //     const productId = index + 1; // Asumsi ID produk dimulai dari 1
    //     subtotal += count * (productPrices[productId] || 0); // Ambil harga dari productPrices
    // });


    const total = subtotal + shippingCost;

    subtotalElement.textContent = `Rp ${subtotal.toLocaleString()}`;
    feeElement.textContent = `Rp ${shippingCost.toLocaleString()}`;
    totalElement.textContent = `Rp ${total.toLocaleString()}`;
}

function increment(id) {
    const countElement = document.getElementById(`count${id}`);
    let count = parseInt(countElement.textContent) || 0;
    count++;
    countElement.textContent = count;
    updateTotalPrice();
}

function decrement(id) {
    const countElement = document.getElementById(`count${id}`);
    let count = parseInt(countElement.textContent) || 0;
    if (count > 0) { 
        count--;
        countElement.textContent = count;
        updateTotalPrice();
    }
}

// Mengatur biaya pengiriman berdasarkan metode pengiriman yang dipilih
function setPriceShipping() {
    const selectedShipping = document.querySelector('input[name="shippingMethod"]:checked');
    if (selectedShipping) {
        const method = selectedShipping.value;
        if (method === "Same-Day") {
            shippingCost = 20000;
        } else if (method === "Express") {
            shippingCost = 15000;
        } else if (method === "Longer") {
            shippingCost = 5000;
        }
    } else {
        shippingCost = 0;
    }
    updateTotalPrice();
}

// Daftarkan event listener untuk setiap opsi pengiriman
document.querySelectorAll('input[name="shippingMethod"]').forEach(option => {
    option.addEventListener("change", setPriceShipping);
});

// Validasi dan kirim data checkout
function validateCheckout() {
    const nameInput = document.querySelector("input[name='name']");
    const numberInput = document.querySelector("input[name='number']");
    const addressInput = document.querySelector("input[name='address']");
    if (nameInput.value && numberInput.value && addressInput.value) {
        alert("Checkout berhasil! Melanjutkan ke halaman pembayaran.");
    } else {
        alert("Silakan lengkapi semua informasi sebelum checkout.");
    }
}

document.querySelector(".co").addEventListener("click", validateCheckout);

// Inisialisasi total harga saat halaman dimuat
updateTotalPrice();

async function setShippingMethod() {
    // Memastikan hanya satu checkbox yang dipilih
    const shippingOptions = document.querySelectorAll('input[name="shippingMethod"]:checked');
    if (shippingOptions.length !== 1) {
        alert("Pilih satu metode pengiriman.");
        return;
    }

    const shippingMethod = shippingOptions[0].value;

    // Membuat permintaan SOAP dalam bentuk XML
    const soapRequest = `
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://localhost/sistem1/servers/server.php">
            <soapenv:Header/>
            <soapenv:Body>
                <ser:setShippingMethod>
                    <shippingMethod>${shippingMethod}</shippingMethod>
                </ser:setShippingMethod>
            </soapenv:Body>
        </soapenv:Envelope>
    `;

    try {
        // Mengirimkan permintaan SOAP ke server.php
        const response = await fetch("/sistem1/servers/server.php", {
            method: "POST",
            headers: {
                "Content-Type": "text/xml"
            },
            body: soapRequest
        });

        if (!response.ok) throw new Error("Gagal mengatur metode pengiriman.");

        const responseText = await response.text();

        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(responseText, "text/xml");

        const returnValue = xmlDoc.getElementsByTagName("return")[0].textContent;
        
        // Menampilkan pesan sukses atau hasil response dari SOAP
        document.getElementById("result").textContent = returnValue;
    } catch (error) {
        console.error("Error:", error);
        document.getElementById("result").textContent = "Terjadi kesalahan saat mengatur metode pengiriman.";
    }
}

document.querySelector('#submitCheckout').addEventListener('click', function () {
    validateCheckout();
    // Collect counts
    const counts = [];
    const productCounts = {};
    let subtotal = 0;

    document.querySelectorAll(".counter-container .number").forEach((element) => {
        const count = parseInt(element.textContent) || 0;
        counts.push(count);

        const productId = element.id.replace('count', ''); // Ambil ID produk dari elemen
        productCounts[`count${productId}`] = count; // Simpan dalam format dinamis
        subtotal += count * (productPrices[productId] || 0); // Hitung subtotal
    });

    const shippingMethod = document.querySelector('input[name="shippingMethod"]:checked')?.value || "Unknown";
    const total = subtotal + shippingCost;

    const name = document.getElementById('nameInput').value;
    const number = document.getElementById('numberInput').value;
    const address = document.getElementById('addressInput').value;

    // Gabungkan semua data
    const data = {
        ...productCounts, // Tambahkan data jumlah produk secara dinamis
        shippingMethod,
        subtotal,
        total,
        name,
        number,
        address,
    };

    // Log data sebelum dikirim untuk debugging
    console.log('Data to send:', data);
    console.log('Data prepared to send:', JSON.stringify(data, null, 2));

    // Send data to saveCheckout.php
    fetch('saveCheckout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((responseData) => {
            console.log('Data sent successfully:', responseData);
            alert(responseData.id);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
});
