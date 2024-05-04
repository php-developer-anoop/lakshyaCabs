<?php
if (!function_exists('db')) {
    function db() {
        $db = \Config\Database::connect();
        return $db;
    }
}
if (!function_exists("removeImage")) {
    function removeImage($old_image) {
        if (!empty($old_image) && file_exists(ROOTPATH . 'uploads/' . $old_image)) {
            @unlink(ROOTPATH . 'uploads/' . $old_image);
        }
        return true;
    }
}
if (!function_exists("explodeMe")) {
    function explodeMe($str, $delimiter, $position) {
        $outPut = '';
        if (!empty($str)) {
            $expl = explode($delimiter, $str);
            if (!empty($expl)) {
                $outPut = $expl[$position];
            }
        }
        return $outPut;
    }
}
if (!function_exists("getFileExt")) {
    function getFileExt($filename) {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return strtolower($ext);
    }
}
if (!function_exists("getFileName")) {
    function getFileName($filename, $is_extension = null) {
        $coreFilename = pathinfo(ROOTPATH . '/uploads/' . $filename, PATHINFO_FILENAME);
        return (!empty($is_extension) && !empty($coreFilename) ? $coreFilename . '.' . $is_extension : $coreFilename);
    }
}
if (!function_exists('myRegx')) {
    function myRegx($str, $type = null) {
        $str = trim($str);
        if ($type == 'letter') {
            return preg_replace("/[^A-Za-z ]/", "", $str);
        } else if ($type == 'digit') {
            return preg_replace("/[^0-9]/", "", $str);
        } else if ($type == 'email') {
            return filter_var($str, FILTER_VALIDATE_EMAIL);
        } else if ($type == 'float') {
            return preg_replace("/[^0-9.]/", "", $str);
        } else if ($type == 'alphanum') {
            return preg_replace("/[^A-Za-z0-9. ]/", "", $str);
        }
    }
}
if (!function_exists('dropDownList')) {
    function dropDownList($tableName, $where, $id, $text, $default, $no_default_select = null, $orderBy = null) {
        $keys = $id . ',' . $text;
        $queryBuilder = db()->table($tableName);
        $queryBuilder->select($keys);
        if (!empty($where)) {
            $queryBuilder->where($where);
        }
        if (!empty($orderBy)) {
            $queryBuilder->orderBy($orderBy);
        }
        $getList = $queryBuilder->get()->getResultArray();
        $output = [];
        if (empty($no_default_select)) {
            $output[''] = $default ? $default : '--Select--';
        }
        if (!empty($getList)) {
            foreach ($getList as $item) { // Use $item instead of $key and $value
                $output[$item[$id]] = $item[$text];
            }
        }
        return $output;
    }
}
if (!function_exists("getImagePath")) {
    function getImagePath($imgJpg = null, $imgWebp = null, $cdnImgJpg = null, $cdnIWebp = null) {
        $agent = \Config\Services::request()->getUserAgent();
        $imgJpgUrl = "";
        $imgWebpUrl = "";
        if (!empty($cdnImgJpg)) {
            $imgJpgUrl = $cdnImgJpg;
        } else {
            $imgJpgUrl = base_url('uploads/') . $imgJpg;
        }
        if (!empty($cdnIWebp)) {
            $imgWebpUrl = $cdnIWebp;
        } else {
            $imgWebpUrl = base_url('uploads/') . $imgWebp;
        }
        if ($agent->isBrowser('Safari') && !empty($imgJpg)) {
            return $imgJpgUrl;
        } else if (!empty($imgWebp)) {
            return $imgWebpUrl;
        } else {
            return '';
        }
    }
}
if (!function_exists("getImagePathUrl")) {
    function getImagePathUrl($imgJpg = null, $imgWebp = null, $cdnImgJpg = null, $cdnIWebp = null) {
        $agent = \Config\Services::request()->getUserAgent();
        $imgJpgUrl = "";
        $imgWebpUrl = "";
        if (!empty($cdnImgJpg)) {
            $imgJpgUrl = $cdnImgJpg;
        } else {
            $imgJpgUrl = $imgJpg;
        }
        if (!empty($cdnIWebp)) {
            $imgWebpUrl = $cdnIWebp;
        } else {
            $imgWebpUrl = $imgWebp;
        }
        if ($agent->isBrowser('Safari') && !empty($imgJpg)) {
            return $imgJpgUrl;
        } else if (!empty($imgWebp)) {
            return $imgWebpUrl;
        } else {
            return '';
        }
    }
}
if (!function_exists('dropDownFromList')) {
    function dropDownFromList($list, $id, $text, $default) {
        $output = [];
        $output[''] = $default ? $default : '--Select--';
        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $output[$value[$id]] = $value[$text];
            }
        }
        return $output;
    }
}
if (!function_exists("uploadJpgWebp")) {
    function uploadJpgWebp($file, $is_webp = null, $folderName = 'jwellbox') {
        $UploadToCdn = new \App\Libraries\UploadToCdn();
        $data = [];
        if ($file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $imageName);
            if (file_exists(ROOTPATH . '/uploads/' . $imageName)) {
                $data['jpg'] = $imageName;
                if (ENABLE_CLOUDNARY_UPLOADS) {
                    $data['cdn_jpg'] = $UploadToCdn->uploadToCloudNary($imageName, $folderName);
                }
            }
            // Convert to WebP
            if (!empty($is_webp)) {
                $webPFile = date('YmdHis') . '_img.webp';
                $image = \Config\Services::image()->withFile(ROOTPATH . '/uploads/' . $imageName)->convert(IMAGETYPE_WEBP)->save(ROOTPATH . '/uploads/' . $webPFile);
                if (file_exists(ROOTPATH . '/uploads/' . $webPFile)) {
                    $data['webp'] = $webPFile;
                    if (ENABLE_CLOUDNARY_UPLOADS) {
                        $data['cdn_webp'] = $UploadToCdn->uploadToCloudNary($webPFile, $folderName);
                    }
                }
            }
            return $data;
        }
    }
}
if (!function_exists("removeImageInDuplicateConditions")) {
    function removeImageInDuplicateConditions($fileData) {
        if (!empty($fileData)) {
            if (!empty($fileData['jpg'])) {
                removeImage($fileData['jpg']);
            }
            if (!empty($fileData['webp'])) {
                removeImage($fileData['webp']);
            }
        }
        return true;
    }
}
if (!function_exists('adminview')) {
    function adminview($pagename, $data) {
        $company = websetting('*');
        $data['company'] = $company;
        $data['favicon'] = !empty($company['favicon']) ? base_url('uploads/') . $company['favicon'] : "";
        $data['logo'] = !empty($company['logo']) ? base_url('uploads/') . $company['logo'] : "";
        echo view(ADMINPATH . "includes/meta_file", $data);
        echo view(ADMINPATH . "includes/all_css", $data);
        echo view(ADMINPATH . "includes/header", $data);
        echo view(ADMINPATH . "includes/sidebar", $data);
        echo view(ADMINPATH . $pagename, $data);
        echo view(ADMINPATH . "includes/all_js", $data);
        echo view(ADMINPATH . "includes/footer", $data);
    }
}
if (!function_exists("frontview")) {
    function frontview($page_name, $data) {
        $company = websetting('*');
        $data['company'] = $company;
        $data['homesetting'] = homesetting('*');
        $data['favicon'] = !empty($company['favicon']) ? base_url('uploads/') . $company['favicon'] : "";
        $data['logo'] = !empty($company['logo']) ? base_url('uploads/') . $company['logo'] : "";
        echo view("frontend/includes/meta_file", $data);
        echo view("frontend/includes/all_css", $data);
        echo view("frontend/includes/header", $data);
        echo view("frontend/" . $page_name, $data);
        echo view("frontend/includes/footer", $data);
        echo view("frontend/includes/all_js", $data);
    }
}
if (!function_exists("userview")) {
    function userview($page_name, $data) {
        $company = websetting('*'); 
        $user = getUserProfile();
        $data['company'] = $company;
        $data['homesetting'] = homesetting('*');
        $data['favicon'] = !empty($company['favicon']) ? base_url('uploads/') . $company['favicon'] : "";
        $data['logo'] = !empty($company['logo']) ? base_url('uploads/') . $company['logo'] : "";
        $data['profile_pic'] = !empty($user['profile_image']) ? base_url('uploads/') . $user['profile_image'] : "";
        $data['profile_name'] = !empty($user['name']) ? $user['name'] : "";
        // echo "<pre>";
        // print_r($user);exit;
        echo view("user/includes/header", $data);
        echo view("user/includes/sidebar", $data);
        echo view("user/includes/tophdr", $data);
        echo view("user/" . $page_name, $data);
        echo view("user/includes/footer", $data);
    }
}
if (!function_exists("vendorView")) {
    function vendorView($page_name, $data) {
        $company = websetting('*');
        $data['vendor'] = getVendorProfile();
        $data['company'] = $company;
        $data['homesetting'] = homesetting('*');
        $data['favicon'] = !empty($company['favicon']) ? base_url('uploads/') . $company['favicon'] : "";
        $data['logo'] = !empty($company['logo']) ? base_url('uploads/') . $company['logo'] : "";
        echo view(VENDORPATH . "includes/top-links", $data);
        echo view(VENDORPATH . "includes/header", $data);
        echo view(VENDORPATH . "includes/sidebar", $data);
        echo view(VENDORPATH . $page_name, $data);
        echo view(VENDORPATH . "includes/footer", $data);
    }
}
if (!function_exists("websetting")) {
    function websetting($select) {
        $company = db()->table('dt_setting')->select($select)->get()->getRowArray();
        return $company;
    }
}
if (!function_exists("homesetting")) {
    function homesetting($select) {
        $company = db()->table('dt_homesetting')->select($select)->get()->getRowArray();
        return $company;
    }
}
if (!function_exists("validate_slug")) {
    function validate_slug($text, string $divider = '-') {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = transliterator_transliterate('Any-Latin; Latin-ASCII', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $divider);
        $text = preg_replace('~-+~', $divider, $text);
        $text = strtolower($text);
        return empty($text) ? 'n-a' : $text;
    }
}
function getCategoryPackCount($id) {
    $query = db()->table('package_list')->select('COUNT(id) as total')->where("FIND_IN_SET('" . $id . "', package_category_ids) <> 0")->get();
    $row = $query->getRowArray();
    return $row['total']??0;
}
function getDestinationPackCount($id) {
    $query = db()->table('package_list')->select('COUNT(id) as total')->where("FIND_IN_SET('" . $id . "', destination_ids) <> 0")->get();
    $row = $query->getRowArray();
    return $row['total']??0;
}
if (!function_exists('convertImageInToWebp')) {
    function convertImageInToWebp($folderPath, $uploaded_file_name, $new_webp_file) {
        $source = $folderPath . '/' . $uploaded_file_name;
        $extension = pathinfo($source, PATHINFO_EXTENSION);
        $quality = 100;
        $image = '';
        if ($extension == 'jpeg' || $extension == 'jpg') {
            $image = imagecreatefromjpeg($source);
        } else if ($extension == 'gif') {
            $image = imagecreatefromgif($source);
        } else if ($extension == 'png') {
            $image = imagecreatefrompng($source);
            imagepalettetotruecolor($image);
        } else {
            $image = $uploaded_file_name;
        }
        $destination = $folderPath . '/' . $new_webp_file;
        $webp_upload_done = imagewebp($image, $destination, $quality);
        return $webp_upload_done ? $new_webp_file : '';
    }
}
if (!function_exists('count_data')) {
    function count_data($column, $table, $where = null) {
        $builder = db()->table($table);
        if (!empty($where)) {
            $builder->where($where);
        }
        $count = $builder->countAllResults($column);
        return $count;
    }
}
function random_alphanumeric_string($length) {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$&!=+';
    return substr(str_shuffle($chars), 0, $length);
}
function generate_password($length) {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$';
    return substr(str_shuffle($chars), 0, $length);
}
if (!function_exists('decryptPassword')) {
    function decryptPassword($cookieName, $domain = null) {
        $browser_token = get_cookie($cookieName, true, $domain);
        if ($browser_token) {
            $ciphering = "AES-128-CTR";
            $iv_length = openssl_cipher_iv_length($ciphering);
            $encryption_iv = '9102407892214621';
            $encryption_key = "281d8febfeee1bdc9ec24c5bb73de622";
            $decryption = openssl_decrypt($browser_token, $ciphering, $encryption_key, 0, $encryption_iv);
            $decrypted_data = json_decode($decryption, true);
            return $decrypted_data;
        } else {
            return null;
        }
    }
}
if (!function_exists('getMenuList')) {
    function getMenuList() {
        $list = db()->table('dt_menus')->select('id,menu_name,slug,type,menu_id,priority')->where('status', 'Active')->orderBy("priority ASC")->get()->getResultArray();
        return $list;
    }
}
if (!function_exists('menuList')) {
    function menuList() {
        $list = session()->get('menu_list');
        return !empty($list) ? json_decode($list, true) : getMenuList();
    }
}
function FetchExactBrowserName() {
    $userAgent = strtolower($_SERVER["HTTP_USER_AGENT"]);
    if (strpos($userAgent, "opr/") !== false) {
        return "Opera";
    } elseif (strpos($userAgent, "chrome/") !== false) {
        return "Chrome";
    } elseif (strpos($userAgent, "edg/") !== false) {
        return "Microsoft Edge";
    } elseif (strpos($userAgent, "msie") !== false || strpos($userAgent, "trident/") !== false) {
        return "Internet Explorer";
    } elseif (strpos($userAgent, "firefox/") !== false) {
        return "Firefox";
    } elseif (strpos($userAgent, "safari/") !== false && strpos($userAgent, "chrome/") === false) {
        return "Safari";
    } else {
        return "Unknown";
    }
}
function imgExtension($image_jpg_png_gif, $image_webp = null) {
    $browserName = FetchExactBrowserName();
    if ($browserName === "Chrome" && !empty($image_webp)) {
        return $image_webp;
    } elseif ($browserName === "Safari" && !empty($image_webp)) {
        return $image_webp;
    } else {
        return $image_jpg_png_gif;
    }
}
if (!function_exists('getTimeInterval')) {
    function getTimeInterval($time) {
        $current_time = new DateTime();
        $from = new DateTime($time);
        $difference = $current_time->diff($from);
        $totalHours = $difference->days * 24 + $difference->h;
        return $totalHours;
    }
}
function getData($table, $keys = null, $where = null, $limit = null, $offset = null, $order_by = null, $key = null, $groupby = null, $jointable = null, $join = null) {
    $builder = db()->table($table);
    if (!empty($keys)) {
        $builder->select($keys);
    }
    if (!empty($where)) {
        $builder->where($where);
    }
    if (!empty($limit) && !empty($offset)) {
        $builder->limit($limit, $offset);
    } elseif (!empty($limit) && empty($offset)) {
        $builder->limit($limit);
    }
    if (!empty($order_by)) {
        $builder->orderBy($order_by);
    }
    if (!empty($groupby)) {
        $builder->groupBy($groupby);
    }
    if (!empty($jointable) && !empty($join)) {
        $builder->join($jointable, $join);
    }
    return $builder->get()->getResultArray();
}
function getSingle($table, $keys = null, $where = null, $limit = null, $offset = null, $order_by = null,$joinArray=null) {
    $builder = db()->table($table);
    if (!empty($keys)) {
        $builder->select($keys);
    }
    if (!empty($where)) {
        $builder->where($where);
    }
    if (!empty($limit)) {
        if (!empty($offset)) {
            $builder->limit($limit, $offset);
        } else {
            $builder->limit($limit);
        }
    }
    if( !empty($joinArray) ){
            foreach ($joinArray as $key => $value) {
                $builder->join( $value['table'], $value['join_on'], $value['join_type'] );
            } 
    }
    if (!empty($order_by)) { // corrected variable name
        $builder->orderBy($order_by); // corrected variable name
        
    }
    return $builder->get()->getRowArray();
}
function showRatings($ratingValue) {
    $filledStar = '<li><i class="fa fa-star"></i></li>';
    $filledStarsCount = $ratingValue;
    $emptyStarsCount = 5 - $ratingValue;
    $ratingsHTML = '';
    for ($i = 0;$i < $filledStarsCount;$i++) {
        $ratingsHTML.= $filledStar;
    }
    return $ratingsHTML;
}
if (!function_exists('getSubMenuList')) {
    function getSubMenuList($menuList, $parent_menu_id) {
        return array_filter($menuList, function ($item) use ($parent_menu_id) {
            return $item['menu_id'] === $parent_menu_id;
        });
    }
}
if (!function_exists('checkWriteMenus')) {
    function checkWriteMenus($uri) {
        $session = session()->get('admin_login_data');
        $write_slug = !empty($session['write_slug']) ? $session['write_slug'] : [];
        return !empty($uri) && in_array($uri, $write_slug);
    }
}
if (!function_exists('getUri')) {
    function getUri($segment) {
        $uri = service('uri');
        $url = $uri->getSegment($segment);
        return $url;
    }
}
if (!function_exists('getFormatFinancialYear')) {
    function getFormatFinancialYear($start_year, $end_year = null) {
        $data = [];
        $current_date = $start_year;
        $start_financial_year = date('Y', strtotime($current_date)) . FINANCIAL_YEAR_START;
        if (strtotime($current_date) > strtotime($start_financial_year)) {
            $start_year = date('Y', strtotime($current_date)) . FINANCIAL_YEAR_START;
            $end_year = date('Y', strtotime($current_date . ' +1 year ')) . FINANCIAL_YEAR_END;
        } else if (strtotime($current_date) < strtotime($start_financial_year)) {
            $start_year = date('Y', strtotime($current_date . ' -1 year ')) . FINANCIAL_YEAR_START;
            $end_year = date('Y', strtotime($current_date)) . FINANCIAL_YEAR_END;
        }
        $data['start_year'] = $start_year;
        $data['end_year'] = $end_year;
        return $data;
    }
}
if (!function_exists("getFaqData")) {
    function getFaqData($where = false) {
        $builder = db()->table('dt_faq');
        return $builder->select('question,answer')->where($where)->get()->getResultArray();
    }
}
if (!function_exists("generateFaqSchema")) {
    function generateFaqSchema($faqData) {
        if (!empty($faqData)) {
            $count = count($faqData);
            $schema = ["@context" => "https://schema.org/", "@type" => "FAQPage", "mainEntity" => []];
            foreach ($faqData as $index => $faqItem) {
                $question = strip_tags($faqItem['question']);
                $answer = strip_tags($faqItem['answer']);
                $schema['mainEntity'][] = ["@type" => "Question", "name" => $question, "acceptedAnswer" => ["@type" => "Answer", "text" => $answer]];
            }
            $jsonSchema = json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $scriptTag = '<script type="application/ld+json">' . PHP_EOL . $jsonSchema . PHP_EOL . '</script>' . PHP_EOL;
            return $scriptTag;
        } else {
            return false;
        }
    }
}
if (!function_exists("generateProductSchema")) {
    function generateProductSchema($name = false, $image = false, $description = false) {
        // $ratingValue = random_int(40, 50) / 10;
        $ratingValue = (int)4;
        $settingData = webSetting('logo,company_name');
        $brandname = $settingData['company_name'];
        if (!empty($image)) {
            $imagePath = WEBSITE_PATH . ('uploads/' . $image);
        } else {
            $imagePath = WEBSITE_PATH . ('uploads/') . $settingData['logo'];
        }
        $schema = '';
        $schema.= '<script type="application/ld+json">' . "\n";
        $schema.= '{' . "\n";
        $schema.= '"@context": "https://schema.org/",' . "\n";
        $schema.= '"@type": "Product", ' . "\n";
        $schema.= '"name": "' . $name . '",' . "\n";
        $schema.= '"image": "' . $imagePath . '",' . "\n";
        $schema.= '"description": "' . $description . '",' . "\n";
        $schema.= '"brand": {' . "\n";
        $schema.= '"@type": "Brand",' . "\n";
        $schema.= '"name": "' . $brandname . '"' . "\n";
        $schema.= '},' . "\n";
        $schema.= '"aggregateRating": {' . "\n";
        $schema.= '"@type": "AggregateRating",' . "\n";
        $schema.= '"ratingValue": "' . $ratingValue . '",' . "\n";
        $schema.= '"bestRating": "5",' . "\n";
        $schema.= '"worstRating": "1",' . "\n";
        $schema.= '"ratingCount": "' . random_int(700, 1500) . '"' . "\n";
        $schema.= '}' . "\n";
        $schema.= '}' . "\n";
        $schema.= '</script>' . "\n";
        return $schema;
    }
}
function getCityStateName($city_id) {
    $cities = getSingle('cities', 'city_name,state_name', ['status' => 'Active', 'id' => $city_id]);
    $formattedCity = '';
    if (!empty($cities)) {
        $formattedCity = $cities['city_name'] . ', ' . $cities['state_name'];
    }
    return $formattedCity;
}
function getStateName($state_id) {
    $state = getSingle('states', 'state_name', ['status' => 'Active', 'id' => $state_id]);
    
    return !empty($state['state_name'])?$state['state_name']:null;
}
function getPaymentOrderStatus($order_id) {
    $status = getSingle('transaction_log', 'order_status', ['order_id' => $order_id]);
    
    if (!empty($status)) {
       return $status['order_status']; 
    }
    return '';
}
function getVehicleCategoryId($model_id) {
    $category = getSingle('vehicle_model', 'category_id', ['status' => 'Active', 'id' => $model_id]);
    if (!empty($category)) {
        return $category['category_id'];
    }
}
function getTripTypeFromCmsTabId($cms_tab_id) {
    $trip_type = getSingle('cms_tab_master', 'trip_type', ['status' => 'Active', 'id' => $cms_tab_id]);
    if (!empty($trip_type)) {
        return $trip_type['trip_type'];
    }
}
function getLocalPackageName($city_id) {
    $local_package = getSingle('hourly_package', 'id', ['status' => 'Active', 'city_id' => $city_id], null, null, 'covered_km ASC');
    if (!empty($local_package)) {
        return $local_package['id'];
    }
    return null;
}
function getModelName() {
    $models = getData('vehicle_model', 'id,model_name', ['status' => 'Active']);
    if (!empty($models)) {
        return $models;
    } else {
        return '';
    }
}
function testInput($input) {
    $input = trim($input);
    $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $input = filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    return $input;
}
function getCategoryName($id) {
    $category = getSingle('package_category', 'category_name', ['status' => 'Active', 'id' => $id]);
    if (!empty($category)) {
        return $category['category_name'];
    }
}
function getModel($model_id) {
    $model = getSingle('vehicle_model', 'model_name', ['status' => 'Active', 'id' => $model_id]);
    if (!empty($model)) {
        return $model['model_name'];
    }
}
function getDestinationName($id) {
    $destination = getSingle('destinations', 'destination', ['status' => 'Active', 'id' => $id]);
    if (!empty($destination)) {
        return $destination['destination'];
    }
}
function getTabName($id) {
    $tab_name = getSingle('cms_tab_master', 'tab_name', ['status' => 'Active', 'id' => $id]);
    if (!empty($tab_name)) {
        return $tab_name['tab_name'];
    }
}
function getTabStatus($id, $tab_id) {
    $tab_name = getSingle('all_cms_data', 'cms_tab_id', ['status' => 'Active', 'parent_id' => $id, 'cms_tab_id' => $tab_id, 'page_type' => 'seo']);
    return !empty($tab_name['cms_tab_id']) ? $tab_name['cms_tab_id'] : '';
    // return db()->getLastQuery
    
}
function getUserProfile() {
    $session = session('user_login_data');
    $user = getSingle('customer_list', '*', ['email' => $session['email']]);
    if (!empty($user)) {
        return $user;
    }
}
function getVendorProfile() {
    $vendor = session('vendor_login_data');
    if ($vendor) {
        $vendorDetails = getSingle('vendor_list', '*', ['id' => $vendor['id']]);
        if (!empty($vendorDetails)) {
            return $vendorDetails;
        }
    }
    return null; // Return null if the vendor profile is not found or if there's no vendor_id in session
}
function getVendorId() {
    $vendor = session()->get('vendor_id');
    if ($vendor) {
        $vendorDetails = getSingle('vendor_list', '*', ['id' => $vendor]);
        if (!empty($vendorDetails)) {
            return $vendorDetails;
        }
    }
    return null; // Return null if the vendor profile is not found or if there's no vendor_id in session
}
function getPopularRoutesName() {
    $routes = getData('dt_all_cms_data', 'page_name,page_slug, trip_type,from_city_name ', ['status' => 'Active', 'page_type' => 'route', 'from_city_id !=' => ''], null, null, null, 'ASC', 'page_name');
    return $routes;
}
function getPopularRoutes($route_name) {
    $routes = getData('dt_popular_routes', 'route_title,url', ['status' => 'Active', 'route_name' => $route_name], null, null, null, null);
    return $routes;
}
function getAboutDescription() {
    $cms = getSingle('cms', 'description', ['status' => 'Active', 'url' => 'about-us']);
    if (!empty($cms)) {
        return substr($cms['description'], 0, 150) . '..';
    }
}
function getPopularTaxi() {
    $popular_taxis = getData('all_cms_data', 'DISTINCT(from_city_name),page_slug', ['status' => 'Active', 'page_type' => 'seo', 'parent_id != ' => 0], null, null, null, null, 'from_city_name');
    return $popular_taxis;
}
function percentage($totalAmount, $gatewayFee) {
    if ($totalAmount == 0) {
        return 0;
    }
    return ($gatewayFee / $totalAmount) * 100;
}
function getCustomerName($customer_id) { 
    $customer = getSingle('customer_list', 'name', ['id' => $customer_id]);
    if (!empty($customer)) {
        return $customer['name'];
    }
}
if (!function_exists('getDaysFromTwoDates')) {
    function getDaysFromTwoDates($start, $end) {
        $date1 = date('Y-m-d', strtotime($start));
        $date2 = date('Y-m-d', strtotime($end));
        $start = strtotime($start);
        $end = strtotime($end);
        $days_between = ceil(abs($end - $start) / 86400);
        return ($date1 != $date2) ? ($days_between + 1) : 1;
    }
}
if (!function_exists('twoDecimal')) {
    function twoDecimal($value) {
        $decimal = number_format((float)$value, 2, '.', '');
        return $decimal;
    }
}
if (!function_exists('oneDecimal')) {
    function oneDecimal($value) {
        $decimal = number_format((float)$value, 1, '.', '');
        return $decimal;
    }
}
if (!function_exists('percentValue')) {
    function percentValue($value, $percent) {
        return ((float)$value * (float)$percent) / 100;
    }
}
if (!function_exists('withPercentValue')) {
    function withPercentValue($value, $percent) {
        $output = (float)$value + ((float)$value * (float)$percent) / 100;
        return $output;
    }
}
if (!function_exists('applyCalenderValue')) {
    function applyCalenderValue($value, $charge_type, $charge_value_type, $charge_value) {
        $output = $value;
        if ($charge_type == 'decrease') {
            if ($charge_value_type == 'percent') {
                $output = (float)$value - ((float)$value * (float)$charge_value) / 100;
            } else if ($charge_value_type == 'fixed') {
                $output = (float)$value - (float)$charge_value;
            }
        } else if ($charge_type == 'increase') {
            if ($charge_value_type == 'percent') {
                $output = withPercentValue($value, $charge_value);
            } else if ($charge_value_type == 'fixed') {
                $output = (float)$value + (float)$charge_value;
            }
        }
        return $output;
    }
}
if (!function_exists('applySameDateCondition')) {
    function applySameDateCondition($value, $charge_type, $charge_value_type, $charge_value) {
        $output = $value;
        if ($charge_type == 'less') {
            if ($charge_value_type == 'percent') {
                $output = (float)$value - ((float)$value * (float)$charge_value) / 100;
            } else if ($charge_value_type == 'fixed') {
                $output = (float)$value - (float)$charge_value;
            }
        } else if ($charge_type == 'extra') {
            if ($charge_value_type == 'percent') {
                $output = withPercentValue($value, $charge_value);
            } else if ($charge_value_type == 'fixed') {
                $output = (float)$value + (float)$charge_value;
            }
        }
        return $output;
    }
}
/*******************   Google Distance Calculation System *********************/
/*******************   Google Distance Calculation System *********************/
if (!function_exists("hourToMin")) {
    function hourToMin($str) {
        $data = '';
        $newstring = preg_replace('/\s+/', '', $str);
        $posmin = $str ? strpos($newstring, 'mins', '1') : '';
        $poshours = $str ? strpos($newstring, 'hours', '1') : '';
        $explodehr = explode("hours", $newstring);
        $explodemin = explode("mins", $newstring);
        if ($poshours > 0 && $posmin > 0) {
            $data = (float)($explodehr[0] * 60) + (float)($explodehr[1]);
        } else if ($poshours > 0) {
            $data = (int)$explodehr[0] * 60;
        } else if ($posmin > 0) {
            $data = $explodemin[0];
        }
        return $data;
    }
}
if (!function_exists("hourToMinColumn")) {
    function hourToMinColumn($str) {
        $explodehr = explode(":", $str);
        return $explodehr[0] * 60 + $explodehr[1];
    }
}
function convertMinutesToDaysHoursMinutes($minutes) {
    if (!is_numeric($minutes)) {
        return "Input must be a numeric value.";
    }
    $days = floor($minutes / (24 * 60));
    $remainingHours = $minutes % (24 * 60);
    $hours = floor($remainingHours / 60);
    $remainingMinutes = $minutes % 60;
    $result = "";
    if ($days > 0) {
        $result.= $days . " day(s), ";
    }
    if ($hours > 0) {
        $result.= $hours . " hour(s), ";
    }
    if ($remainingMinutes > 0) {
        $result.= $remainingMinutes . " minute(s)";
    }
    return $result;
}
if (!function_exists("googleDistanceMatrixApi")) {
    function googleDistanceMatrixApi($source, $destination, $trip_type = null, $coordsArray = null) {
        //check distance in db
        $dbDistance = getDbDistance($source, $destination, $trip_type, $coordsArray);
        if (!empty($dbDistance)) {
            return $dbDistance;
        } else {
            $Api = GOOGLE_DISTANCE_MATRIX_API_KEY;
            $arraykey = array('', '');
            $keyval = array_rand($arraykey);
            //  $Api = $arraykey[$keyval];
            $distance = '';
            $duration = '';
            $origin = !empty($source) ? urlencode($source) : null;
            $destination = !empty($destination) ? urlencode($destination) : null;
            $urlf = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $origin . '&destinations=' . $destination . '&mode=driving&language=en-US&key=' . $Api . '';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $urlf);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            $jsondata = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($jsondata, true);
            $output = '0#0';
            if ($data['status'] == 'OK') {
                $result = $data['rows'][0]['elements'][0]['distance']['text'];
                $distance = str_replace(',', '', trim(str_replace('km', '', $result)));
                $duration = $data['rows'][0]['elements'][0]['duration']['text'];
                $duration_min = !empty($data['rows'][0]['elements'][0]['duration']['value']) ? round(($data['rows'][0]['elements'][0]['duration']['value']) / 60) : '';
                $output = $distance . '#' . $duration_min;
                $insert = getDbDistance($source, $destination, $distance, $duration, $duration_min);
            }
            return $output;
        }
    }
}
if (!function_exists("googleTime")) {
    function googleTime($data) {
        $array = explode('#', $data);
        return !empty($array[1]) ? $array[1] : 0;
    }
}
if (!function_exists("googleKms")) {
    function googleKms($data) {
        $array = explode('#', $data);
        return !empty($array[0]) ? $array[0] : 0;
    }
}
if (!function_exists("calculateDistance")) {
    function calculateDistance($source, $destination, $trip_type = null) {
        return googleDistanceMatrixApi($source, $destination, $trip_type);
    }
}
if (!function_exists("calculateViaDistance")) {
    function calculateViaDistance($allcitylist) {
        $wayPoints = explode('|', $allcitylist);
        $lastcity = end($wayPoints);
        $source = $wayPoints[0];
        if ($source != $lastcity) {
            $wayPoints[] = $source;
        }
        $kms = 0;
        $time = 0;
        $count = !empty($wayPoints) ? sizeof($wayPoints) : 0;
        $i = 1;
        if (!empty($wayPoints)) {
            foreach ($wayPoints as $key => $value) {
                if ($i < $count) {
                    $source = $wayPoints[$key];
                    $destination = $wayPoints[$key + 1];
                    $arraydist = googleDistanceMatrixApi($source, $destination);
                    $kms+= googleKms($arraydist);
                    $time+= googleTime($arraydist);
                }
                $i++;
            }
        }
        return $kms . '#' . $time;
    }
}
if (!function_exists("getDbDistance")) {
    function getDbDistance($source_in, $destination_in, $is_distance = null, $minutes = 0, $duration_min = 0, $trip_type = null) {
        if (empty($trip_type) || $trip_type != 'Airport') {
            //get 3 steps address
            $source = extractLocation(removePinCodeFromAddress(urldecode($source_in)));
            $destination = extractLocation(removePinCodeFromAddress(urldecode($destination_in)));
            //get 4 steps address id addres is same in above strings
            if (trim($source) == trim($destination)) {
                $source = extractLocation(removePinCodeFromAddress(urldecode($source_in)), 4);
                $destination = extractLocation(removePinCodeFromAddress(urldecode($destination_in)), 4);
            }
        }
        $where = [];
        $where["(`from_address` LIKE '%" . $source . "%' AND `to_address` LIKE '%" . $destination . "%') OR (`from_address` LIKE '%" . $destination . "%' AND `to_address` LIKE '%" . $source . "%') "] = NULL;
        $builder = db()->table('dt_distance_address_book');
        $builder->select('distanc_km,time_minutes');
        $builder->where($where);
        $getCity = $builder->get()->getRowArray();
        if (!empty($getCity)) {
            return $getCity['distanc_km'] . '#' . $getCity['time_minutes'];
        } else if (!empty($is_distance)) {
            $save = [];
            $save['from_address'] = $source;
            $save['to_address'] = $destination;
            $save['distanc_km'] = (int)$is_distance;
            $save['time_minutes'] = (int)$duration_min;
            $insert = db()->table('dt_distance_address_book')->insert($save);
            return $is_distance . '#' . $minutes;
        } else {
            return '';
        }
    }
}
if (!function_exists("removePinCodeFromAddress")) {
    function removePinCodeFromAddress($address) {
        $pattern = '/\b\d{6}\b$/';
        $addressWithoutPin = preg_replace($pattern, '', $address);
        $str = rtrim($addressWithoutPin, ', ');
        $str = rtrim($str, ',');
        return trim($str);
    }
}
if (!function_exists("extractLocation")) {
    function extractLocation($address, $length = 3) {
        $parts = explode(', ', $address);
        $totalParts = count($parts);
        if ($totalParts >= 3) {
            $extractedParts = array_slice($parts, $totalParts - $length, $length);
            return implode(', ', $extractedParts);
        } else {
            return $address;
        }
    }
}
if (!function_exists("cityIdGoogleAddress")) {
    function cityIdGoogleAddress($str, $state_id = null, $fullRow = null) {
        $str = trim($str);
        $explode = explode(',', $str);
        $count = count($explode);
        $output = '';
        $statename = '';
        $cityname = '';
        $stateid = !empty($state_id) ? $state_id : '';
        $cityid = '';
        $checkfirst = in_array(' India', $explode, true);
        if ($checkfirst && $count > 3) {
            $arr = array_slice($explode, -3, 3, true);
            reset($arr);
            $first_key = key($arr);
            $cityname = $arr[$first_key];
            $statename = $arr[$first_key + 1];
        } else if ($checkfirst && $count == 3) {
            $arr = array_slice($explode, -3, 3, true);
            reset($arr);
            $first_key = key($arr);
            $cityname = $arr[$first_key];
            $statename = $arr[$first_key + 1];
        } else if ($checkfirst && $count == 2) {
            $arr = array_slice($explode, -2, 1, true);
            reset($arr);
            $first_key = key($arr);
            $cityname = $arr[$first_key];
            $statename = '';
        } else if (empty($checkfirst) && $count > 2) {
            $arr = array_slice($explode, -2, 2, true);
            reset($arr);
            $first_key = key($arr);
            $cityname = $arr[$first_key];
            $statename = $arr[$first_key + 1];
        } else if (empty($checkfirst) && $count == 2) {
            $arr = array_slice($explode, -2, 2, true);
            reset($arr);
            $first_key = key($arr);
            $cityname = $arr[$first_key];
            $statename = $arr[$first_key + 1];
        } else if (empty($checkfirst) && $count == 1) {
            $cityname = $str;
            $statename = '';
        }
        $cityname = preg_replace('/\d+/u', '', $cityname);
        $cityname = trim($cityname);
        $cityname = strtolower($cityname);
        if (!empty($statename) && empty($state_id)) {
            $statename = preg_replace('/\d+/u', '', $statename);
            $statename = trim(strtolower($statename));
            $builder = db()->table('dt_states');
            $builder->select('id');
            $builder->where(["LOWER(state_name)" => $statename]);
            $state_array = $builder->get()->getRowArray();
            $stateid = !empty($state_array['id']) ? $state_array['id'] : '';
        }
        if (!empty($cityname)) {
            $builder = db()->table('dt_cities');
            $selectKeys = !empty($fullRow) ? '*' : 'id';
            $builder->select($selectKeys);
            if (!empty($stateid) && !empty($cityname)) {
                $builder->where(["LOWER(city_name)" => $cityname, 'state_id' => $stateid]);
            } else if (empty($stateid) && !empty($cityname)) {
                $builder->where(["LOWER(city_name)" => $cityname]);
            }
            $city_array = $builder->get()->getRowArray();
            if (!empty($fullRow)) {
                $cityid = $city_array;
                !empty($city_array) ? $city_array : [];
            } else {
                $cityid = !empty($city_array['id']) ? $city_array['id'] : '';
            }
        }
        if (empty($cityid)) {
            $builder = db()->table('dt_cities');
            $builder->select('id');
            $builder->where(["LOWER(city_name)" => $cityname]);
            $city_array = $builder->get()->getRowArray();
            $cityid = !empty($city_array['id']) ? $city_array['id'] : '';
        }
        return $cityid;
    }
}
/*********************** Create distance Address book End Script **************************/
/*********************** Create distance Address book End Script **************************/
if (!function_exists("curlApisFun")) {
    function curlApisFun($postUrl, $method = null, $postarray = null, $header = null, $time = null) {
        $curl = curl_init();
        $timeout = !empty($time) ? $time : 30;
        curl_setopt($curl, CURLOPT_URL, $postUrl);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_POST, FALSE);
        if ($method == 'POST') {
            $jsonpostdata = json_encode($postarray);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonpostdata);
            curl_setopt($curl, CURLOPT_POST, TRUE);
        }
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        /*Tell cURL that it should only spend 10 seconds to connect to the URL*/
        //curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20 );
        /*A given cURL operation should only take 30 seconds max.*/
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 5);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        if (!empty($header)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        $jsondata = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($jsondata, TRUE);
        return $data;
    }
}
function getSeatSegment($model_id) {
    $model = getSingle('vehicle_model', 'seat_segment', ['status' => 'Active', 'id' => $model_id]);
    if (!empty($model)) {
        return $model['seat_segment'];
    }
}
function convertAmountToWords($amount) {
    $ones = array(
        0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen',
        18 => 'eighteen', 19 => 'nineteen'
    );

    $tens = array(
        0 => 'zero', 1 => 'ten', 2 => 'twenty', 3 => 'thirty', 4 => 'forty', 5 => 'fifty', 6 => 'sixty', 7 => 'seventy', 8 => 'eighty', 9 => 'ninety'
    );

    $amount = (int)$amount;

    if ($amount < 20) {
        return $ones[$amount];
    }

    if ($amount < 100) {
        return $tens[floor($amount / 10)] . (($amount % 10 > 0) ? ' ' . $ones[$amount % 10] : '');
    }

    if ($amount < 1000) {
        return $ones[floor($amount / 100)] . ' hundred' . (($amount % 100 > 0) ? ' and ' . convertAmountToWords($amount % 100) : '');
    }

    if ($amount < 1000000) {
        return convertAmountToWords(floor($amount / 1000)) . ' thousand' . (($amount % 1000 > 0) ? ' ' . convertAmountToWords($amount % 1000) : '');
    }

    if ($amount < 1000000000) {
        return convertAmountToWords(floor($amount / 1000000)) . ' million' . (($amount % 1000000 > 0) ? ' ' . convertAmountToWords($amount % 1000000) : '');
    }

    return 'value too large';
}

function getMinPrice($taxi_package_id){
    $taxi = getSingle('dt_taxi_package_vehicle_price','MIN(fixed_price) as min_price',['taxi_package_id'=>$taxi_package_id]);
    return !empty($taxi['min_price'])?$taxi['min_price']:'';
}

