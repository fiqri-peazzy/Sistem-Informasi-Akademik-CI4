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
        </div>
    </div>
</div>
<?= $this->endSection('content') ?>