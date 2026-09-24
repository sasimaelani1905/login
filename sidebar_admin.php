<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
        <a href="../home_admin/" class="nav-link <?php if ($hal == 'beranda_admin'){
            echo 'active';
            } ?>
            ">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Beranda</p>
        </a>
        
        <li class="nav-item">
        <a href="../admin_data_administrator/" class="nav-link <?= $aktif = ($hal == 'admin_admin')? 'active' :''?>">
            <i class="nav-icon fas fa-user"></i>
            <p>Data Pengguna</p>
        </a>

        <li class="nav-item">
        <a href="../admin_periode_akademik/" class="nav-link <?= $aktif = ($hal == 'periode_akademik')? 'active' :''?>">
            <i class="nav-icon fas fa-calendar"></i>
            <p>Periode Akademik</p>
        </a>

        <li class="nav-item">
        <a href="../data_dosen/" class="nav-link <?= $aktif = ($hal == 'dosen_dosen')? 'active' :''?>">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>Data Dosen</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="../data_mahasiswa/" class="nav-link <?= $aktif = ($hal == 'mhs_mahasiswa')? 'active' :''?>">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>Data Mahasiswa</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="../admin_mata_kuliah/" class="nav-link <?= $aktif = ($hal == 'mata_kuliah')? 'active' :''?>">
            <i class="nav-icon fas fa-book-open"></i>
            <p>Mata Kuliah</p>
        </a>
        </li>
        <li class="nav-item">
        <a href="../admin_data_kelas_matkul/" class="nav-link <?= $aktif = ($hal == 'data_kelas_matkul')? 'active' :''?>">
            <i class="nav-icon fas fa-book-open"></i>
            <p>Data Kelas Matkul</p>
        </a>
        </li>

        <li class="nav-item">
        <a href="../admin_data_jurusan/" class="nav-link <?= $aktif = ($hal == 'data_jurusan')? 'active' :''?>">
            <i class="nav-icon fas fa-book-open"></i>
            <p>Data Jurusan</p>
        </a>
        </li>

        <li class="nav-item">
        <a href="../admin_ganti_password/" class="nav-link <?= $aktif = ($hal == 'ganti_password')? 'active' :''?>">
            <i class="nav-icon fas fa-lock"></i>
            <p>Ganti Password</p>
        </a>
        <li class="nav-item">
        <a href="../logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Keluar</p>
        </a>
        </li>
    </ul>
</nav>