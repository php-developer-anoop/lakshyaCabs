<div class="wd80 tophdrrow d-flex justify-content-end">
  <div class="topdashhdr d-flex align-items-center">
    <div class="togglemenu d-lg-none d-md-none d-xl-none">
      <i class="fa-solid fa-bars"></i>
    </div>
    <div class="d-flex align-items-center hdrprof_menu">
      <img src="<?=!empty($profile_pic)?$profile_pic:base_url('assets/user/images/user.png')?>" width="50" height="50">
      <div class="nav-item dropdown">
        <a id="dropdownMenuButton1" aria-expanded="false" data-bs-toggle="dropdown" class="dropdown-toggle nav-link" href="javascript:void(0)"><?=$profile_name?></a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li><a class="dropdown-item" href="#">Book Cab</a></li>
          <li><a class="dropdown-item" href="<?=base_url(USERPATH.'logout')?>">Logout</a></li>
        </ul>
      </div>
      <div class="notf_icn">
        <i class="fa-solid fa-bell"></i>
      </div>
    </div>
  </div>
</div>