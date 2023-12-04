<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<?php
    date_default_timezone_set('Asia/Jakarta');
?>

<div class="container">
    <div class="mt-3 mx-3">
        <h6><strong>Semua Transaksi</strong></h6>
    </div>

    <div class="mt-3 mx-3">
        <div class="overflow-y-scroll height-50vh" id="transaction-card">
            <?php foreach ($history as $row) { ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="<?= $row->transaction_type == "PAYMENT" ? "text-red" : "text-green" ?>"><strong><?= $row->transaction_type == "PAYMENT" ? "-" : "+" ?> Rp.<?= number_format($row->total_amount) ?></strong></h5>
                                <span class="text-grey font-size-10px"><?= date('d-m-Y h:i', strtotime($row->created_on)) ?> WIB</span>
                            </div>
                            <div class="col-md-4">
                                <div class="float-right">
                                    <span class="font-size-13px"><?= strtoupper($row->description) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="d-flex justify-content-center mb-3 mt-3" id="show-more">
            <span class="text-center text-red pointer" onclick="addTransaction()"><strong>Show More</strong></span>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            /* transaction active pas diklik */
            $("#transaction-tab").addClass("active");
        })

        var offset = 5;

        function addTransaction() {

            $.ajax({
                url: "<?= base_url() ?>/transaction-show-more?offset=" + offset,
                type: "GET",
                headers: {
                    "Authorization": "Bearer <?= $_COOKIE['sims_token'] ?>"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 108) {
                        window.location.href = "<?= base_url('logout?expired=true') ?>"
                    }

                    if (response.jumlah > 0) {
                        offset = offset + 5;
                        addListTransaction(response)
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    notifAlert("Error Load Data", "error", "Oops...")
                }
            });
        }

        function addListTransaction(response) {

            var data = '';

            for (var i = 0; i < response.jumlah; i++) {
                var transaction_type = "<?= $row->transaction_type == "PAYMENT" ? "text-red" : "text-green" ?>"
                var symbol_transaction = "<?= $row->transaction_type == "PAYMENT" ? "-" : "+" ?>"
                var amount = "<?= number_format($row->total_amount) ?>"
                var date_transaction = "<?= date('d-m-Y h:i', strtotime($row->created_on)) ?>"
                var description = "<?= strtoupper($row->description) ?>"

                data += `
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="` + transaction_type + `"><strong>` + symbol_transaction + ` Rp.` + amount + `</strong></h5>
                                <span class="text-grey font-size-10px">` + date_transaction + ` WIB</span>
                            </div>
                            <div class="col-md-4">
                                <div class="float-right">
                                    <span class="font-size-13px">` + description + `</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `
            }
            $('#transaction-card').append(data)

            if (response.jumlah < 6) {
                $("#show-more").remove();
            }
        }
    </script>

    <?= $this->endSection() ?>