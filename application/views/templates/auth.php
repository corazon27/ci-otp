<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>assets/vendor/fontawesome-free-6.4.0-web/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link href="<?= base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.19/dist/sweetalert2.min.css">
    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
    .bg-login-image {
        background-image: url("<?= base_url('assets/img/finance_0bdk.svg'); ?>");
        background-repeat: no-repeat;
        background-size: 80%;
    }
    </style>
</head>


<body class="bg-gradient-primary">
    <div class="container">

        <?= $contents; ?>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url(); ?>assets/js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.19/dist/sweetalert2.all.min.js"></script>
</body>

</html>

<!-- application/views/auth/login.php -->

<!-- ... kode login form ... -->

<!-- jQuery dan SweetAlert -->
<script>
function getNewCaptcha() {
    $.ajax({
        url: "<?= base_url('auth/newCaptcha'); ?>",
        success: function(response) {
            $('#Captcha-image').html(response);
        }
    });
}
</script>

<script>
$(document).ready(function() {
    // Ajax login form submission
    $('#loginForm').on('submit', function(e) {
        e.preventDefault(); // Mencegah form dari pengiriman langsung

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        html: 'Berhasil login!'
                    }).then(function() {
                        window.location.href = response.redirect
                        // Redirect ke halaman login kembali jika diperlukan
                        // Misalnya, setelah berhasil login, user akan diarahkan kembali ke halaman login
                        // Gantilah 'auth/login' dengan URL halaman setelah login
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: response.msg
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while processing the request.'
                });
            }
        });
    });
});
</script>