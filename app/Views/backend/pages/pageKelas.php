<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Data Kelas</h4>
                <small class="mb-2">Manajemen Data kelas Rombongan Belajar</small>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Data Kelas
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
                        <h5 class="mb-0">Data Kelas</h5>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-primary btn-sm" id="btnAddClass"><i class="fa fa-plus"></i> Tambah
                            Kelas</button>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <table class="table table-sm table-borderless table-hover table-strip" id="table-kelas">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Wali Kelas</th>
                            <th>Jumlah Siswa</th>
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
<?php include('modal/kelas_modal_form.php') ?>
<?php include('modal/edit_kelas_form.php') ?>

<?= $this->endSection('content') ?>
<?= $this->section('scripts') ?>
<script>
$('#btnAddClass').on('click', function(e) {
    e.preventDefault();
    var modal = $('body').find('div#modalTambahKelas');
    modal.modal('show');
});

$('#formTambahKelas').on('submit', function(e) {
    e.preventDefault();

    $('.error-text').text('');

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 0) {
                $.each(response.error, function(field, message) {
                    $('.' + field + '_error').text(message);
                });
            } else if (response.status === 1) {
                toastr.success(response.msg);
                $('#modalTambahKelas').modal('hide');
                $('#formTambahKelas')[0].reset();

                // Jika ada DataTable kelas, reload datanya
                if (typeof kelas_DT !== 'undefined') {
                    kelas_DT.ajax.reload(null, false);
                }
            } else {
                toastr.error(response.msg || 'Terjadi kesalahan.');
            }
        },
        error: function() {
            toastr.error('Gagal mengirim data ke server.');
        }
    });
});
var kelas_DT = $('#table-kelas').DataTable({
    processing: true,
    serverSide: true,
    ajax: "<?= route_to('data.kelas.datatables') ?>",
    dom: "Brtip",
    info: false,
    ordering: false,

    fnCreatedRow: function(row, data, index) {
        $('td', row).eq(0).html(index + 1);
    },

});



// Submit form edit kelas
$('#formEditKelas').on('submit', function(e) {
    e.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#modalEditKelas').modal('hide');
                kelas_DT.ajax.reload(null, false);
                toastr.success('Data kelas berhasil diperbarui.');
            } else if (response.status === 'validation_error') {
                $.each(response.errors, function(key, val) {
                    $('.' + key + '_error').text(val);
                });
            } else {
                alert('Gagal memperbarui data kelas.');
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat menyimpan data.');
        }
    });
});


$(document).on('click', '.btn-edit-kelas', function() {
    var kelasId = $(this).data('id');
    var modal = $('body').find('div#modalEditKelas');
    $('#formEditKelas')[0].reset();
    $('.error-text').text('');

    // Ambil data kelas via AJAX
    $.ajax({
        url: "<?= route_to('get.data.kelas') ?>",
        type: 'GET',
        data: {
            id: kelasId
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Isi form dengan data yang diterima
                modal.find('#nama_kelas').val(response.data.nama_kelas)
                modal.find('#wali_kelas').val(response.data.wali_kelas)
                modal.find('input[name="id"]').val(response.data.id)
                // Tampilkan modal edit
                modal.modal('show');
            } else {
                alert('Data kelas tidak ditemukan.');
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat mengambil data.');
        }
    });
});

$(document).on('click', '.btn-delete-kelas', function(e) {
    e.preventDefault();
    var id_kelas = $(this).data('id');

    swal({
        title: 'Apakah Anda yakin?',
        text: "Data kelas akan dihapus secara permanen!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            $.get("<?= route_to('data.kelas.drop') ?>", {
                    id: id_kelas
                })
                .done(function(response) {
                    if (response.status === 'success') {
                        kelas_DT.ajax.reload(null, false); // Reload DataTable tanpa reset paging
                        swal(
                            'Terhapus!',
                            'Data kelas berhasil dihapus.',
                            'success'
                        );
                    } else {
                        swal(
                            'Gagal!',
                            response.message || 'Gagal menghapus data kelas.',
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