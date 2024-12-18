
        function generateResi() {
            const button = document.getElementById('generateButton');
            const demo = document.querySelector('.demo');
            const checkoutId = document.getElementById('checkoutId').value;

            if (!checkoutId) {
                demo.innerText = "Silakan masukkan ID checkout.";
                return;
            }

            // Simulasi generate nomor resi
            const generatedResi = "RESI" + Math.floor(Math.random() * 1000000);

            // Tampilkan nomor resi
            demo.innerText = `Nomor Resi: ${generatedResi}`;

            // Ubah tombol menjadi "Simpan"
            button.innerText = "Simpan";
            button.onclick = function () {
                saveResi(generatedResi, checkoutId);
            };
        }

        function saveResi(resi, id) {
            // Simulasi penyimpanan data ke database
            alert(`Nomor resi ${resi} untuk ID ${id} berhasil disimpan.`);
            // Reset form
            document.getElementById('resiForm').reset();
            document.querySelector('.demo').innerText = '';
            const button = document.getElementById('generateButton');
            button.innerText = "Generate";
            button.onclick = generateResi;
        }
        
        