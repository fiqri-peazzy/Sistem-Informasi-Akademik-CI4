<!-- Modal Import Excel Data Guru -->
<div class="modal fade" id="modalImportGuru" tabindex="-1" aria-labelledby="modalImportGuruLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formImportGuru" method="post" action="<?= route_to('data.guru.import') ?>"
                enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalImportGuruLabel">Import Data Guru (Excel)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file_excel" class="form-label">Pilih file Excel (.xlsx)</label>
                        <input class="form-control" type="file" id="file_excel" name="file_excel" accept=".xlsx"
                            required>
                    </div>
                    <div class="mb-3">
                        <a href="<?= base_url('templates/template_import_guru.xlsx') ?>" download
                            class="btn btn-sm btn-info">
                            <i class="fa fa-download"></i> Download Template Excel
                        </a>
                    </div>
                    <div class="progress mb-2">
                        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                    </div>
                    <div id="importStatus" class="mb-2"></div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>