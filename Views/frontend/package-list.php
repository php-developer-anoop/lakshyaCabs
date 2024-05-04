<?php 
  $midbanner = !empty($homesetting['tour_package_mid_banner_jpg'] || $homesetting['tour_package_mid_banner_webp']) ? base_url('uploads/') . imgExtension($homesetting['tour_package_mid_banner_jpg'],$homesetting['tour_package_mid_banner_webp']) : ""; 
  ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-7 order-mbl-2 pl-0 pr-0">
      <div class="brdcrumb pl-60 pr-30">
        <ul>
          <li><a href="<?=base_url()?>"> Home </a></li>
          <li class="current"> <?=$result = !empty($page['category_name']) ? '/ ' . $page['category_name'] : (!empty($page['page_name']) ? '/ '. $page['page_name'] : '/ '.$page['destination'].' Packages');
            ?></li>
        </ul>
      </div>
      <section class="about_sec sec_padd pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <?php if(!empty($page['category_name'])){?>  
        <div class="norml_hdng">
          <h1><?=!empty($page['category_name'])?$page['category_name']:""?></h1>
        </div>
        <?php } ?>
        <?php if(!empty($page['content_data'])){?>
        <div class="content intro-text" id="introTextWrap">
          <?=!empty($page['content_data'])?$page['content_data']:""?>
        </div>
        <div class="morebtn">
          <a href="javascript:void(0)" id="introTextBtn" class="readmore tbtn"> Read More </a>
        </div>
        <?php } ?>
      </section>
      <?php if(!empty($packages)){?>
      <section class="pt-4 pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="col-sm-12 packglisting">
          <?php foreach($packages as $pckey=>$pcvalue){
            $bgimage = !empty($pcvalue['jpg_image'] || $pcvalue['webp_image']) ? base_url('uploads/') . imgExtension($pcvalue['jpg_image'],$pcvalue['webp_image']) : "";
            		?>
          <div class="packgbox d-flex align-items-center">
            <div class="pimg">
              <img src="<?=$bgimage?>">
            </div>
            <div class="pkgtxt_btns">
              <div class="d-flex pkgtxt_price align-items-center">
                <div class="pkgtxt">
                  <span><?=!empty($pcvalue['no_of_days_nights'])?$pcvalue['no_of_days_nights']:''?></span>
                  <h4><a href="<?=!empty($pcvalue['url'])?base_url($pcvalue['url']):'javascript:void(0)'?>" ><?=!empty($pcvalue['package_title'])?$pcvalue['package_title']:$pcvalue['destination']?></a></h4>
                  <div class="ratng_btns d-flex align-items-center">
                    <span class="btnylw d-none">Flat 21% Off</span>
                    <?php $c_id=!empty($pcvalue['package_category_ids'])?explode(',',$pcvalue['package_category_ids']):[];
                      $cat_name='';
                      if(!empty($c_id[0])){
                        $cat_name=getCategoryName($c_id[0]);
                      ?>
                    <span class="btnlblue"><?=$cat_name?></span>
                    <?php } ?>
                  </div>
                  <p><?=!empty($pcvalue['short_description'])?$pcvalue['short_description'].'...':''?></p>
                </div>
                <div class="tourprc">
                  <?php if(!empty($pcvalue['offer_price'])){?>
                  <p>Starts from</p>
                  <h3><?=!empty($pcvalue['offer_price'])?'₹ '.(int)$pcvalue['offer_price']:''?></h3>
                  <span class="<?=!empty($cab)?$cab:''?>">*per person</span>
                  <?php } ?>
                  <?php  if(!empty($pcvalue['mrp_price'])){ ?>
                  <p class="cutprice"><?=!empty($pcvalue['mrp_price'])?'₹ '.(int)$pcvalue['mrp_price']:''?></p>
                  <?php } ?>
                </div>
              </div>
              <div class="pkgbtns d-flex align-items-center">
                <div class="loct_jorny">
                  <!-- <i class="fa-solid fa-location-dot"></i><span>Delhi(1N) </span><i class="fa-solid fa-arrow-right-long"></i>
                    <span>Manali (2N)</span> -->
                </div>
                <div class="btnswrp">
                  <a href="<?=!empty($pcvalue['url'])?base_url($pcvalue['url']):'javascript:void(0)'?>" class="sitebtn tbtn">View Detail</a>
                  <a href="<?=!empty($pcvalue['url'])?base_url($pcvalue['url']):'javascript:void(0)'?>" class="sitebtn bgbtn">Book Now</a>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </section>
      <?php } ?>
      <?php if(!empty($popular_category)){?>
      <section class="pt-0 reviewslider sec_padd pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="hdng_btn norml_hdng d-flex">
          <h2>Popular Trip</h2>
          <a href="<?=!empty($popular_category[0]['url'])?base_url($popular_category[0]['url']):'javascript:void(0)'?>" class="viewall">View All</a>
        </div>
        <div class="revw_sldier_sec">
          <div class="review_sldr owl-theme owl-carousel">
            <?php foreach($popular_category as $pckey=>$pcvalue){
              $category_image = !empty($pcvalue['jpg_image'] || $pcvalue['webp_image']) ? base_url('uploads/') . imgExtension($pcvalue['jpg_image'],$pcvalue['webp_image']) : "";          
              ?>
            <div class="pop_tripbx">
              <img src="<?=$category_image?>" alt="<?=!empty($pcvalue['image_alt'])?$pcvalue['image_alt']:""?>">
              <a href="<?=!empty($pcvalue['url'])?base_url($pcvalue['url']):'javascript:void(0)'?>">
                <h3><?=!empty($pcvalue['category_name'])?$pcvalue['category_name']:""?></h3>
                <p><?=!empty(getCategoryPackCount($pcvalue['id']))?getCategoryPackCount($pcvalue['id']).'+':'No'?> Packages</p>
              </a>
            </div>
            <?php } ?>
          </div>
        </div>
      </section>
      <?php } ?>
      <?php if(!empty($midbanner)){?>
      <section class="os-animation pb-2 " data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="fullimg">
          <img src="<?=$midbanner?>">
        </div>
      </section>
      <?php } ?>
      <?php if(!empty($popular_destination)){?>
      <section class="pt-4 pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="norml_hdng hdng_btn d-flex">
          <h2>Popular Destinations</h2>
          <a href="<?=base_url('popular-destinations')?>" class="viewall">View All</a>
        </div>
        <div class="row">
          <?php foreach($popular_destination as $pdkey=>$pdvalue){
            $destimage = !empty($pdvalue['jpg_image'] || $pdvalue['webp_image']) ? base_url('uploads/') . imgExtension($pdvalue['jpg_image'],$pdvalue['webp_image']) : "";          
            ?>
          <div class="col-sm-4">
            <a href="<?=!empty($pdvalue['url'])?base_url($pdvalue['url']).'-packages':"javascript:void(0)"?>">
              <div class="destnbox">
                <img src="<?=$destimage?>" alt=<?=!empty($pdvalue['image_alt'])?$pdvalue['image_alt']:""?>>
                <div class="dstxt">
                  <span>Tour Package From</span>
                  <h6><?=!empty($pdvalue['destination'])?$pdvalue['destination']:""?></h6>
                  <p><?=!empty(getDestinationPackCount($pdvalue['id']))?getDestinationPackCount($pdvalue['id']).'+':'No'?> Packages</p>
                </div>
              </div>
            </a>
          </div>
          <?php } ?>
        </div>
      </section>
      <?php } ?>
      <?=view('frontend/common-section')?>
    </div>
    <?=view('frontend/trip_form')?>
  </div>
  <?=view('frontend/taxi-rental')?>
</div>