<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme sitesidemenu">
  <div class="app-brand demo sideimgtxt">
    <a href="javascript:void(0);" class="app-brand-link">
    <a href="javascript:void(0);" class="layout-menu-toggle d-xl-none toggle-btn menu-link text-large ms-auto">
    <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
    <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>
  <?php $url = getUri(2) ?? 'dashboard'; ?>
  <p class="menuhdng">Navigation</p>
  <ul class="menu-inner py-1">
    <!-- Main Menu Item -->
    <li class="menu-item <?= $url == 'dashboard'? "active" : ""; ?>">
      <a href="<?=base_url(VENDORPATH.'dashboard')?>" class="menu-link">
        <img src="<?=base_url('assets/vendor/images/dashboard.png')?>">
        <div>Dashboard</div>
      </a>
    </li>
    <li class="menu-item <?= $url == 'booking-list'? "active" : ""; ?>">
      <a href="<?=base_url(VENDORPATH.'booking-list')?>" class="menu-link">
        <img src="<?=base_url('assets/vendor/images/notebook--reference.png')?>">
        <div>Bookings</div>
      </a>
      <!-- Submenu Items -->
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="" class="menu-link active">
            <div></div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item <?= $url == 'tickets'? "active" : ""; ?>">
      <a href="<?=base_url(VENDORPATH.'tickets')?>" class="menu-link">
        <img src="<?=base_url('assets/vendor/images/car.png')?>">
        <div>Tickets</div>
      </a>
    </li>
    <!--<li class="menu-item">-->
    <!--  <a href="<?=base_url(VENDORPATH.'setting')?>" class="menu-link">-->
    <!--    <img src="<?=base_url('assets/vendor/images/settings.png')?>">-->
    <!--    <div>Settings</div>-->
    <!--  </a>-->
    <!--</li>-->
    <li class="menu-item <?= $url == 'my-wallet'? "active" : ""; ?>">
      <a href="<?=base_url(VENDORPATH.'my-wallet')?>" class="menu-link">
        <img src="<?=base_url('assets/vendor/images/wallet.png')?>">
        <div>Wallets</div>
      </a>
    </li>
    <li class="menu-item <?= $url == 'my-profile'? "active" : ""; ?>">
      <a href="<?=base_url(VENDORPATH.'my-profile')?>" class="menu-link">
        <img src="<?=base_url('assets/vendor/images/settings.png')?>">
        <div>My Profile</div>
      </a>
    </li>
  </ul>
</aside>