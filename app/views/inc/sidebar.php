<?php
    $currentPath = $_SERVER['REQUEST_URI'];

?>

<aside>
    <div class="sidebar-left-logo">
        <h1 class="text-2xl">eCare</h1>
        <img src="<?= URL_ROOT?>/assets/img/eCare-icon.png" style="width: 70px" alt="eCare icon">
    </div>


    <div class="sidebar-left-options">
        <a href="<?= URL_ROOT ?>/admin/dashboard"
   class="side-link<?= strpos($currentPath, '/admin/dashboard') !== false ? ' active' : '' ?>">
            <span class="material-symbols-sharp">dashboard</span>
            <h3>Dashboard</h3>
        </a>

        <!-- <a href="<?= URL_ROOT ?>/admin/user-management" class="side-link" onclick="setActiveLink(this); return false;">
            <span class="material-symbols-sharp">groups</span>
            <h3>Manage Users</h3>
        </a> -->

        
<!-- ...existing code... -->
<a href="<?= URL_ROOT ?>/admin/user-management"
   class="side-link<?= strpos($currentPath, '/admin/user-management') !== false ? ' active' : '' ?>">
    <span class="material-symbols-sharp">groups</span>
    <h3>Manage Users</h3>
</a>
        
        <a href="<?= URL_ROOT ?>/admin/medical-records"class="side-link<?= strpos($currentPath, '/admin/medical-records') !== false ? ' active' : '' ?>">
            <span class="material-symbols-sharp">
health_and_safety
</span>
            <h3>Medical Records</h3>
        </a>
        
        <a href="<?= URL_ROOT ?>/admin/prescriptions"class="side-link<?= strpos($currentPath, '/admin/prescriptions') !== false ? ' active' : '' ?>">
            <span class="material-symbols-sharp">medication</span>
            <h3>Prescriptions</h3>
        </a>
        
        <a href="<?= URL_ROOT ?>/admin/billings"class="side-link<?= strpos($currentPath, '/admin/billings') !== false ? ' active' : '' ?>" class="side-link" onclick="setActiveLink(this)">
            <span class="material-symbols-sharp">receipt_long</span>
            <h3>Billing</h3>
        </a>

        <a href="<?= URL_ROOT ?>/admin/inventory"class="side-link<?= strpos($currentPath, '/admin/inventory') !== false ? ' active' : '' ?>" class="side-link" onclick="setActiveLink(this)">
            <span class="material-symbols-sharp">inventory</span>
            <h3>Inventory</h3>
        </a>

        
        <div class="sidebar-left-lower">
            <a href="#" class="side-link" onclick="setActiveLink(this)">
                <span class="material-symbols-sharp">help</span>
                <h3>Help</h3>
            </a>
            <a href="<?= URL_ROOT ?>/user/logout">
                <span class="material-symbols-sharp">logout</span>
                <h3>Logout</h3>
            </a>
        </div>
    </div>

</aside>