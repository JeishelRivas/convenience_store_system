<?php include '../includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - QuickMart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/style.css?v=1.1">

    <style>
        /* Table structural alignment matching your global theme palette */
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
            <h2>👥 Customers</h2>
            <p class="mb-0">Manage customer accounts and regional profiles</p>
        </div>
        <button class="btn btn-pink" id="addBtn">
            <i class="bi bi-plus-circle"></i> Add Customer
        </button>
    </div>

    <div class="card-box table-card">
        <table id="tbl" class="table table-hover style-table" style="width:100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Barangay</th>
                    <th>Email</th>
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
                    <h5 class="modal-title" id="modalTitle">Customer Form</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="CustomerID" id="CustomerID">

                    <div class="mb-2">
                        <label class="form-label">Full Name</label>
                        <input class="form-control" name="FullName" placeholder="Enter Full Name" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Barangay</label>
                        <input class="form-control" name="Barangay" placeholder="Enter Barangay" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="Email" placeholder="Enter Email Address" required>
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
        { data: "CustomerID" },
        { data: "FullName" },
        { data: "Barangay" },
        { data: "Email" },
        {
            data: null,
            orderable: false,
            render: function(d) {
                return `
                <button class="btn btn-warning btn-sm editBtn" style="border-radius:8px;" data-id="${d.CustomerID}">
                    <i class="bi bi-pencil"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm deleteBtn" style="border-radius:8px;" data-id="${d.CustomerID}">
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
    $('#CustomerID').val('');
    $('#modalTitle').text('Add Customer');
    $('#modal').modal('show');
});

/* EDIT LOOKUP RENDERING */
$(document).on('click', '.editBtn', function() {
    let id = $(this).data('id');
    $('#modalTitle').text('Edit Customer');

    $.get('fetch.php', { id: id }, function(res) {
        // Handle array responses out from standard fetch wrappers securely
        let c = Array.isArray(res) ? res[0] : res;

        $('#CustomerID').val(c.CustomerID);
        $('[name="FullName"]').val(c.FullName);
        $('[name="Barangay"]').val(c.Barangay);
        $('[name="Email"]').val(c.Email);

        $('#modal').modal('show');
    }, 'json');
});

/* FORM PRESERVATION DISPATCH (INSERT OR UPDATE) */
$('#form').submit(function(e) {
    e.preventDefault();

    let url = $('#CustomerID').val() ? 'update.php' : 'insert.php';

    $.post(url, $(this).serialize(), function(res) {
        if(res.status === 'success' || res.message) {
            $('#modal').modal('hide');
            table.ajax.reload();
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: res.message || 'Operation successful!',
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            Swal.fire('Error', res.message || 'An error occurred.', 'error');
        }
    }, 'json');
});

/* DATA ENTRY PURGE REMOVAL ROUTINE */
$(document).on('click', '.deleteBtn', function() {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Remove Customer Profile?',
        text: "This could conflict with linked historical orders!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff8fab',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('delete.php', { id: id }, function(res) {
                table.ajax.reload();
                Swal.fire('Deleted!', res.message || 'Customer profile removed.', 'success');
            }, 'json').fail(function() {
                Swal.fire('Error', 'Could not run deletion context rules.', 'error');
            });
        }
    });
});
</script>

</body>
</html>