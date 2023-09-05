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
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@500;600&display=swap");

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Inter", sans-serif;
    }

    body {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e0e0e0;
    }

    .container {
        width: 300px;
        height: auto;
        padding: 40px 30px;
        background-color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border-radius: 15px;
    }

    h4 {
        font-size: 20px;
        color: #121212;
    }

    .form {
        width: 100%;
        height: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 20px;
    }

    .input_field_box {
        width: 100%;
        height: auto;
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
    }

    .input_field_box input {
        border: none;
        max-width: 20%;
        height: 60px;
        text-align: center;
        border-radius: 5px;
        background: #f0f0f0;
        font-size: 25px;
    }

    .input_field_box input::-webkit-inner-spin-button,
    .input_field_box input::-webkit-outer-spin-button {
        display: none;
    }

    .input_field_box input:focus {
        outline: 1.5px solid #00b991;
        outline-offset: 2px;
    }

    form button {
        margin-top: 25px;
        width: 92%;
        color: #525252;
        font-size: 16px;
        padding: 10px 0;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        pointer-events: none;
        cursor: pointer;
        background: #e9d585;
        transition: all 0.2s ease;
    }

    form button.active {
        background: #ffcc00;
        pointer-events: auto;
        color: #000000;
    }

    form button:hover {
        background: #e6b801;
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

<script>
const OTPinputs = document.querySelectorAll("input");
const button = document.querySelector("button");

window.addEventListener("load", () => OTPinputs[0].focus());

OTPinputs.forEach((input) => {
    input.addEventListener("input", () => {
        const currentInput = input;
        const nextInput = input.nextElementSibling;

        if (currentInput.value.length > 1 && currentInput.value.length == 2) {
            currentInput.value = "";
        }

        if (nextInput !== null && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
            nextInput.removeAttribute("disabled");
            nextInput.focus();
        }

        if (!OTPinputs[3].disabled && OTPinputs[3].value !== "") {
            button.classList.add("active");
        } else {
            button.classList.remove("active");
        }

    });


    input.addEventListener("keyup", (e) => {
        if (e.key === "Backspace") {
            if (input.previousElementSibling !== null) {
                e.target.value = "";
                e.target.setAttribute("disabled", true);
                input.previousElementSibling.focus();
            }
        }
    })

});

button.addEventListener("click", () => {
    alert("OTP Sent")
})
</script>