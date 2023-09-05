<div class="card p-2 shadow-sm border-bottom-primary">
    <div class="card-header bg-white">
        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
            <?= userdata('name'); ?>
        </h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 mb-4 mb-md-0">
                <img src="<?= base_url() ?>assets/img/avatar/<?= userdata('photo'); ?>" alt=""
                    class="img-thumbnail rounded mb-2">
                <a href="<?= base_url('admin/profile/setting'); ?>" class="btn btn-sm btn-block btn-primary"><i
                        class="fa fa-edit"></i> Edit Profile</a>
                <a href="<?= base_url('admin/profile/ubahpassword'); ?>" class="btn btn-sm btn-block btn-primary"><i
                        class="fa fa-lock"></i> Ubah Password</a>
            </div>
            <div class="col-md-10">
                <table class="table">
                    <tr>
                        <th width="200">Username</th>
                        <td><?= userdata('username'); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= userdata('email'); ?></td>
                    </tr>
                    <tr>
                        <th>Created at</th>
                        <td><?= date('d F Y', userdata('date_created')); ?></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td class="text-capitalize"><?= $this->session->userdata('login_session')['role']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>