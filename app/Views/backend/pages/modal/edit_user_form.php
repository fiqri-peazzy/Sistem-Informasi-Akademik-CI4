<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEditUser" method="post" action="<?= route_to('data.user.update') ?>">
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditUserLabel">Edit Data Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12 form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" id="name">
                            <span class="error-text text-danger name_error"></span>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username">
                            <span class="error-text text-danger username_error"></span>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email">
                            <span class="error-text text-danger email_error"></span>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control"
                                placeholder="Kosongkan jika tidak ingin mengubah password" name="password"
                                id="password">
                            <span class="error-text text-danger password_error"></span>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="role">Role</label>
                            <select class="form-control" name="role" id="role">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="guru">Guru</option>
                                <option value="kepala">Kepala</option>
                                <option value="ortu">Orang Tua</option>
                            </select>
                            <span class="error-text text-danger role_error"></span>
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