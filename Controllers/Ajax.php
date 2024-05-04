<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Ajax extends BaseController {
    public $c_model;
    public $session;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
    }
    function index() {
        $captua_token = random_alphanumeric_string(6);
        echo $captua_token;
    }
    public function getDestination() {
        $val = $this->request->getVar("val");
        if (!empty($val)) {
            $query = "SELECT id, city_name, state_name,destination FROM dt_destinations WHERE destination LIKE ? AND status = 'Active'";
            $cities = db()->query($query, ["%" . $val . "%"])->getResultArray();
            if (empty($cities)) {
                echo "No Record Found";
                exit;
            } else {
                foreach ($cities as $key => $value) {
                    echo "<li value='" . htmlspecialchars($value['id']) . "' >" . htmlspecialchars($value['destination']) . "</li>";
                }
            }
        }
    }
    public function getPackages() {
        $destination_id = $this->request->getVar("destination_id");
        if (!empty($destination_id)) {
            $query = "SELECT id, package_title FROM dt_package_list WHERE FIND_IN_SET(?, destination_ids) AND status = 'Active'";
            $packs = db()->query($query, [$destination_id])->getResultArray();
            $html = '<option value="">Select Package</option>';
            if (!empty($packs)) {
                foreach ($packs as $key => $value) {
                    $packInfo = $value['id'] . ',' . $value['package_title'];
                    $html.= '<option value="' . $packInfo . '">' . $value['package_title'] . '</option>';
                }
            }
            echo $html;
        }
    }
    function getSpecialPacks() {
        $category_id = !empty($this->request->getVar('category_id')) ? $this->request->getVar('category_id') : '';
        if (!empty($category_id)) {
            $query = db()->query("SELECT id, package_title, jpg_image, webp_image,package_category_ids,image_alt, url, no_of_days_nights, mrp_price, offer_price FROM dt_package_list WHERE status='Active' AND is_special='Yes' AND FIND_IN_SET('" . $category_id . "', package_category_ids) LIMIT 6 ");
            $special_packages = $query->getResultArray();
            if (!empty($special_packages)) {
                foreach ($special_packages as $spkey => $spvalue) {
                    $title = !empty($spvalue['package_title']) ? $spvalue['package_title'] : "";
                    $no_of_days_nights = !empty($spvalue['no_of_days_nights']) ? $spvalue['no_of_days_nights'] : "";
                    $rating = !empty($spvalue['rating']) ? showRatings($spvalue['rating']) : "";
                    $url = !empty($spvalue['url']) ? base_url($spvalue['url']) : "javascript:void(0)";
                    $c_id = !empty($spvalue['package_category_ids']) ? explode(',', $spvalue['package_category_ids']) : [];
                    $sdiscount = '';
                    $sdiscount = (($spvalue['mrp_price'] - $spvalue['offer_price']) / $spvalue['mrp_price']) * 100;
                    $cat_name = '';
                    if (!empty($c_id[0])) {
                        $cat_name = getCategoryName($c_id[0]);
                    }
                    $special_pack_image = !empty($spvalue['jpg_image'] || $spvalue['webp_image']) ? base_url('uploads/') . imgExtension($spvalue['jpg_image'], $spvalue['webp_image']) : ""; // Assuming this variable contains the image URL
                    echo '<div class="col-sm-4" >
                        <div class="tour_box">
                            <img src="' . $special_pack_image . '">
                            <div class="tourtxt">
                                <h6><a href=' . $url . '>' . $title . '</a></h6>
                                <p>' . $no_of_days_nights . '</p>
                                <div class="ratng_btns d-flex align-items-center">
                                    <div class="rating">
                                        ' . (!empty($spvalue['rating']) ? '
                                        <ul>' . $rating . '</ul>' : '') . '
                                    </div>
                                    ' . (!empty($sdiscount) ? '
                                    <span class="btnylw">Flat ' . (int)$sdiscount . '% Off</span>
                                    ' . $rating . '</ul>' : '') . '
                                    <span class="btnlblue">' . $cat_name . '</span>
                                </div>
                                <div class="trbtn">
                                    <a href="' . $url . '" class="pkgbtn">View Package</a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            }
        }
    }
    public function getCities() {
        $state_id = $this->request->getVar("state_id");
        $cities = [];
        if ($state_id !== null) {
            $cities = $this->c_model->getAllData('cities', 'id, city_name', ['state_id' => $state_id],null,null,'ASC','city_name');
        }
        $cityvalue = $this->request->getVar("city") ??"";
        $html = '<option value="">--Select City--</option>';
        if (!empty($cities)) {
            foreach ($cities as $key => $value) {
                $cityInfo = $value['id'];
                $selected = ($cityInfo === $cityvalue) ? "selected" : "";
                $html.= '<option ' . $selected . ' value="' . $cityInfo . '">' . $value['city_name'] . '</option>';
            }
        }
        echo $html;
    }
    public function validateUser() {
        $useremail = !empty($this->request->getVar("useremail")) ? trim($this->request->getVar("useremail")) : '';
        $response = [];
        if (empty($useremail)) {
            $response['status'] = false;
            $response['message'] = 'Please Enter Email';
            echo json_encode($response);
            exit;
        } else {
            $check = $this->c_model->getSingle('customer_list', '*', ['email' => $useremail]);
            if (empty($check['id'])) {
                $otp = rand(1000, 9999);
                $savedata = ['email' => $useremail, 'otp' => $otp, 'otp_sent_at' => date('Y-m-d H:i:s'), 'add_date' => date('Y-m-d H:i:s') ];
                $userid = $this->c_model->insertRecords('customer_list', $savedata);
                $sessionData = ['useremail' => $useremail, 'otp' => $savedata['otp']];
                $this->session->set('user_login', $sessionData);
                sendUserEmailOtp($useremail, $useremail, $otp);
                $response['status'] = true;
                $response['message'] = 'OTP sent on the entered mail';
                echo json_encode($response);
                exit;
            } else {
                $otp = rand(1000, 9999);
                $updateData = ['otp' => $otp, 'otp_sent_at' => date('Y-m-d H:i:s') ];
                $this->c_model->updateRecords('customer_list', $updateData, ['id' => $check['id']]);
                $userid = $check['id'];
                $sessionData = ['useremail' => $useremail, 'otp' => $otp];
                $this->session->set('user_login', $sessionData);
                sendUserEmailOtp($useremail, $useremail, $otp);
                $response['status'] = true;
                $response['message'] = 'OTP sent on the entered mail';
                echo json_encode($response);
                exit;
            }
        }
    }
    public function validateOtp() {
        $otp = !empty($this->request->getVar("otp")) ? trim($this->request->getVar("otp")) : '';
        $current_page = !empty($this->request->getVar("current_page")) ? trim($this->request->getVar("current_page")) : '';
        $loginData = $this->session->get('user_login');
        $sess_otp = $loginData['otp'];
        $sess_email = $loginData['useremail'];
        $response = [];
        if (empty($otp)) {
            $response['status'] = false;
            $response['message'] = 'Please Enter Otp';
            echo json_encode($response);
            exit;
        } else if ($otp === $sess_otp) {
            $response['status'] = false;
            $response['message'] = 'OTP Not Matched';
            echo json_encode($response);
            exit;
        }
        $user = $this->c_model->getSingle('customer_list', '*', ['email' => $sess_email]);
        $sessionData = ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'], 'mobile_no' => $user['mobile_no'], 'state_id' => $user['state_id'], 'city_id' => $user['city_id'], 'pin_code' => $user['pin_code'], 'address' => $user['address'], 'company_name' => $user['company_name'], 'company_pan_number' => $user['company_pan_number'], 'gstin_number' => $user['gstin_number'], 'company_state' => $user['company_state'], 'company_city' => $user['company_city'], 'company_pin_code' => $user['company_pin_code'], 'company_address' => $user['company_address'], 'profile_image' => $user['profile_image'], 'otp' => $user['otp'], 'is_logged_in' => true];
        $this->session->set('user_login_data', $sessionData);
        $this->c_model->updateRecords('customer_list', ['last_login' => date('Y-m-d H:i:s') ], ['email' => $sess_email]);
        $response['status'] = true;
        $response['goto'] = !empty($current_page) ? $current_page : base_url('user/my-bookings');
        $response['message'] = 'Logged in Successfully';
        echo json_encode($response);
        exit;
    }
    public function resendOtp() {
        $loginData = $this->session->get('user_login');
        $sess_email = $loginData['useremail'];
        $otp = rand(1000, 9999);
        $updateData = ['otp' => $otp, 'otp_sent_at' => date('Y-m-d H:i:s') ];
        $this->c_model->updateRecords('customer_list', $updateData, ['email' => $sess_email]);
        $sessionData = ['useremail' => $sess_email, 'otp' => $otp];
        $this->session->set('user_login', $sessionData);
        sendUserEmailOtp($sess_email, $sess_email, $otp);
        $response['status'] = true;
        $response['message'] = 'OTP sent successfully';
        echo json_encode($response);
        exit;
    }
    public function save_address() {
        $post = $this->request->getVar();
        $data = [];
        $response = [];
        $data['address'] = !empty($post['address']) ? trim($post['address']) : '';
        $data['latitude'] = !empty($post['lat']) ? trim($post['lat']) : '';
        $data['longitude'] = !empty($post['lng']) ? trim($post['lng']) : '';
        $check = $this->c_model->getSingle('address_book', 'id', $data);
        $data['add_date'] = date('Y-m-d H:i:s');
        if (empty($check)) {
            $last_id = $this->c_model->insertRecords('address_book', $data);
        }
        $response['status'] = true;
        $response['message'] = 'Address Saved Successfully';
        echo json_encode($response);
        exit;
    }
    public function get_address() {
        $keyword = !empty($this->request->getVar('address')) ? trim($this->request->getVar('address')) : '';
        $selector = !empty($this->request->getVar('selector_id')) ? trim($this->request->getVar('selector_id')) : '';
        $query = "SELECT address FROM dt_address_book WHERE address LIKE ?";
        $address = db()->query($query, ["" . $keyword . "%"])->getResultArray();
        $result = "";
        if (!empty($address)) {
            foreach ($address as $value) {
                $result.= "<li><a href='javascript:void(0)' onclick=\"getVal('" . $value['address'] . "','" . $selector . "')\">" . $value['address'] . "</a></li>";
            }
        }
        return $result;
    }
    public function getHourlyPackage() {
        $city_id = cityIdGoogleAddress(removePinCodeFromAddress($this->request->getVar("city_name")));
        $html = '<option value="">Select Package</option>';
        if (!empty($city_id)) {
            $query = "SELECT id, package_name FROM dt_hourly_package WHERE city_id='" . $city_id . "'  AND status = 'Active'";
            $packageList = db()->query($query)->getResultArray();
            if (!empty($packageList)) {
                foreach ($packageList as $key => $value) {
                    $html.= '<option value="' . $value['id'] . '">' . $value['package_name'] . '</option>';
                }
            }
            echo $html;
        }
    }
   public function getSeoPackages() {
    $post = $this->request->getVar();
    // echo json_encode($post);exit;
    $data = curlApis(base_url('api/v1/customer/search_cab'), 'POST', $post);
    $list = !empty($data['data']) ? $data['data'] : [];
    $html = '';
    if (!empty($list)) {
        foreach ($list as $key => $value) {
            $cabimage = getImagePathUrl($value['jpg_image'], $value['webp_image']);
            $starRatings = showRatings($value['star_rating']);

            $water_bottle = ($value['water_bottle'] == "Yes") ? '<span class="fac_btn"> <img src="'.getImagePathUrl(base_url('assets/images/f5.png'), base_url('assets/images/f5.webp')).'">Water Bottle</span>' : '';
            $carrier = ($value['carrier'] == "Yes") ? '<span class="fac_btn"> <img src="'.getImagePathUrl(base_url('assets/images/f6.png'), base_url('assets/images/f6.webp')).'">Carrier</span>' : '';

            $html .= '<div class="cablist_box">
        <div class="cb_img">
          <img src="'.$cabimage.'"> 
        </div>
        <div class="cb_details">
          <h4>'.$value['model_name'].'</h4>
          <div class="rating">
            <ul>
              '.$starRatings.'
            </ul>
          </div>
          <div class="facility">
            <span class="fac_btn"> <img src="'.getImagePathUrl(base_url('assets/images/f1.png'), base_url('assets/images/f1.webp')).'">'.$value['seat_segment'].'</span>
            <span class="fac_btn"> <img src="'.getImagePathUrl(base_url('assets/images/f2.png'), base_url('assets/images/f2.webp')).'">'.$value['fuel_type'].'</span>
            <span class="fac_btn"> <img src="'.getImagePathUrl(base_url('assets/images/f3.png'), base_url('assets/images/f3.webp')).'">'.$value['luggage'].' Luggage</span>
            <span class="fac_btn"> <img src="'.getImagePathUrl(base_url('assets/images/f4.png'), base_url('assets/images/f4.webp')).'">'.$value['ac_or_non_ac'].' Cabs</span>
            '.$water_bottle.'
            '.$carrier.'
          </div>
        </div>
        <div class="cab_pricebox">
          <span class="discnt">Flat '.INSTANT_DISCOUNT.'% Off</span>
          <h2>'.(!empty($value['total_trip_amount_with_gst']) ? '₹'.$value['total_trip_amount_with_gst'] : '').' <span class="cutprice">'.(!empty($value['original_price']) ? '₹'.$value['original_price'] : '').'</span></h2>
          <div class="viewall">
            <a href="javascript:void(0)" onclick="saveBookingData('.$value['id'].')" class="viewbtn">Book Now</a>
          </div>
          <span class="faresmry" onclick="fareSummary('.$value['id'].')"><i class="fa-solid fa-circle-info"></i> 
          Fare Summary</span>
        </div>
      </div>'; 
      
        }
    }
    $response=['html'=>$html,'list_data'=>json_encode($list)];
    echo json_encode($response);exit;
}


}
