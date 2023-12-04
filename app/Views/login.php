<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMS PPOB - Joshua Pratama Silitonga</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css') ?>?v=0.0.1" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo.png') ?>">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-6">
                <div class="row h-100">
                    <div class="col-sm-12 pt-5 my-auto">
                        <div class="col-12 col-lg-6 col-md-12 mx-auto w-100">
                            <div class="d-flex justify-content-center">
                                <div class="media">
                                    <div class="mr-3">
                                        <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" class="width-100">
                                    </div>
                                    <div class="media-body">
                                        <h3><strong>SIMS PPOB</strong> </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="desc-title mt-3">
                                <p class="title"><strong>Masuk atau buat akun untuk memulai</strong></p>
                            </div>
                            <div class="mt-5">
                                <form>
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" placeholder="@ Masukan email anda">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="password" placeholder="Masukan password anda">
                                    </div>
                                    <button type="button" class="btn btn-submit btn-block" onclick="validateForm()"><strong>Masuk</strong></button>
                                    <p class="text-center mt-3">belum punya akun ? register <a href="<?= base_url('register') ?>" class="text-danger"><strong>disini</strong></a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none d-lg-block background-pink">
                <div class="imgbox">
                    <img src="<?= base_url('assets/images/ilustrasi_login.png') ?>" class="center-fit" alt="Image Login">
                </div>
            </div>
        </div>
    </div>
    <!-- Jquery dan Bootsrap JS -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            var expired = "<?= $expired_notif ?>"
            if(expired){
                confirmAlert("Maaf, sesi anda telah berakhir", "Notifikasi", "info")
            }
        });

        function validateForm() {
            if ($('#email').val() == "") {
                notifAlert("Email tidak boleh kosong", "error", "Oops...")
                $('#email').focus()
                return false
            } else if (!validateEmail($('#email').val())) {
                notifAlert("Format Email Salah", "error", "Oops...")
                $('#email').focus()
                return false
            } else if ($('#password').val() == "") {
                notifAlert("Password tidak boleh kosong", "error", "Oops...")
                $('#password').focus()
                return false
            } else if ($('#password').val().length < 8) {
                notifAlert("Password tidak boleh kurang dari 8 karakter", "error", "Oops...")
                $('#password').focus()
                return false
            }

            apiProcessLogin()
        }

        function apiProcessLogin(data) {
            $.ajax({
                url: "https://take-home-test-api.nutech-integrasi.app/login",
                type: "POST",
                dataType: "json",
                data: {
                    "email": $('#email').val(),
                    "password": $('#password').val()
                },
                success: function(response) {
                    setCookie('sims_token', response.data.token, 10000)
                    loginProcess()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    notifAlert("Error, Login Gagal, Email atau Password Salah !!", "error", "Oops...")
                }
            });
        }

        function loginProcess() {
            $.ajax({
                url: "<?= base_url('login-process') ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    confirmAlert("Login Sukses", "Success", "success")
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    notifAlert("Error, Login Gagal !!", "error", "Oops...")
                }
            });
        }

        function validateEmail(email) {
            return email.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
        }

        function notifAlert(msg, type, title) {
            Swal.fire({
                icon: type,
                title: title,
                text: msg
            })
        }

        function confirmAlert(msg, title, type) {
            Swal.fire({
                title: title,
                text: msg,
                icon: type,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= base_url() ?>"
                }
            })
        }

        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/;secure;samesite=lax;";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        function eraseCookie(name) {
            document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }
    </script>

</body>

</html>