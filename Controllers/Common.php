<?php
namespace App\Controllers;
use App\Models\Common_model;
class Common extends BaseController {
    public $c_model;
    public $session;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
    }
    public function index() {
        $data = [];
        $uri = service('uri');
        $url = $uri->setSilent()->getSegment(1);
        $dest_url = [];
        $destination_package = [];
        $common_cms_page = $this->c_model->getSingle("all_cms_data", '*', ['status' => 'Active', 'page_slug' => $url, 'page_type' => 'common']);
        $route_cms_page = $this->c_model->getSingle("all_cms_data", '*', ['status' => 'Active', 'page_slug' => $url, 'page_type' => 'route']);
        $seo_page = $this->c_model->getSingle("all_cms_data", '*', ['status' => 'Active', 'page_slug' => $url, 'page_type' => 'seo']);
   
        $package_detail = $this->c_model->getSingle("package_list", '*,jpg_image as banner_image_jpg,webp_image as banner_image_webp', ['status' => 'Active', 'url' => $url]);
        $package_listing = $this->c_model->getSingle("package_category", '*,jpg_image as banner_image_jpg,webp_image as banner_image_webp', ['status' => 'Active', 'url' => $url]);
        $destination_detail = $this->c_model->getSingle("destinations", '*,jpg_image as banner_image_jpg,webp_image as banner_image_webp', ['status' => 'Active', 'url' => $url]);
        $cab_package_detail = $this->c_model->getSingle("taxi_package_list", '*,jpg_image as banner_image_jpg,webp_image as banner_image_webp', ['status' => 'Active', 'url' => $url]);
        $route_detail = $this->c_model->getSingle("popular_routes", '*,jpg_image as banner_image_jpg,webp_image as banner_image_webp', ['status' => 'Active', 'url' => $url]);
        if (strpos($url, '-packages')) {
            $dest_url = explode('-packages', $url);
            $destination_package = $this->c_model->getSingle("destinations", '*,jpg_image as banner_image_jpg,webp_image as banner_image_webp', ['status' => 'Active', 'url' => $dest_url[0]]);
        }
        if ($common_cms_page) {
            $this->LoadCMSPages($url, $common_cms_page);
        } else if ($route_cms_page) {
            $this->LoadRouteCMSPages($url, $route_cms_page);
        } else if ($seo_page) {
            $this->LoadSeoPages($url, $seo_page);
        } else if ($package_detail) {
            $this->LoadPackageDetail($url, $package_detail);
        } else if ($package_listing) {
            $this->LoadPackageListing($url, $package_listing);
        } else if ($destination_detail) {
            $this->LoadDestinationDetail($url, $destination_detail);
        } else if (!empty($destination_package)) {
            $this->LoadDestinationPackages($url, $destination_package);
        } else if ($cab_package_detail) {
            $this->LoadCabPackageDetail($url, $cab_package_detail);
        } else if ($route_detail) {
            $this->LoadRouteDetail($url, $route_detail);
        } else if ($url == 'taxi-list') {
            $this->LoadTaxiList();
        } else if ($url == 'taxi-details') {
            $this->LoadTaxiDetail();
        }
    }
    public function LoadCMSPages($url, $page) {
        if ($url == "about-us") {
            $data = [];
            $data['url'] = $url;
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['why_choose'] = $this->c_model->getAllData("why_choose_us", "title,description", ['status' => 'Active']);
            $data['page'] = $page;
            frontview('about-us', $data);
        } else if ($url == "faqs") {
            $data = [];
            $data['url'] = $url;
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['page'] = $page;
            $data['faqs'] = $this->c_model->getAllData("faqs", "question,answer", null, null, null, 'DESC');
            frontview('faq', $data);
        } else if ($url == "book-tour-package") {
            $data = [];
            $data['url'] = $url;
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['page'] = $page;
            $data['faqs'] = $this->c_model->getAllData("faqs", "question,answer", ['status' => 'Active', 'table_name' => 'dt_cms', 'table_list_id' => $page['id']], null, null, 'DESC', 'id');
            $data['popular_packages'] = $this->c_model->getAllData("package_list", "package_title,jpg_image,webp_image,image_alt,url,no_of_days_nights,mrp_price,offer_price,package_category_ids", ['status' => 'Active', 'is_popular' => 'Yes'], 6, null, 'DESC', 'id');
            $data['popular_category'] = $this->c_model->getAllData("package_category", "id,category_name,jpg_image,webp_image,image_alt,url", ['status' => 'Active', 'is_popular' => 'Yes'], null, null, 'DESC', 'id');
            $data['popular_destination'] = $this->c_model->getAllData("destinations", "id,destination,url,jpg_image,webp_image,image_alt", ['status' => 'Active', 'is_popular' => 'Yes'], null, null, 'DESC', 'id');
            $data['testimonials'] = $this->c_model->getAllData("testimonials", "*", ['status' => 'Active', 'jpg_image != ' => ''], null, null, 'DESC', 'id');
            $special_category = $this->c_model->getAllData("package_category", "id,category_name", ['status' => 'Active', 'is_special' => 'Yes'], 4, null, 'ASC', 'id');
            $data['special_category'] = $special_category;
            if (!empty($special_category)) {
                $id = $special_category[0]['id'];
                $query = db()->query("SELECT id, package_title, jpg_image, webp_image, image_alt, url, no_of_days_nights, mrp_price, offer_price,package_category_ids FROM dt_package_list WHERE status='Active' AND is_special='Yes' AND FIND_IN_SET('" . $id . "',package_category_ids)");
                $data['special_packages'] = $query->getResultArray();
            } else {
                $data['special_packages'] = [];
            }
            frontview('tour-package', $data);
        } else if ($url == "privacy-policy") {
            $data = [];
            $data['url'] = $url;
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['page'] = $page;
            frontview('privacy-policy', $data);
        } else if ($url == "terms-and-conditions") {
            $data = [];
            $data['url'] = $url;
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['page'] = $page;
            frontview('terms-conditions', $data);
        } else if ($url == "contact-us") {
            $data = [];
            $data['url'] = $url;
            $data['company'] = websetting('*');
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['page'] = $page;
            frontview('contact', $data);
        } else if ($url == "refund-policy") {
            $data = [];
            $data['url'] = $url;
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['page'] = $page;
            frontview('refund-policy', $data);
        } else if ($url == "attach-taxi") {
            $data = [];
            $data['url'] = $url;
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['page'] = $page;
            frontview('attach-taxi', $data);
        } else if ($url == "testimonials") {
            $data = [];
            $data['url'] = $url;
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['page'] = $page;
            $data['testimonials'] = $this->c_model->getAllData("testimonials", "person_name,place,title,description,rating", ['status' => 'Active']);
            frontview('reviews-listing', $data);
        } else if ($url == "drive-with-us") {
            $data = [];
            $data['url'] = $url;
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['page'] = $page;
            $data['why_choose'] = $this->c_model->getAllData("why_choose_drive", "title,description", ['status' => 'Active']);
            frontview('driver', $data);
        } else if ($url == "speciality-tour") {
            $data = [];
            $data['url'] = $url;
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['page'] = $page;
            $data['packages'] = $this->c_model->getAllData("package_list", "id, package_title, jpg_image, webp_image, image_alt, url, no_of_days_nights, mrp_price, offer_price,short_description", ['status' => 'Active', 'is_special' => 'Yes'], null, null, 'DESC', 'id');
            frontview('package-list', $data);
        } else if ($url == "popular-tour-packages") {
            $data = [];
            $data['url'] = $url;
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['page'] = $page;
            $data['packages'] = $this->c_model->getAllData("package_list", "id, package_title, jpg_image, webp_image, image_alt, url, no_of_days_nights, mrp_price, offer_price,short_description", ['status' => 'Active', 'is_popular' => 'Yes'], null, null, 'DESC', 'id');
            frontview('package-list', $data);
        } else if ($url == "popular-destinations") {
            $data = [];
            $data['url'] = $url;
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['page'] = $page;
            $data['packages'] = $this->c_model->getAllData("destinations", "id, destination, jpg_image, webp_image, image_alt, url, description", ['status' => 'Active', 'is_popular' => 'Yes'], null, null, 'DESC', 'id');
            frontview('package-list', $data);
        } else if ($url == "trending-cab-packages") {
            $data = [];
            $data['url'] = $url;
            $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
            $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
            $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
            $data['page'] = $page;
            $data['faqs'] = $this->c_model->getAllData("faqs", "question,answer", ['status' => 'Active', 'table_name' => 'dt_cms', 'table_list_id' => $page['id']], null, null, 'DESC', 'id');
            $data['cab'] = 'd-none';
            $data['packages'] = $this->c_model->getAllData("taxi_package_list", "id, package_title, jpg_image, webp_image, image_alt, url, mrp_price, offer_price,short_description", ['status' => 'Active', 'is_popular' => 'Yes'], null, null, 'DESC', 'id');
            frontview('package-list', $data);
        }
    }
    public function LoadRouteCMSPages($url, $page) {
        $data = [];
        $data['url'] = $url;
        $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
        $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
        $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
        $data['page'] = $page;
        $data['faqs'] = $this->c_model->getAllData("faqs", "question,answer", ['status' => 'Active', 'table_name' => 'dt_all_cms_data', 'table_list_id' => $page['id']], null, null, 'DESC', 'id');
        $data['testimonials'] = $this->c_model->getAllData("testimonials", "*", ['status' => 'Active', 'jpg_image != ' => ''], null, null, 'DESC', 'id');
        $data['route_list'] = $this->c_model->getAllData('all_cms_data', 'to_city_name,page_slug', ['status' => 'Active', 'from_city_id' => $page['from_city_id'], 'to_city_name != ' => '', 'page_type' => 'route', 'trip_type' => 'Oneway']);
        $data['tariff_list'] = $this->c_model->getAllData('fare_configuration', 'model_id,trip_type,base_covered_km, per_km_charge,(base_covered_km * per_km_charge) as min_charge,', ['pickup_city_id' => $page['from_city_id']], null, null, 'ASC', '(base_covered_km * per_km_charge)');
        frontview('package-details', $data);
    }
    public function LoadPackageDetail($url, $page) {
        $data = [];
        $data['url'] = $url;
        $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
        $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
        $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
        $data['page'] = $page;
        $data['faqs'] = $this->c_model->getAllData("faqs", "question,answer", ['status' => 'Active', 'table_name' => 'dt_package_list', 'table_list_id' => $page['id']], null, null, 'DESC', 'id');
        $data['testimonials'] = $this->c_model->getAllData("testimonials", "*", ['status' => 'Active', 'jpg_image != ' => ''], null, null, 'DESC', 'id');
        $data['route_list'] = '';
        $data['tariff_list'] = $this->c_model->getAllData('fare_configuration', 'model_id,base_covered_km,per_km_charge', ['pickup_city_id' => $page['from_city_id']]);
        frontview('package-details', $data);
    }
    public function LoadRouteDetail($url, $page) {
        $data = [];
        $data['url'] = $url;
        $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
        $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
        $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
        $data['page'] = $page;
        $data['cab'] = 'd-none';
        $data['faqs'] = $this->c_model->getAllData("faqs", "question,answer", ['status' => 'Active', 'table_name' => 'dt_popular_routes', 'table_list_id' => $page['id']], null, null, 'DESC', 'id');
        $data['testimonials'] = $this->c_model->getAllData("testimonials", "*", ['status' => 'Active', 'jpg_image != ' => ''], null, null, 'DESC', 'id');
        $data['route_list'] = '';
        $data['tariff_list'] = $this->c_model->getAllData('fare_configuration', 'model_id,base_covered_km,per_km_charge', ['pickup_city_id' => $page['from_city_id']]);
        frontview('package-details', $data);
    }
    public function LoadCabPackageDetail($url, $page) {
        $data = [];
        $data['url'] = $url;
        $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
        $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
        $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
        $data['page'] = $page;
        $data['vehicles'] = $this->c_model->getAllData("taxi_package_vehicle_price", "taxi_package_vehicle_price.model_id, taxi_package_vehicle_price.fixed_price, taxi_package_vehicle_price.per_km_price, vehicle_model.model_name, vehicle_model.jpg_image, vehicle_model.webp_image, vehicle_model.image_alt", ['taxi_package_vehicle_price.status' => 'Active', 'taxi_package_vehicle_price.taxi_package_id' => $page['id']], null, null, null, null, null, 'vehicle_model', 'taxi_package_vehicle_price.model_id = vehicle_model.id');
        $data['popular_packages'] = $this->c_model->getAllData("taxi_package_list", "id,package_title,jpg_image,webp_image,image_alt,short_description,url", ['status' => 'Active', 'url !=' => $page['url'], 'from_city' => $page['from_city']], null, null, 'DESC', 'id');
        $data['faqs'] = $this->c_model->getAllData("faqs", "question,answer", ['status' => 'Active', 'table_name' => 'dt_taxi_package_list', 'table_list_id' => $page['id']], null, null, 'DESC', 'id');
        $data['testimonials'] = $this->c_model->getAllData("testimonials", "*", ['status' => 'Active', 'jpg_image != ' => ''], null, null, 'DESC', 'id');
        frontview('cms', $data);
    }
    public function LoadSeoPages($url, $page) {
        $data = [];
        $data['url'] = $url;
        $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
        $data['meta_keyword'] = !empty($page['meta_keywords']) ? $page['meta_keywords'] : "";
        $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
        $data['page'] = $page;
        $data['trip_type'] = !empty($page['cms_tab_id']) ? getTripTypeFromCmsTabId($page['cms_tab_id']) : '';
        $data['pickup_city'] = !empty($page['from_city_id']) ? getCityStateName($page['from_city_id']) . ', India' : '';
        $data['local_package'] = !empty($page['from_city_id']) ? getLocalPackageName($page['from_city_id']) : '';
        $data['tab_list'] = $this->c_model->getAllData('all_cms_data', 'cms_tab_id,cms_tab_name,page_slug', ['parent_id' => $page['parent_id']]);
        $data['faqs'] = $this->c_model->getAllData("faqs", "question,answer", ['status' => 'Active', 'table_name' => 'dt_all_cms_data', 'table_list_id' => $page['id']], null, null, 'DESC', 'id');
        $data['testimonials'] = $this->c_model->getAllData("testimonials", "*", ['status' => 'Active', 'jpg_image != ' => ''], null, null, 'DESC', 'id');
        $data['oneway_cab_list'] = $this->c_model->getAllData('all_cms_data', 'page_name,page_slug', ['page_type' => 'route', 'trip_type' => 'Oneway', 'from_city_id' => $page['from_city_id']], 30);
        $data['route_list'] = $this->c_model->getAllData('all_cms_data', 'page_name,page_slug', ['status' => 'Active', 'from_city_id' => $page['from_city_id'], 'to_city_name != ' => '', 'page_type' => 'route', 'trip_type' => 'Oneway']);
        $data['tariff_list'] = $this->c_model->getAllData('fare_configuration', 'model_id,base_covered_km,per_km_charge', ['trip_type' => $data['trip_type'], 'pickup_city_id' => $page['from_city_id']]);
        frontview('seo_page', $data);
    }
    public function LoadPackageListing($url, $page) {
        $data = [];
        $data['url'] = $url;
        $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
        $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
        $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
        $data['page'] = $page;
        $data['popular_category'] = $this->c_model->getAllData("package_category", "id,category_name,jpg_image,webp_image,image_alt,url", ['status' => 'Active', 'is_popular' => 'Yes'], null, null, 'DESC', 'id');
        $data['faqs'] = $this->c_model->getAllData("faqs", "question,answer", ['status' => 'Active', 'table_name' => 'dt_package_category', 'table_list_id' => $page['id']], null, null, 'DESC', 'id');
        $data['testimonials'] = $this->c_model->getAllData("testimonials", "*", ['status' => 'Active', 'jpg_image != ' => ''], null, null, 'DESC', 'id');
        $data['popular_destination'] = $this->c_model->getAllData("destinations", "id,destination,jpg_image,webp_image,image_alt,url", ['status' => 'Active', 'is_popular' => 'Yes'], null, null, 'DESC', 'id');
        $query = db()->query("SELECT id, package_title, jpg_image, webp_image, image_alt,package_category_ids, url, no_of_days_nights, mrp_price, offer_price,short_description FROM dt_package_list WHERE status='Active' AND FIND_IN_SET('" . $page['id'] . "', package_category_ids) ");
        $data['packages'] = $query->getResultArray();
        frontview('package-list', $data);
    }
    public function LoadDestinationDetail($url, $page) {
        $data = [];
        $data['url'] = $url;
        $data['none'] = 'd-none';
        $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
        $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
        $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
        $data['page'] = $page;
        $data['faqs'] = $this->c_model->getAllData("faqs", "question,answer", ['status' => 'Active', 'table_name' => 'dt_destinations', 'table_list_id' => $page['id']], null, null, 'DESC', 'id');
        $data['testimonials'] = $this->c_model->getAllData("testimonials", "*", ['status' => 'Active', 'jpg_image != ' => ''], null, null, 'DESC', 'id');
        $data['route_list'] = '';
        $data['tariff_list'] = $this->c_model->getAllData('fare_configuration', 'model_id,base_covered_km,per_km_charge', ['trip_type' => $data['trip_type'], 'pickup_city_id' => $page['from_city_id']]);
        frontview('package-details', $data);
    }
    public function LoadDestinationPackages($url, $page) {
        $data = [];
        $data['url'] = $url;
        $data['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : "";
        $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
        $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
        $data['page'] = $page;
        $query = db()->query("SELECT id, package_title, jpg_image, webp_image, image_alt,package_category_ids, url, no_of_days_nights, mrp_price, offer_price,short_description FROM dt_package_list WHERE status='Active' AND FIND_IN_SET('" . $page['id'] . "', destination_ids) ");
        $data['packages'] = $query->getResultArray();
        $data['faqs'] = $this->c_model->getAllData("faqs", "question,answer", ['status' => 'Active', 'table_name' => 'dt_destinations', 'table_list_id' => $page['id']], null, null, 'DESC', 'id');
        $data['testimonials'] = $this->c_model->getAllData("testimonials", "*", ['status' => 'Active', 'jpg_image != ' => ''], null, null, 'DESC', 'id');
        frontview('package-list', $data);
    }
    public function LoadTaxiList() {
        $data = [];
        $data['meta_title'] = "";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "";
        frontview('taxi-list', $data);
    }
    public function LoadTaxiDetail() {
        $data = [];
        $data['meta_title'] = "";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "";
        frontview('taxi-details', $data);
    }
}
