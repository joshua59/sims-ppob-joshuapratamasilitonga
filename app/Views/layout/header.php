<header class="mx-4 my-4">
    <div class="container">
        <div class="row mx-2">
            <div class="col-md-4">
                <?php if($session->profile_image == "https://minio.nutech-integrasi.app/take-home-test/null"){ ?>
                    <img src="<?= base_url('assets/images/profile_photo.png') ?>" alt="Photo Profile">
                <?php }else{ ?>
                    <img src="<?= $session->profile_image ?>" alt="Photo Profile" class="max-width-180px">
                <?php } ?>
                <h5 class="mt-2 grey">Selamat datang, </h5>
                <h4><?= $session->first_name ?> <?= $session->last_name ?></h4>
            </div>
            
            <div class="col-md-8">
                <div class="card w-100 background-red">
                    <div class="card-body">
                        <span class="text-white font-size-15px"><strong>Saldo anda</strong></span>
                        <div class="d-flex mt-2">
                            <h3 class="text-white mr-2">Rp</h3>
                            <h6 class="text-white mt-2" id="saldo">
                                <i class="fa fa-circle mt-2 mr-1"></i>
                                <i class="fa fa-circle mt-2 mr-1"></i>
                                <i class="fa fa-circle mt-2 mr-1"></i>
                                <i class="fa fa-circle mt-2 mr-1"></i>
                                <i class="fa fa-circle mt-2"></i>
                            </h6>
                        </div>
                        <div class="d-flex mt-2" id="div_saldo">
                            <span class="text-white mr-3 font-size-15px"><strong>Lihat Saldo</strong></span>
                            <i class="fa fa-eye text-white mt-1 pointer" id="show_saldo" onclick="showSaldo(balance)"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>