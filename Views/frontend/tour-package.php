<?php 
  $midbanner = !empty($homesetting['tour_package_mid_banner_jpg'] || $homesetting['tour_package_mid_banner_webp']) ? base_url('uploads/') . imgExtension($homesetting['tour_package_mid_banner_jpg'],$homesetting['tour_package_mid_banner_webp']) : ""; 
  $bottombanner = !empty($homesetting['tour_package_bottom_banner_jpg'] || $homesetting['tour_package_bottom_banner_webp']) ? base_url('uploads/') . imgExtension($homesetting['tour_package_bottom_banner_jpg'],$homesetting['tour_package_bottom_banner_webp']) : ""; 
  ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-7 order-mbl-2 pl-0 pr-0">
      <section class="homeslider pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="site_hdng">
          <!--<h1><?=!empty($page['h1'])?$page['h1']:""?></h1>-->
          <h1><span>Plan an unforgettable</span> Trip From Your City With Lakshya Cabs</h1>
        </div>
      </section>
      <?php $bgimage = !empty($page['banner_image_jpg'] || $page['banner_image_webp']) ? base_url('uploads/') . imgExtension($page['banner_image_jpg'],$page['banner_image_webp']) : ""; ?>
      <div class="homebnr_slider">
        <img src="<?=$bgimage?>">
      </div>
      <?php if(!empty($popular_packages)){?>
      <section class="pt-4 pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="norml_hdng hdng_btn d-flex">
          <h2>Popular Tour Packages</h2>
          <a href="<?=base_url('popular-tour-packages')?>" class="viewall">View All</a>
        </div>
        <div class="packg_sldier_sec">
          <div class="packg_slider owl-theme owl-carousel os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
            <?php foreach($popular_packages as $ppkey=>$ppvalue){
              $pack_image = !empty($ppvalue['jpg_image'] || $ppvalue['webp_image']) ? base_url('uploads/') . imgExtension($ppvalue['jpg_image'],$ppvalue['webp_image']) : "";
              ?>  
            <div class="pkg_box">
              <img src="<?=$pack_image?>" alt="<?=!empty($ppvalue['image_alt'])?$ppvalue['image_alt']:""?>">
              <div class="tourtxt">
                <h6><a href="<?=!empty($ppvalue['url'])?base_url($ppvalue['url']):'javascript:void(0)'?>" ><?=!empty($ppvalue['package_title'])?$ppvalue['package_title']:""?></a></h6>
                <p><?=!empty($ppvalue['no_of_days_nights'])?$ppvalue['no_of_days_nights'].' Tour Package':""?></p>
                <div class="ratng_btns d-flex align-items-center">
                  <?php $discount='';
                    $discount=(($ppvalue['mrp_price']-$ppvalue['offer_price'])/$ppvalue['mrp_price'])*100;
                    
                    ?>
                  <?php if(!empty($discount)){?>
                  <span class="btnylw">Flat <?=round($discount)?>% OFF</span>
                  <?php } ?>
                  <?php $c_id=!empty($ppvalue['package_category_ids'])?explode(',',$ppvalue['package_category_ids']):[];
                    $cat_name='';
                    if(!empty($c_id[0])){
                      $cat_name=getCategoryName($c_id[0]);
                    ?>
                  <span class="btnlblue"><?=$cat_name?></span>
                  <?php } ?>
                </div>
              </div>
              <div class="d-flex code_btn">
                <?php if(!empty($ppvalue['offer_price'])){?>
                <p class="code">₹<?=(int)$ppvalue['offer_price']?> <span>per person</span></p>
                <?php } else { ?>
                <p class="code">₹<?=(int)$ppvalue['mrp_price']?> <span>per person</span></p>
                <?php } ?>
                <a href="<?=!empty($ppvalue['url'])?base_url($ppvalue['url']):'javascript:void(0)'?>" class="knowmore"> <i class="fa fa-arrow-right"> </i>  </a> 
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </section>
      <?php } ?>
      <section class="about_sec sec_padd pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="content intro-text" id="introTextWrap">
          <?=!empty($page['content_data'])?$page['content_data']:""?>
        </div>
        <div class="morebtn">
          <a href="javascript:void(0)" id="introTextBtn" class="readmore tbtn"> Read More </a>
        </div>
      </section>
      <?php if(!empty($popular_category)){?>
      <section class="pt-0 reviewslider sec_padd pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="hdng_btn norml_hdng d-flex">
          <h2>Popular Trip Categories</h2>
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
      <?php if(!empty($special_category)){?>
      <section class="pt-4 pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="norml_hdng hdng_btn d-flex">
          <h2>Speciality Tour</h2>
          <a href="<?=base_url('speciality-tour')?>" class="viewall">View All</a>
        </div>
        <div class="speclt_tour_sec">
          <div class="row">
            <ul class="spt_tabs d-flex">
              <?php foreach($special_category as $sckey=>$scvalue){?>
              <li><a href="javascript:void(0)" onclick="getSpecialPacks(<?=$scvalue['id']?>)" id="currentpack_<?=$scvalue['id']?>" class="sptab_btn package_page_count <?=$sckey==0?'active':''?>"><?=$scvalue['category_name']?></a></li>
              <?php } ?>
            </ul>
          </div>
          <div class="row sp-tour" data-os-animation="fadeInUp" data-os-animation-delay="0.5s" id="append_packs">
            <?php if(!empty(!empty($special_packages))){foreach($special_packages as $spkey=>$spvalue){
              $special_pack_image = !empty($spvalue['jpg_image'] || $spvalue['webp_image']) ? base_url('uploads/') . imgExtension($spvalue['jpg_image'],$spvalue['webp_image']) : "";            
              ?>
            <div class="col-sm-4" >
              <div class="tour_box">
                <img src="<?=$special_pack_image?>">
                <div class="tourtxt">
                  <h6><a href="<?=!empty($spvalue['url'])?base_url($spvalue['url']):"javascript:void(0)"?>"><?=!empty($spvalue['package_title'])?$spvalue['package_title']:""?></a></h6>
                  <p><?=!empty($spvalue['no_of_days_nights'])?$spvalue['no_of_days_nights']:""?></p>
                  <div class="ratng_btns d-flex align-items-center">
                    <div class="rating">
                      <?php if(!empty($spvalue['rating'])){?>
                      <ul>
                        <?=showRatings($spvalue['rating'])?>
                      </ul>
                      <?php } ?>
                    </div>
                    <?php $sdiscount='';
                      $sdiscount=(($spvalue['mrp_price']-$spvalue['offer_price'])/$spvalue['mrp_price'])*100;
                      
                      ?>
                    <?php if(!empty($sdiscount)){?>
                    <span class="btnylw">Flat <?=round($discount)?>% OFF</span>
                    <?php } ?>
                    <?php $c_id=!empty($spvalue['package_category_ids'])?explode(',',$spvalue['package_category_ids']):[];
                      $cat_name='';
                      if(!empty($c_id[0])){
                        $cat_name=getCategoryName($c_id[0]);
                      ?>
                    <span class="btnlblue"><?=$cat_name?></span>
                    <?php } ?>
                  </div>
                  <div class="trbtn">
                    <a href="<?=!empty($spvalue['url'])?base_url($spvalue['url']):"javascript:void(0)"?>" class="pkgbtn">View Package</a>
                  </div>
                </div>
              </div>
            </div>
            <?php }} ?>
          </div>
        </div>
      </section>
      <?php } ?>
      <?php if(!empty($midbanner)){?>
      <section class="os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="fullimg">
          <img src="<?=$midbanner?>">
        </div>
      </section>
      <?php } ?>
      <section class="pt-4 pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="norml_hdng hdng_btn d-flex">
          <h2>All Inclusive tour</h2>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="ftrbx">
              <div class="ftrimg">
                <img src="<?=base_url('assets/frontend/')?>images/ti1.png">
              </div>
              <div class="ftrtxt">
                <h4>Accomodation</h4>
                <p>Comfortable & convenient hotels cherry picked by our hotel management team</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="ftrbx">
              <div class="ftrimg">
                <img src="<?=base_url('assets/frontend/')?>images/ti2.png">
              </div>
              <div class="ftrtxt">
                <h4>Tour Transport</h4>
                <p>Comfortable & convenient hotels cherry picked by our hotel management team</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="ftrbx">
              <div class="ftrimg">
                <img src="<?=base_url('assets/frontend/')?>images/ti3.png">
              </div>
              <div class="ftrtxt">
                <h4>Dedicated Support</h4>
                <p>Comfortable & convenient hotels cherry picked by our hotel management team</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="ftrbx">
              <div class="ftrimg">
                <img src="<?=base_url('assets/frontend/')?>images/ti4.png">
              </div>
              <div class="ftrtxt">
                <h4>Best value itinerary</h4>
                <p>Comfortable & convenient hotels cherry picked by our hotel management team</p>
              </div>
            </div>
          </div>
        </div>
      </section>
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
      <?php if(!empty($testimonials)){?>
      <section class="reviewslider sec_padd pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="hdng_btn norml_hdng d-flex">
          <h2>Why People Love Us</h2>
          <a href="<?=base_url('testimonials')?>" class="viewall">View All</a>
        </div>
        <div class="revw_sldier_sec">
          <div class="img_review_sldr owl-theme owl-carousel">
            <?php foreach($testimonials as $tkey=>$tvalue){
              $testimage = !empty($tvalue['jpg_image'] || $tvalue['webp_image']) ? base_url('uploads/') . imgExtension($tvalue['jpg_image'],$tvalue['webp_image']) : "";          
              ?>
            <div class="img_review_box">
              <div class="rvw_imgs">
                <div class="imgss">
                  <img src="<?=$testimage?>">
                </div>
              </div>
              <div class="imgrvwtext">
                <div class="rating">
                  <?php if(!empty($tvalue['rating'])){?>
                  <ul>
                    <?=showRatings($tvalue['rating'])?>
                  </ul>
                  <?php } ?>
                  <p class="name"><?=!empty($tvalue['person_name'])?$tvalue['person_name']:""?>, <?=!empty($tvalue['place'])?$tvalue['place']:""?></p>
                </div>
                <p class="comment"><?=!empty($tvalue['description'])?$tvalue['description']:""?></p>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </section>
      <?php } ?>
      <section class="pb-4 os-animation bgdblue" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="row pl-60 pr-30 align-items-center bgmapimg pos-relative">
          <div class="col-sm-3">
            <img src="<?=$bottombanner?>">
          </div>
          <div class="col-sm-9">
            <div class="prfttext">
              <span>WE ARE AVAILABLE 24*7</span>
              <h2>We’ll plan a perfect holiday for you</h2>
              <div class="d-flex optns">
                <div class="optnitem">
                  <a href="<?=base_url('contact-us')?>">
                    <img src="<?=base_url('assets/frontend/')?>images/cstm.png">
                    <p>Customize</p>
                  </a>
                </div>
                <div class="optnitem">
                  <a href="<?=base_url('contact-us')?>">
                    <img src="<?=base_url('assets/frontend/')?>images/exprt.png">
                    <p>Ask Expert</p>
                  </a>
                </div>
                <div class="optnitem">
                  <a href="<?=base_url('contact-us')?>">
                    <img src="<?=base_url('assets/frontend/')?>images/chat.png">
                    <p>Chat with us</p>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <?=view('frontend/common-faq')?>
    </div>
    <?=view('frontend/trip_form')?>
  </div>
  <?=view('frontend/taxi-rental')?>
</div>
<script>
  function getSpecialPacks(category_id){
    $('#append_packs').html('');
    $('.package_page_count').removeClass('active', true );
    $('#currentpack_'+category_id ).addClass('active', true);
    $.ajax({
       url: "<?=base_url('getSpecialPacks')?>",
       data: {category_id:category_id},
       cache: false,
       method: 'POST',
       success: function(html) {
           $('#append_packs').html(html);
           
       }
   });

  }
</script>