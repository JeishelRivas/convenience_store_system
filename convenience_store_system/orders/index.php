<?php include '../includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders | QuickMart</title>

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
            <h2>🛒 Orders</h2>
            <p class="mb-0">Manage and track customer checkout transactions</p>
        </div>
        <button class="btn btn-pink" id="addBtn">
            <i class="bi bi-plus-circle"></i> Add Order
        </button>
    </div>

    <div class="card-box table-card">
        <table id="tbl" class="table table-hover" style="width:100%;">
            <thead>
                <tr>
                    <th>OrderID</th>
                    <th>CustomerID</th>
                    <th>EmployeeID</th>
                    <th>ShipperID</th>
                    <th>OrderDate</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="form">
            <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
                <div class="modal-header modal-header-pink">
                    <h5 class="modal-title" id="modalTitle">Order Form</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="OrderID" id="OrderID">

                    <div class="mb-2">
                        <label class="form-label">Customer ID</label>
                        <input type="number" class="form-control" name="CustomerID" placeholder="Enter Customer ID" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Employee ID</label>
                        <input type="number" class="form-control" name="EmployeeID" placeholder="Enter Employee ID" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Shipper ID</label>
                        <input type="number" class="form-control" name="ShipperID" placeholder="Enter Shipper ID" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Order Date & Time</label>
                        <input type="datetime-local" class="form-control" name="OrderDate" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-pink">Save Changes</button>
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
        { data: "OrderID" },
        { data: "CustomerID" },
        { data: "EmployeeID" },
        { data: "ShipperID" },
        { data: "OrderDate" },
        {
            data: null,
            orderable: false,
            render: function(d) {
                return `
                <button class="btn btn-warning btn-sm editBtn" style="border-radius:8px;" data-id="${d.OrderID}">
                    <i class="bi bi-pencil"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm deleteBtn" style="border-radius:8px;" data-id="${d.OrderID}">
                    <i class="bi bi-trash"></i> Delete
                </button>
                `;
            }
        }
    ]
});

/* ADD INITIALIZATION HANDLER */
$('#addBtn').click(function() {
    $('#form')[0].reset();
    $('#OrderID').val('');
    $('#modalTitle').text('Add Order');
    $('#orderModal').modal('show');
});

/* EDIT FIELD LOOKUP RENDERING */
$(document).on('click', '.editBtn', function() {
    let id = $(this).data('id');
    $('#modalTitle').text('Edit Order');

    $.get('fetch.php', { id: id }, function(res) {
        let o = Array.isArray(res) ? res[0] : res;

        $('#OrderID').val(o.OrderID);
        $('[name="CustomerID"]').val(o.CustomerID);
        $('[name="EmployeeID"]').val(o.EmployeeID);
        $('[name="ShipperID"]').val(o.ShipperID);
        
        // Formats space separation into 'T' formatting expected for datetime-local elements safely
        if(o.OrderDate) {
            let formattedDate = o.OrderDate.replace(" ", "T").substring(0, 16);
            $('[name="OrderDate"]').val(formattedDate);
        }

        $('#orderModal').modal('show');
    }, 'json');
});

/* FORM SUBMIT LOGIC (INSERT OR UPDATE) */
$('#form').submit(function(e) {
    e.preventDefault();

    let url = $('#OrderID').val() ? 'update.php' : 'insert.php';

    $.post(url, $(this).serialize(), function(res) {
        if(res.status === 'success') {
            $('#orderModal').modal('hide');
            table.ajax.reload();
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: res.message,
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            Swal.fire('Error', res.message || 'Action processing failure', 'error');
        }
    }, 'json');
});

/* ATOMIC REMOVAL DISPOSAL ROUTINE */
$(document).on('click', '.deleteBtn', function() {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Delete Order Context?',
        text: "This removal cascade will break matching data lines inside Order Details!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff8fab',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('delete.php', { id: id }, function(res) {
                if (res.status === 'success') {
                    table.ajax.reload();
                    Swal.fire('Deleted!', res.message, 'success');
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