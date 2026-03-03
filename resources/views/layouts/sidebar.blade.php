<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* RESET */
body {
    margin: 0;
    font-family: Arial, sans-serif;
}

/* ================= SIDEBAR ================= */
.sidebar {
    width: 250px;
    background: #1e293b;
    color: #fff;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    transition: width 0.3s ease;
    overflow: hidden;
}

.sidebar.collapsed {
    width: 80px;
}

/* ===== BRAND ===== */
.sidebar-header {
    padding: 18px 20px;
}

.brand {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo {
    width: 50px;
    height: 50px;
    object-fit: contain;
}

.brand-text {
    font-size: 14px;
    font-weight: 600;
    line-height: 1.2;
    white-space: normal;
    max-width: 150px;
    transition: opacity 0.3s ease;
}

.sidebar.collapsed .brand-text {
    opacity: 0;
    visibility: hidden;
    width: 0;
}

.sidebar.collapsed .brand {
    justify-content: center;
}

.sidebar.collapsed .sidebar-header {
    padding: 20px 0;
}

/* ================= MENU ================= */
.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 10px 0 0 0;
}

.sidebar-menu li {
    margin: 5px 0;
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 20px;
    color: #cbd5e1;
    text-decoration: none;
    font-size: 14px;
    transition: 0.2s;
    border-left: 3px solid transparent;
    white-space: nowrap;
}

.sidebar-menu a i {
    font-size: 18px;
    min-width: 20px;
    text-align: center;
}

.sidebar-menu a:hover,
.sidebar-menu a.active {
    background: #334155;
    color: #fff;
    border-left: 3px solid #3399ff;
}

.sidebar.collapsed .menu-text {
    opacity: 0;
    visibility: hidden;
    width: 0;
}

.sidebar.collapsed .sidebar-menu a {
    justify-content: center;
}

</style>
</head>
<body>

@auth

<div class="sidebar">

    <!-- BRAND -->
    <div class="sidebar-header">
        <div class="brand">
            <img src="{{ asset('assets/logoBulat.png') }}" class="logo">
            <span class="brand-text">
                Satuan Penjaminan Pemenuhan Gizi
            </span>
        </div>
    </div>

    <ul class="sidebar-menu">

        <!-- SUPER ADMIN -->
        @role('super-admin')
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('role.permission') }}">
                    <i class="fas fa-user-shield"></i>
                    <span class="menu-text">Role & Permission</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fas fa-users-cog"></i>
                    <span class="menu-text">Manajemen User</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('datasppg.index') }}">
                    <i class="fas fa-database"></i>
                    <span class="menu-text">Data SPPG</span>
                </a>
            </li>
        @endrole


        <!-- ADMIN -->
        @role('admin')
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="fas fa-home"></i>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('datasppg.index') }}">
                <i class="fas fa-users"></i>
                <span class="menu-text">Data SPPG</span>
            </a>
        </li>
        @endrole


        <!-- PEMDA -->
        @role('pemda')
        <li>
                <a href="{{ route('pemda.dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('datasppg.index') }}">
                    <i class="fas fa-database"></i>
                    <span class="menu-text">Data SPPG</span>
                </a>
            </li>
        @endrole


        <!-- USER -->
        @role('user')
            <li>
                <a href="{{ route('user.dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('datasppg.index') }}">
                    <i class="fas fa-file-alt"></i>
                    <span class="menu-text">Data SPPG</span>
                </a>
            </li>
        @endrole


        <!-- SEMUA ROLE -->
        <li>
            <a href="#">
                <i class="fas fa-cog"></i>
                <span class="menu-text">Pengaturan</span>
            </a>
        </li>

    </ul>
</div>

@endauth

</script>

</body>
</html>