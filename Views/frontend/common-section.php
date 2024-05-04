<?php 
  $bottombanner = !empty($homesetting['tour_package_bottom_banner_jpg'] || $homesetting['tour_package_bottom_banner_webp']) ? base_url('uploads/') . imgExtension($homesetting['tour_package_bottom_banner_jpg'],$homesetting['tour_package_bottom_banner_webp']) : ""; 
  ?>
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
            <a href="">
              <img src="<?=base_url('assets/frontend/')?>images/cstm.png">
              <p>Customize</p>
            </a>
          </div>
          <div class="optnitem">
            <a href="">
              <img src="<?=base_url('assets/frontend/')?>images/exprt.png">
              <p>Ask Expert</p>
            </a>
          </div>
          <div class="optnitem">
            <a href="">
              <img src="<?=base_url('assets/frontend/')?>images/chat.png">
              <p>Chat with us</p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php if (!empty($faqs)) { ?>
<section class="faqs sec_padd pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
  <div class="hdng_btn d-flex">
    <div class="norml_hdng">
      <h2>FAQs</h2>
      <!-- <p class="sub_hdng">Outstation Taxi Service in Lucknow | Local cabs in Lucknow Airport</p> -->
    </div>
    
  </div>
  <div class="faqs_txt">
    <?php $i = 1; ?>
    <?php foreach ($faqs as $key => $value) { ?>
    <div class="accordion" id="accordionExample">
      <div class="accordion-item faqs_column">
        <h2 class="accordion-header <?= ($i !== 1) ? 'collapsed' : '' ?>" id="heading<?= $i ?>">
          <button class="accordion-button faq_qstn"  type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>" aria-expanded="true" aria-controls="collapse<?= $i ?>">
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