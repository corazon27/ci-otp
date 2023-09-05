<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Form Edit Profile User
                </h4>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open_multipart('', [], ['id_user' => $user['id_user']]); ?>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="foto">Foto</label>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-3">
                                <img src="<?= base_url() ?>assets/img/avatar/<?= $user['photo']; ?>"
                                    alt="<?= $user['name']; ?>" class="rounded-circle shadow-sm img-thumbnail">
                            </div>
                            <div class="col-9">
                                <input type="file" name="foto" id="foto">
                                <?= form_error('foto', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="username">Username</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-fw fa-user"></i></span>
                            </div>
                            <input value="<?= set_value('username', $user['username']); ?>" name="username"
                                id="username" type="text" class="form-control" placeholder="Username...">
                        </div>
                        <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="name">Nama Anda</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa-solid fa-user-plus"></i></span>
                            </div>
                            <input value="<?= set_value('name', $user['name']); ?>" name="name" id="name" type="text"
                                class="form-control" placeholder="Nama Anda...">
                        </div>
                        <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="email">Email</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-fw fa-envelope"></i></span>
                            </div>
                            <input value="<?= set_value('email', $user['email']); ?>" name="email" id="email"
                                type="text" class="form-control" placeholder="Email...">
                        </div>
                        <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <hr>

                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="no_telp">No Telpon</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa-solid fa-phone"></i></span>
                            </div>
                            <input
                                value="<?= set_value('no_telp', isset($profile['no_telp']) ? $profile['no_telp'] : ''); ?>"
                                name="no_telp" id="no_telp" type="text" class="form-control" placeholder="No Telpon...">
                        </div>
                        <?= form_error('no_telp', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>


                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="jk">Jenis Kelamin</label>
                    <div class="col-md-9">
                        <select name="jk" id="jk" class="form-control js-select2">
                            <option value="" selected disabled>Pilih Jenis Kelamin</option>
                            <?php $jenisKelamin = isset($profile['jk']) ? $profile['jk'] : ''; ?>
                            <option value="Laki-laki"
                                <?= set_select('jk', 'Laki-laki', $jenisKelamin === 'Laki-laki'); ?>>
                                Laki-laki
                            </option>
                            <option value="Perempuan"
                                <?= set_select('jk', 'Perempuan', $jenisKelamin === 'Perempuan'); ?>>
                                Perempuan
                            </option>
                        </select>
                        <?= form_error('jk', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="alamat">Alamat</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa-solid fa-map-location-dot"></i></span>
                            </div>
                            <input
                                value="<?= set_value('alamat', isset($profile['alamat']) ? $profile['alamat'] : ''); ?>"
                                name="alamat" id="alamat" type="text" class="form-control" placeholder="Alamat...">

                        </div>
                        <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <hr>


























                <div class="row form-group" id="provinsiWrapper">
                    <label class="col-md-3 text-md-right" for="id_provinsi">Provinsi</label>
                    <div class="col-md-9">
                        <?php if (!empty($provinsi)) : ?>
                        <select name="id_provinsi" id="id_provinsi" class="form-control">
                            <option value="" disabled selected>Pilih Provinsi</option>
                            <?php foreach ($provinsi as $row) : ?>
                            <option <?php echo ($user['id_provinsi'] == $row['id_provinsi']) ? 'selected' : '';?>
                                value="<?php echo $row['id_provinsi'];?>"><?php echo $row['provinsi'];?></option>
                            <?php endforeach; ?>
                        </select>

                        <?php else : ?>

                        <select name="id_provinsi" id="id_provinsi" class="form-control">
                            <option value="" disabled selected>Pilih Provinsi</option>
                        </select>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="row form-group" id="kotaWrapper" style="display: none;">
                    <label class="col-md-3 text-md-right" for="id_kota">Kota</label>
                    <div class="col-md-9" id="citiesBox">
                        <?php if (!empty($kota)) : ?>
                        <select name="id_kota" id="id_kota" class="form-control">
                            <option value="" disabled selected>Pilih Kota</option>
                            <?php foreach ($kota as $row) : ?>
                            <option <?php echo ($user['id_kota'] == $row['id_kota']) ? 'selected' : '';?>
                                value="<?php echo $row['id_kota'];?>"><?php echo $row['kota'];?></option>
                            <?php endforeach; ?>
                        </select>

                        <?php else : ?>

                        <select name="id_kota" id="id_kota" class="form-control">
                            <option value="" disabled selected>Pilih Kota</option>
                        </select>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row form-group" id="kecamatanWrapper" style="display: none;">
                    <label class="col-md-3 text-md-right" for="id_kecamatan">Kecamatan</label>
                    <div class="col-md-9">
                        <?php if (empty($kecamatan)) : ?>
                        <!-- Jika ada data provinsi, tampilkan langsung datanya -->
                        <select name="id_kecamatan" id="id_kecamatan" class="form-control">
                            <option value="" disabled selected>Pilih Kecamatan</option>
                            <?php foreach ($kecamatan as $row) : ?>
                            <option <?php echo ($user['id_kecamatan'] == $row['id_kecamatan']) ? 'selected' : '';?>
                                value="<?php echo $row['id_kecamatan'];?>"><?php echo $row['kecamatan'];?></option>
                            <?php endforeach; ?>
                        </select>

                        <?php else : ?>

                        <!-- Jika tidak ada data provinsi, tampilkan nested select option -->
                        <select name="id_kecamatan" id="id_kecamatan" class="form-control">
                            <option value="" disabled selected>Pilih Kecamatan</option>
                        </select>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>