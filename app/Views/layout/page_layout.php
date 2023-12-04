<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMS PPOB - Joshua Pratama Silitonga</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css') ?>?v=0.0.1" />

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/owl.carousel.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/owl.theme.default.min.css') ?>" />


    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo.png') ?>">
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/owl.carousel.js') ?>"></script>
</head>

<body>

    <?= $this->include('layout/navbar') ?>
    <?php $request = \Config\Services::request();
    $header_block = array('account', 'edit-profile');
    if (!in_array($request->uri->getSegment(1), $header_block)) { ?>
        <?= $this->include('layout/header') ?>
    <?php } ?>


    <?= $this->renderSection('content') ?>

    <!-- Jquery dan Bootsrap JS -->
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            var owl = $('.owl-carousel');
            owl.owlCarousel({
                loop:true,
                margin:10,
                autoplay:true,
                autoplayTimeout:2500,
                autoplayHoverPause:true,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:4
                    }
                }
            });
        })

        var balance = "<?= $balance->data->balance ?>"

        function notifAlert(msg, type, title) {
            Swal.fire({
                icon: type,
                title: title,
                text: msg
            })
        }

        function confirmAlert(msg, title, type, redirect) {
            Swal.fire({
                title: title,
                text: msg,
                icon: type,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url() ?>" + redirect
                }
            })
        }

        function showSaldo(saldo) {
            $('#saldo').empty()
            $('#saldo').html(numberWithCommas(saldo)).css('font-size', '25px')
            $('#div_saldo').empty()
            $('#div_saldo').html(
                `<span class="text-white mr-3" style="font-size: 15px;"><strong>Tutup Saldo</strong></span>
            <i class="fa fa-eye-slash text-white mt-1" id="show_saldo" style="cursor: pointer" onclick="closeSaldo()"></i>`
            )
        }

        function closeSaldo() {
            $('#saldo').empty()
            $('#saldo').html(`<i class="fa fa-circle mr-1" style="font-size: 14px;"></i>
                              <i class="fa fa-circle mr-1" style="font-size: 14px;"></i>
                              <i class="fa fa-circle mr-1" style="font-size: 14px;"></i>
                              <i class="fa fa-circle mr-1" style="font-size: 14px;"></i>
                              <i class="fa fa-circle" style="font-size: 14px;"></i>`)
            $('#div_saldo').empty()
            $('#div_saldo').html(
                `<span class="text-white mr-3" style="font-size: 15px;"><strong>Lihat Saldo</strong></span>
                <i class="fa fa-eye text-white mt-1" id="show_saldo" style="cursor: pointer" onclick="showSaldo(balance)"></i>`
            )
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>

</body>

</html>