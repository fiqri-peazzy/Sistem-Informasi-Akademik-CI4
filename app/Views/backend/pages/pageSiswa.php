<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Data Siswa</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= route_to('admin.home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Data Siswa
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Siswa</h5>
        <button class="btn btn-primary btn-sm btnAddSiswa">
            <i class="bi bi-plus-circle me-1"></i> Tambah Data Siswa
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tableSiswa" class="table table-sm table-borderless table-hover table-strip" style="width:100%">
                <thead class="">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis Kelamin</th>
                        <th>NISN</th>
                        <th>Kelas</th>

                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan di-load via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('modal/siswa_modal_form.php') ?>
<?php include('modal/edit_siswa_form.php') ?>
<?= $this->endSection('content') ?>
<?= $this->section('scripts')  ?>
<script>
$('.btnAddSiswa').on('click', function() {
    var modal = $('body').find('div#modalTambahSiswa');
    modal.modal('show');
});

$('#formTambahSiswa').submit(function(e) {
    e.preventDefault();

    // Reset error text
    $('.error-text').text('');

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 0) {
                // Tampilkan error validasi
                $.each(response.error, function(field, message) {
                    $('.' + field + '_error').text(message);
                });
            } else {
                // Berhasil simpan data
                toastr.success(response.msg);
                $('#modalTambahSiswa').modal('hide');
                // Reload data tabel atau lakukan aksi lain
                siswa_DT.ajax.reload(null, false)
            }
        },
        error: function() {
            toastr.error('Terjadi kesalahan saat mengirim data.');
        }
    });
});
var siswa_DT = $('#tableSiswa').DataTable({
    processing: true,
    serverSide: true,
    ajax: "<?= route_to('data.siswa.datatables') ?>",
    dom: "Brtip",
    info: false,
    ordering: false,

    fnCreatedRow: function(row, data, index) {
        $('td', row).eq(0).html(index + 1);
    },

});

$(document).on('click', '.btnEditSiswa', function(e) {
    e.preventDefault();
    var id_siswa = $(this).data('id');

    $.getJSON("<?= route_to('get.data.siswa') ?>", {
        id_siswa: id_siswa
    }, function(response) {
        if (response.data) {
            var modal = $('#modalEditSiswa');
            modal.find('input[name="id"]').val(response.data.id);
            modal.find('input[name="nama"]').val(response.data.nama);
            modal.find('select[name="jk"]').val(response.data.jk);
            modal.find('input[name="nisn"]').val(response.data.nisn);
            modal.find('input[name="tempat_lahir"]').val(response.data.tempat_lahir);
            modal.find('input[name="tanggal_lahir"]').val(response.data.tanggal_lahir);
            modal.find('input[name="nik"]').val(response.data.nik);
            modal.find('input[name="agama"]').val(response.data.agama);
            modal.find('input[name="alamat"]').val(response.data.alamat);
            modal.find('select[name="rombel_saat_ini"]').val(response.data.rombel_saat_ini);
            modal.modal('show');
        } else {
            alert('Data siswa tidak ditemukan.');
        }
    }).fail(function() {
        alert('Terjadi kesalahan saat mengambil data.');
    });
});

$(document).on('submit', '#formEditSiswa', function(e) {
    e.preventDefault();

    // Reset error text
    $('.error-text').text('');

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 0) {
                // Tampilkan error validasi
                $.each(response.error, function(field, message) {
                    $('.' + field + '_error').text(message);
                });
            } else {
                toastr.success(response.msg);
                $('#modalEditSiswa').modal('hide');
                // Reload data tabel atau aksi lain
                siswa_DT.ajax.reload(null, false)
            }
        },
        error: function() {
            toastr.error('Terjadi kesalahan saat mengirim data.');
        }
    });
});

$(document).on('click', '.btnDeleteSiswa', function(e) {
    e.preventDefault();
    var id_siswa = $(this).data('id');

    swal({
        title: 'Yakin ingin menghapus data siswa ini?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            $.getJSON("<?= route_to('data.siswa.drop') ?>", {
                id_siswa: id_siswa
            }, function(response) {
                if (response.status === 1) {
                    toastr.success(response.msg);
                    siswa_DT.ajax.reload(null, false);

                } else {
                    toastr.error(response.msg || 'Gagal menghapus data.');
                }
            }).fail(function() {
                toastr.error('Terjadi kesalahan saat menghapus data.');
            });
        }
    });
});
</script>
<?= $this->endSection('scripts')  ?>