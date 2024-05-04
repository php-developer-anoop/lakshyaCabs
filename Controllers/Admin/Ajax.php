<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Ajax extends BaseController {
    protected $c_model;
    protected $session;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
    }
    public function index() {
        $id = !empty($this->request->getVar("id")) ? $this->request->getVar("id") : "";
        $table = !empty($this->request->getVar("table")) ? $this->request->getVar("table") : "";
        $records = $this->c_model->getSingle($table, null, ['id' => $id]);
        if (!empty($records)) {
            $result = $this->c_model->deleteRecords($table, ['id' => $id]);
        }
    }
    public function changeStatus() {
        $id = !empty($this->request->getVar("id")) ? $this->request->getVar("id") : "";
        $table = !empty($this->request->getVar("table")) ? $this->request->getVar("table") : "";
        $records = $this->c_model->getSingle($table, 'status', ['id' => $id]);
        if (!empty($records)) {
            $current_status = $records['status'];
            if ($current_status == "Active") {
                $data['status'] = "Inactive";
            } else {
                $data['status'] = "Active";
            }
            $this->c_model->updateRecords($table, $data, ['id' => $id]);
            echo $data['status'];
        }
    }
    public function changeProfileStatus() {
        $id = !empty($this->request->getVar("id")) ? $this->request->getVar("id") : "";
        $table = !empty($this->request->getVar("table")) ? $this->request->getVar("table") : "";
        $records = $this->c_model->getSingle($table, 'profile_status', ['id' => $id]);
        if (!empty($records)) {
            $current_status = $records['profile_status'];
            if ($current_status == "Active") {
                $data['profile_status'] = "Inactive";
            } else {
                $data['profile_status'] = "Active";
            }
            $this->c_model->updateRecords($table, $data, ['id' => $id]);
            echo $data['profile_status'];
        }
    }
    public function changePopular() {
        $id = !empty($this->request->getVar("id")) ? $this->request->getVar("id") : "";
        $table = !empty($this->request->getVar("table")) ? $this->request->getVar("table") : "";
        $records = $this->c_model->getSingle($table, 'is_popular', ['id' => $id]);
        if (!empty($records)) {
            $current_status = $records['is_popular'];
            if ($current_status == "Yes") {
                $data['is_popular'] = "No";
            } else {
                $data['is_popular'] = "Yes";
            }
            $this->c_model->updateRecords($table, $data, ['id' => $id]);
            echo $data['is_popular'];
        }
    }
    public function changeMenu() {
        $id = !empty($this->request->getVar("id")) ? $this->request->getVar("id") : "";
        $table = !empty($this->request->getVar("table")) ? $this->request->getVar("table") : "";
        $records = $this->c_model->getSingle($table, 'is_menu', ['id' => $id]);
        if (!empty($records)) {
            $current_status = $records['is_menu'];
            if ($current_status == "Yes") {
                $data['is_menu'] = "No";
            } else {
                $data['is_menu'] = "Yes";
            }
            $this->c_model->updateRecords($table, $data, ['id' => $id]);
            echo $data['is_menu'];
        }
    }
    public function changeHome() {
        $id = !empty($this->request->getVar("id")) ? $this->request->getVar("id") : "";
        $table = !empty($this->request->getVar("table")) ? $this->request->getVar("table") : "";
        $records = $this->c_model->getSingle($table, 'is_home', ['id' => $id]);
        if (!empty($records)) {
            $current_status = $records['is_home'];
            if ($current_status == "Yes") {
                $data['is_home'] = "No";
            } else {
                $data['is_home'] = "Yes";
            }
            $this->c_model->updateRecords($table, $data, ['id' => $id]);
            echo $data['is_home'];
        }
    }
    public function changeSpecial() {
        $id = !empty($this->request->getVar("id")) ? $this->request->getVar("id") : "";
        $table = !empty($this->request->getVar("table")) ? $this->request->getVar("table") : "";
        $records = $this->c_model->getSingle($table, 'is_special', ['id' => $id]);
        if (!empty($records)) {
            $current_status = $records['is_special'];
            if ($current_status == "Yes") {
                $data['is_special'] = "No";
            } else {
                $data['is_special'] = "Yes";
            }
            $this->c_model->updateRecords($table, $data, ['id' => $id]);
            echo $data['is_special'];
        }
    }
    public function getSlug() {
        $keyword = $this->request->getVar("keyword");
        if (empty($keyword)) {
            return '';
        }
        $slug = validate_slug($keyword);
        return $slug;
    }
    public function getCount() {
        $type = $this->request->getVar('type') ??"";
        $table = $this->request->getVar('table') ??"";
        $where = [];
        if ($table != "fare_configuration") {
            $where['status'] = 'Active';
        }
        if ($type == "users") {
            $where['user_type'] = 'Admin';
        }
        $count = count_data('id', $table, $where);
        echo $count;
    }
    
    public function checkDuplicate() {
        $val = $this->request->getVar('val');
        $table = $this->request->getVar('table');
        $column = $this->request->getVar('column');
        if (empty($val) || empty($table) || empty($column)) {
            return;
        }
        $where = ['status' => 'Active', $column => $val ];
        $data = $this->c_model->getSingle($table, 'id', $where);
        if ($data) {
            echo "yes";
        }else{
            echo '';
        }
    }
    public function getCity() {
        $val = $this->request->getVar("val");
        if (!empty($val)) {
            $query = "SELECT id, city_name, state_name,state_id FROM dt_cities WHERE ( city_name LIKE '%" . $val . "%' OR state_name LIKE '%" . $val . "%' ) AND status = 'Active' ORDER BY city_name asc ";
            $cities = db()->query($query)->getResultArray();
            if (empty($cities)) {
                echo "No Record Found";
                exit;
            } else {
                foreach ($cities as $key => $value) {
                    echo "<li value='" . htmlspecialchars($value['id']) . "' data-stateid='" . htmlspecialchars($value['state_id']) . "'>" . htmlspecialchars($value['city_name']) . ' , ' . htmlspecialchars($value['state_name']) . "</li>";
                }
            }
        }
    }
    public function getCityList() {
        $val = $this->request->getVar("val");
        if (!empty($val)) {
            $query = "SELECT id, city_name, state_name,state_id FROM dt_cities WHERE ( city_name LIKE '%" . $val . "%' ) AND status = 'Active' ORDER BY city_name asc ";
            $cities = db()->query($query)->getResultArray();
            if (empty($cities)) {
                echo "No Record Found";
                exit;
            } else {
                foreach ($cities as $key => $value) {
                    echo "<li value='" . htmlspecialchars($value['id']) . "' data-stateid='" . htmlspecialchars($value['state_id']) . "'>" . htmlspecialchars($value['city_name']) . ' , ' . htmlspecialchars($value['state_name']) . "</li>";
                }
            }
        }
    }
    public function getCitiesFromAjax() {
        $state_id = $this->request->getVar("state_id");
        $stateIds = !empty($state_id) ? explode(',', $state_id) : [];
        $stateId = !empty($stateIds[0]) ? $stateIds[0] : null;
        $cities = [];
        if ($stateId !== null) {
            $cities = $this->c_model->getAllData('cities', 'id, city_name', ['state_id' => $stateId]);
        }
        $cityvalue = $this->request->getVar("city") ??"";
        $cityid = $this->request->getVar("cityid") ??"";
        $html = '<option value="">Select City</option>';
        if (!empty($cities)) {
            foreach ($cities as $key => $value) {
                $cityInfo = $value['id'] . ',' . $value['city_name'];
                if (!empty($cityid)) {
                    $selected = ($cityid === $value['id']) ? "selected" : "";
                } else {
                    $selected = ($cityInfo === $cityvalue) ? "selected" : "";
                }
                $html.= '<option ' . $selected . ' value="' . $cityInfo . '">' . $value['city_name'] . '</option>';
            }
        }
        echo $html;
    }
    public function getModelsFromAjax() {
        $category_id = $this->request->getVar("category_id") ??"";
        $model_id = $this->request->getVar("model_id") ??"";
        $category_id = filter_var($category_id, FILTER_SANITIZE_NUMBER_INT);
        $model_id = filter_var($model_id, FILTER_SANITIZE_NUMBER_INT);
        $models = $this->c_model->getAllData('vehicle_model', 'id,model_name', ['category_id' => $category_id]);
        $html = '<option value="">--Select Vehicle Model--</option>';
        if (!empty($models)) {
            foreach ($models as $key => $value) {
                $selected = ($value['id'] == $model_id) ? "selected" : "";
                $html.= '<option ' . $selected . ' value="' . $value['id'] . '">' . $value['model_name'] . '</option>';
            }
        }
        echo $html;
    }
    public function getPacksFromAjax() {
        $city_id = $this->request->getVar("city_id") ??"";
        $state_ids = $this->request->getVar("state_id") ? explode(',', $this->request->getVar("state_id")) : [];
        $package_id = $this->request->getVar("package_id") ??"";
        $city_id = filter_var($city_id, FILTER_SANITIZE_NUMBER_INT);
        $package_id = filter_var($package_id, FILTER_SANITIZE_NUMBER_INT);
        $state_id = !empty($state_ids) ? $state_ids[0] : "";
        $where = [];
        $where['state_id'] = $state_id;
        if (!empty($city_id)) {
            $where['city_id'] = $city_id;
        }
        $packs = $this->c_model->getAllData('dt_airport', 'id, airport_name', $where);
        // echo $this->c_model->getLastQuery();exit;
        $html = '<option value="">--Select Airport--</option>';
        if (!empty($packs)) {
            foreach ($packs as $key => $value) {
                $selected = ($value['id'] == $package_id) ? "selected" : "";
                $html.= '<option ' . $selected . ' value="' . $value['id'] . '">' . $value['airport_name'] . '</option>';
            }
        }
        echo $html;
    }
    public function getAirpoartFromAjax() {
        $city_id = $this->request->getVar("city_id") ??"";
        $state_ids = $this->request->getVar("state_id") ? explode(',', $this->request->getVar("state_id")) : [];
        $package_id = $this->request->getVar("package_id") ??"";
        $city_id = filter_var($city_id, FILTER_SANITIZE_NUMBER_INT);
        $package_id = filter_var($package_id, FILTER_SANITIZE_NUMBER_INT);
        $state_id = !empty($state_ids) ? $state_ids[0] : "";
        $where = [];
        $where['state_id'] = $state_id;
        if (!empty($city_id)) {
            $where['city_id'] = $city_id;
        }
        $packs = $this->c_model->getAllData('hourly_package', 'id, package_name', $where);
        // echo $this->c_model->getLastQuery();exit;
        $html = '<option value="">--Select Package--</option>';
        if (!empty($packs)) {
            foreach ($packs as $key => $value) {
                $selected = ($value['id'] == $package_id) ? "selected" : "";
                $html.= '<option ' . $selected . ' value="' . $value['id'] . '">' . $value['package_name'] . '</option>';
            }
        }
        echo $html;
    }
    public function fetchHoursKm() {
        $package_id = $this->request->getVar("package_id") ??"";
        $package_id = filter_var($package_id, FILTER_SANITIZE_NUMBER_INT);
        $pack = $this->c_model->getSingle('hourly_package', 'covered_hours,covered_km', ['id' => $package_id]);
        $response = [];
        $response['hours'] = !empty($pack['covered_hours']) ? (int)$pack['covered_hours'] : "";
        $response['km'] = !empty($pack['covered_km']) ? (int)$pack['covered_km'] : "";
        echo json_encode($response);
    }
    public function assign_menus() {
        $response = [];
        if ($this->request->getMethod() != "post") {
            $response['status'] = false;
            $response['message'] = 'Invalid Request ';
            echo json_encode($response);
            exit;
        }
        $post = $this->request->getVar();
        $id = $post['user'] ? $post['user'] : '';
        if (empty($post['user'])) {
            $response['status'] = false;
            $response['message'] = "Please Choose A User";
            echo json_encode($response);
            exit;
        }
        $data = [];
        $data = ['read_menu_ids' => !empty($post['read']) ? implode(",", $post['read']) : '', 'write_menu_ids' => !empty($post['write']) ? implode(",", $post['write']) : ''];
        $this->c_model->updateRecords("role_users", $data, ['id' => $id]);
    }
    public function assignmenu() {
        $response = [];
        if ($this->request->getMethod() != "post") {
            $response['status'] = false;
            $response['message'] = 'Invalid Request ';
            echo json_encode($response);
            exit;
        }
        $post = $this->request->getVar();
        $id = $post['user'] ? $post['user'] : '';
        if (empty($post['user'])) {
            $response['status'] = false;
            $response['message'] = "Please Choose A User";
            echo json_encode($response);
            exit;
        }
        if ($post['type'] == "read") {
            $data = ['read_menu_ids' => !empty($post['read']) ? implode(",", $post['read']) : ''];
        }
        if ($post['type'] == "write") {
            $data = ['write_menu_ids' => !empty($post['write']) ? implode(",", $post['write']) : ''];
        }
        $this->c_model->updateRecords("role_users", $data, ['id' => $id]);
    }
    public function exportFile() {
        $stateid = $this->request->getVar("stateid") ? explode(',', $this->request->getVar("stateid")) : [];
        $cityid = $this->request->getVar("cityid") ? explode(',', $this->request->getVar("cityid")) : "";
        $triptype = $this->request->getVar("triptype") ??"";
        $package = $this->request->getVar("package") ??"";
        $models = $this->c_model->getAllData('vehicle_model', 'model_name,id', ['status' => 'Active']);
        if (!empty($cityid)) {
            $where['pickup_city_id'] = $cityid;
        }
        $headerLabels = ['model_name', 'model_id', 'base_fare', 'base_covered_km', 'per_km_charge', 'night_charge', 'driver_charge', 'covered_hours', 'per_minute_charge', 'package_id'];
        $csvData = [];
        $exportLabels = ['state_id', 'city_id', 'trip_type', 'package_id'];
        $exportValues = [$stateid[0]??'', $cityid[0]??'', $triptype, $package];
        // Append CSV header row
        $csvData[] = $exportLabels;
        $csvData[] = $exportValues;
        $csvData[] = $headerLabels;
        foreach ($models as $key => $value) {
            $csvData[] = $value;
        }
        $file = fopen('php://output', 'w');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=' . date('Y-m-d') . '.csv');
        foreach ($csvData as $data) {
            fputcsv($file, $data);
        }
        fclose($file);
        exit();
    }
    public function importFile() {
        if (!$this->request->getFile('csv_file')) {
            echo 'Please upload a file';
            return;
        }
        $file = $this->request->getFile('csv_file');
        if ($file->isValid() && !$file->hasMoved() && $file->getClientMimeType() === 'text/csv') {
            $csvFilePath = $file->getTempName();
            $csvData = [];
            if (($handle = fopen($csvFilePath, 'r')) !== false) {
                while (($row = fgetcsv($handle)) !== false) {
                    array_push($csvData, $row);
                }
                fclose($handle);
                $getFirstSectionList = [];
                $getSecondSectionList = [];
                $getVehicleModelIdList = [];
                $getFareHeadersList = [];
                $getWhere = [];
                $where = [];
                $getWherevalues = [];
                $whereValues = [];
                $getFareHeaders = [];
                $saveData = [];
                $i = 0;
                //extract data from csv file
                foreach ($csvData as $row) {
                    if ($i < 2) {
                        $getFirstSectionList[] = $row;
                    } else if ($i == 2) {
                        unset($row[0]);
                        unset($row[1]);
                        $getFareHeadersList[] = $row;
                    } else {
                        $getSecondSectionList[] = $row;
                    }
                    $i++;
                }
                for ($a = 0;$a < count($getFirstSectionList[0]);$a++) {
                    $getWhere = $getFirstSectionList[0][$a];
                    array_push($where, $getWhere);
                    if ($a == 3) {
                        break;
                    }
                }
                for ($b = 0;$b < count($getFirstSectionList[1]);$b++) {
                    $getWherevalues = $getFirstSectionList[1][$b];
                    array_push($whereValues, $getWherevalues);
                    if ($b == 3) {
                        break;
                    }
                }
                //combine first section
                $result = array_combine($where, $whereValues);
                foreach ($getSecondSectionList as $vehicleRow) {
                    $getVehicleModelIdList[] = $vehicleRow[1]??'';
                    unset($vehicleRow[0]);
                    unset($vehicleRow[1]);
                    if ($result['trip_type'] != "Local") {
                        unset($vehicleRow[9]);
                    }
                    $getFareHeaders[] = $vehicleRow;
                }
                foreach ($getFareHeadersList as & $fareHeaders) {
                    if ($result['trip_type'] != "Local") {
                        unset($fareHeaders[9]);
                    }
                }
                $keys = implode(',', $fareHeaders) . ',id';
                $whereCondition = [];
                $whereCondition['pickup_state_id'] = $result['state_id'];
                $whereCondition['trip_type'] = $result['trip_type'];
                if (!empty($result['city_id'])) {
                    $whereCondition['pickup_city_id'] = $result['city_id'];
                }
                if ($result['trip_type'] == "Local") {
                    if ($result['package_id'] == "") {
                        echo "Package Id Is Blank";
                        exit;
                    } else {
                        $whereCondition['package_id'] = $result['package_id'];
                    }
                }
                $k = 0;
                foreach ($getFareHeaders as $fareRow) {
                    $saveData = [];
                    $saveData = array_combine($getFareHeadersList[0], $fareRow);
                    $saveData['pickup_state_id'] = $result['state_id'];
                    $saveData['trip_type'] = $result['trip_type'];
                    $saveData['pickup_city_id'] = !empty($result['city_id']) ? $result['city_id'] : 0;
                    $saveData['package_id'] = $result['package_id'];
                    $saveData['status'] = 'Active';
                    if (!empty($result['city_id'])) {
                        $saveData['pickup_city_name'] = getCityStateName($result['city_id']);
                    }
                    foreach ($getVehicleModelIdList as $key => $value) {
                        if ($k == $key) {
                            $whereCondition['model_id'] = $value;
                            $saveData['model_id'] = $value;
                            $saveData['category_id'] = getVehicleCategoryId($value);
                            $checkFareData = $this->c_model->getSingle("fare_configuration", 'id', $whereCondition);
                            if (!empty($checkFareData['id'])) {
                                $saveData['update_date'] = date('Y-m-d H:i:s');
                                $this->c_model->updateRecords("fare_configuration", $saveData, ['id' => $checkFareData['id']]);
                            } else {
                                $saveData['add_date'] = date('Y-m-d H:i:s');
                                $this->c_model->insertRecords("fare_configuration", $saveData);
                            }
                        }
                    }
                    $k++;
                }
                //exit;
                $this->session->setFlashdata('success', 'Data Imported Successfully');
                return redirect()->to(base_url(ADMINPATH . 'import-export-fare'));
            } else {
                echo 'Error reading the CSV file';
                exit;
            }
        } else {
            echo 'Please upload a valid CSV file';
            exit;
        }
    }
    public function getAjaxSubmenu() {
        $menuId = !empty($this->request->getVar('menu_id')) ? $this->request->getVar('menu_id') : '';
        $submenus = $this->c_model->getAllData('menus', 'id, menu_name', ['status' => 'Active', 'menu_id' => $menuId, 'type' => 'Submenu']);
        $html = '';
        if (!empty($submenus)) {
            $html.= '<div class="d-flex flex-row gap-3">';
            foreach ($submenus as $smkey => $smvalue) {
                $html.= '<div>
                    <input type="checkbox" name="submenu[]" id="sub_menu' . $smvalue['id'] . '" onchange="getAccessName(' . $smvalue['id'] . ',' . $menuId . ',this.value)" class="sub_menu commonclass" value="' . $smvalue['id'] . '">
                    <label>' . $smvalue['menu_name'] . '</label>
                    <div class="row mb-3" id="submodes' . $smvalue['id'] . '">
                        <div class="col-lg-5">
                            <div class="d-flex gap-2">
                                <input type="checkbox"  onchange="checkSubmenu(' . $smvalue['id'] . ',this.value)" class="submenu commonclass" id="edit' . $smvalue['id'] . '" name="edit" value="edit">
                                <label for="edit' . $smvalue['id'] . '" class="col-form-label" value="Edit">Edit</label>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="d-flex gap-2">
                                <input type="checkbox" onchange="checkSubmenu(' . $smvalue['id'] . ',this.value)" class="submenu commonclass"  id="view' . $smvalue['id'] . '" name="view" value="view">
                                <label for="view' . $smvalue['id'] . '" class="col-form-label" value="View">View</label>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            $html.= '</div>';
        } else {
            $html = '<div class="row" id="menumodes' . $menuId . '">
                <div class="col-lg-2">
                    <div class="d-flex gap-2">
                        <input type="checkbox" onchange="checkMenu(' . $menuId . ',this.value)" class="menu commonclass" id="edit' . $menuId . '" name="edit" value="edit">
                        <label for="edit' . $menuId . '" class="col-form-label" value="Edit">Edit</label>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="d-flex gap-2">
                        <input type="checkbox" onchange="checkMenu(' . $menuId . ',this.value)" class="menu commonclass" id="view' . $menuId . '" name="view" value="view">
                        <label for="view' . $menuId . '" class="col-form-label" value="View">View</label>
                    </div>
                </div>
            </div>';
        }
        echo $html;
    }
    public function deleteAllPage() {
        $table = 'dt_all_cms_data';
        $parent_id = !empty($this->request->getPost('parent_id')) ? $this->request->getPost('parent_id') : '';
        $this->c_model->deleteRecords($table, ['id' => $parent_id]);
        $page_ids = $this->c_model->getAllData($table, 'id,banner_image_jpg,banner_image_webp', ['parent_id' => $parent_id, 'page_type' => 'seo']);
        if (!empty($page_ids)) {
            foreach ($page_ids as $pkey => $pvalue) {
                removeImage($pvalue['banner_image_jpg']);
                removeImage($pvalue['banner_image_webp']);
            }
        }
        $this->c_model->deleteRecords($table, ['parent_id' => $parent_id, 'page_type' => 'seo']);
    }
    public function finalClose() {
        $post = $this->request->getVar();
        $id = !empty($post['id']) ? $post['id'] : '';
        $table = !empty($post['table']) ? $post['table'] : '';
        $updated = $this->c_model->updateData($table, ['is_final_closed' => 'yes', 'update_date' => date('Y-m-d H:i:s') ], ['id' => $id]);
        if ($updated) {
            $response = ['status' => true, 'message' => 'Ticket Closed Successfully'];
            echo json_encode($response);
            exit;
        }
        $response = ['status' => false, 'message' => 'Something Went Wrong'];
        echo json_encode($response);
        exit;
    }
}
