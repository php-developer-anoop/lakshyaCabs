<div class="container-fluid">
	<div class="row">
	   <div class="booknghdr pl-60 pr-30">
	   	  <h3><?=$list['waypoints']?></h3>
	   	  <p><?=$list['trip_type']?> <?=$list['pickup_date_time']?>, <?=$list['travels_time_text']?></p>
	   </div>
	</div>
</div>

<style>
    #couponDivS{ display: none; }
    .btn-close {display: none; }
</style>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 order-1 order-md-0 pl-0 pr-0">
			<section class="cablist sec_padd pl-60 pr-30">
				<div class="cablist_box cabdtlsbox">
					<div class="cbimginfo_wrp d-flex align-items-center">
						<div class="cb_img">
							<img src="<?=getImagePathUrl($list['jpg_image'], $list['webp_image'] )?>"> 
						</div>
						<div class="cb_details">
							<h4><?=$list['model_name'];?> </h4>
							<p><?=$list['category_name'];?></p>
							<div class="facility">
							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f1.png'), base_url('assets/images/f1.webp') )?>"><?=$list['seat_segment']?> Seater</span>
    							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f2.png'), base_url('assets/images/f2.webp') )?>"><?=$list['fuel_type']?></span>
    							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f1.png'), base_url('assets/images/f3.webp') )?>"><?=$list['luggage'];?> Luggage</span>
    							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f4.png'), base_url('assets/images/f4.webp') )?>"><?=$list['ac_or_non_ac'];?> Cabs</span>
    							<?php if($list['water_bottle']=='yes'){?>
    							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f5.png'), base_url('assets/images/f5.webp') )?>"><?=$list['water_bottle'];?>Water Bottle</span>
    							<?php }?>
    							<?php if($list['carrier']=='yes'){?>
    							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f6.png'), base_url('assets/images/f6.webp') )?>">Carrier</span>
    							<?php }?>
    							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f7.png'), base_url('assets/images/f7.webp') )?>">Professional Driver</span>
							</div>
						</div>
						<div class="dtlbx_pinfo hdngwrpr_grn "><h4><?=$list['estimated_kms']?> KMs fares included. Extra fare ₹ <?=$list['per_km_charge']?> per KM after <?=$list['estimated_kms']?> KMs</h4></div>
					</div>
					<div class="cab_pricebox">
					    <span class="discnt">Flat <?=INSTANT_DISCOUNT?>% Off</span>
						<p><span class="cutprice">₹<?=$list['original_price']?></span></p>
						<h2>₹<?=$list['total_trip_amount_with_gst']?> </h2>
					</div>
				</div>
				<div class="passenger-info">
					<h4>Driver & Cab details will be shared up to 1hr prior to departure.</h4>
					<div class="infoform">
						<h3>Trip Information</h3>
						<form>
							<div class="row">
								<div class="col-lg-6 mb-3">
  								    <label for="floatingInput">Name</label>
									<input type="text" class="form-control alphanum ucwords" id="full_name" value="<?=$name?>" placeholder="Enter Full Name" onkeyup="checkLoginUser()">
								</div>
								<div class="col-lg-6 mb-3">
									<label for="floatingInput">Email ID(Booking confirmation will be sent here)</label>
									<input type="text" class="form-control emailOnly" id="email_id" value="<?=$email?>"  placeholder="Enter email id" onkeyup="checkLoginUser()">
								</div>
								<div class="col-lg-6 mb-3">
									<label for="floatingInput">Enter Phone Number</label>
									<input type="text" class="form-control numbersOnly" id="phone_no" value="<?=$mobile_no?>" placeholder="Enter Phone Number"  onkeyup="checkLoginUser()">
								</div>
								<div class="col-lg-6 mb-3">  
								    <label>Number of Passengers</label>                         
									<select class="form-select" aria-label="Default select example" name="no_of_passenger" id="no_of_passenger"  onkeyup="checkLoginUser()">
										<?php for($i = 1; $i <= (int)$list['seat_segment']; $i++ ){?>
										<option value="<?=$i?>"><?=$i?></option>
										<?php }?> 
									</select>
								</div>
								<div class="col-lg-6 mb-3">
									<label for="floatingInput">Company Name</label>
									<input type="text" class="form-control address ucwords" value="<?=$company_name;?>" id="company_name" placeholder="Enter Company Name"  onkeyup="checkLoginUser()">
								</div>
								<div class="col-lg-6 mb-3">
									<label for="floatingInput">Enter GSTIN</label>
									<input type="text" class="form-control alphanum uppercase" id="gst_in" value="<?=$gstin_number;?>" placeholder="Enter GSTIN"  onkeyup="checkLoginUser()">
								</div> 
							</div>
							<div class="row">
								<div class="col-lg-6 mb-3">
									<label for="floatingInput">Pick Up Location</label>
									<input type="text" class="form-control address ucwords" id="pickup_address" value="<?=$pickup_address?>" placeholder="Pick Up Location"  onkeyup="checkLoginUser()">
								</div>
								<div class="col-lg-6 mb-3">
									<label for="floatingInput">Drop Location</label>
									<input type="text" class="form-control address ucwords" id="drop_address" placeholder="Drop Location" required onkeyup="checkLoginUser()">
								</div>
							</div>
						</form>
					</div>
				</div>
			</section>
		</div>
		<div class="col-md-4 pos-relative p-0">
			<div class="side_booking sidefare">
				<div class="farebox">
					<div class="tripbox">
						<h5>Overall fare summary</h5>
					</div>
					<form action="" method="post">
						<div class="pricesumbox">
							<div class="fare-pricecnt">
								<div class="fare-name"><h5>Taxi Cost</h5></div>
								<div class="fare-price"><h5> ₹<?=$list['total_trip_amount']?></h5></div>
							</div>
							<div class="fare-pricecnt">
								<div class="fare-name"><h5>GST Charge@<?=$list['gst_percentage']?>% </h5></div>
								<div class="fare-price"><h5>₹<?=$list['gst_amount_on_total_trip_amount']?></h5></div>
							</div>                    
							<div class="fare-pricecnt" id="">	                                                     
								<div class="fare-name"><h5>Payment Due </h5></div>
								<div class="fare-price"><h5> ₹<?=$list['total_trip_amount_with_gst']?></h5></div>
							</div>
							<div class="coupn_apply">
								<input type="text" id="couponfind" name="coupon" class="form-control" placeholder="Enter Coupon Code" onkeyup="enterCoupon(this.value)">
								<span id="btnapply" onclick="viewCouponList()"> Check Coupon </span> 
							</div>
							<div class="fare-pricecnt" id="couponDivS">	                                                     
								<div class="fare-name"><h5>Coupon Discount</h5></div>
								<div class="fare-price cpnprice"><h5 id="discountAmount" >- ₹ 0</h5></div>
							</div>
							<div class="fare-pricecnt">
								<h5 class="payable" id="fp">Total Payable Amount </h5>
								<span class="pr_item" id="subtotal"> ₹ <?=$list['total_trip_amount_with_gst']?> </span>
							</div>  
							<div class="hdngwrpr_grn tcgrn">
								<p>By clicking ‘Make Payment’, you are confirming that you have read, understood and accepted our <a href="<?=base_url('terms-and-conditions')?>" target="_blank">Terms & Conditions</a></p>
							</div>
							<?php if( $wallet_balance > 0 ){?>
							<div class="col-md-12 mb-3">
								<label class="wltlabel" for="myCheck"><input type="checkbox" value="yes" id="myWallet" onclick="checkWallet('')"> Use <span class="wltbalnc">₹ <?=$wallet_balance?></span> wallet balance</label>    
							</div>
							<?php }else{ ?>
							<input type="hidden" value="" name="" id="myWallet">
							<?php }?>
							<div class="paymenttype">
								<label>Select Payment Mode*</label>
								<select class="form-select" aria-label="Default select example" id="payment_mode" onchange="choosePaymentMode()">
								    <option value="advance">Part Payment</option>
									<option value="full">Full Payment</option> 
									<option value="cash">Pay To Driver</option> 
								</select>
							</div>
							<div class="col-sm-12 formbtn mt-3">
								<button type="button" class="form_btn" onClick="createBooking();" id="ctBtn">Proceed To Payment</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    
    <div class="row pl-60 pr-30">
    	<div class="cbdtl_tabs">
	    	<ul class="nav nav-tabs" id="myTab" role="tablist">
				  <li class="nav-item" role="presentation">
				    <button class="nav-link active" id="fare-tab" data-bs-toggle="tab" data-bs-target="#fare" type="button" role="tab" aria-controls="fare" aria-selected="true">Fare Breakup</button>
				  </li>
				  <li class="nav-item" role="presentation">
				    <button class="nav-link" id="inclusion-tab" data-bs-toggle="tab" data-bs-target="#inclusion" type="button" role="tab" aria-controls="inclusion" aria-selected="false">Inclusion</button>
				  </li>
				  <li class="nav-item" role="presentation">
				    <button class="nav-link" id="exclusion-tab" data-bs-toggle="tab" data-bs-target="#exclusion" type="button" role="tab" aria-controls="exclusion" aria-selected="false">Exclusion</button>
				  </li>
				  <li class="nav-item" role="presentation">
				    <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab" aria-controls="notes" aria-selected="false">Notes</button>
				  </li>
			</ul>
			<div class="tab-content" id="myTabContent">
				  <div class="tab-pane fade show active" id="fare" role="tabpanel" aria-labelledby="fare-tab">
				  	<div class="faretb_content">
				  	    <div class="fare-pricecnt">
							<div class="fare-name"><h5>Estimated Cost</h5></div>
							<div class="fare-price"><h5> ₹<?=$list['total_trip_amount']?></h5></div>
						</div>
						<div class="fare-pricecnt">
							<div class="fare-name"><h5>Covered Kms </h5></div>
							<div class="fare-price"><h5><?=$list['estimated_kms']?> Km(s)</h5></div>
						</div>                    
						<div class="fare-pricecnt" id="">	                                                     
							<div class="fare-name"><h5>Driver Night Charge </h5></div>
							<div class="fare-price"><h5> ₹<?=$list['night_charge']?></h5></div>
					    </div>
					    <div class="fare-pricecnt">
							<div class="fare-name"><h5>GST Charge@<?=$list['gst_percentage']?>% </h5></div>
							<div class="fare-price"><h5>₹<?=$list['gst_amount_on_total_trip_amount']?></h5></div>
						</div>                    
						<div class="fare-pricecnt" id="">	                                                     
							<div class="fare-name"><h5>Total Cost </h5></div>
							<div class="fare-price"><h5> ₹<?=$list['total_trip_amount_with_gst']?></h5></div>
					    </div>
					</div>
				 </div>
				 <div class="tab-pane fade" id="inclusion" role="tabpanel" aria-labelledby="inclusion-tab">
				  	 <div class="tabcontnt"> 
                            <div class="row fare-area">
                            <div class="col-lg-12">
                            <h4 class="notesclas"><img src="<?=getImagePathUrl( base_url('assets/images/check.png'), base_url('assets/images/check.webp') )?>">Inclusion :</h4>
                                <ul>
                                <li>
                                Driver, Vehicle and Fuel
                                </li>
                                <li>
                                Driver Food &amp; Stay charge
                                </li>
                                </ul>
                            </div>
                            </div>
				  	 </div>
				 </div>
				 <div class="tab-pane fade" id="exclusion" role="tabpanel" aria-labelledby="exclusion-tab">
				  	 <div class="tabcontnt">
				  	        <div class="row fare-area">
                            <div class="col-lg-12">
                            <h4 class="notesclas"><img src="<?=getImagePathUrl( base_url('assets/images/check.png'), base_url('assets/images/check.webp') )?>">Exclusion :</h4>
                                <ul>
                                <li>
                                Parking Charge, Airport Parking Charge
                                </li>
                                <li>
                                Toll Tax, State Tax Charge
                                </li>
                                </ul>
                            </div>
                            </div>
				  	 </div>
				 </div>
				 <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
				  	 <div class="tabcontnt">
                        <div class="row fare-area">
                        <div class="col-lg-12">
                        <h4 class="notesclas"><img src="<?=getImagePathUrl( base_url('assets/images/check.png'), base_url('assets/images/check.webp') )?>">Notes :</h4>
                            <ul>
                            <li>
                            Kms &amp; Timing will be charged from customer location
                            </li>
                            <li>
                            Car shall not be used for local use in (City) after completion of one way duty.
                            </li>
                            <li>
                            In case of Booking wil be Cancelled then infrom to us before 24 Hrs in then Pickup Time
                            </li>
                            <li>
                            Toll Tax, Inter State Tax Are Excluded
                            </li>
                            </ul>
                        </div>
                        </div>
				  	 </div>
				 </div>
			</div>
		</div> 
    </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="norml_hdng">
          <h2>Coupons </h2>
          <p class="sub_hdng">Choose a coupon to get the best discount</p>
        </div>
        <div class="row coupns">
            <?php if(!empty($coupon_list)){
            foreach($coupon_list as $key=>$value ){?>
          <div class="col-md-6">
            <div class="cpnbox">
              <div class="ccode">
                <h5><?=$value['coupon_code']?></h5>
                <p><?=$value['description']?></p>
              </div>
              <div class="d_btn">
                <h4><?=$value['title_name']?></h4>
                <button class="aplybtn" onclick="applyCoupon('<?=$value['coupon_code']?>' )"> Apply</button>
              </div>
            </div>
          </div>
          <?php }} ?>
           
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
 
 
<script>
  $( document ).ready( function(){
      setTimeout(()=>{
          checkLoginUser();
      },500 );
  });
    

    function viewCouponList(){
	       $('#couponModal').modal('show');
	}
	
    function applyCoupon( cpnCode = '' ){
        var couponCode = ( cpnCode === '' ) ? $('#couponfind').val() : cpnCode;
        if( couponCode.trim() === '' ){
             toastr.error('Enter Valid Coupon Code');
        }
          
        $('#couponModal').modal('hide');
        $('#couponfind').val( couponCode );
        $.ajax({
            type:'POST',
            data: {'coupon_code': couponCode },
            url: '<?=base_url('apply-coupon')?>',
            cache : false, 
            success: function( res ){
                var objData = JSON.parse(res);
                if(objData.status == true ){
                    toastr.success( objData.message );
                    $('#couponDivS').show();
                    $('#discountAmount').html( '- ₹ '+parseFloat(objData.data.discount_amount).toFixed(2) );
                    $('#subtotal').html( '₹ '+(parseFloat(objData.data.trip_amount) - parseFloat(objData.data.discount_amount)).toFixed(2)  );
                    $('#btnapply').attr('onclick', 'removeCoupon()' );
                    $('#btnapply').html( 'Remove' );
                }else{
                    $('#couponDivS').hide();
                    $('#discountAmount').html( '- ₹ 0' );
                    $('#subtotal').html( '₹ <?=$list['total_trip_amount_with_gst']?>' );
                    toastr.error( objData.message ); 
                }
            }
        });  
    }
    
    function removeCoupon(){
        $('#couponfind').val( '' );
        $('#btnapply').attr('onclick', 'viewCouponList()' );
        $('#btnapply').html( 'Check Coupon' );
        $('#couponDivS').hide();
        $('#discountAmount').html( '- ₹ 0' );
        $('#subtotal').html( '₹ <?=$list['total_trip_amount_with_gst']?>' );
        toastr.success( 'Coupon Removed Successfully' );
    }
    
    function choosePaymentMode(){
       var type = document.querySelector('#payment_mode').value; 
	   if( type === 'cash' ){ 
            if($('input[type="checkbox"]').is(':checked') == true){
                $('input[type="checkbox"]').prop('checked', false); 
            }
	        $('#ctBtn').html('Create Booking');
	   }else if( type !== 'cash' ){
	       $('#ctBtn').html('Proceed To Payment');
	   }
	}
	
	function enterCoupon( valuD ){
	        var textValue,clickValue = '';
	        if( valuD === '' ){
	            textValue = 'Check Coupon';
	            clickValue = "viewCouponList()"; 
	        }else if( valuD !== '' ){
	            textValue = 'Apply Coupon';
	            clickValue = "applyCoupon()"; 
	        }
	        $('#btnapply').html( textValue );
	        $('#btnapply').attr('onclick', clickValue ); 
	        $('#couponDivS').hide();
            $('#discountAmount').html( '- ₹ 0' );
            $('#subtotal').html( '₹ <?=$list['total_trip_amount_with_gst']?>' );
	 } 
	 
	function checkWallet(){
        var checkedWallet = document.querySelector('#myWallet:checked').value;
        var checkedPaymentMode = document.querySelector('#payment_mode').value; 
        if( checkedWallet !== '' ){
            $('#payment_mode').val('full').change();
        } 
    }
    
    function checkLoginUser(){  
        var is_loggedin = '<?=$is_logged_in?>';
        if(!is_loggedin){ 
            $('#loginmodal').modal('show');  
            return;
        }
    }
    /***** Create booking Script start here *******/  
    function createBooking(){
        
        var is_loggedin = '<?=$is_logged_in?>';
        if(!is_loggedin){
            $('#loginmodal').modal('show');
            return;
        }
        
        var fullName = document.getElementById('full_name').value;
        var email_id = document.getElementById('email_id').value;
        var phone_no = document.getElementById('phone_no').value;
        var no_of_passenger = document.getElementById('no_of_passenger').value;
        var company_name = document.getElementById('company_name').value;
        var gst_in = document.getElementById('gst_in').value;
        var pickup_address = document.getElementById('pickup_address').value;
        var drop_address = document.getElementById('drop_address').value;
        var coupon_code = document.getElementById('couponfind').value;
        var payment_mode = document.querySelector('#payment_mode').value; 
        var is_wallet_enable = ($('input[type="checkbox"]').is(':checked') == true) ? document.querySelector('#myWallet:checked').value : '';
        
        if( fullName === ''){
            return alertMsg( 'error', 'Plaese enter full name'); 
        }
        else if( email_id === ''){
            return alertMsg( 'error', 'Plaese enter valid email ID'); 
        }
        if( phone_no === ''){
            return alertMsg( 'error', 'Plaese enter 10 digit mobile No.'); 
        }
        var id = '<?=$list['id']?>';
        var searchPayloadData = JSON.parse( localStorage.getItem("searchPayload") );  
        
        
        var payLoad = {}
        payLoad['full_name'] = fullName;
        payLoad['email_id'] = email_id;
        payLoad['phone_no'] = phone_no;
        payLoad['no_of_passenger'] = no_of_passenger;
        payLoad['company_name'] = company_name;
        payLoad['gst_in'] = gst_in;
        payLoad['pickup_address'] = pickup_address;
        payLoad['drop_address'] = drop_address;
        payLoad['coupon_code'] = coupon_code; 
        payLoad['is_wallet_enable'] = is_wallet_enable; 
        payLoad['payment_mode'] = payment_mode;
        payLoad['trip_type'] = searchPayloadData.trip_type;
        payLoad['trip_mode'] = searchPayloadData.trip_mode;
        payLoad['pickup_city'] = searchPayloadData.pickup_city;
        payLoad['drop_city'] = searchPayloadData.drop_city;
        payLoad['local_package'] = searchPayloadData.local_package;
        payLoad['booking_amount'] = payment_mode =='advance' ? '<?=$list['advance_booking_amount']?>' : '<?=$list['total_trip_amount_with_gst']?>';
        
        $.ajax({
            type:'POST',
            data: payLoad ,
            url: '<?=base_url('create-booking')?>',
            cache : false, 
            success: function( res ){
                var objData = JSON.parse( res );
                 if( objData.status ){
                     if( objData.data.status == 'new' ){
                         setTimeout( ()=>{ window.location.href='<?=base_url('user/my-bookings')?>';}, 500 );
                        return alertMsg( 'success', 'Booking Created Successfully' );   
                     }
                     else if( objData.data.status == 'temp' ){
                        return loadGateway( objData.data.pending_amount, objData.data.user_id, objData.data.order_id );   
                     }
                 }else{
                    return alertMsg( 'error', objData.message );  
                 }
            }
        }); 
    } 
 
    const cashfree = Cashfree({
        mode: "<?php echo CASHFREE_MODE == 'TEST' ? 'sandbox':'production'; ?>"
    });
   
    function loadGateway( amount, user_id , order_id ){ 
  
      $.ajax({
            url: "<?=base_url(USERPATH.'getToken')?>",
            method: 'POST',
            data: { amount: amount, id: user_id },
            dataType: 'json',
            beforeSend: function() {
              $('#ctBtn').prop('disabled', true).text('Please Wait...');
            },
            success: function(respd) {
                 
              if (respd.status) { 
                    var paymentSessionId  = respd.data.payment_session_id; 
                     
                    let paymentOptions = { 
                        paymentSessionId: paymentSessionId,
                        returnUrl: "<?=base_url('booking-details?odr=')?>"+btoa(order_id),
                        redirect: "_self"
                    }  
                    cashfree.checkout( paymentOptions );
              } else {
                  return alertMsg( 'error', respd.message ); 
              }
            }
      });
}

<?php if(!empty($booking_id)){?>

checkAmount('<?=$booking_id?>');


function checkAmount( order_id ){ 
  
      $.ajax({
            url: "<?=base_url('confirm-booking')?>",
            method: 'POST',
            data: { order_id ,'<?=csrf_token()?>':'<?=csrf_hash()?>'}, 
            beforeSend: function() {
              $('#ctBtn').prop('disabled', true).text('Please Wait...');
            },
            success: function(respd) { 
                var objDt = JSON.parse( respd );
              if (objDt.status) { 
                    window.location.href='<?=base_url('user/my-bookings');?>'
              } else {
                  return alertMsg( 'error', 'Please Wait...' ); 
              }
            }
      });
}

<?php }?>
    
</script>

 