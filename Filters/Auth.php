<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
class Auth implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $adminLoginData = session()->get("admin_login_data");
        if (!$adminLoginData) {
            return redirect()->to(base_url(ADMINPATH . "login"));
        }
        if ($adminLoginData['role'] !== "Admin") {
            $menu_list = $this->menuList();
            if ($menu_list) {
                $session = session()->get('admin_login_data');
                $readMenusIdsArray = $session['read_menu_ids']??'';
                $readMenusIds = explode(',', $readMenusIdsArray);
                $writeMenusIdsArray = $session['write_menu_ids']??'';
                $writeMenusIds = explode(',', $writeMenusIdsArray);
                $uri = $request->uri->getSegment(2);
                $matchMenuId = '';
                foreach ($menu_list as $key => $value) {
                    if (strtolower($value['slug']) === strtolower($uri)) {
                        $matchMenuId = $value['id'];
                        break;
                    }
                }
                if (empty($matchMenuId) || !in_array($matchMenuId, $readMenusIds) || !in_array($matchMenuId, $writeMenusIds)) {
                    // session()->setFlashdata('failed', 'Access Denied!');
                    // return redirect()->to(base_url(ADMINPATH . 'dashboard'));
                }
            }
        }
    }
    
    public function menuList() {
        $list = session()->get('menu_list');
        return !empty($list) ? json_decode($list, true) : getMenuList();
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
