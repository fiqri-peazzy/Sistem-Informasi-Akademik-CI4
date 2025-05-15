<?= $this->extend('backend/layout/auth-layout') ?>
<?= $this->section('stylesheets') ?>
<style>
.login-box {
    width: 400px;
    padding: 40px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 15px 25px rgba(0, 0, 0, 0.3);
}

.login-title h2 {
    margin-bottom: 30px;
    font-weight: 700;
    color: #2575fc;
    text-align: center;
}

.input-group-text {
    background: #2575fc;
    color: #fff;
    border: none;
    cursor: pointer;
}

.input-group-text:hover {
    background: #1a52d1;
}

.btn-primary {
    background: #2575fc;
    border: none;
    font-weight: 600;
    transition: background 0.3s ease;
}

.btn-primary:hover {
    background: #1a52d1;
}

.forgot-password a {
    color: #2575fc;
    font-weight: 500;
    text-decoration: none;
}

.forgot-password a:hover {
    text-decoration: underline;
}
</style>
<?= $this->endSection('stylesheets') ?>

<?= $this->section('content') ?>


<div class="login-box">
    <div class="login-title">
        <h2>Login Sistem Informasi Akademik<br>TK Islam Alhijrah</h2>
    </div>
    <?php $validation = \Config\Services::validation(); ?>
    <form action="<?= route_to('admin.login.handler') ?>" method="post">
        <?= csrf_field() ?>

        <?php if (!empty(session()->getFlashdata('success'))) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>

        <?php if (!empty(session()->getFlashdata('fail'))) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('fail') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>

        <div class="input-group custom mb-3">
            <input type="text" class="form-control form-control-lg" placeholder="Username atau Email" name="login_id"
                value="<?= set_value('login_id') ?>">
            <div class="input-group-append custom">
                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
            </div>
        </div>
        <?php if ($validation->getError('login_id')) : ?>
        <div class="d-block text-danger mb-3">
            <?= $validation->getError('login_id') ?>
        </div>
        <?php endif; ?>

        <div class="input-group custom mb-3">
            <input type="password" id="password" name="password" class="form-control form-control-lg"
                placeholder="**********">
            <div class="input-group-append custom">
                <span class="input-group-text" id="togglePassword" style="cursor:pointer;">
                    <i class="dw dw-padlock1"></i>
                </span>
            </div>
        </div>
        <?php if ($validation->getError('password')) : ?>
        <div class="d-block text-danger mb-3">
            <?= $validation->getError('password') ?>
        </div>
        <?php endif; ?>

        <div class="row pb-30">
            <div class="col-6">

            </div>
            <div class="col-6 text-right">
                <div class="forgot-password">
                    <a href="<?= route_to('admin.forgot.form') ?>">Forgot Password?</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
            </div>
        </div>
    </form>
</div>



<?= $this->endsection('content') ?>

<?= $this->section('scripts') ?>
<script>
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

togglePassword.addEventListener('click', function() {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle icon (optional)
    this.querySelector('i').classList.toggle('dw-padlock1');
    this.querySelector('i').classList.toggle('dw-eye1');
});
</script>
<?= $this->endSection('scripts') ?>