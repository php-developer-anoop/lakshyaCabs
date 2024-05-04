<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
class Vendor implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        $vendorLoginData = session()->get("vendor_login_data");
        if (!$vendorLoginData) {
            return redirect()->to(base_url(VENDORPATH.'login'));
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
