<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme customtopnav" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
    <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>
  <div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">
    <div class="logotoggle">
      <div class="hdrlogo">
        <a href="<?=base_url(VENDORPATH.'dashboard')?>">
        <img src="<?=$logo?>">
        </a>
      </div>
      <div class="togglemenu">
        <img src="<?=base_url('assets/vendor/images/menuicon.png')?>">
      </div>
    </div>
    <div class="currentdate">
      <p><i class="fa-regular fa-calendar"></i> <?=date('d-m-Y h:i a')?></p>
    </div>
    <div class="time_menu_notifi">
      <p class="logintime">Login: 05/01/2024, 11:00 am</p>
      <p class="notification">
          <a href="<?=base_url(VENDORPATH.'notification-list')?>">
        <i class="fa-regular fa-bell"></i>
        <span class="notf_count">2</span>
        </a>
      </p>
      <ul class="navbar-nav align-items-center ms-auto">
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
              <img src="<?=base_url('assets/vendor/images/prf.png')?>" alt class="w-px-40 h-auto rounded-circle" />
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="<?=base_url(VENDORPATH.'logout')?>">
              <i class="bx bx-power-off me-2"></i>
              <span class="align-middle">Log Out</span>
              </a>
            </li>
          </ul> 
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="layout-wrapper layout-content-navbar">
<div class="layout-container">
<div class="layout-page">
       <div class="modal fade mt-3" id="bookingDetailModal">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <!--<div class="modal-header">-->
      <!--  <h1 class="modal-title fs-4" id="bookingDetailModal">Booking Details</h1>-->
      <!--  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
      <!--</div>-->
      <div class="modal-body" id="appendBookingDetail">
        
      </div>
    </div>
  </div>
</div>