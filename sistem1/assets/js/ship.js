        let count = 0;
        let basePrice = 150000;  // Harga per item
        let shippingCost = 0;    // Biaya pengiriman
    
        function updateTotalPrice() {
            const totalElement = document.querySelector(".checkout span:nth-child(6)");
            const subtotalElement = document.querySelector(".checkout span:nth-child(2)");
            const feeElement = document.querySelector(".checkout span:nth-child(4)");
            
            const count1 = parseInt(document.getElementById("count1").textContent);
            const count2 = parseInt(document.getElementById("count2").textContent);
            const count3 = parseInt(document.getElementById("count3").textContent);

            const subtotal = (basePrice * count1) + (basePrice * count2) + (basePrice * count3) ;
            const total = subtotal + shippingCost;
            
            subtotalElement.textContent = `Rp${subtotal.toLocaleString()}`;
            feeElement.textContent = `Rp${shippingCost.toLocaleString()}`;
            totalElement.textContent = `Rp${total.toLocaleString()}`;
        }
    
        function increment(id) {
            const countElement = document.getElementById(`count${id}`);
            let count = parseInt(countElement.textContent)
            count++;
            countElement.textContent = count;
            updateTotalPrice();
        }
        
      
        function decrement(id) {
            const countElement = document.getElementById(`count${id}`);
            let count = parseInt(countElement.textContent);
            if (count > 0) {  // Minimum quantity 1
                count--;
                countElement.textContent = count;
                updateTotalPrice();
            }
        }
    
        // Mendapatkan pilihan metode pengiriman dan menampilkan biayanya
        // const shippingOptions = document.querySelectorAll(".ship_desc2 input[type='checkbox']");
        // shippingOptions.forEach(option => {
        //     option.addEventListener("change", function() {
        //         // Hanya satu checkbox yang dapat dipilih
        //         shippingOptions.forEach(opt => {
        //             if (opt !== this) opt.checked = false;
        //         });
                
        //         if (this.checked) {
        //             shippingCost = parseInt(this.nextElementSibling.textContent.replace(/Rp|,|\./g, ''));
        //         } else {
        //             shippingCost = 0;
        //         }
        //         updateTotalPrice();
        //     });
        // });


    
        // Fungsi validasi untuk memastikan semua field terisi sebelum checkout
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

        function setPriceShipping(){
            const selectedShipping = document.querySelector('input[name="shippingMethod"]:checked');
            if (selectedShipping){
                const method = selectedShipping.value;
                if (method === "Same-Day") {
                    shippingCost = 20000;
                } else if (method === "Express") {
                    shippingCost = 15000;
                } else if (method === "Longer") {
                    shippingCost = 5000;
                }
                updateTotalPrice();
            } else {
                    alert("Please select a shipping method.");
            }
        }

            const shippingOptions = document.querySelectorAll('input[name="shippingMethod"]');
            shippingOptions.forEach(option => {
                option.addEventListener("change", setPriceShipping); // Memanggil setShippingMethod saat checkbox berubah
            });

            // Inisialisasi total harga saat halaman dimuat
            updateTotalPrice();

            document.querySelector('#submitCheckout').addEventListener('click', function() {
                // Collect values
                const count1 = parseInt(document.getElementById("count1").textContent);
                const count2 = parseInt(document.getElementById("count2").textContent);
                const count3 = parseInt(document.getElementById("count3").textContent);
            
                const shippingMethod = document.querySelector('input[name="shippingMethod"]:checked')?.value || 'Standard';
                const subtotal = (basePrice * count1) + (basePrice * count2) + (basePrice * count3);
                const total = subtotal + shippingCost;
                
                // Collect additional data
                const name = document.getElementById('nameInput').value;
                const number = document.getElementById('numberInput').value;
                const address = document.getElementById('addressInput').value;
            
                // Prepare data for POST request
                const data = {
                    count1,
                    count2,
                    count3,
                    shippingMethod,
                    subtotal,
                    total,
                    name,
                    number,
                    address
                };
            
                // Send data to checkout.php using POST request
                fetch('getCheckout.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data), // Send data as JSON
                })
                .then(response => response.json())
                .then(data => {
                    // Handle response from server (optional)
                    console.log('Success:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
            