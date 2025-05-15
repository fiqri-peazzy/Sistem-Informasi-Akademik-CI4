<div class="modal fade" id="modalEditSiswa" tabindex="-1" aria-labelledby="modalEditSiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formEditSiswa" method="post" action="<?= route_to('data.siswa.update') ?>">
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahSiswaLabel">Form Edit Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6 form-group">
                            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan nama lengkap">
                            <span class="error-text text-danger nama_error"></span>
                        </div>
                        <div class="col-6 form-group">
                            <label for="jk" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-control" id="jk" name="jk">
                                <option value="" selected disabled>Pilih jenis kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <span class="error-text text-danger jk_error"></span>
                        </div>

                        <div class="col-6 form-group">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" placeholder="Masukkan NISN">
                            <span class="error-text text-danger nisn_error"></span>
                        </div>
                        <div class="col-6 form-group">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                placeholder="Masukkan tempat lahir">
                            <span class="error-text text-danger tempat_lahir_error"></span>
                        </div>

                        <div class="col-6 form-group">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                            <span class="error-text text-danger tanggal_lahir_error"></span>
                        </div>
                        <div class="col-6 form-group">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK">
                            <span class="error-text text-danger nik_error"></span>
                        </div>

                        <div class="col-6 form-group">
                            <label for="agama" class="form-label">Agama</label>
                            <input type="text" class="form-control" id="agama" name="agama"
                                placeholder="Masukkan agama">
                            <span class="error-text text-danger agama_error"></span>
                        </div>
                        <div class="col-6 form-group">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input class="form-control" id="alamat" name="alamat"
                                placeholder="Masukkan alamat lengkap"></input>
                            <span class="error-text text-danger alamat_error"></span>
                        </div>

                        <div class="col-6 form-group">
                            <label for="rombel_saat_ini" class="form-label">Rombel Saat Ini</label>
                            <select name="rombel_saat_ini" id="rombel_saat_ini" class="form-control">
                                <option value="" selected>--pilih</option>
                                <?php foreach ($kelas as $k) : ?>
                                <option value="<?= $k->id ?>"><?= $k->nama_kelas ?></option>

                                <?php endforeach; ?>
                            </select>
                            <span class="error-text text-danger rombel_saat_ini_error"></span>
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