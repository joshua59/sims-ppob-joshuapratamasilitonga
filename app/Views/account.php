<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="mt-3">
        <div class="col-6 mx-auto w-100">
            <div class="d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="mr-3">
                        <?php if ($session->profile_image == "https://minio.nutech-integrasi.app/take-home-test/null") { ?>
                            <img src="<?= base_url('assets/images/profile_photo.png') ?>" alt="Photo Profile" class="width-100">
                        <?php } else { ?>
                            <img src="<?= $session->profile_image ?>" alt="Photo Profile" class="width-100">
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="mt-3 d-flex justify-content-center">
                <h4><?= $session->first_name ?> <?= $session->last_name ?></h4>
            </div>
            <div class="mt-3">
                <form>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" value="<?= $session->email ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nama_depan">Nama Depan</label>
                        <input type="text" class="form-control" id="nama_depan" value="<?= $session->first_name ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nama_belakang">Nama Belakang</label>
                        <input type="text" class="form-control" id="nama_belakang" value="<?= $session->last_name ?>" disabled>
                    </div>
                    <a href="<?= base_url('edit-profile') ?>" class="btn btn-block text-red background-white border-1px-red"><strong>Edit Profile</strong></a>
                    <a href="<?= base_url('logout') ?>" class="btn btn-block my-3 text-white background-red"><strong>Logout</strong></a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        /* account active pas diklik */
        $("#account-tab").addClass("active");
    })
</script>
<?= $this->endSection() ?>