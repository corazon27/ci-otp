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
                                <th><input type="checkbox" id="check-all"></th>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                            <?php foreach ($products as $index => $product): ?>
                            <tr>
                                <td><input type='checkbox' class='check-item' name="delete_ids[]"
                                        value="<?= $product['id']; ?>"></td>
                                <td><?= ++$start ?></td>
                                <td><?= $product['name']; ?></td>
                                <td><?= $product['description'] ?></td>
                                <td><?= $product['price'] ?></td>
                                <td> <img src="<?= base_url('upload/') . $product['image'] ?>" width="250" height="200">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary edit-btn"
                                        data-id="<?= $product['id'] ?>" data-toggle="modal"
                                        data-target="#editModal">Edit</button>
                                    <button type="button" class="btn btn-danger delete-btn"
                                        data-id="<?= $product['id'] ?>">Delete</button>
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


<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="image">Image:</label>
                        <div class="control-file">
                            <input type="file" class="form-control" id="image" name="image"
                                onchange="previewImage(event)">
                        </div>
                    </div>
                    <div id="imagePreviewContainer">
                        <img class="img-fluid" id="imagePreview" src="#" alt="Image Preview"
                            style="display: none; max-height: 20%;">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addBtn">Add</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" enctype="multipart/form-data">
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" class="form-control" id="editName" name="name">
                    </div>
                    <div class="form-group">
                        <label for="editDescription">Description</label>
                        <textarea class="form-control" id="editDescription" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editPrice">Price</label>
                        <input type="number" class="form-control" id="editPrice" name="price">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="image">Image:</label>
                        <div class="control-file">
                            <input type="file" class="form-control" id="image" name="image"
                                onchange="previewEditImage(event)">
                            <!-- <span id="selectedImageName"></span> -->
                        </div>
                    </div>
                    <div id="imageEditPreviewContainer">
                        <img class="img-fluid" id="imageEditPreview" src="#" alt="Image Preview"
                            style="display: none; max-height: 50%;">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Misalnya, atur font, warna, dan jarak antar elemen */
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    color: #333;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 15px;
}

.container-fluid {
    padding: 15px;
}

/* Atur jarak antara elemen dalam tabel */
table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ccc;
}

table th,
table td {
    padding: 8px;
    border: 1px solid #ccc;
}

/* Atur jarak antara form search dan tombol search */
#searchForm {
    display: flex;
}

#searchForm .form-group {
    margin-right: 10px;
}

/* Atur tampilan tombol Edit dan Delete */
.edit-btn,
.delete-btn {
    margin-right: 5px;
}

/* Atur tampilan gambar pada tabel agar tetap berada dalam kotak */
.table img {
    max-width: 100%;
    height: auto;
}

@media screen and (max-width: 398px) {
    .float-right {
        margin-bottom: 15px;
    }

    #searchInput {
        width: 100%;
    }

    .delete-btn {
        margin-top: 10px;
    }


}

@media screen and (max-width: 798px) {

    #imagePreview,
    #imageEditPreview {
        max-width: 50%;
        display: block;
        margin: 0 auto;
    }


    .delete-btn {
        margin-top: 10px;
    }

    table {
        width: 100%;
    }

    th,
    td {
        /* display: block; */
        width: auto;
        text-align: center;
    }

    th {
        font-size: 14px;
        font-weight: bold;
    }

    tbody tr {
        margin-bottom: 10px;
    }

    tbody td {
        margin-bottom: 10px;
        border: none;
    }

    tbody td::before {
        content: attr(data-label);
        display: block;
        font-weight: bold;
        margin-right: 5px;
        margin: 0 auto;
    }
}
</style>