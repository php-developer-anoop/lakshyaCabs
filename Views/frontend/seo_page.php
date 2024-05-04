<div class="container-fluid">
  <div class="row">
    <div class="col-sm-7 pl-0 pr-0">
      <section class="contact_sec sec_padd pl-60 pr-30">
        <div class="norml_hdng">
          <h1><?=!empty($page['h_one_heading'])?$page['h_one_heading']:''?></h1>
        </div>
        <div class="content">
          <?php if(!empty($tab_list)){?>
          <div class="routes_tabs">
            <ul class="nav" id="myTab" role="tablist">
              <?php foreach($tab_list as $tlkey=>$tlvalue){?>
              <li class="nav-item " role="presentation">
                <a class="nav-link <?=$page['cms_tab_id']==$tlvalue['cms_tab_id']?"active":''?>" href="<?=!empty($tlvalue['page_slug'])?base_url($tlvalue['page_slug']):'javascript:void(0)';?>"><?=str_replace('{City}',$page['from_city_name'],$tlvalue['cms_tab_name'])?></a>
              </li>
              <?php } ?>
            </ul>
          </div>
          <?php } ?>
          <?php $bgimage = !empty($page['banner_image_jpg'] || $page['banner_image_webp']) ? base_url('uploads/') . imgExtension($page['banner_image_jpg'],$page['banner_image_webp']) : ""; ?>
          <div class="content_img mb-3">
            <img src="<?=$bgimage?>">
          </div>
          <div class="content_text">
            <?=!empty($page['content_data'])?$page['content_data']:''?>
          </div>
        </div>
        <div class="cablist" id="cablist">
        </div>
      </section>
      <?php if(!empty($tariff_list)){?>
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
                <?php foreach($tariff_list as $trkey=>$trvalue){?>
              <tr>
                <td><?=getModel($trvalue['model_id'])?></td>
                <td><?=($page['from_city_name'])?></td>
                <td><?=((int)$trvalue['per_km_charge'])?> INR/KM</td>
                <td><?=(int)($trvalue['base_covered_km']*$trvalue['per_km_charge'])?> INR</td>
                <td><?=((int)$trvalue['base_covered_km'])?> KM</td>
              </tr>
             <?php } ?>
            </tbody>
          </table>
        </div>
      </section>
      <?php } ?>
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
          <a href="javascript:void(0)">
          <img src="<?=base_url('assets/frontend/')?>images/driverbnr.png">
          </a>
        </div>
      </section>
      <?php if(!empty($oneway_cab_list)){?>
      <section class="cabsfrom pl-60 pb-4 pr-30 os-animation fadeInUp" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="norml_hdng">
          <h2>Cabs from <?=!empty($page['from_city_name'])?$page['from_city_name']:''?></h2>
        </div>
        <div class="row">
          <?php foreach($oneway_cab_list as $oclkey=>$oclvalue){?>
          <div class="col-sm-4">
            <a href="<?=!empty($oclvalue['page_slug'])?base_url($oclvalue['page_slug']):'javascript:void(0)'?>"><?=$oclvalue['page_name']?> </a>
          </div>
          <?php } ?>
        </div>
      </section>
      <?php } ?>
      <?php if (!empty($faqs)) { ?>
      <section class="faqs sec_padd pl-60 pr-30">
        <div class="hdng_btn d-flex">
          <div class="norml_hdng">
            <h2>FAQs <?= !empty($page['from_city_name']) ? 'on '.$page['from_city_name'] . ' Cab Service' : 'Cab Service' ?></h2>
          </div>
        </div>
        <div class="faqs_txt">
          <div class="accordion" id="accordionExample">
            <?php $i = 1; foreach ($faqs as $fkey => $fvalue) { ?>
            <div class="accordion-item faqs_column">
              <h2 class="accordion-header <?= ($i !== 1) ? 'collapsed' : '' ?>" id="heading<?= $i ?>">
                <button class="accordion-button faq_qstn" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapse<?= $i ?>"
                  aria-expanded="<?= ($i === 1) ? 'true' : 'false' ?>"
                  aria-controls="collapse<?= $i ?>">
                <?= $i ?>- <?= $fvalue['question'] ?>
                </button>
              </h2>
              <div id="collapse<?= $i ?>"
                class="accordion-collapse <?= ($i !== 1) ? 'collapse' : 'show' ?>"
                aria-labelledby="heading<?= $i ?>" data-bs-parent="#accordionExample">
                <div class="accordion-body faq_answr">
                  <p><?= $fvalue['answer'] ?></p>
                </div>
              </div>
            </div>
            <?php $i++;
              } ?>
          </div>
        </div>
      </section>
      <?php } ?>
    </div>
    <?=view('frontend/trip_form')?>
  </div>
  <?php if($route_list){?>
  <div class="row">
    <section class="rental sec_padd pl-60 pr-30">
      <div class="norml_hdng">
        <h2>Routes from <?=$page['from_city_name']?> </h2>
      </div>
      <div class="row">
        <?php foreach($route_list as $rlkey=>$rlvalue){?>
        <div class="col-sm-3 rentalcities">
          <a href="<?=base_url($rlvalue['page_slug'])?>"><?=ucwords(strtolower($rlvalue['page_name']))?></a>
        </div>
        <?php } ?>
      </div>
    </section>
  </div>
  <?php } ?>
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
<script>
var SearchData, SearchPayload;
$(document).ready(function(){
    $('#cablist').html('');
    $.ajax({
        url: '<?= base_url('getSeoPackages') ?>',
        type: 'POST',
        dataType:'json',
        data: {
            'trip_type': '<?=$trip_type?>',
            'trip_mode': '',
            'pickup_city': '<?=$pickup_city?>',
            'drop_city' : '<?=$trip_type=="Outstation"?$pickup_city:''?>',
            'route_list' : '',
            'pickup_date_time' : '<?=date('Y-m-d H:i:s', strtotime('+150 minutes'))?>',
            'return_date_time' : '<?=$trip_type=="Outstation"?date('Y-m-d H:i:s', strtotime('+2 days')):''?>',
            'local_package' : '<?=$trip_type=="Local"?$local_package:''?>',
            'app_type' : 'web'
        },
        cache: false,
        success: function (response) {
            
            if(response){
                $('#cablist').html(response.html);
                SearchData = response.list_data;
                localStorage.setItem("searchData",(SearchData));
            }
        }
    });
}); 



</script>
<?php echo view('frontend/includes/fare_summary')?>