<?php if(!empty($testimonials)){?>
<section class="py-4 py-md-5">
  <div class="container">
    <div class="row os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
      <div class="col-md-12">
        <div class="site_hdng mb-3 mb-md-4">
          <h1><?=!empty($page['h_one_heading'])?$page['h_one_heading']:""?></h1>
        </div>
      </div>
    </div>
    <div class="row g-3 g-md-4 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
      <?php foreach($testimonials as $tkey=>$tvalue){?>
      <div class="col-sm-6 col-md-4">
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
      </div>
      <?php  } ?>
    </div>
  </div>
</section>
<?php  } ?>