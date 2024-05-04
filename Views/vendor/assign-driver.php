<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="d-flex flex-row justify-content-between ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="javascript:void(0);">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="javascript:void(0);"><?=$menu?></a>
        </li>
        <li class="breadcrumb-item active"><?=$title?></li>
      </ol>
    </nav>
    <div class="row">
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-body">
            <div class="dflexbtwn hdngvwall">
              <h4 class="cardhdng">Assign Driver</h4>
            </div>
            <div class="form-bkdtls">
              <div class="drivrform">
                <div class="row mb-3 mw75">
                  
                 <input type="hidden" id="booking_id" value="<?=!empty($booking_details['id'])?$booking_details['id']:''?>"/>
                   <div class="col-sm-6 mb-3">
                    <label class="col-form-label" for="driver_name">Driver Name</label>
                    <input type="text" name="driver_name" autocomplete="off" value="<?=!empty($booking_details['driver_name'])?$booking_details['driver_name']:''?>"   class="form-control ucwords restrictedInput" required id="driver_name" placeholder="Driver Name" />
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label class="col-form-label" for="driver_mobile_no">Driver Mobile</label>
                    <input type="text" name="driver_mobile_no" autocomplete="off" value="<?=!empty($booking_details['driver_mobile_no'])?$booking_details['driver_mobile_no']:''?>"  class="form-control numbersWithZeroOnlyInput" maxlength="10" required id="driver_mobile_no" placeholder="Driver Mobile" />
                  </div>
                  <div class="col-sm-6 mb-3">
                    <label class="col-form-label" for="vehicle_no">Vehicle No.</label>
                    <input type="text" name="vehicle_no" autocomplete="off" value="<?=!empty($booking_details['vehicle_no'])?$booking_details['vehicle_no']:''?>" class="form-control alphanum uppercase" maxlength="12" required id="vehicle_no" placeholder="Vehicle No." />
                  </div>
                  
                  <div class="col-sm-10">
                    <button type="submit" id="submit" class="btn btn-primary" onclick="return assignDriver()">Submit</button>
                  </div>
                </div>
              </div>
              <div class="bkngdtls">
                <h4>Booking Details</h4>
                <div class="bkngtxts">
                  <div class="dflexbtwn bordrbtm">
                    <h6>Booking Number:</h6>
                    <h3><?=!empty($booking_details['booking_id'])?$booking_details['booking_id']:''?></h3>
                  </div>
                  <div class="dflexbtwn">
                    <h4>Customer Name:</h4>
                    <h5><?=!empty($booking_details['guest_name'])?$booking_details['guest_name']:''?></h5>
                  </div>
                  <div class="dflexbtwn">
                    <h4>Customer Number:</h4>
                    <h5><?=!empty($booking_details['guest_mobile_no'])?$booking_details['guest_mobile_no']:''?></h5>
                  </div>
                  <div class="dflexbtwn">
                    <h4>Trip Type:</h4>
                    <h5><?=!empty($booking_details['trip_type'])?$booking_details['trip_type']:''?></h5>
                  </div>
                  <div class="dflexbtwn">
                    <h4>Pickup date & time:</h4>
                    <h5><?=!empty($booking_details['formatted_pickup_date_time'])?$booking_details['formatted_pickup_date_time']:''?></h5>
                  </div>
                  <div class="dflexbtwn">
                    <h4>Pickup Address:</h4>
                    <h5><?=!empty($booking_details['pickup_city_name'])?$booking_details['pickup_city_name']:''?></h5>
                  </div>
                  <div class="dflexbtwn">
                    <h4>Drop off/Package:</h4>
                    <h5><?=!empty($booking_details['trip_type']=="Local")?$booking_details['package_name']:$booking_details['drop_city_name']?></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    function assignDriver(){
        var driver_name = $('#driver_name').val().trim();
        var driver_mobile_no = $('#driver_mobile_no').val().trim();
        var vehicle_no = $('#vehicle_no').val().trim();
        var booking_id = $('#booking_id').val().trim();
        
        if(driver_name == ""){
            toastr.error("Enter Driver Name");
            return false;
        }
        if(driver_mobile_no == ""){
            toastr.error("Enter Driver Mobile Number");
            return false;
        }
        if(vehicle_no == ""){
            toastr.error("Enter Vehicle Number");
            return false;
        }
        if(booking_id == ""){
            toastr.error("Booking Id Is Blank");
            return false;
        }
        $.ajax({
       type: 'POST',
       url: '<?=base_url(VENDORPATH.'assignDriver')?>',
       data: {
         driver_name: driver_name,
         driver_mobile_no: driver_mobile_no,
         vehicle_no: vehicle_no,
         booking_id: booking_id,
       },
       dataType: 'json',
       beforeSend : () =>{
           $('#submit').text('Please Wait ...').prop('disabled',true);
       } ,
       success: (res) => {
         if (res.status == true) {
            toastr.success(res.message);
            $('#submit').text('Submit').prop('disabled',false);
         } else {
           toastr.error(res.message);
           $('#submit').text('Submit').prop('disabled',false);
         }
       }
     });
        
    }
</script>