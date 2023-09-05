<?= $this->session->flashdata('message'); ?>
<h4>Enter Your 4 Digit OTP</h4>

<form class="form">

    <div class="input_field_box">
        <input type="number" />
        <input type="number" disabled />
        <input type="number" disabled />
        <input type="number" disabled />
    </div>

    <button>Verify OTP</button>
</form>

</div>