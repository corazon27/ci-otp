$(document).ready(function() {
    // Add Product
    $('#addBtn').click(function() {
        var form = $('#addForm').serialize();
        $.ajax({
            url: '<?= base_url('admin/product/create') ?>',
            method: 'POST',
            data: form,
            success: function(response) {
                if (response) {
                    location.reload();
                } else {
                    alert('Failed to add product');
                }
            }
        });
    });

    // Edit Product
    $('.edit-btn').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: '<?= base_url('admin/product/get_product') ?>',
            method: 'POST',
            data: {
                id: id
            },
            success: function(response) {
                var product = JSON.parse(response);
                $('#editId').val(product.id);
                $('#editName').val(product.name);
                $('#editDescription').val(product.description);
                $('#editPrice').val(product.price);
            }
        });
    });

    $('#updateBtn').click(function() {
        var form = $('#editForm').serialize();
        $.ajax({
            url: '<?= base_url('admin/product/update') ?>',
            method: 'POST',
            data: form,
            success: function(response) {
                if (response) {
                    location.reload();
                } else {
                    alert('Failed to update product');
                }
            }
        });
    });

    // Delete Product
    $('.delete-btn').click(function() {
        var id = $(this).data('id');
        if (confirm('Are you sure to delete this product?')) {
            $.ajax({
                url: '<?= base_url('admin/product/delete') ?>',
                method: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    if (response) {
                        location.reload();
                    } else {
                        alert('Failed to delete product');
                    }
                }
            });
        }
    });
});