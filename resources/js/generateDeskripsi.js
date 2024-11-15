"use strict";

document.addEventListener("livewire:init", () => {
    Livewire.on("generateDeskripsi", (nilaiData) => {
        const data = JSON.parse(nilaiData);

        // Modifikasi data dengan menambahkan properti
        const modifiedData = data.map((siswa) => {
            // Reset deskripsi_tertinggi dan deskripsi_terendah pada setiap siswa
            let deskripsiTertinggi = [];
            let deskripsiTerendah = [];
            // Loop pada setiap item di array detail
            siswa.detail.forEach((detail) => {
                if (detail.tampil === 1) {
                    if (detail.kktp == true) {
                        // Tambahkan ke deskripsi_tertinggi
                        deskripsiTertinggi.push(
                            detail.tujuan_pembelajaran_deksripsi
                        );
                    } else if (detail.kktp === 0) {
                        // Tambahkan ke deskripsi_terendah
                        deskripsiTerendah.push(
                            detail.tujuan_pembelajaran_deksripsi
                        );
                    }
                } else {
                    // Jika tampil adalah false, hapus tujuan_pembelajaran_deksripsi dari deskripsi
                    detail.tujuan_pembelajaran_deksripsi = "";
                }
            });

            // Gabungkan deskripsi dengan tanda koma
            siswa.deskripsi_tertinggi = deskripsiTertinggi.join(", ");
            siswa.deskripsi_terendah = deskripsiTerendah.join(", ");

            return { ...siswa };
        });

        // kirim data yang sudah dimodifikasi kembali ke Livewire
        Livewire.dispatch("updateDeskripsi", [modifiedData]);
    });
});
