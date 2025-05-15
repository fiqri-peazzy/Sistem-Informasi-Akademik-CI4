<!-- Modal Edit Data Guru -->
<div class="modal fade" id="modalEditGuru" tabindex="-1" aria-labelledby="modalEditGuruLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formEditGuru" method="post" action="<?= route_to('data.guru.update') ?>">
                <input type="hidden" name="id" id="id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditGuruLabel">Edit Data Guru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row g-3">
                            <div class="col-md-6 form-group">
                                <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Masukkan nama lengkap">
                                <span class="error-text text-danger nama_error"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="jk" class="form-label">Jenis Kelamin <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="jk" name="jk">
                                    <option value="" selected disabled>Pilih jenis kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <span class="error-text text-danger jk_error"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                    placeholder="Masukkan tempat lahir">
                                <span class="error-text text-danger tempat_lahir_error"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                                <span class="error-text text-danger tanggal_lahir_error"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="status_kepegawaian" class="form-label">Status Kepegawaian <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="status_kepegawaian"
                                    name="status_kepegawaian" placeholder="Masukkan status kepegawaian">
                                <span class="error-text text-danger status_kepegawaian_error"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="jenis_ptk" class="form-label">Jenis PTK <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="jenis_ptk" name="jenis_ptk">
                                    <option value="" selected disabled>Pilih jenis PTK</option>
                                    <option value="Guru">Guru</option>
                                    <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                                    <option value="Kepala Sekolah">Kepala Sekolah</option>
                                    <option value="Guru Honor Sekolah">Guru Honor Sekolah</option>
                                    <option value="GTY/PTY">GTY/PTY</option>
                                </select>
                                <span class="error-text text-danger jenis_ptk_error"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="hp" name="hp"
                                    placeholder="Masukkan nomor HP">
                                <span class="error-text text-danger hp_error"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Masukkan email">
                                <span class="error-text text-danger email_error"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="agama" class="form-label">Agama</label>
                                <input type="text" class="form-control" id="agama" name="agama"
                                    placeholder="Masukkan agama">
                                <span class="error-text text-danger agama_error"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK">
                                <span class="error-text text-danger nik_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>