<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="mt-3 mx-3">
        <h6 class="text-grey"><strong>Silahkan Masukan</strong></h6>
        <h4><strong>Nominal Top up</strong></h4>
    </div>

    <div class="mt-3 mx-3">
        <div class="row">
            <div class="col-md-7 mt-3">
                <div class="form-group">
                    <input type="text" class="form-control" id="topup" onkeyup="formatInput(this)" max="1000000" placeholder="Masukan nominal Top up">
                    <button class="btn btn-secondary btn-block mt-3" id="button_topup" onclick="confirmTopUp()" disabled><strong>Top Up</strong></button>
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <button class="btn btn-outline-secondary btn-block mt-3" onclick="passingSaldo('10.000')">Rp10.000</button>
                    </div>
                    <div class="col-lg-4 col-6">
                        <button class="btn btn-outline-secondary btn-block mt-3" onclick="passingSaldo('20.000')">Rp20.000</button>
                    </div>
                    <div class="col-lg-4 col-6">
                        <button class="btn btn-outline-secondary btn-block mt-3" onclick="passingSaldo('50.000')">Rp50.000</button>
                    </div>
                    <div class="col-lg-4 col-6">
                        <button class="btn btn-outline-secondary btn-block mt-3" onclick="passingSaldo('100.000')">Rp100.000</button>
                    </div>
                    <div class="col-lg-4 col-6">
                        <button class="btn btn-outline-secondary btn-block mt-3" onclick="passingSaldo('250.000')">Rp250.000</button>
                    </div>
                    <div class="col-lg-4 col-6">
                        <button class="btn btn-outline-secondary btn-block mt-3" onclick="passingSaldo('500.000')">Rp500.000</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            /* topup active pas diklik */
            $("#topup-tab").addClass("active");
        })

        var rupiah = document.getElementById('topup');
        rupiah.addEventListener('keyup', function(e){
            formatInput(this);
        });

        function formatInput(input) {
            // Untuk maks topup 1.000.000
            let enteredValue = input.value;
            if (parseInt(enteredValue.replace(/\D/g, '')) > parseInt(input.getAttribute('max').replace(/\D/g, ''))) {
                input.value = formatRupiah(input.getAttribute('max'));
            } else {
                input.value = formatRupiah(enteredValue);
            }

            // Disable button jika topup dibawah 10.000
            var amount = parseInt(input.value.replace(/\D/g, '')); // Mengambil angka saja
            if (amount > 9999) {
                document.getElementById('button_topup').disabled = false;
                $('#button_topup').removeClass('btn-secondary')
                $('#button_topup').addClass('btn-primary')
            } else {
                document.getElementById('button_topup').disabled = true;
                $('#button_topup').removeClass('btn-primary')
                $('#button_topup').addClass('btn-secondary')
            }
        }

        /* Fungsi */
        function formatRupiah(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split    = number_string.split(','),
                sisa     = split[0].length % 3,
                rupiah     = split[0].substr(0, sisa),
                ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
                
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        function passingSaldo(saldo){
            $('#topup').val(saldo)
            document.getElementById('button_topup').disabled = false;
            $('#button_topup').removeClass('btn-secondary')
            $('#button_topup').addClass('btn-primary')
        }

        function confirmTopUp() {
            Swal.fire({
                html: `<h6>Anda yakin untuk Top Up sebesar <h6>
                    <h3 class="mt-3">Rp`+$('#topup').val()+`</h3>`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Lanjutkan Top Up',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    topUpProcess()
                }
            })
        }

        function topUpProcess() {

            $.ajax({
                url: "https://take-home-test-api.nutech-integrasi.app/topup",
                type: "POST",
                headers: {"Authorization": "Bearer <?= $_COOKIE['sims_token'] ?>"},
                dataType: "json",
                data: {
                    "top_up_amount": $('#topup').val().replace(/[^,\d]/g, ''),
                },
                success: function(response) {
                    if(response.status == 108){
                        window.location.href = "<?= base_url('logout?expired=true') ?>"
                    }
                    confirmAlert(response.message, "Success", "success", "") 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    notifAlert("Error, TopUp Gagal", "error", "Oops...")
                }
            });
        }
    </script>

    <?= $this->endSection() ?>