<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="mt-3 mx-3">
        <h6 class="text-grey"><strong>Pembayaran</strong></h6>
        <div class="d-flex mt-2">
            <img src="<?= $service->service_icon ?>" alt="<?= $service->service_name ?> Logo" class="mr-3 width-40px">
            <h5 class="mt-2"><strong><?= strtoupper(str_replace("_", " ", $category)) ?></strong></h5>
        </div>
    </div>

    <div class="mt-5 mx-3">
        <div class="form-group">
            <input type="text" class="form-control" id="service_tariff" value="<?= number_format($service->service_tariff) ?>" readonly>
            <button class="btn btn-block mt-3 background-red text-white" onclick="confirmPayment()"><strong>Bayar</strong></button>
        </div>
    </div>

    <script>
        function confirmPayment() {
            Swal.fire({
                html: `<h6>Beli <?= $service->service_name ?> senilai <h6>
                    <h3 class="mt-3">Rp<?= number_format($service->service_tariff) ?></h3>`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Lanjutkan Bayar',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    validateSaldo()
                }
            })
        }

        function validateSaldo() {
            var service_tarif = "<?= $service->service_tariff ?>"
            if (parseInt(balance) < parseInt(service_tarif)) {
                notifAlert("Error, Payment gagal, saldo kurang !!!", "error", "Oops...")
                return false
            }

            paymentProcess()
        }

        function paymentProcess() {

            $.ajax({
                url: "https://take-home-test-api.nutech-integrasi.app/transaction",
                type: "POST",
                headers: {
                    "Authorization": "Bearer <?= $_COOKIE['sims_token'] ?>"
                },
                dataType: "json",
                data: {
                    "service_code": "<?= $service->service_code ?>",
                },
                success: function(response) {
                    if (response.status == 108) {
                        window.location.href = "<?= base_url('logout?expired=true') ?>"
                    }
                    confirmAlert(response.message, "Success", "success", "")
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    notifAlert("Error, Payment Gagal", "error", "Oops...")
                }
            });
        }
    </script>

    <?= $this->endSection() ?>