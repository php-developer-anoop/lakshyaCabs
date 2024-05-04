<div class="container-fluid">
  <div class="row">
    <div class="col-sm-7 pl-0 pr-0">
      <section class="cablist sec_padd pl-60 pr-30">
        <div class="norml_hdng">
          <h1><?=!empty($page['h_one_heading'])?$page['h_one_heading']:""?></h1>
        </div>
        <div class="content">
          <?=!empty($page['content_data'])?$page['content_data']:""?>
        </div>
      </section>
      <section class="drivrfeatr sec_padd pl-60 pr-30">
        <div class="norml_hdng">
          <h2>Why Choose Us? </h2>
        </div>
        <?php if(!empty($why_choose)){?>
        <div class="featrs row">
          <?php foreach($why_choose as $key=>$value){?>
          <div class="col-sm-4">
            <div class="ftrbox">
              <h4><?=!empty($value['title'])?$value['title']:""?></h4>
              <p><?=!empty($value['description'])?$value['description']:""?></p>
            </div>
          </div>
          <?php } ?>
        </div>
        <?php } ?>
      </section>
      <?=view('frontend/popular-city-taxi')?>
    </div>
    <div class="col-sm-5 pos-relative p-0">
      <div class="side_booking sidefare">
        <div class="drvr-img">
          <?php $bgimage = !empty($page['banner_image_jpg'] || $page['banner_image_webp']) ? base_url('uploads/') . imgExtension($page['banner_image_jpg'],$page['banner_image_webp']) : ""; ?>
          <img src="<?=$bgimage?>">
        </div>
      </div>
    </div>
  </div>
</div>