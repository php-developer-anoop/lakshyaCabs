</head> 
<body>
  <header>
    <div class="container-fluid">
      <div class="row">
        <div class="site_headr">
          <div class="logo_togglr">
            <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <img src="<?=base_url('assets/frontend/')?>images/toggle.png">
            </a>
            <div class="logo">
              <a href="<?=base_url()?>">
              <img src="<?=$logo?>">
              </a>
            </div>
          </div>
          <div class="hdr_btns">
            <a href="<?=base_url('book-tour-package')?>" class="sitebtn bgblue"> Book Tour Package </a>
            <!--<a href="<?=base_url('attach-taxi')?>" class="sitebtn bgbtn"> Attach Taxi </a>-->
            <a href="tel:<?=!empty($company['care_mobile'])?'+91'.$company['care_mobile']:""?>" class="sitebtn btbtn tbtn"> <i class="fa-solid fa-phone"></i> <?=!empty($company['care_mobile'])?'+91'.$company['care_mobile']:""?></a>
            <?php
              $usersession = session()->get('user_login_data');
              
              if (empty($usersession)) {
              ?>
            <a href="javascript:void(0)" class="cstmlogin" data-bs-toggle="modal" data-bs-target="#loginmodal"> <i class="fa-regular fa-user"></i></a>
            <?php } else { ?>
            <a href="<?= base_url(USERPATH . 'my-bookings') ?>" class="cstmlogin"> <i class="fa-regular fa-user"></i></a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </header>
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <div class="logo">
              <a href="<?=base_url()?>">
                 <img src="<?=$logo?>">
              </a>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="site_menu">
        <ul>
          <li> <a href="<?=base_url()?>"> <img src="<?=base_url('assets/frontend/')?>images/mi1.png">  Home </a></li>
          
          <li> <a href="<?=base_url('about-us')?>"> <img src="<?=base_url('assets/frontend/')?>images/mi4.png">  About Us </a></li>
          <li> <a href="<?=base_url('drive-with-us')?>"> <img src="<?=base_url('assets/frontend/')?>images/mi5.png"> Drive With Us </a></li>
          <li> <a href="<?=base_url('contact-us')?>"> <img src="<?=base_url('assets/frontend/')?>images/mi7.png"> Contact Us </a></li>
          <?php
              $usersession = session()->get('user_login_data');
              
              if (!empty($usersession)) {
              ?>
              <li> <a href="<?=base_url(USERPATH.'my-profile')?>"> <img src="<?=base_url('assets/frontend/')?>images/mi2.png"> Profile </a></li>
          <li> <a href="<?=base_url(USERPATH.'my-bookings')?>"> <img src="<?=base_url('assets/frontend/')?>images/mi3.png">  My Bookings </a></li>
          <li> <a href="javascript:void(0)"> <img src="<?=base_url('assets/frontend/')?>images/mi9.png"> Logout </a></li>
          <?php } ?>
        </ul>
        <div class="canvasbtns">
          <a href="<?=base_url('book-tour-package')?>" class="sitebtn bgblue mb-3"> Book Tour Package </a>
          <a href="tel:<?=!empty($company['care_mobile'])?'+91'.$company['care_mobile']:""?>" class="sitebtn btbtn tbtn">
              <i class="fa-solid fa-phone"></i> <?=!empty($company['care_mobile'])?'+91'.$company['care_mobile']:""?>
          </a>
        </div>
      </div>
    </div>
  </div>