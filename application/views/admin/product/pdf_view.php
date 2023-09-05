<!-- application/views/admin/product/pdf_view.php -->

<!DOCTYPE html>
<html>

<head>
    <style>
    /* Define your styling for PDF here */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        text-align: center;
        /* Center-align the content */
    }

    .container {
        width: 100%;
        padding: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Product List</h1>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($products as $product) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['description'] ?></td>
                    <td><?= $product['price'] ?></td>
                    <td><img src="<?= base_url('upload/') . $product['image'] ?>" alt="Product Image"
                            style="max-width: 100px; height: auto;"></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>