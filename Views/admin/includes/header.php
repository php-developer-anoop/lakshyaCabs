</head>
<body>
  <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme customtopnav" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
      <?php 
        $session = session();
        $username = '';
        $role = '';
        if ($session->has('admin_login_data')) {
         $loginData = $session->get('admin_login_data');
        
         if (isset($loginData['name'])) {
           $username = $loginData['name'];
         }
         if (isset($loginData['role'])) {
           $role = $loginData['role'];
         }
        }
        ?>
      <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
      </a>
    </div>
    <div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">
      <!--<p class="fs-4 text-center mt-3">Welcome <?= $username; ?> (<?= $role; ?>)</p>-->
      <div class="logotoggle">
          <div class="hdrlogo">
            <img src="<?=$logo?>">
          </div>
          <div class="togglemenu">
              <img src="<?=base_url('assets/vendor/images/menuicon.png')?>">
          </div>
      </div>
      <div class="currentdate">
          <p><i class="fa-regular fa-calendar"></i> <span id=""><?=date('d-m-Y h:i a')?></span> </p>
      </div>
      <div class="time_menu_notifi">
        <p class="logintime">Login: <?=!empty($loginData['login_at'])?date('d-m-Y h:i a',strtotime($loginData['login_at'])):''?></p>
        <p class="notification">
            <i class="fa-regular fa-bell"></i>
            <span class="notf_count">2</span>
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
              <a class="dropdown-item" href="<?=base_url(ADMINPATH.'logout')?>">
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