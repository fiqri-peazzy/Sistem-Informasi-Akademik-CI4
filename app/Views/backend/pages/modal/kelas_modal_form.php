<!-- Modal Tambah Data Guru -->
<div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-labelledby="modalTambahKelasLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formTambahKelas" method="post" action="<?= route_to('data.kelas.store') ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKelasLabel">Tambah Data Guru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row g-3">
                            <div class="col-md-12 form-group">
                                <label for="">Nama Kelas</label>
                                <input type="text" name="nama_kelas" class="form-control" id="nama_kelas">
                                <span class="error-text text-danger nama_kelas_error"></span>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="">Wali Kelas</label>

                                <select name="wali_kelas" id="wali_kelas" class="form-control">
                                    <option value="" selected>--Pilih</option>
                                    <?php foreach ($guru as $g) : ?>
                                    <option value="<?= $g->id ?>"><?= $g->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="error-text text-danger wali_kelas_error"></span>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>