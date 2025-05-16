<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Data Kelas</h4>
                <small class="mb-2">Manajemen Data Pengguna</small>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Data Pengguna
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <!-- Tabel Kelas (col-8) -->
    <div class="col-lg-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="clearfix">
                    <div class="pull-left">
                        <h5>Data Pengguna</h5>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-primary btn-sm btn-add-users"><i class="fa fa-plus"></i> Tambah
                            Data</button>
                    </div>
                </div>
            </div>

            <div class="card-body p-3">
                <div class="table-responsive">

                    <table class="table table-sm table-borderless table-hover table-strip" id="table-users">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('modal/users_modal_form.php') ?>
<?php include('modal/edit_user_form.php') ?>
<?= $this->endSection('content') ?>

<?= $this->section('scripts') ?>

<script>
$('.btn-add-users').on('click', function() {

    var modal = $('body').find('div#modalTambahUser');
    modal.find('#formTambahUser')[0].reset();
    modal.modal('show');

});

$('#formTambahUser').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);

    var modal = $('body').find('div#modalTambahUser');

    $.ajax({
        url: $(form).attr('action'),
        method: 'post',
        data: formData,
        processData: false,
        dataType: 'json',
        contentType: false,
        cache: false,
        beforeSend: function() {
            toastr.remove();
            $(form).find('span.error-text').text('');
        },
        success: function(response) {
            if ($.isEmptyObject(response.error)) {
                if (response.status == 1) {
                    $(form)[0].reset();
                    modal.modal('hide');

                    toastr.success(response.msg);
                    if (typeof user_DT !== 'undefined') {
                        user_DT.ajax.reload(null, false);
                    }
                } else {
                    toastr.error(response.msg);
                }
            } else {
                $.each(response.error, function(prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val);
                });
            }
        }
    });
});

var user_DT = $('#table-users').DataTable({
    processing: true,
    serverSide: true,
    ajax: "<?= route_to('datatable.user') ?>",
    dom: "Brtip",
    info: false,
    ordering: false,

    fnCreatedRow: function(row, data, index) {
        $('td', row).eq(0).html(index + 1);
    },

});

$(document).on('click', '.btn-edit-user', function() {
    var modal = $('body').find('div#modalEditUser');
    var url = '<?= route_to('get.user') ?>';
    var id = $(this).data('id');

    $.getJSON(url, {
        id: id
    }, function(response) {
        modal.find('input[name="id"]').val(response.data.id);
        modal.find('input[name="name"]').val(response.data.name);
        modal.find('input[name="username"]').val(response.data.username);
        modal.find('input[name="email"]').val(response.data.email);
        modal.find('select[name="role"]').val(response.data.role);
        modal.modal('show');
    });
});

$(document).on('submit', '#formEditUser', function(e) {
    e.preventDefault();

    var form = this;
    var formData = new FormData(form);
    var modal = $('body').find('div#modalEditUser');

    $.ajax({
        url: $(form).attr('action'),
        method: 'post',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        cache: false,
        beforeSend: function() {
            toastr.remove();
            $(form).find('span.error-text').text('');
        },
        success: function(response) {
            if ($.isEmptyObject(response.error)) {
                if (response.status == 1) {
                    $(form)[0].reset();
                    modal.modal('hide');
                    toastr.success(response.msg);
                    if (typeof user_DT !== 'undefined') {
                        user_DT.ajax.reload(null, false); // reload DataTable jika digunakan
                    }
                } else {
                    toastr.error(response.msg);
                }
            } else {
                $.each(response.error, function(prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val);
                });
            }
        }
    });
});

$(document).on('click', '.btn-delete-user', function(e) {
    e.preventDefault();
    var userId = $(this).data('id');

    swal({
        title: 'Apakah Anda yakin?',
        text: "Data user akan dihapus!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?= route_to('data.user.drop') ?>',
                type: 'GET',
                data: {
                    id: userId
                },
                success: function(response) {
                    if (response.status === 'error') {
                        toastr.error(response.message);
                    } else {
                        toastr.success(response.message);
                        if (typeof user_DT !== 'undefined') {
                            user_DT.ajax.reload(null,
                                false); // reload DataTable jika digunakan
                        }
                    }
                },
                error: function() {
                    toastr.error('Terjadi kesalahan saat menghapus data.');
                }
            });
        }
    });
})
</script>
<?= $this->endSection('scripts') ?>