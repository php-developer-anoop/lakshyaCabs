<?php 
  $topbanner = !empty($homesetting['top_banner_jpg'] || $homesetting['top_banner_webp']) ? base_url('uploads/') . imgExtension($homesetting['top_banner_jpg'],$homesetting['top_banner_webp']) : ""; 
  $midbanner = !empty($homesetting['mid_banner_jpg'] || $homesetting['mid_banner_webp']) ? base_url('uploads/') . imgExtension($homesetting['mid_banner_jpg'],$homesetting['mid_banner_webp']) : ""; 
  $bottombanner = !empty($homesetting['bottom_banner_jpg'] || $homesetting['bottom_banner_webp']) ? base_url('uploads/') . imgExtension($homesetting['bottom_banner_jpg'],$homesetting['bottom_banner_webp']) : ""; 
  ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-7 order-mbl-2 pl-0 pr-0">
      <section class="homeslider pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="site_hdng">
          <!--<h1><?=!empty($homesetting['top_heading'])?$homesetting['top_heading']:""?></h1>-->
          <h1><span>Book A City Taxi </span> To Your Destination</h1>
          <p class="sub_hdng"> <?=!empty($homesetting['top_sub_heading'])?$homesetting['top_sub_heading']:""?></p>
        </div>
      </section>
      <?php if(!empty($topbanner)){?>
      <div class="homebnr_slider">
        <img src="<?=$topbanner?>">
      </div>
      <?php } ?>
      <?php if(!empty($cab_packages)){?>
      <section class="pt-4 pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="norml_hdng hdng_btn d-flex">
          <h2><?=!empty($homesetting['trending_package_heading'])?$homesetting['trending_package_heading']:""?></h2>
          <a href="<?=base_url('trending-cab-packages')?>" class="viewall">View All</a>
        </div>
        <div class="packg_sldier_sec">
          <div class="packg_slider owl-theme owl-carousel os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
          <?php foreach($cab_packages as $key=>$value){?>
            <?php $packimage = !empty($value['jpg_image'] || $value['webp_image']) ? base_url('uploads/') . imgExtension($value['jpg_image'],$value['webp_image']) : ""; ?>
          <div class="pkg_box">
              <img src="<?=$packimage?>">
              <div class="tourtxt">
                <h6><a href="<?=!empty($value['url'])?base_url($value['url']):'javascript:void(0)'?>"><?=!empty($value['package_title'])?$value['package_title']:''?></a></h6>
                <p><?=!empty($value['short_description'])?$value['short_description'].'....':''?></p>
              </div>
              <div class="d-flex code_btn">
                <h2><?=!empty($value['id'])?'₹'.(int)getMinPrice($value['id']):'';?></h2>
                <a href="<?=!empty($value['url'])?base_url($value['url']):'javascript:void(0)'?>" class="knowmore"> <i class="fa fa-arrow-right"> </i>  </a> 
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </section>
      <?php } ?>
      <section class="about_sec sec_padd pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="norml_hdng">
          <h2><?=!empty($homesetting['about_heading'])?$homesetting['about_heading']:""?> </h2>
          <p class="sub_hdng"><?=!empty($homesetting['about_sub_heading'])?$homesetting['about_sub_heading']:""?></p>
        </div>
        <div class="content abtcontent">
          <?=!empty($about['description'])?substr($about['description'],0,500):""?>
          <div class="morebtn">
            <a href="<?=base_url('about-us')?>" class="readmore"> Know More </a>
          </div>
        </div>
      </section>
      <section class="pt-0 reviewslider sec_padd pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="hdng_btn norml_hdng d-flex">
          <h2><?=!empty($homesetting['taxi_heading'])?$homesetting['taxi_heading']:""?></h2>
          <a href="javascript:void(0)" class="viewall">View All</a>
        </div>
        <div class="revw_sldier_sec">
          <div class="review_sldr owl-theme owl-carousel">
            <div class="taxibox">
              <img src="<?=base_url('assets/frontend/')?>images/cab.png">
              <h3>Ertiga or Similar (6+1)</h3>
              <div class="rating">
                <ul>
                  <li> <i class="fa fa-star"> </i> </li>
                  <li> <i class="fa fa-star"> </i> </li>
                  <li> <i class="fa fa-star"> </i> </li>
                  <li> <i class="fa fa-star"> </i> </li>
                  <li> <i class="fa fa-star"> </i> </li>
                </ul>
              </div>
              <p class="rvw_num">194 Reviews</p>
              <a href="javascript:void(0)" class="sitebtn bgbtn">Book Now</a>
            </div>
          </div>
        </div>
      </section>
      <?php if(!empty($midbanner)){?>
      <section class="os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="fullimg">
          <img src="<?=$midbanner?>">
        </div>
      </section>
      <?php } ?>
      <?php if(!empty($testimonials)){?>
      <section class="reviewslider sec_padd pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="hdng_btn norml_hdng d-flex">
          <h2><?=!empty($homesetting['testimonial_heading'])?$homesetting['testimonial_heading']:""?></h2>
          <a href="<?=base_url('testimonials')?>" class="viewall">View All</a>
        </div>
        <div class="revw_sldier_sec">
          <div class="review_sldr owl-theme owl-carousel">
            <?php foreach($testimonials as $tkey=>$tvalue){?>
            <div class="review_box">
              <div class="rating">
                <?php if(!empty($tvalue['rating'])){?>
                <ul>
                  <?=showRatings($tvalue['rating'])?>
                </ul>
                <?php } ?>
              </div>
              <h5><?=!empty($tvalue['title'])?$tvalue['title']:''?></h5>
              <p class="comment"><?=!empty($tvalue['description'])?$tvalue['description']:''?></p>
              <p class="name"><?=!empty($tvalue['person_name'])?$tvalue['person_name']:''?>, <?=!empty($tvalue['place'])?$tvalue['place']:''?></p>
            </div>
            <?php } ?>
          </div>
        </div>
      </section>
      <?php } ?>
      <?php if(!empty($bottombanner)){?>
      <section class="pb-4 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="fullimg">
          <a href="javascript:void(0)">
          <img src="<?=$bottombanner?>">
          </a>
        </div>
      </section>
      <?php } ?>
      <?=view('frontend/common-faq')?>
    </div>
    <?=view('frontend/trip_form')?>
  </div>
  <?=view('frontend/taxi-rental')?>
</div>