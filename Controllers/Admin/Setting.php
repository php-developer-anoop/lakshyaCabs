<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Setting extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = "dt_setting";
    }
    public function index() {
        $data = [];
        $data['title'] = 'Web Setting';
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data['web'] = $this->c_model->getSingle($this->table, '*');
        adminview('websetting', $data);
    }
    public function save_setting() {
    
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        if ($file = $this->request->getFile('logo')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file('uploads/' . $post['old_logo']) && file_exists(ROOTPATH . 'uploads/' . $post['old_logo'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_logo']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . 'uploads/' . $filename);
                $data['logo'] = $filename;
            }
        }
        if ($file = $this->request->getFile('favicon')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file('uploads/' . $post['old_favicon']) && file_exists(ROOTPATH . 'uploads/' . $post['old_favicon'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_favicon']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . 'uploads/' . $filename);
                $data['favicon'] = $filename;
            }
        }
        $data['gst_no'] = trim($post['gst_no']);
        $data['pan_no'] = trim($post['pan_no']);
        $data['company_name'] = trim($post['company_name']);
        $data['care_whatsapp_no'] = trim($post['care_whatsapp_no']);
        $data['care_email'] = trim($post['care_email_id']);
        $data['care_mobile'] = trim($post['care_mobile_no']);
        $data['map_script'] = trim($post['map_script']);
        //$data['user_app_link'] = trim($post['user_app_link']);
        $data['office_address'] = trim($post['office_address']);
        if (empty($id)) {
            $this->c_model->insertRecords($this->table, $data);
            $this->session->setFlashdata('success', 'Data Added Successfully');
        } else {
            $this->c_model->updateRecords($this->table, $data, ['id' => $id]);
           $this->session->setFlashdata('success', 'Data Updated Successfully');
            
        }
        return redirect()->to(base_url(ADMINPATH . 'web-setting'));
    }

    public function home_setting() {
        $data = [];
        $data['title'] = 'Home Setting';
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data['home'] = $this->c_model->getSingle('homesetting', '*');
        adminview('homesetting', $data);
    }

    public function save_home_setting() {
    
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        if ($file = $this->request->getFile('top_banner')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_top_banner_jpg']) && file_exists(ROOTPATH . 'uploads/' . $post['old_top_banner_jpg'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_top_banner_jpg']);
                }
                if (is_file(ROOTPATH . 'uploads/' . $post['old_top_banner_webp']) && file_exists(ROOTPATH . 'uploads/' . $post['old_top_banner_webp'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_top_banner_webp']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename);
                $webp_file = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
                $webp_image = convertImageInToWebp('uploads', $filename, $webp_file);
                $data['top_banner_jpg'] = $filename;
                $data['top_banner_webp'] = $webp_image;
                
            }
        }
        if ($file = $this->request->getFile('mid_banner')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_mid_banner_jpg']) && file_exists(ROOTPATH . 'uploads/' . $post['old_mid_banner_jpg'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_mid_banner_jpg']);
                }
                if (is_file(ROOTPATH . 'uploads/' . $post['old_mid_banner_webp']) && file_exists(ROOTPATH . 'uploads/' . $post['old_mid_banner_webp'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_mid_banner_webp']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename);
                $webp_file = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
                $webp_image = convertImageInToWebp('uploads', $filename, $webp_file);
                $data['mid_banner_jpg'] = $filename;
                $data['mid_banner_webp'] = $webp_image;
                
            }
        }
        if ($file = $this->request->getFile('bottom_banner')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_bottom_banner_jpg']) && file_exists(ROOTPATH . 'uploads/' . $post['old_bottom_banner_jpg'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_bottom_banner_jpg']);
                }
                if (is_file(ROOTPATH . 'uploads/' . $post['old_bottom_banner_webp']) && file_exists(ROOTPATH . 'uploads/' . $post['old_bottom_banner_webp'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_bottom_banner_webp']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename);
                $webp_file = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
                $webp_image = convertImageInToWebp('uploads', $filename, $webp_file);
                $data['bottom_banner_jpg'] = $filename;
                $data['bottom_banner_webp'] = $webp_image;
                
            }
        }
        if ($file = $this->request->getFile('tour_package_mid_banner')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_tour_package_mid_banner_jpg']) && file_exists(ROOTPATH . 'uploads/' . $post['old_tour_package_mid_banner_jpg'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_tour_package_mid_banner_jpg']);
                }
                if (is_file(ROOTPATH . 'uploads/' . $post['old_tour_package_mid_banner_webp']) && file_exists(ROOTPATH . 'uploads/' . $post['old_tour_package_mid_banner_webp'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_tour_package_mid_banner_webp']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename);
                $webp_file = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
                $webp_image = convertImageInToWebp('uploads', $filename, $webp_file);
                $data['tour_package_mid_banner_jpg'] = $filename;
                $data['tour_package_mid_banner_webp'] = $webp_image;
                
            }
        }
        if ($file = $this->request->getFile('tour_package_bottom_banner')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_tour_package_bottom_banner_jpg']) && file_exists(ROOTPATH . 'uploads/' . $post['old_tour_package_bottom_banner_jpg'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_tour_package_bottom_banner_jpg']);
                }
                if (is_file(ROOTPATH . 'uploads/' . $post['old_tour_package_bottom_banner_webp']) && file_exists(ROOTPATH . 'uploads/' . $post['old_tour_package_bottom_banner_webp'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_tour_package_bottom_banner_webp']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename);
                $webp_file = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
                $webp_image = convertImageInToWebp('uploads', $filename, $webp_file);
                $data['tour_package_bottom_banner_jpg'] = $filename;
                $data['tour_package_bottom_banner_webp'] = $webp_image;
                
            }
        }

        $data['top_heading'] = trim($post['top_heading']);
        $data['top_sub_heading'] = trim($post['top_sub_heading']);
        $data['trending_package_heading'] = trim($post['trending_package_heading']);
        $data['about_heading'] = trim($post['about_heading']);
        $data['about_sub_heading'] = trim($post['about_sub_heading']);
        $data['taxi_heading'] = trim($post['taxi_heading']);
        $data['testimonial_heading'] = trim($post['testimonial_heading']);
        $data['faq_heading'] = trim($post['faq_heading']);
        $data['faq_sub_heading'] = trim($post['faq_sub_heading']);
        $data['taxi_rental_heading'] = trim($post['taxi_rental_heading']);
        $data['taxi_rental_sub_heading'] = trim($post['taxi_rental_sub_heading']);
        $data['popular_heading'] = trim($post['popular_heading']);
      
        if (empty($id)) {
            $this->c_model->insertRecords('homesetting', $data);
            $this->session->setFlashdata('success', 'Data Added Successfully');
        } else {
            $this->c_model->updateRecords('homesetting', $data, ['id' => $id]);
           $this->session->setFlashdata('success', 'Data Updated Successfully');
            
        }
        return redirect()->to(base_url(ADMINPATH . 'home-setting'));
    }
}
?>