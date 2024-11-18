"use strict";

document.addEventListener("livewire:init", () => {
    // menghapus keterangan deskripsi
    // awal : Almira Kuswandari S.Pd menunjukkan pemahaman dalam sadasdasd
    // menjadi : sadasdasd
    const getSanitizedText = (text) => {
        const target = "dalam";
        const textStartIndex = text.indexOf(target);

        if (textStartIndex !== -1)
            return text.substring(textStartIndex + target.length).trim();

        return text;
    };

    Livewire.on("generateDeskripsi", (params) => {
        const { dataIndex = null, nilaiIndex = null, nilaiData } = params;
        const data = JSON.parse(JSON.stringify(nilaiData));

        let modifiedData = [];

        const sanitizeArray = (array) => [...new Set(array)];

        if (dataIndex !== null && nilaiIndex !== null) {
            // Mode: Perbarui deskripsi untuk dataIndex dan nilaiIndex tertentu
            const localModifiedData = data[dataIndex];
            const detail = localModifiedData.detail[nilaiIndex];

            let deskripsiTertinggi = getSanitizedText(
                localModifiedData.deskripsi_tertinggi
            );
            deskripsiTertinggi = deskripsiTertinggi
                ? deskripsiTertinggi.split(", ")
                : [];

            let deskripsiTerendah = getSanitizedText(
                localModifiedData.deskripsi_terendah
            );
            deskripsiTerendah = deskripsiTerendah
                ? deskripsiTerendah.split(", ")
                : [];

            // Perbarui hanya data detail yang berubah
            if (detail.tampil === true) {
                if (detail.kktp === true) {
                    // Tambahkan ke deskripsi tertinggi
                    if (
                        !deskripsiTertinggi.includes(
                            detail.tujuan_pembelajaran_deksripsi
                        )
                    ) {
                        deskripsiTertinggi.push(
                            detail.tujuan_pembelajaran_deksripsi
                        );
                    }
                    // Hapus dari deskripsi terendah jika ada
                    deskripsiTerendah = deskripsiTerendah.filter(
                        (d) => d !== detail.tujuan_pembelajaran_deksripsi
                    );
                } else if (detail.kktp === false) {
                    // Tambahkan ke deskripsi terendah
                    if (
                        !deskripsiTerendah.includes(
                            detail.tujuan_pembelajaran_deksripsi
                        )
                    ) {
                        deskripsiTerendah.push(
                            detail.tujuan_pembelajaran_deksripsi
                        );
                    }
                    // Hapus dari deskripsi tertinggi jika ada
                    deskripsiTertinggi = deskripsiTertinggi.filter(
                        (d) => d !== detail.tujuan_pembelajaran_deksripsi
                    );
                }
            } else {
                // Hapus dari kedua deskripsi jika tampil adalah false
                deskripsiTertinggi = deskripsiTertinggi.filter(
                    (d) => d !== detail.tujuan_pembelajaran_deksripsi
                );
                deskripsiTerendah = deskripsiTerendah.filter(
                    (d) => d !== detail.tujuan_pembelajaran_deksripsi
                );
            }

            // Perbarui deskripsi siswa tanpa duplikasi
            localModifiedData.deskripsi_tertinggi = `${
                localModifiedData.nama_siswa
            } menunjukkan pemahaman dalam ${sanitizeArray(
                deskripsiTertinggi
            ).join(", ")}`;

            localModifiedData.deskripsi_terendah = `${
                localModifiedData.nama_siswa
            } membutuhkan pemahaman dalam ${sanitizeArray(
                deskripsiTerendah
            ).join(", ")}`;

            // Salin data yang sudah dimodifikasi
            modifiedData = JSON.parse(JSON.stringify(params.nilaiData));
            modifiedData[dataIndex] = localModifiedData;
        } else {
            // Mode: Modifikasi seluruh data
            modifiedData = data.map((siswa) => {
                let deskripsiTertinggi = [];
                let deskripsiTerendah = [];

                // Salin detail siswa
                const detailCopy = siswa.detail.map((detail) => ({
                    ...detail,
                }));

                detailCopy.forEach((detail) => {
                    if (detail.tampil === true) {
                        if (detail.kktp === true) {
                            // Tambahkan ke deskripsi tertinggi
                            if (
                                !deskripsiTertinggi.includes(
                                    detail.tujuan_pembelajaran_deksripsi
                                )
                            ) {
                                deskripsiTertinggi.push(
                                    detail.tujuan_pembelajaran_deksripsi
                                );
                            }
                        } else if (detail.kktp === false) {
                            // Tambahkan ke deskripsi terendah
                            if (
                                !deskripsiTerendah.includes(
                                    detail.tujuan_pembelajaran_deksripsi
                                )
                            ) {
                                deskripsiTerendah.push(
                                    detail.tujuan_pembelajaran_deksripsi
                                );
                            }
                        }
                    } else {
                        // Kosongkan tujuan_pembelajaran_deksripsi jika tampil adalah false
                        deskripsiTertinggi = deskripsiTertinggi.filter(
                            (d) => d !== detail.tujuan_pembelajaran_deksripsi
                        );
                        deskripsiTerendah = deskripsiTerendah.filter(
                            (d) => d !== detail.tujuan_pembelajaran_deksripsi
                        );
                    }
                });

                // Gabungkan deskripsi tanpa duplikasi
                siswa.deskripsi_tertinggi = `${
                    siswa.nama_siswa
                } menunjukkan pemahaman dalam ${sanitizeArray(
                    deskripsiTertinggi
                ).join(", ")}`;
                siswa.deskripsi_terendah = `${
                    siswa.nama_siswa
                } membutuhkan pemahaman dalam ${sanitizeArray(
                    deskripsiTerendah
                ).join(", ")}`;

                return { ...siswa };
            });
        }

        // Konversi data yang sudah dimodifikasi menjadi JSON
        const jsonString = JSON.stringify(modifiedData);

        // Kirim data yang sudah dimodifikasi kembali ke Livewire
        Livewire.dispatch("updateDeskripsi", [jsonString]);
    });
});
