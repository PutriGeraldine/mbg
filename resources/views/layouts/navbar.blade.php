<style>
body {
    margin: 0;
    padding-top: 60px; /* biar konten gak nutup navbar */
}

/* ================= NAVBAR ================= */
.navbar {
    position: fixed;
    top: 0;
    left: 250px; /* lebar sidebar default */
    right: 0;
    height: 60px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    z-index: 99999;
    box-sizing: border-box;
    transition: left 0.3s, width 0.3s;
    width: calc(100% - 250px);
}

.navbar-left {
    display: flex;
    align-items: center;        /* ⬅️ teks sejajar tombol */
    gap: 10px;                  /* ⬅️ jarak tombol & teks */
    font-weight: 600;
    font-size: 20px;
    /* white-space: nowrap; */
}

.navbar-left span {
    white-space: nowrap;  /* double safety */
}

.navbar-right {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-shrink: 0;
    white-space: nowrap;
}

/* user & logout */
.user-name {
    font-size: 14px;
    color: #555;
}

.logout-btn {
    padding: 8px 16px;
    background: #ff4d4f;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: 0.2s;
}

.logout-btn:hover {
    background: #d9363e;
}

/* TOGGLE BUTTON */
.toggle-btn {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
    padding: 4px 6px;
}

.toggle-btn:hover {
    color: #000;
}

/* ================= SIDEBAR ================= */
#sidebar {
    position: fixed;
    top: 60px;
    left: 0;
    width: 250px;
    height: 100%;
    background: #f1f1f1;
    transition: width 0.3s;
    overflow: hidden;
}

#sidebar.collapsed {
    width: 80px; /* versi kecil */
}
</style>

<div class="navbar">
    <div class="navbar-left">
        <button id="toggleSidebar" class="toggle-btn">☰</button>
        {{-- <span>MBG Super Admin</span> --}}
    </div>

    <div class="navbar-right">
        <div class="user-name">{{ auth()->user()->name }}</div>

        <a href="{{ route('logout') }}" class="logout-btn"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
</div>

<!-- Sidebar contoh -->
<div id="sidebar">
    <p style="padding:20px;">Menu Sidebar</p>
</div>

<script>
const toggleBtn = document.getElementById('toggleSidebar');
const sidebar = document.getElementById('sidebar');
const navbar = document.querySelector('.navbar');

toggleBtn.addEventListener('click', function() {
    sidebar.classList.toggle('collapsed');

    // Sesuaikan navbar
    if (sidebar.classList.contains('collapsed')) {
        navbar.style.left = '80px';
        navbar.style.width = 'calc(100% - 80px)';
    } else {
        navbar.style.left = '250px';
        navbar.style.width = 'calc(100% - 250px)';
    }
});
</script>