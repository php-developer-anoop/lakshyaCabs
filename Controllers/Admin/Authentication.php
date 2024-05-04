<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;

class Authentication extends BaseController {
    protected $c_model;
    protected $session;
    protected $cookieName;
    
    public function __construct() {
        $this->session = session();
        $this->c_model = new Common_model();
        $this->cookieName = 'LoginStuck';
    }
    
    public function index() {
        $data["meta_title"] = "Admin";
        $rememberData = decryptPassword($this->cookieName, $_SERVER['HTTP_HOST']);
        $data['email'] = !empty($rememberData['ue']) ? $rememberData['ue'] : '';
        $data['password'] = !empty($rememberData['up']) ? $rememberData['up'] : '';
        echo view("admin/login_form", $data);
    }
    public function checkLogin() {
        $post = $this->request->getVar();
        $response = [];
        $email = !empty($post["email"]) ? $post["email"] : "";
        $password = !empty($post["password"]) ? $post["password"] : "";
        $is_remember = !empty($post['is_remember']) ? trim($post['is_remember']) : '';
        if (empty($email) || empty($password)) {
            $response['status'] = false;
            $response['message'] = 'Please Enter Valid Email Address and Password';
            echo json_encode($response);
            exit;
        }
        $where = ["user_email" => $email, "enc_password" => md5($password) ];
        $select = "*";
        $user = $this->c_model->getSingle('role_users', $select, $where);
        if (empty($user)) {
            $response['status'] = false;
            $response['message'] = 'Invalid Email or Password';
            echo json_encode($response);
            exit;
        }
        if ($user['user_type'] == "Role User") {
            if ($user['status'] == "Inactive") {
                $response['status'] = false;
                $response['message'] = 'Your Profile Is Currently Inactive';
                echo json_encode($response);
                exit;
            } else if ($user['status'] == "Blocked") {
                $response['status'] = false;
                $response['message'] = 'Your Profile Is Currently Blocked';
                echo json_encode($response);
                exit;
            } else if ($user['read_menu_ids'] == "" && $user['write_menu_ids'] == "") {
                $response['status'] = false;
                $response['message'] = 'No Menu Assigned To You!!';
                echo json_encode($response);
                exit;
            } else if($user['read_menu_ids'] == ""){
                $response['status'] = false;
                $response['message'] = 'No Read Permission Assigned!!';
                echo json_encode($response);
                exit;
                
            }
        }
        // Set Login Data on Session
        $deviceInfo = $this->getBrowserName();
        $ipAddress = $this->request->getIPAddress();
        $setLoginActivity = $this->addLoginActivity($user['id'], $user['user_name'], $ipAddress, $deviceInfo);
        $sessionData = ['id' => $user['id'], 
                        'role' => $user['user_type'], 
                        'name' => $user['user_name'], 
                        'email' => $user['user_email'], 
                        'financial_year' => !empty($setLoginActivity['financial_year']) ? $setLoginActivity['financial_year'] : '', 'login_at' => date('Y-m-d H:i:s'), 
                        'login_city' => !empty($setLoginActivity['login_city']) ? $setLoginActivity['login_city'] : '', 
                        'login_device' => !empty($setLoginActivity['device']) ? $setLoginActivity['device'] : '', 
                        'login_os' => !empty($setLoginActivity['os']) ? $setLoginActivity['os'] : '', 
                        'login_ip' => $ipAddress, 
                        'activity_id' => !empty($setLoginActivity['activity_id']) ? $setLoginActivity['activity_id'] : '', 
                        'is_logged_in' => true
                       ];
        // Get menu Ids assigned to role user
        if ($user['user_type'] == "Role User") {
            $sessionData['read_menu_ids'] = !empty($user['read_menu_ids']) ? $user['read_menu_ids'] : '';
            $sessionData['write_menu_ids'] = !empty($user['write_menu_ids']) ? $user['write_menu_ids'] : '';
        }
         $read = [];
                if (!empty($user["read_menu_ids"])) {
                    $readSlugs = $this->getMenuSlugsByIDs($user["read_menu_ids"]);
                    foreach ($readSlugs as $key => $value) {
                        $read[] = $value['slug'];
                    }
                }
               $sessionData['read_slug']=$read; 
        $write = [];
                if (!empty($user["write_menu_ids"])) {
                    $writeSlugs = $this->getMenuSlugsByIDs($user["write_menu_ids"]);
                    foreach ($writeSlugs as $key => $value) {
                        $write[] = $value['slug'];
                    }
                }
        $sessionData['write_slug']=$write;
        $this->session->set('admin_login_data', $sessionData);
        $this->session->set('menu_list', json_encode(getMenuList()));
        $saveAdData = ['whitelist_ip' => $ipAddress, 'last_login' => date('Y-m-d H:i:s A') ];
        $this->c_model->updateRecords('role_users', $saveAdData, ['id' => $user['id']]);
        $response['status'] = true;
        $response['goto'] = base_url(ADMINPATH . 'dashboard');
        $response['message'] = 'Logged in Successfully';
        echo json_encode($response);
        exit;
    }
    public function getBrowserName() {
        $data = [];
        $agent = $this->request->getUserAgent();
        $isMob = is_numeric(strpos(strtolower($agent), "mobile"));
        $isTab = is_numeric(strpos(strtolower($agent), "tablet"));
        $isWin = is_numeric(strpos(strtolower($agent), "windows"));
        $isAndroid = is_numeric(strpos(strtolower($agent), "android"));
        $isIPhone = is_numeric(strpos(strtolower($agent), "iphone"));
        $isIPad = is_numeric(strpos(strtolower($agent), "ipad"));
        $isIOS = $isIPhone || $isIPad;
        if ($isMob) {
            if ($isTab) {
                $data['device'] = 'Tablet';
            } else {
                $data['device'] = 'Mobile';
            }
        } else {
            $data['device'] = 'Desktop';
        }
        if ($isAndroid) {
            $data['os'] = 'Android';
        } elseif ($isWin) {
            $data['os'] = 'Windows';
        } else {
            $data['os'] = 'iOS';
        }
        return $data;
    }
    protected function addLoginActivity($userId, $userName, $ipAddress, $deviceInfo) {
        if ($ipAddress != '::1') {
            $ipDetails = file_get_contents("http://ip-api.com/json/" . $ipAddress);
        } else {
            $ipDetails = file_get_contents("http://ip-api.com/json/");
        }
        $ipLog = json_decode($ipDetails, true);
        $saveLog = [];
        $saveLog['user_id'] = $userId;
        $saveLog['user_name'] = $userName;
        $saveLog['login_at'] = date('Y-m-d H:i:s');
        $saveLog['os'] = !empty($deviceInfo['os']) ? $deviceInfo['os'] : '';
        $saveLog['device'] = !empty($deviceInfo['device']) ? $deviceInfo['device'] : '';
        $saveLog['login_city'] = !empty($ipLog['city']) ? $ipLog['city'] : '';
        $saveLog['login_state'] = !empty($ipLog['regionName']) ? $ipLog['regionName'] : '';
        $saveLog['login_country'] = !empty($ipLog['country']) ? $ipLog['country'] : '';
        $saveLog['login_ip'] = $ipAddress;
        $saveLog['add_date'] = date('Y-m-d H:i:s');
        $activity_id = $this->c_model->insertRecords('role_users_login_activity', $saveLog);
        $saveLog['activity_id'] = $activity_id;
        return $saveLog;
    }
    public function logout() {
        $loginData = $this->session->get('admin_login_data');
       
        $activity_id = !empty($loginData['activity_id']) ? $loginData['activity_id'] : '' ;
        if (!empty($activity_id)) {
            $activityData = $this->c_model->getSingle('role_users_login_activity', '*', ['id' => $activity_id]);
            $login_at = $activityData['login_at'];
            $current_time = date('Y-m-d H:i:s');
            $from = strtotime($login_at);
            $to = strtotime($current_time);
            $difference = round(abs($to - $from) / 60);
            $activity = [];
            $activity['logout_at'] = date('Y-m-d H:i:s');
            $activity['session'] = $difference;
            $return_id = $this->c_model->updateRecords('role_users_login_activity', $activity, ['id' => $activity_id]);
        }
        $session = $this->session;
        $session->remove('admin_login_data');
        return redirect()->to(base_url(ADMINPATH . "login"));
    }
    function forgot_password() {
        $data["meta_title"] = "Forgot Password";
        echo view("admin/forgot-password", $data);
    }
    public function sendNewPassword() {
        $email = !empty($this->request->getVar('email')) ? $this->request->getVar('email') : "";
        if (empty($email)) {
            echo "Please Enter Email";
            exit;
        }
        $valid = $this->c_model->getSingle("users", 'id', ['user_email' => $email]);
        if (empty($valid)) {
            echo "This Email Id Is Not Registered";
            exit;
        }
        $password = generate_password(10);
        sendEmailForgotPassword($email, $email, $password);
        $this->c_model->updateRecords("users", ['enc_password' => md5($password), 'raw_password' => $password], ['user_email' => $email]);
        echo "success";
    }
    function getMenuSlugsByIDs($menuIDs) {
        $where = "id IN (" . $menuIDs . ") AND status='Active'";
        $slugs = db()->table('dt_menus')->select('slug')->where($where)->get()->getResultArray();
        return $slugs;
    }
}
?>
