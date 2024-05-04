<?php
$populartaxis = getPopularTaxi();
if (!empty($populartaxis)) {
?>
  <section class="rental sec_padd pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
    <div class="norml_hdng">
      <h2><?= !empty($homesetting['taxi_rental_heading']) ? $homesetting['taxi_rental_heading'] : "" ?></h2>
      <p class="sub_hdng"><?= !empty($homesetting['taxi_rental_sub_heading']) ? $homesetting['taxi_rental_sub_heading'] : "" ?></p>
    </div>
    <div class="row">
      <?php foreach ($populartaxis as $ptkey => $ptvalue) { ?>
        <div class="col-sm-2">
          <a href="<?= !empty($ptvalue['page_slug']) ? base_url($ptvalue['page_slug']) : 'javascript:void(0)' ?>" class="rentalcities"><?= !empty($ptvalue['from_city_name']) ? $ptvalue['from_city_name'] : '' ?></a>
        </div>
      <?php } ?>
    </div>
  </section>
<?php } ?>
