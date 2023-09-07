<?= $this->session->flashdata('message'); ?>
<h4>Enter Your 4 Digit OTP</h4>

<form class="form" method="post" action="<?= site_url('auth/resetPassword') ?>">
    <div class="input_field_box">
        <input type="number" name="otp_1" />
        <input type="number" name="otp_2" disabled />
        <input type="number" name="otp_3" disabled />
        <input type="number" name="otp_4" disabled />
    </div>
    <button type="submit">Verify OTP</button>
</form>


</div>