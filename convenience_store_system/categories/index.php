<?php include '../includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | QuickMart</title>

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
            <h2>📦 Categories</h2>
            <p class="mb-0">Manage inventory and product classification groups</p>
        </div>
        <button class="btn btn-pink" id="addBtn">
            <i class="bi bi-plus-circle"></i> Add Category
        </button>
    </div>

    <div class="card-box table-card">
        <table id="tbl" class="table table-hover" style="width:100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
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
                    <h5 class="modal-title" id="modalTitle">Category Form</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="CategoryID" id="CategoryID">

                    <div class="mb-2">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="CategoryName" class="form-control" placeholder="e.g., Snacks, Beverages" required>
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
        { data: "CategoryID" },
        { data: "CategoryName" },
        {
            data: null,
            orderable: false,
            render: function(d) {
                return `
                <button class="btn btn-warning btn-sm editBtn" style="border-radius:8px;" data-id="${d.CategoryID}">
                    <i class="bi bi-pencil"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm deleteBtn" style="border-radius:8px;" data-id="${d.CategoryID}">
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
    $('#CategoryID').val('');
    $('#modalTitle').text('Add Category');
    $('#modal').modal('show');
});

/* EDIT REQUEST ROUTINE */
$(document).on('click', '.editBtn', function() {
    let id = $(this).data('id');
    $('#modalTitle').text('Edit Category');

    $.get('fetch.php', { id: id }, function(res) {
        // Safe check whether your backend array wrapper returned a single item or row set
        let c = Array.isArray(res) ? res[0] : res;

        $('#CategoryID').val(c.CategoryID);
        $('[name="CategoryName"]').val(c.CategoryName);

        $('#modal').modal('show');
    }, 'json');
});

/* FORM SAVE PROCESSING (INSERT OR UPDATE) */
$('#form').submit(function(e) {
    e.preventDefault();

    let url = $('#CategoryID').val() ? 'update.php' : 'insert.php';

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

/* RECORD ELIMINATION ROUTINE */
$(document).on('click', '.deleteBtn', function() {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Delete Category Group?',
        text: "This could impact products tied directly to this classification!",
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