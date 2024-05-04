<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
class User implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $userLoginData = session()->get("user_login_data");
        if (!$userLoginData) {
            return redirect()->to(base_url());
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
