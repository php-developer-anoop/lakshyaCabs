<?php
namespace App\Controllers;
use App\Models\Common_model;
class Home extends BaseController {
    public $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
    }
    public function index() {
        $data = [];
        $data['url'] = '';
        $data['company'] = websetting('*');
        $data['meta_title'] = $data['company']['company_name'];
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';
        $data['about'] = $this->c_model->getSingle('cms', 'description', ['url' => 'about-us']);
        $data['testimonials'] = $this->c_model->getAllData("testimonials", "person_name,place,title,description,rating", ['status' => 'Active']);
        $data['faqs'] = '';
        $data['cab_packages'] = $this->c_model->getAllData("taxi_package_list", "id,package_title,jpg_image,webp_image,image_alt,url,mrp_price,offer_price,short_description", ['status' => 'Active', 'is_popular' => 'Yes'], 9, null, 'DESC', 'id');
        frontview('index', $data);
    }
}
