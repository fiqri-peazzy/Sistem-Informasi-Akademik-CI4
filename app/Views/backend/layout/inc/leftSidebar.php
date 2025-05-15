<div class="left-side-bar">
    <div class="brand-logo">
        <a href="<?= route_to('admin.home') ?>">
            <img src="/backend/vendors/images/deskapp-logo.svg" alt="Logo" class="dark-logo">
            <img src="/backend/vendors/images/deskapp-logo-white.svg" alt="Logo" class="light-logo">
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">

                <li>
                    <a href="<?= route_to('admin.home') ?>"
                        class="dropdown-toggle no-arrow <?= current_url() == base_url('/admin/home') ? 'active' : '' ?>">
                        <span class="micon dw dw-home"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>

                <li>
                    <div class="dropdown-divider"></div>
                </li>

                <li>
                    <div class="sidebar-small-cap">Data Master</div>
                </li>

                <li>
                    <a href="<?= route_to('data.guru') ?>"
                        class="dropdown-toggle no-arrow <?= current_url() == base_url('/admin/guru') ? 'active' : '' ?>">
                        <span class="micon dw dw-user1"></span><span class="mtext">Data Guru</span>
                    </a>
                </li>

                <li>
                    <a href="<?= route_to('page.siswa') ?>"
                        class="dropdown-toggle no-arrow <?= current_url() == base_url('/admin/siswa') ? 'active' : '' ?>">
                        <span class="micon dw dw-group"></span><span class="mtext">Data Siswa</span>
                    </a>
                </li>

                <li>
                    <a href="<?= route_to('page.kelas') ?>"
                        class="dropdown-toggle no-arrow <?= current_url() == base_url('/admin/kelas')  ? 'active' : '' ?>">
                        <span class="micon dw dw-building"></span><span class="mtext">Data Kelas</span>
                    </a>
                </li>

                <li>
                    <a href="<?= route_to('page.users') ?>"
                        class="dropdown-toggle no-arrow <?= current_url() == base_url('/admin/data_users')  ? 'active' : '' ?>">
                        <span class="micon bi bi-people"></span><span class="mtext">Pengguna</span>
                    </a>
                </li>

                <li>
                    <a href="<?= route_to('data.jadwal_pelajaran') ?>" class="dropdown-toggle no-arrow">
                        <span class="micon fa fa-clock-o"></span><span class="mtext">Jadwal Pelajaran</span>
                    </a>
                </li>

                <li>
                    <div class="dropdown-divider"></div>
                </li>

                <li>
                    <div class="sidebar-small-cap">Akademik</div>
                </li>

                <li>
                    <a href="<?= route_to('absensi') ?>"
                        class="dropdown-toggle no-arrow <?= current_route_name() == 'absensi' ? 'active' : '' ?>">
                        <span class="micon dw dw-check"></span><span class="mtext">Absensi Siswa</span>
                    </a>
                </li>


                <li>
                    <a href="<?= route_to('penilaian.murid') ?>"
                        class="dropdown-toggle no-arrow <?= current_route_name() == 'penilaian.murid' ? 'active' : '' ?>">
                        <span class="micon ti-pencil"></span><span class="mtext">Penilaian Murid</span>
                    </a>
                </li>
                <li>
                    <a href="<?= route_to('raport') ?>"
                        class="dropdown-toggle no-arrow <?= current_route_name() == 'raport' ? 'active' : '' ?>">
                        <span class="micon dw dw-file-1"></span><span class="mtext">Raport</span>
                    </a>
                </li>

                <li>
                    <div class="dropdown-divider"></div>
                </li>

                <li>
                    <div class="sidebar-small-cap">Pendaftaran</div>
                </li>

                <li>
                    <a href="<?= route_to('pendaftaran.siswa_baru') ?>" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-add-user"></span><span class="mtext">PPDB</span>
                    </a>
                </li>

                <li>
                    <a href="<?= route_to('pendaftaran.status') ?>"
                        class="dropdown-toggle no-arrow <?= current_route_name() == 'pendaftaran.status' ? 'active' : '' ?>">
                        <span class="micon dw dw-list3"></span><span class="mtext">Status Pendaftaran</span>
                    </a>
                </li>

                <li>
                    <div class="dropdown-divider"></div>
                </li>

                <li>
                    <div class="sidebar-small-cap">Pengguna</div>
                </li>

                <li>
                    <a href="<?= route_to('admin.profile') ?>"
                        class="dropdown-toggle no-arrow <?= current_route_name() == 'admin.profile' ? 'active' : '' ?>">
                        <span class="micon dw dw-user"></span><span class="mtext">Profile</span>
                    </a>
                </li>

                <li>
                    <a href="<?= route_to('settings') ?>"
                        class="dropdown-toggle no-arrow <?= current_route_name() == 'settings' ? 'active' : '' ?>">
                        <span class="micon dw dw-settings2"></span><span class="mtext">Pengaturan Umum</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>