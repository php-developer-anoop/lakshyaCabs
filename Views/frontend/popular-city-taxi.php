<?php $populartaxis=getPopularTaxi();
  if(!empty($populartaxis)){
  ?>
<section class="rental sec_padd pl-60 pr-30">
  <div class="norml_hdng">
    <h2><?=!empty($homesetting['taxi_rental_heading'])?$homesetting['taxi_rental_heading']:""?> </h2>
    <p class="sub_hdng"><?=!empty($homesetting['taxi_rental_sub_heading'])?$homesetting['taxi_rental_sub_heading']:""?></p>
  </div>
  <div class="row">
    <?php foreach($populartaxis as $ptkey=>$ptvalue){?>
    <div class="col-sm-3">
      <a href="<?=!empty($ptvalue['url'])?base_url($ptvalue['url']):'javascript:void(0)'?>" style="text-decoration:none;"><?=!empty($ptvalue['from_city'])?$ptvalue['from_city']:''?></a>
    </div>
    <?php } ?>
  </div>
</section>
<?php } ?>