<div class="menu">
    <header class="header">
        <h1>CTChicks</h1>
        <div class="_name">
            <h2>Dashboard</h2>
        </div>
    </header>
    <div class="main-menu">
        <nav>
            <ul>
                <li><a href="<?=get_url() ?>"><i class="ri-user-add-line"></i>Profiles</a></li>
                <li><a href="<?=get_url() ?>add-city/"><i class="ri-map-pin-range-line"></i>Cities</a></li>
                <li><a href="<?=get_url() ?>"><i class="ri-pages-line"></i>City Content</a></li>
            </ul>
        </nav>
    </div>
    <div class="setting">
        <ul>
            <?php 
            if(!isset($_SESSION['email'])){
?><li><a href="<?=get_url() ?>auth-login"><i class="ri-login-box-line"></i>Login</a></li><?php
            }else{
                ?>
                <li><a href="<?=get_url() ?>auth-logout"><i class="ri-user-received-2-line"></i>Logout</a></li>
                <?php
            }
            ?>
            
            <li><a href="<?=get_url() ?>"><i class="ri-settings-2-line"></i> Settings</a></li>
        </ul>
    </div>
</div>