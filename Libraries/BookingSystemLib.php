<?php
namespace App\Libraries;
use App\Models\Common_model;

class BookingSystemLib
{    
    public $c_model;
    public function __construct()
    {
         $this->c_model = new Common_model();
    }
    
    
    public function searchCab( $postData ){
        
        $response = [];
         
        
        $trip_type = !empty($postData['trip_type']) ? ucfirst(strtolower( trim($postData['trip_type']) )) : '';
        $trip_mode = !empty($postData['trip_mode']) ? ucfirst(strtolower( trim($postData['trip_mode']) )) : '';
        $pickup_city = !empty($postData['pickup_city']) ? trim($postData['pickup_city']) : '';
        $drop_city = !empty($postData['drop_city']) ? trim($postData['drop_city']) : '';
        $route_list = !empty($postData['route_list']) ? $postData['route_list'] : '';
        $pickup_date_time  = !empty($postData['pickup_date_time']) ? trim($postData['pickup_date_time']) : '';
        $return_date_time  = !empty($postData['return_date_time']) ? trim($postData['return_date_time']) : '';
        $local_package  = !empty($postData['local_package']) ? trim($postData['local_package']) : '';
        $app_type  = !empty($postData['app_type']) ? trim($postData['app_type']) : '';
        
        //echo '<pre>';
        //print_r( $postData );
        
        if ( empty($trip_type) ) {
            $response['status'] = FALSE;
            $response['message'] = 'Trip Type is Blank';
            echo json_encode($response);
            exit;
        }else if ( !in_array($trip_type,['Local','Oneway','Outstation','Airport']) ) {
            $response['status'] = FALSE;
            $response['message'] = 'Invalid Trip Type';
            echo json_encode($response);
            exit;
        }else if (empty($pickup_city)) {
            $response['status'] = FALSE;
            $response['message'] = 'Pickup City is Blank!';
            echo json_encode($response);
            exit;
        }else if ( in_array($trip_type,['Oneway','Outstation','Airport']) && empty($drop_city)) {
            $response['status'] = FALSE;
            $response['message'] = 'Drop City is Blank!';
            echo json_encode($response);
            exit;
        }else if ( in_array($trip_type,['Local']) && empty($local_package)) {
            $response['status'] = FALSE;
            $response['message'] = 'Package ID is Blank!';
            echo json_encode($response);
            exit;
        }else if (empty($pickup_date_time)) {
            $response['status'] = FALSE;
            $response['message'] = 'Pickup Date & Time is Blank!';
            echo json_encode($response);
            exit;
        }else if ( in_array($trip_type,['Outstation']) && empty($return_date_time)) {
            $response['status'] = FALSE;
            $response['message'] = 'Return Date & Time is Blank!';
            echo json_encode($response);
            exit;
        }
        
        
        $pickupdate = date('Y-m-d',strtotime($pickup_date_time));
        $returndate = in_array($trip_type,['Outstation']) ? date('Y-m-d',strtotime($return_date_time)) : $pickupdate;
        
        /************* get all common booking conditions from table ************/
        $getBookingConditions = $this->c_model->getBulkRecords('dt_booking_conditions',['status'=>'Active'],'condition_type,from_value,to_value,apply_type,apply_value_type,apply_value' ,'get' );
        
        $PriorBookingCondition = 2;
        $SameDateBookingCondition = [];
        $FuturePickupDateBookingCondition = [];
        if(!empty($getBookingConditions)){
            foreach( $getBookingConditions as $key=> $value ){
                if( ($value['condition_type'] == '2hour_prior') && ((int)$value['to_value'] > 0) ){
                  $PriorBookingCondition = (int)$value['to_value']; 
                }else if( ($value['condition_type'] == '2h_to_24h') && ((int)$value['to_value'] > 0) ){
                  $SameDateBookingCondition = $value;  
                }else if( ($value['condition_type'] == 'next3days') && ((int)$value['to_value'] > 0) ){
                  $FuturePickupDateBookingCondition = $value;  
                }
            }
        }
        
        //print_r($FuturePickupDateBookingCondition);
        
        /*******check pickupdate & time Condition******/
        if( ($PriorBookingCondition > 0) && ($pickupdate == date('Y-m-d')) && ( strtotime( date('H:i:s').' +'.$PriorBookingCondition.' hours') > strtotime(date('H:i:s',strtotime($pickup_date_time))) ) ){
            $response['status'] = FALSE;
            $response['message'] = "Pickup time must be at least ".$PriorBookingCondition." hours from now.";
            echo json_encode($response);
            exit;
        }
        
        
         
        
        $pickUpNewCityId = '';
        $pickUpNewCityName = '';
        $pickUpNewStateId = '';
        $pickUpNewStateName = '';
        $dropNewCityId = '';
        $dropUpNewCityName = '';
        $dropUpNewStateId = '';
        $dropNewStateName = '';
        
        
        
        /*******  Get City Ids From Address List Start Script ***********/
        $cityWhere = null;
        $cityInKeyName = null;
        $cityInKeyValue = null;
        $cityInKeyType = null;
        if( is_numeric( $pickup_city ) || is_numeric( $drop_city ) ){
            $cityIds = is_numeric( $pickup_city ) ?  $pickup_city.',' : '';
            $cityIds .= is_numeric( $drop_city ) ?  $drop_city.',' : '';
            $cityIds = rtrim( ltrim($cityIds,','),',');
            $cityExplode = !empty($cityIds) ? explode(',',$cityIds) : [];
            if(!empty($cityExplode)){
                $cityExplode = array_unique( $cityExplode );
                $cityIds = implode( ',',$cityExplode );
                $cityInKeyName = 'a.id';
                $cityInKeyValue = $cityIds;
                $cityInKeyType = 'in';
            }
            
        }else{
            $inClauseQuery = "'".$pickup_city."'"; 
            $inClauseQuery .= $drop_city ? ",'".$drop_city."'" : '';  
            $cityWhere = [];
            $cityWhere[" a.address IN(".$inClauseQuery.")"] = NULL;
        }
        
        $joinArray = [];
        $joinArray[0]['table'] = 'dt_cities as b';
        $joinArray[0]['join_on'] = 'a.city_id = b.id AND a.state_id = b.state_id ';
        $joinArray[0]['join_type'] = 'left';
        
        $selectedKeys = 'a.*, b.state_name,b.city_name ';
        $getAllCityData = $this->c_model->getBulkRecords( 'dt_address_book as a',$cityWhere, $selectedKeys ,'get',null,null,null,null, $joinArray , $cityInKeyName, $cityInKeyValue, $cityInKeyType );
        //print_r($getAllCityData);
        if( !empty($getAllCityData) ){
            foreach($getAllCityData as $key=>$cValue ){
                if( ( is_numeric( $pickup_city ) && $pickup_city == $cValue['id']) || ($pickup_city == $cValue['address']) ){ 
                    $pickup_city = $cValue['address']; 
                    $pickUpNewCityId = $cValue['city_id'];
                    $pickUpNewCityName = $cValue['city_name'];
                    $pickUpNewStateId = $cValue['state_id'];
                    $pickUpNewStateName = $cValue['state_name'];
                    if( $cValue['city_id'] == 0  && $cValue['state_id'] == 0 ){
                        $getCityDataFromAddress = cityIdGoogleAddress($pickup_city,null,true);
                        if(!empty($getCityDataFromAddress)){
                            $pickUpNewCityId = $getCityDataFromAddress['id'];
                            $pickUpNewCityName = $getCityDataFromAddress['city_name'];
                            $pickUpNewStateId = $getCityDataFromAddress['state_id'];
                            $pickUpNewStateName = $getCityDataFromAddress['state_name'];
                            $this->c_model->updateData('dt_address_book',['city_id'=>$pickUpNewCityId,'state_id'=>$pickUpNewStateId],['id'=>$cValue['id']]);
                        }
                    }  
                }
                else if( ( is_numeric( $drop_city ) && $drop_city == $cValue['id']) || ($drop_city == $cValue['address']) ){
                    $drop_city = $cValue['address']; 
                    $dropNewCityId = $cValue['city_id'];
                    $dropNewCityName = $cValue['city_name'];
                    $dropNewStateId = $cValue['state_id'];
                    $dropNewStateName = $cValue['state_name'];
                    if( $cValue['city_id'] == 0  && $cValue['state_id'] == 0 ){
                        $getCityDataFromAddress = cityIdGoogleAddress($pickup_city,null,true);
                        if(!empty($getCityDataFromAddress)){
                            $dropNewCityId = $getCityDataFromAddress['id'];
                            $dropNewCityName = $getCityDataFromAddress['city_name'];
                            $dropNewStateId = $getCityDataFromAddress['state_id'];
                            $dropNewStateName = $getCityDataFromAddress['state_name'];
                            $this->c_model->updateData('dt_address_book',['city_id'=>$dropNewCityId,'state_id'=>$dropNewStateId],['id'=>$cValue['id']]);
                        } 
                    }
                }
            }
        } 
        
        /*******  Get City Ids From Address List End Script ***********/ 
         
         
        /*******  get package details  ***********/
        $hourly_package_id = ''; 
        
        if( $trip_type == 'Local' && !is_numeric($local_package) ) {
            $packWhere = [];
            $packWhere['state_id'] = $pickUpNewStateId; 
            $packWhere['status'] = 'Active'; 
            $packWhere["( id IN('".$local_package."') OR package_name IN('".$local_package."') )"] = NULL; 
            $packageData = $this->c_model->getSingle('dt_hourly_package','id,package_name', $packWhere );
            if(!empty($packageData)){
                $hourly_package_id = $packageData['id'];
            } 
        }else{
                $hourly_package_id = $local_package; 
        }
        
        
        /*calculate Days*/
        $days = $pickupdate && $returndate ? getDaysFromTwoDates($pickupdate,$returndate) : false;
        $days = ( $days && ($pickupdate != $returndate)) ? ($days) : 1;
        
        
        /******* Prepare Distance Calculation System  ***********/
        $travelKms = 0;
        $travelTimeText = '';
        $travelTimeMinutes = '';
        $wayPoints = '';
        if ( in_array($trip_type,['Oneway','Outstation','Airport']) && !empty($drop_city)) {
             
            if( !empty($route_list)){
                $wayPoints = $route_list;
                $calculateDistanceAPI = calculateViaDistance( $wayPoints, $trip_type ); 
            }else if( empty($route_list)){
                $wayPoints = $pickup_city.'|'. $drop_city;
                $calculateDistanceAPI = calculateDistance( $pickup_city, $drop_city, $trip_type ); 
            }
                 
            $travelKms = googleKms( $calculateDistanceAPI );
            $travelTimeMinutes = is_numeric(googleTime( $calculateDistanceAPI )) ? googleTime( $calculateDistanceAPI ) : hourToMin( googleTime( $calculateDistanceAPI ) );
            $travelTimeText = convertMinutesToDaysHoursMinutes( $travelTimeMinutes ); 
              
        }
        
        /******* Prepare Fare Calculation System  ***********/
        $fareWhere = [];
        $fareWhere['f.status'] = 'Active'; 
        $fareWhere['f.trip_type'] = $trip_type; 
        if( in_array($trip_type,['Airport'])){
             
             $pickWhere = !empty($pickUpNewCityId) ? " ((f.pickup_city_id = '".$pickUpNewCityId."' AND f.pickup_state_id = '".$pickUpNewStateId."' ) OR ( f.pickup_state_id = '".$pickUpNewStateId."'))" : '';
             $orCondition = !empty($pickUpNewCityId) && !empty($dropNewCityId) ? "OR" : '';
             $dropWhere = !empty($dropNewCityId) ? " ((f.pickup_city_id = '".$dropNewCityId."' AND f.pickup_state_id = '".$dropNewStateId."' ) OR ( f.pickup_state_id = '".$dropNewStateId."'))" : '';
             if( !empty($pickWhere) || !empty($dropWhere)){ $fareWhere["(  ".$pickWhere." ".$orCondition." ".$dropWhere." )"] = NULL; } 
        }else{
          $fareWhere["( (f.pickup_city_id = '".$pickUpNewCityId."' AND f.pickup_state_id = '".$pickUpNewStateId."' ) OR ( f.pickup_state_id = '".$pickUpNewStateId."') )"] = NULL;  
        }
         
        if( in_array($trip_type,['Oneway']) && (!empty($dropNewCityId) || !empty($dropNewStateId) )){ 
            $fareWhere["( (f.drop_city_id = '".$dropNewCityId."' AND f.drop_state_id = '".$dropNewStateId."' ) OR ( f.drop_state_id = '".$dropNewStateId."') )"] = NULL;  
        }
        else if( in_array($trip_type,['Local'])){
            $fareWhere['f.package_id'] = $hourly_package_id; 
        }
        
        
        $fareTable = 'dt_fare_configuration as f';
        $joinFareArray = [];
        $joinFareArray[0]['table'] = 'dt_vehicle_model as md';
        $joinFareArray[0]['join_on'] = 'f.model_id = md.id';
        $joinFareArray[0]['join_type'] = 'left';
        
        //set page limit for default SEO Page search
        $start = null;
        $limit = null;
        $orderBy = null;
        $orderByKeys = null;
        if($app_type == 'web' && in_array($trip_type,['Oneway','Oustation']) ){
             $limit = 10;
             $start = 0;
             $orderBy = 'ASC';
             $orderByKeys = 'f.base_fare, f.per_km_charge';
             $fareWhere["f.drop_city_id !="] =  '';
        }
        
        $selectFareKeys = 'f.*, md.category_id,md.category_name,md.model_name,md.seat_segment,md.fuel_type, md.luggage, md.ac_or_non_ac,md.water_bottle,md.carrier,md.jpg_image,md.webp_image,md.image_alt, md.total_ratings,md.star_rating ';
        $getAllFareData = $this->c_model->getBulkRecords( $fareTable, $fareWhere, $selectFareKeys ,'get',$orderBy,$orderByKeys,$start,$limit, $joinFareArray  );
        
        //echo $this->c_model->getLastQuery(); exit;
        
        if(empty($getAllFareData)){
            $response['status'] = false;
            $response['message'] = 'No record found in our database';
            echo json_encode( $response ); exit;
        } 
        
        //get Calender Conditions Records
        $condCalenderWhere = [];
        $condCalenderWhere['status'] = 'Active'; 
        $condCalenderWhere['trip_type'] = $trip_type; 
        $condCalenderWhere['state_id'] = $pickUpNewStateId; 
        $condCalenderWhere['from_date <='] = date('Y-m-d',strtotime($pickup_date_time)); 
        $condCalenderWhere['to_date >='] = date('Y-m-d',strtotime($pickup_date_time)); 
        $getCalenderConditions = $this->c_model->getSingle('dt_calender_booking_conditions','charge_type,charge_value_type,charge_value', $condCalenderWhere );
         
        //echo $this->c_model->getLastQuery();
        
        $collectFare = [];
        /*********** Populate fare for collection  ************/
        foreach($getAllFareData as $key=>$value ){
            $push = [];
            $push['id']                 = (string) $value['id']; 
            $push['model_id']           = (string) $value['model_id'];
            $push['category_id']        = (string) $value['category_id'];
            $push['base_fare']          = (string) $value['base_fare'];
            $push['per_km_charge']      = (string) $value['per_km_charge'];
            
            
            //**********Apply seasonal calender conditions*************//
            if(!empty($getCalenderConditions)){
                if( in_array($trip_type,['Local','Oneway','Airport']) ){ 
                    $push['base_fare'] = (string) applyCalenderValue($push['base_fare'], $getCalenderConditions['charge_type'], $getCalenderConditions['charge_value_type'], $getCalenderConditions['charge_value'] ); 
                }
                else if( in_array($trip_type,['Outstation']) ){
                    $push['per_km_charge'] = (string) applyCalenderValue($push['per_km_charge'], $getCalenderConditions['charge_type'], $getCalenderConditions['charge_value_type'], $getCalenderConditions['charge_value'] ); 
                }
            }
            
            //***********Apply Same Date Booking Condition***************// 
            if( !empty($SameDateBookingCondition) && ($pickupdate == date('Y-m-d')) ){
                 if( in_array($trip_type,['Local','Oneway','Airport']) ){ 
                    $push['base_fare'] = (string) applySameDateCondition($push['base_fare'], $SameDateBookingCondition['apply_type'], $SameDateBookingCondition['apply_value_type'], $SameDateBookingCondition['apply_value'] ); 
                }
                else if( in_array($trip_type,['Outstation']) ){
                    $push['per_km_charge'] = (string) applySameDateCondition($push['per_km_charge'], $SameDateBookingCondition['apply_type'], $SameDateBookingCondition['apply_value_type'], $SameDateBookingCondition['apply_value'] ); 
                }
            }
            
            //***********Apply Next 3 Days Booking Condition***************// 
            if( !empty($FuturePickupDateBookingCondition) && ( strtotime($pickupdate) > strtotime( date('Y-m-d',strtotime( date('Y-m-d').' + '.$FuturePickupDateBookingCondition['from_value'].' days' )))  ) ){
                 if( in_array($trip_type,['Local','Oneway','Airport']) ){ 
                    $push['base_fare'] = (string) applySameDateCondition($push['base_fare'], $FuturePickupDateBookingCondition['apply_type'], $FuturePickupDateBookingCondition['apply_value_type'], $FuturePickupDateBookingCondition['apply_value'] ); 
                }
                else if( in_array($trip_type,['Outstation']) ){
                    $push['per_km_charge'] = (string) applySameDateCondition($push['per_km_charge'], $FuturePickupDateBookingCondition['apply_type'], $FuturePickupDateBookingCondition['apply_value_type'], $FuturePickupDateBookingCondition['apply_value'] ); 
                }
            }
            
            
            $push['base_covered_km']    = (string) $value['base_covered_km']; 
            $push['covered_hours']      = (string) $value['covered_hours']; 
            $push['per_minute_charge']  = (string) $value['per_minute_charge']; 
            $push['per_hour_charge']    = (string) $value['per_hour_charge']; 
             
            $push['night_charge']       = (string) $value['night_charge']; 
            $push['driver_charge']      = (string) $value['driver_charge']; 
            $push['trip_type']          = (string) $value['trip_type']; 
            $push['pickup_state_id']    = (string) $value['pickup_state_id']; 
            $push['pickup_city_id']     = (string) $value['pickup_city_id']; 
            $push['pickup_city_name']   = (string) $value['pickup_city_name']; 
            $push['drop_state_id']    = (string) ($value['drop_state_id'] != 0 ? $value['drop_state_id'] : ''); 
            $push['drop_city_id']     = (string) ($value['drop_city_id'] != 0 ? $value['drop_city_id'] : ''); 
            $push['drop_city_name']   = (string) ($value['drop_city_name'] != 0 ? $value['drop_city_name'] : '');
            
            $push['night_charge_from']  = (string) $value['night_charge_from']; 
            $push['night_charge_till']  = (string) $value['night_charge_till']; 
            $push['toll_charge']        = (string) $value['toll_charge']; 
            $push['parking_charge']     = (string) $value['parking_charge']; 
            $push['airport_parking']    = (string) $value['airport_parking']; 
            $push['state_entry_charge'] = (string) $value['state_entry_charge']; 
            $push['category_name']      = (string) $value['category_name']; 
            $push['model_name']         = (string) $value['model_name']; 
            $push['seat_segment']       = (string) $value['seat_segment']; 
            $push['fuel_type']          = (string) $value['fuel_type']; 
            $push['luggage']            = (string) $value['luggage']; 
            $push['ac_or_non_ac']       = (string) $value['ac_or_non_ac']; 
            $push['water_bottle']       = (string) $value['water_bottle']; 
            $push['carrier']            = (string) $value['carrier'];
            $push['star_rating']        = (string) $value['star_rating'];
            $push['total_ratings']      = (string) $value['total_ratings'];
            $push['jpg_image']          = (string) (!empty($value['jpg_image']) ? UPLOADS_PATH.$value['jpg_image'] : ''); 
            $push['webp_image']         = (string) (!empty($value['webp_image']) ? UPLOADS_PATH.$value['webp_image'] : ''); 
            $push['image_alt']          = (string) $value['image_alt'];
            $push['travels_days']       = (string) $days;
            $push['travels_time_minutes']  = (string) $travelTimeMinutes;
            $push['travels_time_text']  = (string) $travelTimeText;
            $push['pickup_date_time']  = (string) date('d M, h:i A',strtotime($pickupdate));
            
            /*fare calculation */
            $push['estimated_kms'] = (string) $value['base_covered_km'];
            $push['total_trip_amount'] = (string) 0;
            $push['gst_percentage'] = (string) GST_PERCENTAGE;
            $push['gst_amount_on_total_trip_amount'] = (string) 0;
            $push['total_trip_amount_with_gst'] = (string) 0; 
            $push['waypoints']       = (string) $wayPoints;
            $push['inclusions']      = $this->getInclusions( $value['toll_charge'],$value['state_entry_charge'],$value['airport_parking'], $value['parking_charge'] );
            $push['exclusions']      = $this->getExclusions( $value['toll_charge'],$value['state_entry_charge'],$value['airport_parking'], $value['parking_charge'] );
            
            
            
            if( $trip_type == 'Outstation' ){
                    $daysKms = (int)$value['base_covered_km'] * (int)$days;
                    
                    if( (int)$push['estimated_kms'] < (int)$daysKms ){
                        $push['estimated_kms'] = (string) $daysKms;
                    }
                    if( (int)$push['estimated_kms'] < (int)$travelKms ){
                        $push['estimated_kms'] =  (string) $travelKms;
                    } 
     
                    $push['total_trip_amount'] = (string) ( (float)$push['estimated_kms'] * (float)$push['per_km_charge']);
            }
            else if( empty($app_type) && in_array($trip_type,['Airport']) && (float)$value['base_covered_km'] < (float)$travelKms ){ 
                 
                    $extraKm = ((float)$travelKms - (float)$value['base_covered_km']) * (float)$push['per_km_charge']; 
                    $push['total_trip_amount'] = (string) ((float)$extraKm + (float)$push['base_fare']);
            }else{
                    $push['total_trip_amount'] = (string) $push['base_fare'];
            }
             
            
            $push['gst_amount_on_total_trip_amount'] = (string) twoDecimal( percentValue( $push['total_trip_amount'] , GST_PERCENTAGE ));
            $push['total_trip_amount_with_gst'] = (string) twoDecimal(((float)$push['total_trip_amount'] + (float)$push['gst_amount_on_total_trip_amount'])); 
            $push['original_price'] = (string) twoDecimal( withPercentValue($push['total_trip_amount_with_gst'], INSTANT_DISCOUNT ));
            $push['advance_booking_amount'] = (string) twoDecimal( percentValue($push['total_trip_amount_with_gst'], 30 ));
            array_push( $collectFare, $push );
        }
        
        
         $response['status'] = true;
         $response['data'] = $collectFare;
         $response['payload'] = $postData;
         $response['message'] = 'API Accessed Successfully!';
         echo json_encode( $response ); exit; 
         
    }
    
    public function getInclusions( $toll,$stateentry,$airportParking, $parking ){
        $output = [];
        if( (int)$toll > 0 ){
        $output[] = 'Toll tax';
        }
        if( (int)$stateentry > 0 ){
        $output[] = 'State tax';
        }
        if( (int)$parking > 0 ){
        $output[] = 'Parking charge';
        }
        if( (int)$airportParking > 0 ){
        $output[] = 'Airport parking charge';
        } 
        
        $output[] = 'Driver, Vehicle and Fuel';
        $output[] = 'Driver Food & Stay Charge';
        
        return implode(', ', $output );
    }
    
    public function getExclusions( $toll,$stateentry,$airportParking, $parking ){
        $output = [];
        if( (int)$toll == 0 ){
        $output[] = 'Toll tax';
        }
        if( (int)$stateentry == 0 ){
        $output[] = 'State tax';
        }
        if( (int)$parking == 0 ){
        $output[] = 'Parking charge';
        }
        if( (int)$airportParking == 0 ){
        $output[] = 'Airport parking charge';
        } 
        
        return implode(', ', $output );
    }
    
    
} 
?>