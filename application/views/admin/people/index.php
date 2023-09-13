<div class="container">
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
        </div>

        <!-- Card -->
        <div class="card">
            <!-- Card Header -->
            <div class="card-header bg-white py-3 d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    <?= $page ?>
                </h4>
            </div>

            <!-- Card Body -->
            <?= form_open('admin/product/delete_selected', ['class' => 'formHapus']); ?>
            <div class="card-body">
                <div class="clearfix mb-3">
                    <div class="float-right">
                        <!-- Search Form -->
                        <form id="searchForm" class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                            </div>
                            <button type="button" class="btn btn-primary" id="searchBtn">Search</button>
                        </form>
                    </div>
                    <div class="float-left">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                            Add Product
                        </button>
                        <!-- <button class="tes">Title, Text and Icon</button> -->
                    </div>
                    <div class="float-left ml-2">
                        <a href="<?= base_url('admin/product/pdf') ?>" class="btn btn-success">Export PDF</a>
                    </div>
                    <div class="float-left ml-2">
                        <button type="submit" class="btn btn-danger tombolHapusBanyak">Hapus Data</button>
                    </div>

                </div>

                <!-- Responsive Table -->
                <div class="table-responsive text-center mx-auto">
                    <table class="table table-bordered table-striped">
                        <!-- Table Header -->
                        <thead class="thead-dark">
                            <tr>
                                <!-- <th><input type="checkbox" id="check-all"></th> -->
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                            <?php foreach( $peoples as $people ) : ?>
                            <tr>
                                <th><?= ++$start; ?></th>
                                <td><?= $people['name']; ?></td>
                                <td><?= $people['email']; ?></td>
                                <td>
                                    <a href="" class="badge badge-warning">Detail</a>
                                    <a href="" class="badge badge-success">Edit</a>
                                    <a href="" class="badge badge-danger">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?= form_close(); ?>

            <!-- Card Footer -->
            <?= $this->pagination->create_links(); ?>
        </div>
    </div>
</div>