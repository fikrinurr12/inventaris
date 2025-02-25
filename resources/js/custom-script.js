window.onload = function () {
    $(document).ready(function () {
        // Deteksi jika ada perubahan pada form
        $("form").on("input change", function () {
            isFormChanged = true;
        });

        // Tambahkan event listener beforeunload
        window.addEventListener("beforeunload", function (event) {
            if (isFormChanged) {
                const confirmationMessage =
                    "Anda memiliki data yang belum disimpan. Apakah Anda yakin ingin meninggalkan halaman?";
                event.returnValue = confirmationMessage; // Untuk browser modern
                return confirmationMessage; // Untuk beberapa browser lama
            }
        });
    });

    //script jika sudah submit tidak muncul popup
    $("form").on("submit", function () {
        // Setelah form disubmit, ganti status menjadi tidak berubah
        isFormChanged = false;
    });
};

document.addEventListener("DOMContentLoaded", function () {
    var alertData = document.getElementById("swal-alert-data");
    if (alertData) {
        Swal.fire({
            icon: alertData.dataset.icon,
            title: alertData.dataset.title,
            text: alertData.dataset.text,
            showConfirmButton: false,
            showCloseButton: true,
        });
    }
});
