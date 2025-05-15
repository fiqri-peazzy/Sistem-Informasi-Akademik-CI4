<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Data Guru</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Data Guru
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Tabel dengan data dummy -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card shadow-sm mb-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Guru</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm add_guru_btn">
                        <i class="fa fa-plus"></i> Tambah Guru
                    </button>

                    <button type="button" class="btn btn-success btn-sm import_excel_guru_btn">
                        <i class="fa fa-file-excel-o"></i> Import Excel
                    </button>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-hover table-strip" id="guruTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Guru</th>
                                <th>Email</th>
                                <th>Status</th>
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
<?php include('modal/guru_modal.php') ?>

<?php include('modal/import_guru_modal.php') ?>
<?php include('modal/edit_guru_modal.php') ?>
<?= $this->endSection('content') ?>

<?= $this->section('scripts') ?>

<script>
$('.add_guru_btn').on('click', function() {
    var modal = $('body').find('#modalTambahGuru');
    modal.modal('show');
});
$('.import_excel_guru_btn').on('click', function() {
    var modal = $('body').find('#modalImportGuru');
    modal.modal('show');
});
$('#formTambahGuru').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);

    var modal = $('body').find('div#modalTambahGuru');

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
                    guru_DT.ajax.reload(null, false);
                } else {
                    toastr.error(response.msg)
                }
            } else {
                $.each(response.error, function(prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val);
                });
            }
        }

    })
});

$('#formImportGuru').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);

    // Reset progress bar dan pesan
    $('#progressBar').css('width', '0%').text('0%');
    $('#importStatus').text('');

    $.ajax({
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    var percent = Math.round((e.loaded / e.total) * 100);
                    $('#progressBar').css('width', percent + '%').text(percent + '%');
                }
            });
            return xhr;
        },
        url: $(form).attr('action'),
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function() {
            $('#importStatus').text('Mengunggah file...');
        },
        success: function(response) {
            if (response.status == 1) {
                toastr.success('Berhasil menambahkan ' + response.count + ' data guru.')
                $(form)[0].reset();
                $('#progressBar').css('width', '100%').text('100%');
                guru_DT.ajax.reload(null, false);
            } else {
                $('#importStatus').text('Gagal: ' + response.msg);
                $(form)[0].reset();

            }
        },
        error: function() {
            $('#importStatus').text('Terjadi kesalahan saat mengunggah file.');
        }
    });
});

var guru_DT = $('#guruTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "<?= route_to('data.guru.datatables') ?>",
    dom: "Brtip",
    info: false,
    ordering: false,

    fnCreatedRow: function(row, data, index) {
        $('td', row).eq(0).html(index + 1);
    },

});
$(document).on('click', '.btnEditGuru', function(e) {
    e.preventDefault();
    var id_guru = $(this).data('id');
    var url = '<?= route_to('get.data.guru') ?>';

    $.get(url, {
        id_guru: id_guru
    }, function(response) {
        var modal = $('body').find('#modalEditGuru');
        modal.find('input[name="id"]').val(response.data.id);
        modal.find('input[name="nama"]').val(response.data.nama);
        modal.find('select[name="jk"]').val(response.data.jk);
        modal.find('input[name="tempat_lahir"]').val(response.data.tempat_lahir);
        modal.find('input[name="tanggal_lahir"]').val(response.data.tanggal_lahir);
        modal.find('input[name="status_kepegawaian"]').val(response.data.status_kepegawaian);
        modal.find('select[name="jenis_ptk"]').val(response.data.jenis_ptk);
        modal.find('input[name="agama"]').val(response.data.agama);
        modal.find('input[name="hp"]').val(response.data.hp);
        modal.find('input[name="email"]').val(response.data.email);
        modal.find('input[name="nik"]').val(response.data.nik);
        modal.modal('show');
    }, 'json');
});

$('#formEditGuru').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);

    $.ajax({
        url: $(form).attr('action'), // pastikan action form diarahkan ke route update
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function() {
            $(form).find('span.error-text').text('');
        },
        success: function(response) {
            if ($.isEmptyObject(response.error)) {
                if (response.status == 1) {
                    toastr.success(response.msg);
                    $('#modalEditGuru').modal('hide');
                    // reload datatable atau update tampilan data
                    guru_DT.ajax.reload(null, false);
                } else {
                    toastr.error(response.msg);
                }
            } else {
                $.each(response.error, function(prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val);
                });
            }
        },
        error: function() {
            toastr.error('Terjadi kesalahan saat mengupdate data.');
        }
    });
});

$(document).on('click', '.btnDeleteGuru', function(e) {
    e.preventDefault();
    var id_guru = $(this).data('id');
    var url = '<?= route_to('data.guru.drop') ?>';

    swal({
        title: 'Yakin ingin menghapus data ini?',
        text: "Data yang sudah dihapus tidak bisa dikembalikan!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            $.getJSON(url, {
                    id_guru: id_guru
                })
                .done(function(response) {
                    if (response.status == 1) {
                        swal(
                            'Terhapus!',
                            response.msg,
                            'success'
                        );
                        // Reload datatable atau update tampilan data
                        guru_DT.ajax.reload(null, false);
                    } else {
                        swal(
                            'Gagal!',
                            response.msg,
                            'error'
                        );
                    }
                })
                .fail(function() {
                    swal(
                        'Error!',
                        'Terjadi kesalahan saat menghapus data.',
                        'error'
                    );
                });
        }
    });
});
</script>
<?= $this->endSection('scripts') ?>