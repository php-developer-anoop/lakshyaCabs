<script>
    var SearchData, SearchPayload;
    <?php if(!empty($list)){ ?>
      SearchData = '<?=json_encode($list)?>';
      SearchPayload = '<?=json_encode($search_payload)?>';
    <?php } ?>
    
    localStorage.setItem("searchData", SearchData );
    localStorage.setItem("searchPayload", SearchPayload );
 
   
</script>
<?=view('frontend/includes/fare_summary')?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-7 order-mbl-2 pl-0 pr-0">
			<section class="cablist sec_padd pl-60 pr-30">
				<div class="hdngwrpr_grn">
				   <h4>Booking Type: <span><?=ucwords($trip_type)?> (<?=ucwords($trip_mode);?>)</span>  Route: <span> <?=$pickup?> </span> <i class="fa-solid fa-chevron-right"></i> <span> <?=$drop?>  <?=(!empty($local_package) ? $local_package : '')?>  </span></h4>
				</div>
				
				<?php if(!empty($list)){
				foreach( $list as $key=>$value ){?>
    				<div class="cablist_box">
    					<div class="cb_img">
    						<img src="<?=getImagePathUrl($value['jpg_image'], $value['webp_image'] )?>"> 
    					</div>
    					<div class="cb_details">
    						<h4><?=$value['model_name']?></h4>
    						<div class="rating">
    							<ul> 
    							    <?php if( (int)$value['star_rating'] > 0 ){ for($i=1;$i <= (int)$value['star_rating']; $i++ ){?>
    								<li> <i class="fa fa-star"> </i> </li>
    								<?php }} ?> 
    							</ul>
    						</div>
    						<div class="facility">
    							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f1.png'), base_url('assets/images/f1.webp') )?>"><?=$value['seat_segment']?> Seater</span>
    							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f2.png'), base_url('assets/images/f2.webp') )?>"><?=$value['fuel_type']?></span>
    							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f1.png'), base_url('assets/images/f3.webp') )?>"><?=$value['luggage'];?> Luggage</span>
    							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f4.png'), base_url('assets/images/f4.webp') )?>"><?=$value['ac_or_non_ac'];?> Cabs</span>
    							<?php if($value['water_bottle']=='yes'){?>
    							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f5.png'), base_url('assets/images/f5.webp') )?>"><?=$value['water_bottle'];?>Water Bottle</span>
    							<?php }?>
    							<?php if($value['carrier']=='yes'){?>
    							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f6.png'), base_url('assets/images/f6.webp') )?>">Carrier</span>
    							<?php }?>
    							<span class="fac_btn"> <img src="<?=getImagePathUrl( base_url('assets/images/f7.png'), base_url('assets/images/f7.webp') )?>">Professional Driver</span>
    						</div>
    						<div class="exclsn">
    							<p><strong>Exclusion:</strong> <?=$value['exclusions']?>.</p>
    						</div>
    					</div>
    					<div class="cab_pricebox">
    						<span class="discnt">Flat <?=INSTANT_DISCOUNT?>% Off</span>
    						<h2>₹<?=$value['total_trip_amount_with_gst']?> <span class="cutprice">₹<?=$value['original_price'];?></span></h2>
    						<div class="viewall">
    							<a href="javascript:void(0)" onclick="saveBookingData('<?=$value['id'];?>')" class="viewbtn">Book Now</a>
    						</div>
    						<span class="faresmry" onclick="fareSummary('<?=$value['id'];?>')" ><i class="fa-solid fa-circle-info"></i> 
    						Fare Summary</span>
    					</div>
    				</div>
				<?php }}else{ ?>
					<center><img src="<?=getImagePathUrl(base_url('assets/images/nor-record.jpeg'), base_url('assets/images/nor-record.webp') )?>">
					<h5 style="color:red"><?=$error_message?></h5>
					</center>
				<?php } ?>
			</section>
			
			
			
			
			<section class="reviewslider sec_padd pl-60 pr-30">
				<div class="hdng_btn norml_hdng d-flex">
					<h2>Google Reviews</h2>
					<a href="" class="viewall">View All</a>
				</div>

				<div class="revw_sldier_sec">
					<div class="review_sldr owl-theme owl-carousel">
						<div class="review_box">
							<p class="comment">Most comfortable cab for Small family A comfortable sedan having the capacity to accomodate upto 4 passengers and reasonable luggage. A economical option for a family trip.</p>
							<p class="name">Sumit Yadav, Lucknow</p>
							<div class="googlimg">
								<img src="images/review.png">
							</div>
						</div>
						<div class="review_box">
							<p class="comment">Most comfortable cab for Small family A comfortable sedan having the capacity to accomodate upto 4 passengers and reasonable luggage. A economical option for a family trip.</p>
							<p class="name">Sumit Yadav, Lucknow</p>
							<div class="googlimg">
								<img src="images/review.png">
							</div>
						</div>
						<div class="review_box">
							<p class="comment">Most comfortable cab for Small family A comfortable sedan having the capacity to accomodate upto 4 passengers and reasonable luggage. A economical option for a family trip.</p>
							<p class="name">Sumit Yadav, Lucknow</p>
							<div class="googlimg">
								<img src="images/review.png">
							</div>
						</div>
						<div class="review_box">
							<p class="comment">Most comfortable cab for Small family A comfortable sedan having the capacity to accomodate upto 4 passengers and reasonable luggage. A economical option for a family trip.</p>
							<p class="name">Sumit Yadav, Lucknow</p>
							<div class="googlimg">
								<img src="images/review.png">
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="rental sec_padd pl-60 pr-30">
				<div class="norml_hdng">
					<h2>Taxi Rental Service in Most Popular Cities </h2>
					<p class="sub_hdng">Outstation Taxi Service in Lucknow | Local cabs in Lucknow Airport</p>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<ul class="rentalcities">
							<li>Deoria</li>
							<li>Etah</li>
							<li>Etawah</li>
							<li>Faizabad</li>
							<li>Gonda</li>
							<li>Ghaziabad</li>
							<li>Deoria</li>
							<li>Gorakhpur</li>
							<li>Hamirpur</li>
						</ul>
					</div>
					<div class="col-sm-3">
						<ul class="rentalcities">
							<li>Deoria</li>
							<li>Etah</li>
							<li>Etawah</li>
							<li>Faizabad</li>
							<li>Gonda</li>
							<li>Ghaziabad</li>
							<li>Deoria</li>
							<li>Gorakhpur</li>
							<li>Hamirpur</li>
						</ul>
					</div>
					<div class="col-sm-3">
						<ul class="rentalcities">
							<li>Deoria</li>
							<li>Etah</li>
							<li>Etawah</li>
							<li>Faizabad</li>
							<li>Gonda</li>
							<li>Ghaziabad</li>
							<li>Deoria</li>
							<li>Gorakhpur</li>
							<li>Hamirpur</li>
						</ul>
					</div>
					<div class="col-sm-3">
						<ul class="rentalcities">
							<li>Deoria</li>
							<li>Etah</li>
							<li>Etawah</li>
							<li>Faizabad</li>
							<li>Gonda</li>
							<li>Ghaziabad</li>
							<li>Deoria</li>
							<li>Gorakhpur</li>
							<li>Hamirpur</li>
						</ul>
					</div>
				</div>
			</section>
		</div>
		
	 <?=view('frontend/trip_form')?>
	 
	</div>
</div>


<div class="modal fade" id="faresummary" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Fare Summary</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body forgot_body" id="summaryData">
        Loading.....
      </div>
    </div>
  </div>
</div>

<!-- ==================== Success Modal ====================== -->
<div class="modal fade" id="successModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="success-modal text-center">
          <div class="success-icon">
            <img src="images/pktaxi_conform-booking.png" alt="">
          </div>
          <h3>Booking successful</h3>
          <h5>For Ahmedabad to Anand</h5>
          <div class="success-booking-id">Booking ID : 3233334556</div>
          <p>The full details of your booking sent your registered</p>
        </div>
      </div>
    </div>
  </div>
</div>










