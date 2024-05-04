<?php
namespace App\Controllers\User;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Profile extends BaseController {
    public $c_model;
    public $session;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
    }
    public function index() {
        $post = $this->request->getVar();
        // echo "<pre>";
        // print_r($post);exit;
        $saveData = [];
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $saveData['name'] = !empty(testInput($post['name'])) ? testInput(trim($post['name'])) : '';
        $saveData['email'] = !empty(testInput($post['email'])) ? testInput(trim($post['email'])) : '';
        $saveData['mobile_no'] = !empty(testInput($post['mobile_no'])) ? testInput(trim($post['mobile_no'])) : '';
        $saveData['state_id'] = !empty(testInput($post['state_id'])) ? testInput(trim($post['state_id'])) : '';
        $saveData['city_id'] = !empty(testInput($post['city_id'])) ? testInput(trim($post['city_id'])) : '';
        $saveData['pin_code'] = !empty(testInput($post['pin_code'])) ? testInput(trim($post['pin_code'])) : '';
        $saveData['address'] = !empty(testInput($post['address'])) ? testInput(trim($post['address'])) : '';
        $saveData['company_name'] = !empty(testInput($post['company_name'])) ? testInput(trim($post['company_name'])) : '';
        $saveData['company_pan_number'] = !empty(testInput($post['company_pan_number'])) ? testInput(trim($post['company_pan_number'])) : '';
        $saveData['gstin_number'] = !empty(testInput($post['gstin_number'])) ? testInput(trim($post['gstin_number'])) : '';
        $saveData['company_state'] = !empty(testInput($post['company_state'])) ? testInput(trim($post['company_state'])) : '';
        $saveData['company_city'] = !empty(testInput($post['company_city'])) ? testInput(trim($post['company_city'])) : '';
        $saveData['company_pin_code'] = !empty(testInput($post['company_pin_code'])) ? testInput(trim($post['company_pin_code'])) : '';
        $saveData['company_address'] = !empty(testInput($post['company_address'])) ? testInput(trim($post['company_address'])) : '';
        $saveData['update_date'] = date('Y-m-d H:i:s');
        if ($file = $this->request->getFile('profile_image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_profile_image']) && file_exists(ROOTPATH . 'uploads/' . $post['old_profile_image'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_profile_image']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename);
                $saveData['profile_image'] = $filename;
            }
        }
        $this->c_model->updateRecords('customer_list', $saveData, ['id' => $id]);
        $last_id = $id;
        $this->session->setFlashdata('success', 'Profile Updated Successfully');
        return redirect()->to(base_url(USERPATH.'my-profile'));
    }
}
