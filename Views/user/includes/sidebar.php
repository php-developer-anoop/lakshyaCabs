<div class="sidebarmenu">
  <div class="px-sm-2 px-0">
    <div class="sidelogo">
      <a href="<?=base_url()?>">
      <img src="<?=$logo?>">
   
      </a>
      <?php  $url = getUri(2) ?? 'my-bookings'; ?>
      <div class="closemenu d-lg-none d-md-none d-xl-none">
        <i class="fa-solid fa-xmark"></i>
      </div>
    </div>
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
      <h5 class="pb-3">
        <span class="fs-5 d-sm-inline">Menu</span>
      </h5>
      <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
        <li class="nav-item <?=$url=='my-bookings'?'active':''?>">
          <a href="<?=base_url(USERPATH.'my-bookings')?>" class="nav-link align-middle px-0">
          <i class="fa-solid fa-file-lines"></i> <span class="ms-1 d-sm-inline">My Bookings</span>
          </a>
        </li>
        <li class="nav-item <?=$url=='my-profile'?'active':''?>">
          <a href="<?=base_url(USERPATH.'my-profile')?>" class="nav-link px-0 align-middle">
          <i class="fa-solid fa-user"></i> <span class="ms-1 d-sm-inline">My Profile</span>
          </a>
        </li>
        <li class="nav-item <?=$url=='my-wallet'?'active':''?>">
          <a href="<?=base_url(USERPATH.'my-wallet')?>" class="nav-link px-0 align-middle">
          <i class="fa-solid fa-wallet"></i> <span class="ms-1 d-sm-inline">My Wallet</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?=base_url('')?>" class="nav-link px-0 align-middle">
          <i class="fa-solid fa-taxi"></i> <span class="ms-1 d-sm-inline">Book Cab</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?=base_url(USERPATH.'logout')?>" class="nav-link px-0 align-middle">
          <i class="fa-solid fa-arrow-right-from-bracket"></i> <span class="ms-1 d-sm-inline">Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>