<aside>
    <div class="sidebar-left-logo">
        <h1 class="text-2xl">eCare</h1>
        <img src="./assets/img/eCare-icon.png" style="width: 70px" alt="eCare icon">
    </div>


    <div class="sidebar-left-options">
        <a href="#" class="side-link" onclick="setActiveLink(this)">
            <span class="material-symbols-sharp">dashboard</span>
            <h3>Dashboard</h3>
        </a>

        <a href="#" class="side-link" onclick="setActiveLink(this)">
            <span class="material-symbols-sharp">groups</span>
            <h3>Manage Users</h3>
        </a>

        <a href="#" class="side-link" onclick="setActiveLink(this)">
            <i class="fa-solid fa-user-doctor"></i>
            <h3>Appointments</h3>
        </a>
        
        <a href="#" class="side-link" onclick="setActiveLink(this)">
            <i class="fa-solid fa-notes-medical"></i>
            <h3>Medical Records</h3>
        </a>
        
        <a href="#" class="side-link" onclick="setActiveLink(this)">
            <span class="material-symbols-sharp">medication</span>
            <h3>Prescriptions</h3>
        </a>
        
        <a href="#" class="side-link" onclick="setActiveLink(this)">
            <span class="material-symbols-sharp">receipt_long</span>
            <h3>Billing</h3>
        </a>

        <a href="#" class="side-link" onclick="setActiveLink(this)">
            <span class="material-symbols-sharp">inventory</span>
            <h3>Inventory</h3>
        </a>

        <a href="#" class="side-link" onclick="setActiveLink(this)">
            <span class="material-symbols-sharp">description</span>
            <h3>Reports</h3>
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