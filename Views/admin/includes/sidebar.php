<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme sitesidemenu">
  <div class="app-brand demo sideimgtxt">
    <a href="<?= base_url(ADMINPATH . 'dashboard') ?>" class="app-brand-link">
    <a href="javascript:void(0);" class="layout-menu-toggle d-xl-none toggle-btn menu-link text-large ms-auto">
    <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
    <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>
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
  <?php
    if(!empty($role) && ($role=="Role User")){
        
    $readMenuItems = $loginData['read_menu_ids'];
    $writeMenuItems = $loginData['write_menu_ids'];
    }
    
    $readMenuArray = !empty($readMenuItems) ? explode(',', $readMenuItems ) : []; 
    $writeMenuArray = !empty($writeMenuItems) ? explode(',', $writeMenuItems ) : []; 
    
    $menuList = $loginData['role']=="Role User"? menuList():getMenuList();
    
    ?>
  <p class="menuhdng">Navigation</p>
  <ul class="menu-inner py-1">
    <?php
      $url = getUri(2) ?? 'dashboard';
      
      if ($loginData['role'] == "Role User") {
        if (!empty($menuList)) {
          foreach ($menuList as $key => $value) {
            if ($value['type'] == 'Menu') {
              if ((in_array($value['id'], $readMenuArray)) || (in_array($value['id'], $writeMenuArray))) { ?>
    <li class="menu-item <?= $url == $value['slug'] ? "active" : "" ?>">
      <a href="<?= !empty($value['slug']) ? base_url(ADMINPATH) . $value['slug'] : '#'; ?>" class="menu-link <?= !empty($value['slug']) &&  $value['slug']=="#" ? "menu-toggle" : ''; ?>">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="<?= $value['menu_name']; ?>"><?= $value['menu_name']; ?></div>
      </a>
      <?php $subMenuList = getSubMenuList($menuList, $value['id']);
        if (!empty($subMenuList)) { ?>
      <ul class="menu-sub">
        <?php foreach ($subMenuList as $key => $value1) { ?>
        <li class="menu-item">
          <a href="<?= !empty($value1['slug']) ? base_url(ADMINPATH) . $value1['slug'] : '#'; ?>" class="menu-link <?= $url == $value1['slug'] ? "active" : ""; ?> <?=($value1['slug']=="view-teacher-detail")?"d-none":""?>" >
            <div data-i18n="<?= $value1['menu_name']; ?>"><?= $value1['menu_name']; ?></div>
          </a>
        </li>
        <?php } ?>
      </ul>
      <?php } ?>
    </li>
    <?php }
              }     
            }
          }
      } else { ?>
    <?php
      if (!empty($menuList)) {
        foreach ($menuList as $key => $value) {
          if ($value['type'] == 'Menu') { ?>
    <li class="menu-item  <?= $url == $value['slug'] ? "active" : "" ?>">
      <a href="<?= !empty($value['slug']) ? base_url(ADMINPATH) . $value['slug'] : '#'; ?>" class="menu-link <?= !empty($value['slug']) &&  $value['slug']=="#" ? "menu-toggle" : ''; ?>">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="<?= $value['menu_name']; ?>"><?= $value['menu_name']; ?></div>
      </a>
      <?php $subMenuList = getSubMenuList($menuList, $value['id']);
        if (!empty($subMenuList)) { ?>
      <ul class="menu-sub">
        <?php foreach ($subMenuList as $key => $value1) { ?>
        <li class="menu-item <?= $url == $value1['slug'] ? "active" : "" ?>">
          <a href="<?= !empty($value1['slug']) ? base_url(ADMINPATH) . $value1['slug'] : '#'; ?>" class="menu-link <?= $url == $value1['slug'] ? "active" : ""; ?> <?=($value1['slug']=="view-teacher-detail")?"d-none":""?>">
            <div data-i18n="<?= $value1['menu_name']; ?>"><?= $value1['menu_name']; ?></div>
          </a>
        </li>
        <?php } ?>
      </ul>
      <?php } ?>
    </li>
    <?php }
        }
       }
      } ?>
  </ul>
</aside>