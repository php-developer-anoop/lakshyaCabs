<?php
namespace App\Controllers\User;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Home extends BaseController {
    public $c_model;
    public $session;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
    }
    public function my_profile() {
        $data = [];
        $session = $this->session->get('user_login_data');
        $data['meta_title'] = "My Profile";
        $data['meta_keyword'] = !empty($page['meta_keyword']) ? $page['meta_keyword'] : "";
        $data['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : "";
        $data['states'] = $this->c_model->getAllData("states", 'id,state_name', ['status' => 'Active']);
        $savedData = $this->c_model->getSingle('customer_list', '*', ['email' => $session['email']]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : '';
        $data['name'] = !empty($savedData['name']) ? $savedData['name'] : '';
        $data['email'] = !empty($savedData['email']) ? $savedData['email'] : '';
        $data['mobile_no'] = !empty($savedData['mobile_no']) ? $savedData['mobile_no'] : '';
        $data['state_id'] = !empty($savedData['state_id']) ? $savedData['state_id'] : '';
        $data['city_id'] = !empty($savedData['city_id']) ? $savedData['city_id'] : '';
        $data['pin_code'] = !empty($savedData['pin_code']) ? $savedData['pin_code'] : '';
        $data['address'] = !empty($savedData['address']) ? $savedData['address'] : '';
        $data['company_name'] = !empty($savedData['company_name']) ? $savedData['company_name'] : '';
        $data['company_pan_number'] = !empty($savedData['company_pan_number']) ? $savedData['company_pan_number'] : '';
        $data['gstin_number'] = !empty($savedData['gstin_number']) ? $savedData['gstin_number'] : '';
        $data['company_state'] = !empty($savedData['company_state']) ? $savedData['company_state'] : '';
        $data['company_city'] = !empty($savedData['company_city']) ? $savedData['company_city'] : '';
        $data['company_pin_code'] = !empty($savedData['company_pin_code']) ? $savedData['company_pin_code'] : '';
        $data['company_address'] = !empty($savedData['company_address']) ? $savedData['company_address'] : '';
        $data['profile_image'] = !empty($savedData['profile_image']) ? $savedData['profile_image'] : '';
        userview('my-profile', $data);
    }
    public function logout() {
        $this->session->remove('user_login_data');
        return redirect()->to(base_url());
    }
    public function my_wallet() {
        $data = [];
        $data['url'] = '';
        $data['company'] = websetting('*');
        $user = getUserProfile();
        $data['meta_title'] = $data['company']['company_name'];
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';
        $data['user_id'] = !empty($user['id']) ? $user['id'] : '';
        $data['wallet_balance'] = !empty($user['wallet_balance']) ? $user['wallet_balance'] : '';
        $data['wallet_list'] = $this->c_model->getAllData('wallet', "reference_id,txn_amount,credit_debit,DATE_FORMAT(created_date,'%d/%m/%Y') as date", ['user_id' => $user['id']], null, null, 'DESC');
        $data['plan_list'] = $this->c_model->getAllData('recharge_plans', 'amount,id', ['status' => 'Active']);
        userview('wallet', $data);
    }
    public function getToken() {
        $post = $this->request->getVar();
        $user = getUserProfile();
        $user_id = isset($user['id']) ? trim($user['id']) : null;
        if (!$user_id && !empty($post['id'])) {
            $user_id = $post['id'];
        }
        $amount = !empty($post['amount']) ? trim($post['amount']) : 0;
        $response = [];
        // Check if user ID is empty
        if (empty($user_id)) {
            $response['status'] = false;
            $response['message'] = 'No Direct Access Allowed';
            echo json_encode($response);
            exit;
        }
        if ($amount == '' || $amount < 10) {
            $response['status'] = false;
            $response['message'] = 'Amount Should be more than 10 INR';
            echo json_encode($response);
            exit;
        }
        $payLoad = ['user_id' => $user_id, 'amount' => $amount, 'app_type' => 'web'];
        $postUrl = base_url("api/v1/customer/generate_orderid");
        $getdata = curlApis($postUrl, 'POST', $payLoad);
        // echo "<pre>";
        // print_r($getdata);exit;
        if (empty($getdata['status'])) {
            $response['status'] = false;
            $response['message'] = isset($getdata['message']) ? $getdata['message'] : 'Error occurred while processing request';
            echo json_encode($response);
            exit;
        }
        echo json_encode($getdata);
        exit;
    }
    public function cashfree_success() {
        $post = $this->request->getVar();
        $transactionData = $this->c_model->getSingle('transaction_log', '*', ['order_id' => $post['order_id']]);
        if (empty($transactionData)) {
            $this->session->setFlashData('failed', 'No Data Found');
            return redirect()->to(base_url());
        }
        // Check Final Status
        if ($transactionData['final_status'] == 'yes') {
            $this->session->setFlashData('failed', 'Payment Is Already Done');
            return redirect()->to(base_url());
        }
        //Verify Transaction From Cashfree
        $payLoad = ['user_id' => $transactionData['user_id'], 'order_id' => $post['order_id']];
        $postUrl = base_url("api/v1/customer/add_amount");
        $getdata = curlApis($postUrl, 'POST', $payLoad);
        if ($getdata['status'] == 1) {
            $this->session->setFlashData('success', $getdata['message']);
            return redirect()->to(base_url(USERPATH . 'my-wallet'));
        } else {
            $this->session->setFlashData('failed', $getdata['message']);
            return redirect()->to(base_url(USERPATH . 'my-wallet'));
        }
    }
    public function my_wallet_records() {
        $post = $this->request->getVar();
        $get = $this->request->getVar();
        $limit = (int)(!empty($get["length"]) ? $get["length"] : 1);
        $start = (int)!empty($get["start"]) ? $get["start"] : 0;
        $is_count = !empty($post["is_count"]) ? $post["is_count"] : "";
        $totalRecords = !empty($get["recordstotal"]) ? $get["recordstotal"] : 0;
        $orderby = "DESC";
        $where = [];
        $user = getUserProfile();
        $where['user_id'] = $user['id'];
        $searchString = null;
        if (!empty($get["search"]["value"])) {
            $searchString = trim($get["search"]["value"]);
            $where[" credit_debit LIKE '%" . $searchString . "%' OR txn_amount LIKE '%" . $searchString . "%' OR reference_id LIKE '%" . $searchString . "%'"] = null;
            $limit = 100;
            $start = 0;
        }
        $countData = $this->c_model->countRecords('wallet', $where, 'id');
        if ($is_count == "yes") {
            echo (int)(!empty($countData) ? sizeof($countData) : 0);
            exit();
        }
        if (!empty($get["showRecords"])) {
            $limit = $get["showRecords"];
            $orderby = "DESC";
        }
        $select = '*,DATE_FORMAT(created_date , "%d/%m/%Y") AS add_date';
        $listData = $this->c_model->getAllData('wallet', $select, $where, $limit, $start, $orderby);
        $result = [];
        if (!empty($listData)) {
            $i = $start + 1;
            foreach ($listData as $key => $value) {
                $push = [];
                $push = $value;
                $push["sr_no"] = $i;
                array_push($result, $push);
                $i++;
            }
        }
        $json_data = [];
        if (!empty($get["search"]["value"])) {
            $countItems = !empty($result) ? count($result) : 0;
            $json_data["draw"] = intval($get["draw"]);
            $json_data["recordsTotal"] = intval($countItems);
            $json_data["recordsFiltered"] = intval($countItems);
            $json_data["data"] = !empty($result) ? $result : [];
        } else {
            $json_data["draw"] = intval($get["draw"]);
            $json_data["recordsTotal"] = intval($totalRecords);
            $json_data["recordsFiltered"] = intval($totalRecords);
            $json_data["data"] = !empty($result) ? $result : [];
        }
        echo json_encode($json_data);
    }
}
