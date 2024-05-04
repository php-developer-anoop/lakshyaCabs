<?php 

if (!function_exists("getBookingDetails")) {
    function getBookingDetails($booking_id) {
        $joinArray=[];
        
        $joinArray[0]['table'] = 'dt_customer_list';
        $joinArray[0]['join_on'] = 'dt_bookings.user_id =dt_customer_list.id';
        $joinArray[0]['join_type'] = 'INNER';
        
        $joinArray[1]['table'] = 'dt_vendor_list';
        $joinArray[1]['join_on'] = 'dt_bookings.partner_id =dt_vendor_list.id';
        $joinArray[1]['join_type'] = 'INNER';
        
        $joinArray[2]['table'] = 'dt_vehicle_model';
        $joinArray[2]['join_on'] = 'dt_bookings.model_id =dt_vehicle_model.id';
        $joinArray[2]['join_type'] = 'INNER';
        
        $joinArray[3]['table'] = 'dt_states';
        $joinArray[3]['join_on'] = 'dt_customer_list.state_id =dt_states.id';
        $joinArray[3]['join_type'] = 'INNER';
        
        $joinArray[4]['table'] = 'dt_cities';
        $joinArray[4]['join_on'] = 'dt_customer_list.city_id =dt_cities.id';
        $joinArray[4]['join_type'] = 'INNER';
        
        $booking_details = getSingle('bookings',
        'dt_bookings.*,DATE_FORMAT(dt_bookings.created_date,"%d/%m/%Y %r") as created_date,dt_customer_list.name as customer_name,dt_customer_list.mobile_no as customer_mobile_no,dt_customer_list.email as customer_email,dt_customer_list.state_id as customer_state_id,dt_customer_list.city_id as customer_city_id,dt_vendor_list.*,dt_vehicle_model.seat_segment,dt_states.state_name as customer_state_name,dt_cities.city_name as customer_city_name',['dt_bookings.id'=>$booking_id],null,null,null,$joinArray);
        //echo db()->getLastQuery();exit;
        if(!empty($booking_details)){
           
            echo '<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-2 arrowicon">
          <i class="fa-solid fa-arrow-left" data-bs-dismiss="modal" style="cursor:pointer;"></i>
        </div>
        <div class="col-md-8">
          <div class="button-middle">
            <h5 class="bg-green">Complete trip</h5>
            <h5 class="bg-yellow">Edit</h5>
            <h5 class="bg-red">Cancel</h5>
          </div>
        </div>
      </div>
      <div class="main-deatilsSec">
        <div class="cstumerdetil">
          <h5>Customer Details</h5>
          <div class="c-details">
            <span>Name</span>
            <p>'.$booking_details['customer_name'].'</p>
          </div>
          <div class="c-details d-none">
            <span>Customer ID</span>
            <p>10110101000</p>
          </div>
          <div class="c-details">
            <span>Phone number</span>
            <p>+91-'.$booking_details['customer_mobile_no'].'</p>
          </div>
          <div class="c-details">
            <span>Email ID</span>
            <p>'.$booking_details['customer_email'].'</p>
          </div>
          <div class="c-details">
            <span>State</span>
            <p>'.$booking_details['customer_state_name'].'</p>
          </div>
          <div class="c-details">
            <span>City</span>
            <p>'.$booking_details['customer_city_name'].'</p>
          </div>
        </div>
        <div class="booking-section row">
          <div class="col-md-7">
            <div class="bookingdetailsSec">
              <h3>Booking Details</h3>
              <h4>Booking Slip</h4>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="inner-details">
                  <span>Booking Number</span>
                  <p>'.$booking_details['booking_id'].'</p>
                </div>
                <div class="inner-details">
                  <span>Booking Date & Time</span>
                  <p>'.$booking_details['created_date'].'</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="inner-details">
                  <span>Booked By</span>
                  <p>'.$booking_details['customer_name'].'</p>
                </div>
                <div class="inner-details">
                  <span>Trip Mode</span>
                  <p>'.$booking_details['trip_mode'].'</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="inner-details">
                  <span>Booking Status</span>
                  <p class="text-green"> '.ucfirst($booking_details['booking_status']).'</p>
                </div>
                <div class="inner-details">
                  <span>Trip Type</span>
                  <p>'.$booking_details['trip_type'].'</p>
                </div>
              </div>
              <div class="col-md-3 d-none">
                <div class="inner-details">
                </div>
                <div class="inner-details">
                </div>
              </div>
              <div class="col-md-3">
                <div class="inner-details">
                  <span>Travel Day(s)</span>
                  <p class="text-green">'.(int)$booking_details['total_driver_days'].'</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="inner-details">
                  <span>Vehicle Category</span>
                  <p>'.$booking_details['category_name'].'</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="inner-details">
                  <span>Model</span>
                  <p>'.$booking_details['model_name'].'</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="inner-details">
                  <span>Seats Segment</span>
                  <p>'.$booking_details['seat_segment'].'</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="location-main">
              <div class="locationdetailsSec">
                <h4 class="d-none"> <i class="fa-solid fa-location-dot"></i> Delhi</h4>
                <hr  class="d-none" width="60px" color="white" height="2px">
                <h4  class="d-none"><i class="fa-solid fa-location-dot"></i> Lucknow</h4>
                <hr  class="d-none" width="60px" color="white" height="2px">
                <h4  class="d-none"><i class="fa-solid fa-location-dot"></i> Delhi</h4>
                <h4><i class="fa-solid fa-location-dot"></i>'.$booking_details['via_routes'].'</h4>
              </div>
              <div class="row mx-auto">
                <div class="col-md-6">
                  <div class="inner-details">
                    <span>Pickup City</span>
                    <p>'.$booking_details['pickup_city_name'].'</p>
                  </div>
                  <div class="inner-details">
                    <span>Drop City</span>
                    <p>'.$booking_details['drop_city_name'].'</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="inner-details">
                    <span>Pickup Address</span>
                    <p>'.$booking_details['pickup_address'].'</p>
                  </div>
                  <div class="inner-details">
                    <span>Drop Address</span>
                    <p>'.$booking_details['drop_address'].'</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="booking-section row extraclass">
        <div class="col-md-6 ">
          <div class="border-cls">
            <div class="bookingdetailsSec">
              <h3>Vendor Detail</h3>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="inner-details">
                  <span>Vendor Code</span>
                  <p>'.$booking_details['unique_id'].'</p>
                </div>
                <div class="inner-details">
                  <span>Phone Number</span>
                  <p>+91-'.$booking_details['partner_mobile_no'].'</p>
                </div>
              </div>
              <div class="col-md-5">
                <div class="inner-details d-none">
                  <span>Vendor Number</span>
                  <p>'.$booking_details['unique_id'].'</p>
                </div>
                <div class="inner-details">
                  <span>Email ID</span>
                  <p>'.$booking_details['email_id'].'</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="inner-details">
                  <span>Name</span>
                  <p>'.$booking_details['partner_name'].'</p>
                </div>
                <div class="inner-details">
                </div>
              </div>
            </div>
            <div class="bookingdetailsSec">
              <h3>Driver Details</h3>
              <h4>Duty Slip</h4>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="inner-details">
                  <span>Driver Name</span>
                  <p>'.$booking_details['driver_name'].'</p>
                </div>
                
              </div>
              <div class="col-md-4">
                <div class="inner-details">
                  <span>Vehicle Number</span>
                  <p>'.$booking_details['vehicle_no'].'</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="inner-details">
                  <span>Phone Number</span>
                  <p>+91-'.$booking_details['driver_mobile_no'].'</p>
                </div>
              </div>
              
            </div>
          </div>
        </div>
        <div class="col-md-6 ">
          <div class="border-cls">
            <div class="bookingdetailsSec">
              <h3>Fare Detail</h3>
            </div>
            <div class="fare-detailSec">
              <div class="fare-detailsinner">
                <p>Base Fare:</p>
                <p>₹ '.$booking_details['base_fare'].'</p>
              </div>
              <div class="fare-detailsinner">
                <p>KM Fare:</p>
                <p>₹ '.$booking_details['per_km_charge'].'</p>
              </div>
              <div class="fare-detailsinner d-none">
                <p>Extra KM Charge:</p>
                <p>₹ 1520.00</p>
              </div>
              <div class="fare-detailsinner">
                <p>Estimated Fare:</p>
                <p>₹ '.$booking_details['total_trip_amount'].'</p>
              </div>
              <div class="fare-detailsinner">
                <p>GST Amount ('.(int)$booking_details['gst_percentage'].'% @ '.(int)$booking_details['total_trip_amount'].'):</p>
                <p>₹ '.$booking_details['gst_amount_on_total_trip_amount'].'</p>
              </div>
              <div class="fare-detailsinner">
                <p>Pay mode:</p>
                <p>'.ucfirst($booking_details['payment_mode']).'</p>
              </div>
              <div class="fare-detailsinner d-none">
                <p>Start Trip On:</p>
                <p>₹ 0</p>
              </div>
              <div class="fare-detailsinner d-none">
                <p>Start Trip On:</p>
                <p>₹ 0</p>
              </div>
              <div class="fare-detailsinner d-none">
                <p>Toll Charges:</p>
                <p>₹ 0</p>
              </div>
              <div class="fare-detailsinner d-none">
                <p>State Entry Tax Charge:</p>
                <p>₹ 0</p>
              </div>
              <div class="fare-detailsinner d-none">
                <p>Parking Charge:</p>
                <p>₹ 0</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="payment-main">
        <div class="payment-historySecouter">
          <div class="payment-historyinner extrasec">
            <h3>Payment History</h3>
            <h4>Add</h4>
          </div>
          <div class="payment-historyinner">
            <span>Date</span>
            <p>'.date('d/m/Y', strtotime($booking_details['pickup_date_time'])).'</p>
          </div>
          <div class="payment-historyinner">
            <span>Travel Time</span>
            <p>'.date('h:i a', strtotime($booking_details['pickup_date_time'])).'</p>
          </div>
          <div class="payment-historyinner">
            <span>Amount</span>
            <p>'.$booking_details['final_amount'].'</p>
          </div>
          <div class="payment-historyinner">
            <span>Receipt</span>
            <p><a href="javascript:void(0)" ><i class="fa-solid fa-download text-green"></i></a></p>
          </div>
        </div>
      </div>
    </div> 
  </div> 
</div>';
        }
    }
}