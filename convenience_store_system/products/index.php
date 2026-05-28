<?php include '../includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | QuickMart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/style.css?v=1.1">

    <style>
        table thead {
            background: linear-gradient(135deg, #ff8fab, #cdb4db) !important;
            color: white !important;
        }
        .modal-header-pink {
            background: linear-gradient(135deg, #ff8fab, #cdb4db);
            color: white;
        }
    </style>
</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="main">
    <div class="topbar mb-4">
        <div>
            <h2>📦 Products</h2>
            <p class="mb-0">Manage store inventory, pricing, and stock items</p>
        </div>
        <button class="btn btn-pink" id="addBtn">
            <i class="bi bi-plus-circle"></i> Add Product
        </button>
    </div>

    <div class="card-box table-card">
        <table id="tbl" class="table table-hover" style="width:100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category ID</th>
                    <th>Supplier ID</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1">
    <div class="modal-dialog">
        <form id="form">
            <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
                <div class="modal-header modal-header-pink">
                    <h5 class="modal-title" id="modalTitle">Product Form</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="ProductID" id="ProductID">

                    <div class="mb-2">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="ProductName" placeholder="e.g. Potato Chips" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Category ID</label>
                        <input type="number" class="form-control" name="CategoryID" placeholder="Enter Category ID" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Supplier ID</label>
                        <input type="number" class="form-control" name="SupplierID" placeholder="Enter Supplier ID" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" name="Price" placeholder="0.00" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" class="form-control" name="StockQuantity" placeholder="0" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-pink" type="submit">Save Changes</button>
                    <button type="button" class="btn btn-secondary" style="border-radius:12px;" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let table = $('#tbl').DataTable({
    ajax: {
        url: 'fetch.php',
        dataSrc: 'data'
    },
    pageLength: 5,
    columns: [
        { data: 'ProductID' },
        { data: 'ProductName' },
        { data: 'CategoryID' },
        { data: 'SupplierID' },
        { 
            data: 'Price',
            render: function(data) { return parseFloat(data).toFixed(2); }
        },
        { data: 'StockQuantity' },
        {
            data: null,
            orderable: false,
            render: function(d) {
                return `
                <button class="btn btn-warning btn-sm editBtn" style="border-radius:8px;" data-id="${d.ProductID}">
                    <i class="bi bi-pencil"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm deleteBtn" style="border-radius:8px;" data-id="${d.ProductID}">
                    <i class="bi bi-trash"></i> Delete
                </button>
                `;
            }
        }
    ]
});

/* ADD BUTTON TRIGGER INITIALIZATION */
$('#addBtn').click(function() {
    $('#form')[0].reset();
    $('#ProductID').val('');
    $('#modalTitle').text('Add Product');
    $('#modal').modal('show');
});

/* EDIT REQUEST DATA INJECTION ROUTINE */
$(document).on('click', '.editBtn', function() {
    let id = $(this).data('id');
    $('#modalTitle').text('Edit Product');

    $.get('fetch.php', { id: id }, function(res) {
        let p = Array.isArray(res) ? res[0] : res;

        $('#ProductID').val(p.ProductID);
        $('[name="ProductName"]').val(p.ProductName);
        $('[name="CategoryID"]').val(p.CategoryID);
        $('[name="SupplierID"]').val(p.SupplierID);
        $('[name="Price"]').val(p.Price);
        $('[name="StockQuantity"]').val(p.StockQuantity);

        $('#modal').modal('show');
    }, 'json');
});

/* DATA TRANSFERS FORM HANDLING DISPATCH (INSERT OR UPDATE) */
$('#form').submit(function(e) {
    e.preventDefault();

    let url = $('#ProductID').val() ? 'update.php' : 'insert.php';

    $.post(url, $(this).serialize(), function(res) {
        if(res.status === 'success') {
            $('#modal').modal('hide');
            table.ajax.reload();
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: res.message,
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            Swal.fire('Error', res.message || 'Operation failed', 'error');
        }
    }, 'json');
});

/* REMOVAL INTERACTION DATA FLUSH */
$(document).on('click', '.deleteBtn', function() {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Delete Product Item?',
        text: "This cannot be undone and may affect orders history logs!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff8fab',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Delete'
    }).then((r) => {
        if (r.isConfirmed) {
            $.post('delete.php', { id: id }, function(res) {
                if(res.status === 'success') {
                    table.ajax.reload();
                    Swal.fire('Deleted', res.message, 'success');
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        }
    });
});
</script>
</body>
</html>