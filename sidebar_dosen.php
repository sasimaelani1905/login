<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
        <a href="../home_admin/" class="nav-link <?php if ($hal == 'beranda_dosen'){echo 'active';
            } ?>
            ">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Beranda</p>
        </a>
        </li>

        <li class="nav-item">
        <a href="../dosen_kelas_matkul/" class="nav-link <?= $aktif = ($hal == 'dosen_kelas_matkul')? 'active' :''?>">
            <i class="nav-icon fas fa-book-open"></i>
            <p>Kelas Mata Kuliah</p>
        </a>
        </li>
        
        <li class="nav-item">
        <a href="../dosen_ganti_password/" class="nav-link <?= $aktif = ($hal == 'ganti_password')? 'active' :''?>">
            <i class="nav-icon fas fa-lock"></i>
            <p>Ganti Password</p>
        </a>
        </li>
        
        <li class="nav-item">
        <a href="../logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Keluar</p>
        </a>
        </li>
    </ul>
</nav>