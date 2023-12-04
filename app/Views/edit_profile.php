<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="mt-3">
        <div class="col-6 mx-auto w-100">
            <div class="d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="mr-3">
                        <input type="file" id="photo_profile" name="photo_profile" class="d-none"/>
                        <?php if ($session->profile_image == "https://minio.nutech-integrasi.app/take-home-test/null") { ?>
                            <img src="<?= base_url('assets/images/profile_photo.png') ?>" alt="Photo Profile" id="photoImage" class="width-100 pointer" onclick="searchFile()">
                        <?php } else { ?>
                            <img src="<?= $session->profile_image ?>" alt="Photo Profile" id="photoImage" class="width-100 pointer" onclick="searchFile()">
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
                        <input type="email" class="form-control" id="email" value="<?= $session->email ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_depan">Nama Depan</label>
                        <input type="text" class="form-control" id="nama_depan" value="<?= $session->first_name ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_belakang">Nama Belakang</label>
                        <input type="text" class="form-control" id="nama_belakang" value="<?= $session->last_name ?>">
                    </div>
                    <button type="button" class="btn btn-block background-red text-white" onclick="validateForm()"><strong>Simpan</strong></button>
                    <a href="<?= base_url('account') ?>" class="btn btn-block my-3 text-red background-white border-1px-red"><strong>Batalkan</strong></a>
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

    function searchFile(){
        $('#photo_profile').click()
    }
    $("#photo_profile").on("change", function() {
        const file = this.files[0];
        if (file) {
            if (file.type == "image/jpg" || file.type == "image/jpeg" || file.type == "image/png") {
                if (file.size > 100000) {
                    notifAlert("Error, File size tidak boleh lebih dari 100Kb.", "error", "Oops...")
                    return;
                } else {
                    // let reader = new FileReader();
                    // reader.onload = function(event) {
                    //     $('#photoImage').attr('src', event.target.result);
                    // }
                    // reader.readAsDataURL(file);
                    uploadPhoto()
                }
            } else {
                notifAlert("Error, File format tidak sesuai (jpg, jpeg, png)", "error", "Oops...")
                return;
            }
        }
    });

    function uploadPhoto() {
        data = new FormData();
        data.append('file', $('#photo_profile')[0].files[0]);
        $.ajax({
            type: "PUT",
            url: "https://take-home-test-api.nutech-integrasi.app/profile/image",
            data: data,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            headers: {
                "Authorization": "Bearer <?= $_COOKIE['sims_token'] ?>",
            },
            dataType: "json",
            success: function(response) {
                if (response.status == 108) {
                    window.location.href = "<?= base_url('logout?expired=true') ?>"
                }
                confirmAlert(response.message, "Success", "success", "account")
            },
            error: function(xhr) {
                notifAlert("Error, Upload Image Gagal", "error", "Oops...")
            }
        });
    }

    function validateForm() {
        if ($('#nama_depan').val() == "") {
            notifAlert("Nama depan tidak boleh kosong", "error", "Oops...")
            $('#nama_depan').focus()
            return false
        } else if ($('#nama_belakang').val() == "") {
            notifAlert("Nama belakang tidak boleh kosong", "error", "Oops...")
            $('#nama_belakang').focus()
            return false
        }

        updateProcess()
    }

    function updateProcess() {

        $.ajax({
            url: "https://take-home-test-api.nutech-integrasi.app/profile/update",
            type: "PUT",
            headers: {
                "Authorization": "Bearer <?= $_COOKIE['sims_token'] ?>",
            },
            dataType: "json",
            data: {
                "first_name": $('#nama_depan').val(),
                "last_name": $('#nama_belakang').val(),
            },
            success: function(response) {
                if (response.status == 108) {
                    window.location.href = "<?= base_url('logout') ?>"
                }
                confirmAlert(response.message, "Success", "success", "account")
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notifAlert("Error, Update Profile Gagal", "error", "Oops...")
            }
        });
    }
</script>
<?= $this->endSection() ?>