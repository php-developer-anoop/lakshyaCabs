<div class="container-fluid ">
  <div class="row">
    <div class="col-sm-7 pl-0 pr-0">
      <div class="brdcrumb pl-60 pr-30">
        <ul>
          <li><a href="<?=base_url()?>"> Home </a></li>
          <li class="current"> <?=!empty($page['package_name'])?'/ '.$page['package_name']:''?></li>
        </ul>
      </div>
      <section class="contact_sec sec_padd pl-60 pr-30">
        <div class="norml_hdng">
          <h1><?= !empty($page['h1']) ? $page['h1'] : "" ?></h1>
          <div class="tourbrf d-flex align-items-center">
            <?php if (!empty($page['covered_kms'])): ?>
            <span><i class="fa-regular fa-calendar"></i> Full day (<?= $page['covered_kms'] ?> km included)</span>
            <?php endif; ?>
            <?php if (!empty($page['from_to_city'])): ?>
            <span><i class="fa fa-location-dot"></i> <?= $page['from_to_city'] ?></span>
            <?php endif; ?>
            <?php if (!empty($vehicles)): ?>
            <span><i class="fa-solid fa-car-side"></i>
            <?php foreach ($vehicles as $key => $value): ?>
            <?= getModel($value['model_id']) ?><?php if ($key < count($vehicles) - 1) echo ',' ?>
            <?php endforeach; ?>
            </span>
            <?php endif; ?>
          </div>
          <div class="pkgbrdprice d-flex align-items-center justify-content-between">
            <div class="pkleft">
              <h4>Package Starting from </h4>
              <span>*Inclusive of all taxes</span>
            </div>
            <div class="pkright">
              
              <h3> <?=!empty($page['id'])?'₹'.(int)getMinPrice($page['id']):'';?> </h3>
            </div>
          </div>
        </div>
        <div class="content">
          <?=!empty($page['description'])?$page['description']:""?>
          <?php $bgimage = !empty($page['jpg_image'] || $page['webp_image']) ? base_url('uploads/') . imgExtension($page['jpg_image'],$page['webp_image']) : ""; ?>
          <div class="content_img">
            <img src="<?=$bgimage?>" alt="<?=!empty($page['image_alt'])?$page['image_alt']:""?>">
          </div>
        </div>
        <?php $itd =!empty($page['itenary_description'])?json_decode($page['itenary_description'],true):[]?>
       <?php if (!empty($itd)) { ?>
    <div class="content-container pt-4">
        <div class="heading-2 mb-3">
            <h3>Itinerary (Day Wise)</h3>
        </div>
        <div class="itenary_accrd">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <?php foreach ($itd as $i => $day) { ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header <?= ($i !== 0) ? 'collapsed' : '' ?>">
                            <button class="itnryday accordion-button collapsed fs-20" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $i ?>" aria-expanded="<?= ($i === 0) ? 'true' : 'false' ?>" aria-controls="flush-collapse<?= $i ?>">
                                <span><img src="<?= base_url('assets/frontend/') ?>images/lstar.png"><?= $day['day'] ?></span>
                                <?= $day['title'] ?>
                            </button>
                        </h2>
                        <div id="flush-collapse<?= $i ?>" class="accordion-collapse <?= ($i == 1) ? 'collapse' : 'show' ?>" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body fs-16 mx100"><?= $day['description'] ?></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<div class="content-container pt-4">
		           <div class="heading-2 mb-3">
		              <h3>Tour Information</h3>
		           </div>
		           <ul class="tour-info-list">
		              <li class="tour-info-item">
			              <div class="tour-info-head">
			                <h5>Inclusion</h5>
			              </div>
			              <div class="tour-info-body">
			              	<ul>
			              		<?=!empty($page['inclusion'])?$page['inclusion']:""?>
			              	</ul>
			              </div>
		              </li>
		              <li class="tour-info-item">
			            	<div class="tour-info-head">
			            		<h5>Exclusion</h5>
			            	</div>
			            	<div class="tour-info-body">
			            		<ul>
			            		<?=!empty($page['exclusion'])?$page['exclusion']:""?>
			            		</ul>
			            	</div>
		               </li>
		           </ul>
		        </div>
        <div class="content-container pt-4">
		        	<div class="heading-2">
		              <h3>Cancellation Policy & Payment Terms</h3>
		           </div>
		           <div class="tour-info-body" style="border:0">
			              	<ul>
			              		<?=!empty($page['cancellation_terms_conditions'])?$page['cancellation_terms_conditions']:""?>
			              	</ul>
			       </div>
		        </div>
        <div class="content pt-2">
          <?=!empty($page['itenary_terms_conditions'])?$page['itenary_terms_conditions']:""?>
        </div>
      </section>
      <?php if(!empty($vehicles)){?>
      <section class="ocassion sec_padd pl-60 pr-0">
        <div class="norml_hdng">
          <h2>Taxi Fleet in <?=!empty($page['from_city'])?$page['from_city']:''?> </h2>
          <p class="sub_hdng">Taxi fare in <?=!empty($page['from_city'])?$page['from_city']:''?> - Choose from the wide range of <?=!empty($page['from_city'])?$page['from_city']:''?> Cab Booking</p>
        </div>
        <div class="tablehome">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Vehicle Type/Model</th>
                <th scope="col">Rate/KM</th>
                <th scope="col">Fixed Price</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
              <?php foreach($vehicles as $vkey=>$vvalue){ ?>
              <?php $carimage = !empty($vvalue['jpg_image'] || $vvalue['webp_image']) ? base_url('uploads/') . imgExtension($vvalue['jpg_image'],$vvalue['webp_image']) : ""; ?>					
              <tr>
                <td scope="row"><img src="<?=$carimage?>"></td>
                <td><?=!empty($vvalue['model_name'])?$vvalue['model_name']:''?></td>
                <td><?=!empty($vvalue['per_km_price'])?'₹'.(int)$vvalue['per_km_price']:''?></td>
                <td><?=!empty($vvalue['fixed_price'])?'₹'.(int)$vvalue['fixed_price']:''?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </section>
      <?php } ?>
      <?php if(!empty($popular_packages)){?>
      <section class="popularplc_slider sec_padd  pl-60 pr-30">
        <div class="site_hdng">
          <h2>  Taxi Packages in <?=!empty($page['from_city'])?$page['from_city']:''?></h2>
          <p class="sub_hdng"> Choose from a range of categories and prices </p>
        </div>
        <div class="packg_sldier_sec">
          <div class="packg_slider owl-theme owl-carousel">
            <?php foreach($popular_packages as $ppkey=>$ppvalue){?>
            <?php $packbanner = !empty($ppvalue['jpg_image'] || $ppvalue['webp_image']) ? base_url('uploads/') . imgExtension($ppvalue['jpg_image'],$ppvalue['webp_image']) : ""; ?>					
            <div class="pkg_box">
              <img src="<?=$packbanner?>" alt="<?=!empty($ppvalue['image_alt'])?$ppvalue['image_alt']:''?>">
              <h6><a href="<?=!empty($ppvalue['url'])?base_url($ppvalue['url']):''?>"><?=!empty($ppvalue['package_title'])?$ppvalue['package_title']:''?></a></h6>
              <p><?=!empty($ppvalue['short_description'])?$ppvalue['short_description'].'....':''?></p>
            </div>
            <?php } ?>
          </div>
        </div>
      </section>
      <?php } ?>
      <?php $bottom_banner = !empty($page['bottom_banner_jpg'] || $page['bottom_banner_webp']) ? base_url('uploads/') . imgExtension($page['bottom_banner_jpg'],$page['bottom_banner_webp']) : ""; ?>					
      <?php if(!empty($bottom_banner)){?> 
      <section class="ad_sec pl-60 pr-30">
        <img src="<?=$bottom_banner?>" alt="<?=!empty($page['bottom_banner_image_alt'])?$page['bottom_banner_image_alt']:''?>">
      </section>
      <?php  } ?>
      <?php if(!empty($testimonials)){?>
      <section class="reviewslider sec_padd pl-60 pr-30">
        <div class="hdng_btn norml_hdng d-flex">
          <h2>Google Reviews</h2>
          <a href="" class="viewall">View All</a>
        </div>
        <div class="revw_sldier_sec">
          <div class="review_sldr owl-theme owl-carousel">
            <?php foreach($testimonials as $tkey=>$tvalue){?>
            <div class="review_box">
              <p class="comment"><?=!empty($tvalue['description'])?$tvalue['description']:""?></p>
              <p class="name"><?=!empty($tvalue['person_name'])?$tvalue['person_name']:""?>, <?=!empty($tvalue['place'])?$tvalue['place']:""?></p>
              <!-- <div class="googlimg">
                <img src="images/review.png">
                </div> -->
            </div>
            <?php } ?>
          </div>
        </div>
      </section>
      <?php } ?>
      <?php if (!empty($faqs)) { ?>
      <section class="faqs sec_padd pl-60 pr-30">
        <div class="hdng_btn d-flex">
          <div class="norml_hdng">
            <h2>FAQs </h2>
            <!--<p class="sub_hdng">Outstation Taxi Service in Lucknow | Local cabs in Lucknow Airport</p>-->
          </div>
          <a href="" class="viewall d-none">View All</a>
        </div>
        <div class="faqs_txt">
          <?php $i = 1; ?>
          <?php foreach ($faqs as $key => $value) { ?>
          <div class="accordion" id="accordionExample">
            <div class="accordion-item faqs_column">
              <h2 class="accordion-header <?= ($i !== 1) ? 'collapsed' : '' ?>" id="heading<?= $i ?>">
                <button class="accordion-button faq_qstn"  type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>" aria-expanded="<?= ($i === 1) ? 'true' : 'false' ?>" aria-controls="collapse<?= $i ?>">
                <?= $i ?>- <?= $value['question'] ?>
                </button>
              </h2>
              <div id="collapse<?= $i ?>" class="accordion-collapse <?= ($i !== 1) ? 'collapse' : 'show' ?>" aria-labelledby="heading<?= $i ?>" data-bs-parent="#accordionExample">
                <div class="accordion-body faq_answr">
                  <p><?= $value['answer'] ?></p>
                </div>
              </div>
            </div>
          </div>
          <?php $i++; ?>
          <?php } ?>
        </div>
      </section>
      <?php } ?>
      <?=view('frontend/popular-city-taxi')?>
    </div>
    <?=view('frontend/common_cms_form')?>
  </div>
</div>

<div class="container-fluid d-none">
	<div class="row">
		<div class="col-sm-7 pl-0 pr-0">
			<section class="contact_sec sec_padd pl-60 pr-30">
				<div class="norml_hdng">
					<h2>Book One Way Cab Hire from Lucknow To Meerut, One-way taxi Services in Lucknow to Meerut</h2>
				</div>
				<div class="content">
				    <div class="routes_tabs">
					    	<ul class="nav" id="myTab" role="tablist">
								  <li class="nav-item" role="presentation">
								    <a class="nav-link active" href="#">Outstation Taxi</a>
								  </li>
								  <li class="nav-item" role="presentation">
								    <a class="nav-link" href="#">Cabs from lucknow</a>
								  </li>
								  <li class="nav-item" role="presentation">
								    <a class="nav-link" href="#">Airport Taxi</a>
								  </li>
								  <li class="nav-item" role="presentation">
								    <a class="nav-link" href="#">Luxury Taxi</a>
								  </li>
								  <li class="nav-item" role="presentation">
								    <a class="nav-link" href="#">Corporate Taxi</a>
								  </li>
								  <li class="nav-item" role="presentation">
								    <a class="nav-link" href="#">Tempo Traveller</a>
								  </li>
							</ul>
					</div>
					<div class="content_img mb-3">
						<img src="https://okayindia.co.in/lakshya-cabs/images/routes.png">
					</div>
				    
					<div class="content_text">
					    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				    	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					   <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					</div>
				</div>
				<div class="cablist">
					<div class="cablist_box">
						<div class="cb_img">
							<img src="<?=base_url('assets/frontend/')?>images/cab.png"> 
						</div>
						<div class="cb_details">
							<h4>Indica, Swift, Alto, Or Equivalent</h4>
							<div class="rating">
								<ul> 
									<li> <i class="fa fa-star"> </i> </li>
									<li> <i class="fa fa-star"> </i> </li>
									<li> <i class="fa fa-star"> </i> </li>
									<li> <i class="fa fa-star"> </i> </li>
									<li> <i class="fa fa-star"> </i> </li>
								</ul>
							</div>
							<div class="facility">
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f1.png">4 Seater</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f2.png">Petrol</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f3.png">1 Luggage</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f4.png">AC Cabs</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f5.png">Water Bottle</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f6.png">Carrier</span>
							</div>
						</div>
						<div class="cab_pricebox">
							<span class="discnt">Flat 21% Off</span>
							<h2>₹1,462 <span class="cutprice">₹5567</span></h2>
							<div class="viewall">
								<a href="booking-details.php" class="viewbtn">Book Now</a>
							</div>
							<span class="faresmry" data-bs-toggle="modal" data-bs-target="#faresummary"><i class="fa-solid fa-circle-info"></i> 
							Fare Summary</span>
						</div>
					</div>
					<div class="cablist_box">
						<div class="cb_img">
							<img src="<?=base_url('assets/frontend/')?>images/cab.png"> 
						</div>
						<div class="cb_details">
							<h4>Indica, Swift, Alto, Or Equivalent</h4>
							<div class="rating">
								<ul> 
									<li><i class="fa fa-star"></i></li>
									<li><i class="fa fa-star"></i></li>
									<li><i class="fa fa-star"></i></li>
									<li><i class="fa fa-star"></i></li>
									<li><i class="fa fa-star"></i></li>
								</ul>
							</div>
							<div class="facility">
								<span class="fac_btn"><img src="<?=base_url('assets/frontend/')?>images/f1.png">4 Seater</span>
								<span class="fac_btn"><img src="<?=base_url('assets/frontend/')?>images/f2.png">Petrol</span>
								<span class="fac_btn"><img src="<?=base_url('assets/frontend/')?>images/f3.png">1 Luggage</span>
								<span class="fac_btn"><img src="<?=base_url('assets/frontend/')?>images/f4.png">AC Cabs</span>
								<span class="fac_btn"><img src="<?=base_url('assets/frontend/')?>images/f5.png">Water Bottle</span>
								<span class="fac_btn"><img src="<?=base_url('assets/frontend/')?>images/f6.png">Carrier</span>
							</div>
						</div>
						<div class="cab_pricebox">
							<span class="discnt">Flat 21% Off</span>
							<h2>₹1,462 <span class="cutprice">₹5567</span></h2>
							<div class="viewall">
								<a href="booking-details.php" class="viewbtn">Book Now</a>
							</div>
							<span class="faresmry" data-bs-toggle="modal" data-bs-target="#faresummary"><i class="fa-solid fa-circle-info"></i> 
							Fare Summary</span>
						</div>
					</div>
										<div class="cablist_box">
						<div class="cb_img">
							<img src="<?=base_url('assets/frontend/')?>images/cab.png"> 
						</div>
						<div class="cb_details">
							<h4>Indica, Swift, Alto, Or Equivalent</h4>
							<div class="rating">
								<ul> 
									<li> <i class="fa fa-star"></i> </li>
									<li> <i class="fa fa-star"></i> </li>
									<li> <i class="fa fa-star"></i> </li>
									<li> <i class="fa fa-star"></i> </li>
									<li> <i class="fa fa-star"></i> </li>
								</ul>
							</div>
							<div class="facility">
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f1.png">4 Seater</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f2.png">Petrol</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f3.png">1 Luggage</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f4.png">AC Cabs</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f5.png">Water Bottle</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f6.png">Carrier</span>
							</div>
						</div>
						<div class="cab_pricebox">
							<span class="discnt">Flat 21% Off</span>
							<h2>₹1,462 <span class="cutprice">₹5567</span></h2>
							<div class="viewall">
								<a href="booking-details.php" class="viewbtn">Book Now</a>
							</div>
							<span class="faresmry" data-bs-toggle="modal" data-bs-target="#faresummary"><i class="fa-solid fa-circle-info"></i> 
							Fare Summary</span>
						</div>
					</div>
					<div class="cablist_box">
						<div class="cb_img">
							<img src="<?=base_url('assets/frontend/')?>images/cab.png"> 
						</div>
						<div class="cb_details">
							<h4>Indica, Swift, Alto, Or Equivalent</h4>
							<div class="rating">
								<ul> 
									<li> <i class="fa fa-star"> </i> </li>
									<li> <i class="fa fa-star"> </i> </li>
									<li> <i class="fa fa-star"> </i> </li>
									<li> <i class="fa fa-star"> </i> </li>
									<li> <i class="fa fa-star"> </i> </li>
								</ul>
							</div>
							<div class="facility">
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f1.png">4 Seater</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f2.png">Petrol</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f3.png">1 Luggage</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f4.png">AC Cabs</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f5.png">Water Bottle</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f6.png">Carrier</span>
							</div>
						</div>
						<div class="cab_pricebox">
							<span class="discnt">Flat 21% Off</span>
							<h2>₹1,462 <span class="cutprice">₹5567</span></h2>
							<div class="viewall">
								<a href="booking-details.php" class="viewbtn">Book Now</a>
							</div>
							<span class="faresmry" data-bs-toggle="modal" data-bs-target="#faresummary"><i class="fa-solid fa-circle-info"></i> 
							Fare Summary</span>
						</div>
					</div>
					<div class="cablist_box">
						<div class="cb_img">
							<img src="<?=base_url('assets/frontend/')?>images/cab.png"> 
						</div>
						<div class="cb_details">
							<h4>Indica, Swift, Alto, Or Equivalent</h4>
							<div class="rating">
								<ul> 
									<li> <i class="fa fa-star"> </i> </li>
									<li> <i class="fa fa-star"> </i> </li>
									<li> <i class="fa fa-star"> </i> </li>
									<li> <i class="fa fa-star"> </i> </li>
									<li> <i class="fa fa-star"> </i> </li>
								</ul>
							</div>
							<div class="facility">
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f1.png">4 Seater</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f2.png">Petrol</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f3.png">1 Luggage</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f4.png">AC Cabs</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f5.png">Water Bottle</span>
								<span class="fac_btn"> <img src="<?=base_url('assets/frontend/')?>images/f6.png">Carrier</span>
							</div>
						</div>
						<div class="cab_pricebox">
							<span class="discnt">Flat 21% Off</span>
							<h2>₹1,462 <span class="cutprice">₹5567</span></h2>
							<div class="viewall">
								<a href="booking-details.php" class="viewbtn">Book Now</a>
							</div>
							<span class="faresmry" data-bs-toggle="modal" data-bs-target="#faresummary"><i class="fa-solid fa-circle-info"></i> 
							Fare Summary</span>
						</div>
					</div>
				</div>
			</section>
			<section class="ocassion sec_padd pl-60 pr-0">
				<div class="norml_hdng">
					<h2>Tariffs </h2>
				</div>
				<div class="tablehome">
					<table class="table table-striped">
						<thead>
							<tr>
								<th scope="col">Vehicle Name</th>
								<th scope="col">From</th>
								<th scope="col">Rate/KM</th>
								<th scope="col">Estimated Cost</th>
								<th scope="col">Min. KM/Day</th>
							</tr>
						</thead>
						<tbody class="table-group-divider">
							<tr>
								<td>Etios</td>
								<td>Ahmedabad</td>
								<td>15 INR/KM</td>
								<td>12999.00 INR</td>
								<td>200 KM</td>
							</tr>
							<tr>
								<td>Etios</td>
								<td>Ahmedabad</td>
								<td>15 INR/KM</td>
								<td>12999.00 INR</td>
								<td>200 KM</td>
							</tr>
							<tr>
								<td>Etios</td>
								<td>Ahmedabad</td>
								<td>15 INR/KM</td>
								<td>12999.00 INR</td>
								<td>200 KM</td>
							</tr>
							<tr>
								<td>Etios</td>
								<td>Ahmedabad</td>
								<td>15 INR/KM</td>
								<td>12999.00 INR</td>
								<td>200 KM</td>
							</tr>

						</tbody>
					</table>
				</div>
			</section>
			<section class="pt-4 pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
	     		<div class="norml_hdng hdng_btn d-flex">
					<h2>Trending Cab Packages</h2>
					<a href="package-list.php" class="viewall">View All</a>
				</div>
				<div class="packg_sldier_sec">
					<div class="packg_slider owl-theme owl-carousel os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
						<div class="pkg_box">
							<img src="<?=base_url('assets/frontend/')?>images/fleet.png">
							<h6>Introducing Double Guarantee on Outstation Cabs!</h6>
							<p>Get confirmed cab arrival else 2X money back!</p>
							<p class="disc">Flat 12% off</p>
							<div class="d-flex code_btn">
								<p class="code">xuzguz</p>
								<a href="cms.php" class="knowmore"> <i class="fa fa-arrow-right"> </i>  </a> 
							</div>
						</div>
						<div class="pkg_box">
							<img src="<?=base_url('assets/frontend/')?>images/fleet.png">
							<h6>Introducing Double Guarantee on Outstation Cabs!</h6>
							<p>Get confirmed cab arrival else 2X money back!</p>
							<p class="disc">Flat 12% off</p>
							<div class="d-flex code_btn">
								<p class="code">xuzguz</p>
								<a href="cms.php" class="knowmore"> <i class="fa fa-arrow-right"> </i>  </a> 
							</div>
						</div>
						<div class="pkg_box">
							<img src="<?=base_url('assets/frontend/')?>images/fleet.png">
							<h6>Introducing Double Guarantee on Outstation Cabs!</h6>
							<p>Get confirmed cab arrival else 2X money back!</p>
							<p class="disc">Flat 12% off</p>
							<div class="d-flex code_btn">
								<p class="code">xuzguz</p>
								<a href="cms.php" class="knowmore"> <i class="fa fa-arrow-right"> </i>  </a> 
							</div>
						</div>
						<div class="pkg_box">
							<img src="<?=base_url('assets/frontend/')?>images/fleet.png">
							<h6>Introducing Double Guarantee on Outstation Cabs!</h6>
							<p>Get confirmed cab arrival else 2X money back!</p>
							<p class="disc">Flat 12% off</p>
							<div class="d-flex code_btn">
								<p class="code">xuzguz</p>
								<a href="cms.php" class="knowmore"> <i class="fa fa-arrow-right"> </i>  </a> 
							</div>
						</div>
						<div class="pkg_box">
							<img src="<?=base_url('assets/frontend/')?>images/fleet.png">
							<h6>Introducing Double Guarantee on Outstation Cabs!</h6>
							<p>Get confirmed cab arrival else 2X money back!</p>
							<p class="disc">Flat 12% off</p>
							<div class="d-flex code_btn">
								<p class="code">xuzguz</p>
								<a href="cms.php" class="knowmore"> <i class="fa fa-arrow-right"> </i>  </a> 
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="pb-4 pr-30 os-animation fadeInUp" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
				<div class="fullimg">
					<a href="">
  					  <img src="<?=base_url('assets/frontend/')?>images/driverbnr.png">
  					</a>
				</div>
			</section>

			<section class="cabsfrom pl-60 pb-4 pr-30 os-animation fadeInUp" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
				<div class="norml_hdng">
 					<h2>Cabs from Lucknow</h2>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<ul class="rentalcities">
							<li><a href="#">Cabs from Lucknow to Varanasi </a></li>
							<li><a href="#">Cabs from Lucknow to New Delhi</a></li>
							<li><a href="#">Cabs from Lucknow to Varanasi</a></li>
							<li><a href="#">Cabs from Lucknow to Varanasi</a></li>
							<li><a href="#">Cabs from Lucknow to New Delhi</a></li>
							<li><a href="#">Cabs from Lucknow to Varanasi</a></li>
						</ul>
					</div>
					<div class="col-sm-4">
						<ul class="rentalcities">
							<li><a href="#">Cabs from Lucknow to Varanasi</a></li>
							<li><a href="#">Cabs from Lucknow to New Delhi</a></li>
							<li><a href="#">Cabs from Lucknow to Varanasi</a></li>
							<li><a href="#">Cabs from Lucknow to Varanasi</a></li>
							<li><a href="#">Cabs from Lucknow to New Delhi</a></li>
							<li><a href="#">Cabs from Lucknow to Varanasi</a></li>
						</ul>
					</div>
					<div class="col-sm-4">
						<ul class="rentalcities">
							<li><a href="#">Cabs from Lucknow to Varanasi</a></li>
							<li><a href="#">Cabs from Lucknow to New Delhi</a></li>
							<li><a href="#">Cabs from Lucknow to Varanasi</a></li>
							<li><a href="#">Cabs from Lucknow to Varanasi</a></li>
							<li><a href="#">Cabs from Lucknow to New Delhi</a></li>
							<li><a href="#">Cabs from Lucknow to Varanasi</a></li>
						</ul>
					</div>
				</div>
			</section>
			
			<section class="faqs sec_padd pl-60 pr-30">
				<div class="hdng_btn d-flex">
					<div class="norml_hdng">
						<h2>FAQs on Ahmedabad Cab Service </h2>
						<p class="sub_hdng">Outstation Taxi Service in Lucknow | Local cabs in Lucknow Airport</p>
					</div>
					<a href="" class="viewall">View All</a>
				</div>
				<div class="faqs_txt">
						<div class="accordion" id="accordionExample">
						  <div class="accordion-item faqs_column">
						    <h2 class="accordion-header" id="headingOne">
						      <button class="accordion-button faq_qstn"  type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							    1- Why should I book a cab from PKTaxis ?
						      </button>
						    </h2>
						    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
						      <div class="accordion-body faq_answr">
						        	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
						      </div>
						    </div>
						  </div>
						  <div class="accordion-item">
						    <h2 class="accordion-header" id="headingTwo">
						      <button class="accordion-button collapsed faq_qstn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						        2- Why should I book a cab from PKTaxis ?
						      </button>
						    </h2>
						    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
						       <div class="accordion-body faq_answr">
						        	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
						      </div>
						    </div>
						  </div>
						  <div class="accordion-item">
						    <h2 class="accordion-header" id="headingThree">
						      <button class="accordion-button collapsed faq_qstn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						        3- Why should I book a cab from PKTaxis ?
						      </button>
						    </h2>
						    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
						      <div class="accordion-body faq_answr">
						        	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
						      </div>
						    </div>
						  </div>
						</div>
				</div>
			</section>
			
		</div>
			<?=view('frontend/trip_form')?>
	</div>

	<div class="row">
		<section class="rental sec_padd pl-60 pr-30">
				<div class="norml_hdng">
					<h2>Route from Lucknow </h2>
					<p class="sub_hdng">Outstation Taxi Service in Lucknow | Local cabs in Lucknow Airport</p>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<ul class="rentalcities">
							<li><a href="">Deoria</a></li>
							<li><a href="">Etah</a></li>
							<li><a href="">Etawah</a></li>
							<li><a href="">Faizabad</a></li>
							<li><a href="">Gonda</a></li>
							<li><a href="">Ghaziabad</a></li>
							<li><a href="">Deoria</a></li>
							<li><a href="">Gorakhpur</a></li>
							<li><a href="">Hamirpur</a></li>
						</ul>
					</div>
					<div class="col-sm-2">
						<ul class="rentalcities">
							<li><a href="">Deoria</a></li>
							<li><a href="">Etah</a></li>
							<li><a href="">Etawah</a></li>
							<li><a href="">Faizabad</a></li>
							<li><a href="">Gonda</a></li>
							<li><a href="">Ghaziabad</a></li>
							<li><a href="">Deoria</a></li>
							<li><a href="">Gorakhpur</a></li>
							<li><a href="">Hamirpur</a></li>
						</ul>
					</div>
					<div class="col-sm-2">
						<ul class="rentalcities">
							<li><a href="">Deoria</a></li>
							<li><a href="">Etah</a></li>
							<li><a href="">Etawah</a></li>
							<li><a href="">Faizabad</a></li>
							<li><a href="">Gonda</a></li>
							<li><a href="">Ghaziabad</a></li>
							<li><a href="">Deoria</a></li>
							<li><a href="">Gorakhpur</a></li>
							<li><a href="">Hamirpur</a></li>
						</ul>
					</div>
					<div class="col-sm-2">
						<ul class="rentalcities">
							<li><a href="">Deoria</a></li>
							<li><a href="">Etah</a></li>
							<li><a href="">Etawah</a></li>
							<li><a href="">Faizabad</a></li>
							<li><a href="">Gonda</a></li>
							<li><a href="">Ghaziabad</a></li>
							<li><a href="">Deoria</a></li>
							<li><a href="">Gorakhpur</a></li>
							<li><a href="">Hamirpur</a></li>
						</ul>
					</div>
					<div class="col-sm-2">
						<ul class="rentalcities">
							<li><a href="">Deoria</a></li>
							<li><a href="">Etah</a></li>
							<li><a href="">Etawah</a></li>
							<li><a href="">Faizabad</a></li>
							<li><a href="">Gonda</a></li>
							<li><a href="">Ghaziabad</a></li>
							<li><a href="">Deoria</a></li>
							<li><a href="">Gorakhpur</a></li>
							<li><a href="">Hamirpur</a></li>
						</ul>
					</div>
					<div class="col-sm-2">
						<ul class="rentalcities">
							<li><a href="">Deoria</a></li>
							<li><a href="">Etah</a></li>
							<li><a href="">Etawah</a></li>
							<li><a href="">Faizabad</a></li>
							<li><a href="">Gonda</a></li>
							<li><a href="">Ghaziabad</a></li>
							<li><a href="">Deoria</a></li>
							<li><a href="">Gorakhpur</a></li>
							<li><a href="">Hamirpur</a></li>
						</ul>
					</div>
				</div>
		</section>
	</div>
</div>







