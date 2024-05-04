
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-7 order-mbl-2 pl-0 pr-0">
      <div class="brdcrumb pl-60 pr-30">
        <ul>
          <li><a href="<?=base_url()?>"> Home </a></li>
          <li class="current"> <?=$result = !empty($page['package_name']) ? '/ ' . $page['package_name'] : (!empty($page['destination']) ? '/ ' . $page['destination'] : (!empty($page['route_name']) ? '/ ' . $page['route_name'] : (!empty($page['page_name']) ? '/ ' . $page['page_name'] : '')));?></li>
        </ul>
      </div>
      <section class="about_sec sec_padd pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
        <div class="norml_hdng <?=!empty($none)?$none:''?>">
          <h1><?=!empty($page['package_title'])?$page['package_title']: (!empty($page['route_title']) ? ($page['route_title']) : (!empty($page['page_name']) ? $page['page_name'] : ''))?></h1>
          <div class="tourbrf d-flex align-items-center">           
            <?php  if(!empty($page['destination_ids'])){?>
            <span><i class="fa fa-location-dot"></i><?php $explode = explode(',', $page['destination_ids']);
              foreach ($explode as $key => $value) {
              $destination = getDestinationName($value);
              $dest = explode(',', $destination);
              $destination_list[] = $dest[0];
              }
              echo implode(' | ', $destination_list);?></span>
            <?php } ?>
          </div>
        </div>
        <?php $bgimage = !empty($page['banner_image_jpg'] || $page['banner_image_webp']) ? base_url('uploads/') . imgExtension($page['banner_image_jpg'],$page['banner_image_webp']) : ""; ?>
        <div class="content">
          <div class="pk_img">
            <img src="<?=$bgimage?>">
          </div>
          <?php if(!empty($tariff_list)){?>
          <div class="pkgbrdprice d-flex align-items-center justify-content-between <?=!empty($none)?$none:''?>">
            <div class="pkleft">
              <h4>Book A Cab At </h4>
              <span>*Exclusive of all taxes</span>
            </div>
            <div class="pkright">
              <h6 class="cutprice"> </h6>
              <?php //!empty($page['mrp_price'])?'₹ '.(int)$page['mrp_price']:''?>
             
              <h3>
    <?php if (!empty($tariff_list) && isset($tariff_list[0]['min_charge'])): ?>
        <?= '₹ ' . (int)$tariff_list[0]['min_charge'] ?>
    <?php endif; ?>

    <?php if (!empty($cab)): ?>
        <span class="<?= $cab ?>">per person*</span>
    <?php else: ?>
        <br><span><?= !empty($tariff_list) && isset($tariff_list[0]['trip_type']) ? 'For ' . $tariff_list[0]['trip_type'] . ' Taxi' : '' ?></span>
    <?php endif; ?>
</h3>

            </div>
          </div>
          <?php } ?>
          <div class="content intro-text" id="introTextWrap">
           <?= !empty($page['description']) ? $page['description'] : (!empty($page['content_data']) ? $page['content_data'] : "") ?>
          </div>
          <div class="morebtn">
            <a href="javascript:void(0)" id="introTextBtn" class="readmore tbtn"> Read More </a>
          </div>
        </div>
        
        <?php if(!empty($page['itenary_description'])){ ?>
        <div class="content-container pt-2">
          <?=$page['itenary_description']?>
        </div>
        <?php } ?>
        <?php if(!empty($page['itenary_terms_conditions'])){ ?>
        <div class="content-container pt-2">
          <?=$page['itenary_terms_conditions']?>
        </div>
        <?php } ?>
        <?php if(!empty($page['cancellation_policy'])){ ?>
        <div class="content-container pt-2">
          <?=$page['cancellation_policy']?>
        </div>
        <?php } ?>
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
                <th scope="col">Trip Type</th>
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
                <td><?=($trvalue['trip_type'])?></td>
              </tr>
             <?php } ?>
            </tbody>
          </table>
        </div>
      </section>
      <?php } ?>
      </section>
      <?=view('frontend/common-section')?>
    </div>
    <?php if(isset($page['page_type']) &&  $page['page_type']=="route"){
          ?>
          <?=view('frontend/trip_form')?>
          <?php }else{ ?>
    <div class="col-sm-5 order-mbl-1 pos-relative p-0 ">
      <div class="side_booking grad_grn">
        <div class="searchsoftware p0 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
          <div class="pkgbookhdr <?=!empty($none)?$none:''?>">
            <h6 class="cutprice"><?=!empty($page['mrp_price'])?'₹ '.(int)$page['mrp_price']:''?></h6>
            <h3><?=!empty($page['offer_price'])?'₹ '.(int)$page['offer_price']:''?><span class="<?=!empty($cab)?$cab:''?>">per person*</span></h3>
            <p><i class="fa-solid fa-check"></i> Inclusive all taxes</p>
            <?php $discount = '';
              if (!empty($page['mrp_price']) && !empty($page['offer_price']) && $page['mrp_price'] != 0) {
                  $discount = (($page['mrp_price'] - $page['offer_price']) / $page['mrp_price']) * 100;
              }
              
                            
                            ?>
            <?php if(!empty($discount)){?>
            <span class="off"><?=round($discount)?>% OFF</span>
            <?php } ?>
          </div>
          
          <div class="tab-content p23" id="innrtab_content">
            <div class="tab-pane fade show active" id="oneway-tab-pane1" role="tabpanel" aria-labelledby="oneway-tab1" tabindex="0">
              <div class="formcontainer">
                <form>
                  <?php $captua_token = random_alphanumeric_string(6); ?>
                  <input type="hidden" id="csrf" class="csrf" name="csrf_token" value="<?= $captua_token ?>">
                  <div class="row">
                    <div class="fieldwrap col-sm-12 mb-3">
                      <input type="text" class="form-control ucwords restrictedInput" required autocomplete="off" id="pickup_location" value="<?=!empty($page['from_city']) ? $page['from_city'] : (!empty($page['from_city_id']) ? getCityStateName($page['from_city_id']) : "");?>" placeholder="Pick Up Location">
                      <img src="<?=base_url('assets/frontend/')?>images/fi1.png">
                    </div>
                    <div class="fieldwrap col-sm-12 mb-3">
                      <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">+91</span>
                        <input type="text" class="form-control notzero numbersWithZeroOnlyInput" required autocomplete="off" maxlength="10" id="phone" placeholder="Enter Mobile number" aria-label="Username" aria-describedby="basic-addon1">
                        <img src="<?=base_url('assets/frontend/')?>images/ci2.png">
                      </div>
                    </div>
                    <div class="fieldwrap col-sm-6 mb-3">
                      <input type="text" class="form-control datepicker"  id="datepicker" required autocomplete="off" placeholder="Select Date">
                      <img src="<?=base_url('assets/frontend/')?>images/fi2.png">
                    </div>
                    <div class="fieldwrap col-sm-6 mb-3">
                      <input type="text" class="form-control timepicker" id="time" required autocomplete="off" placeholder="Select Time">
                      <img src="<?=base_url('assets/frontend/')?>images/fi3.png">
                    </div>
                    <div class="fieldwrap col-sm-6 mb-3">
                      <input type="text" class="form-control notzero numbersWithZeroOnlyInput" maxlength="1" required id="days" autocomplete="off" placeholder="Number of days">
                    </div>
                    <div class="fieldwrap col-sm-6 mb-3">
                      <input type="text" class="form-control notzero numbersWithZeroOnlyInput" id="people" required maxlength="2" autocomplete="off" placeholder="Number of people">
                    </div>
                  </div>
                  <!--<div class="row py-2 px-4">-->
                  <!--  <div class="bgreprat col-lg-5 col-11">-->
                  <!--    <?= $captua_token; ?>-->
                  <!--  </div>-->
                  <!--  <div class="col-lg-2 col-1 py-2 py-lg-1 ps-0 ps-lg-1">-->
                  <!--    <span class="bgreprat-refesh ps-0" style="cursor:pointer;" onclick="getRandomCaptcha()"><img-->
                  <!--      src="<?= base_url('assets') ?>/refresh.png"></span>-->
                  <!--  </div>-->
                  <!--  <div class="col-lg-5 ps-0 ps-lg-1">-->
                  <!--    <div class="form-group">-->
                  <!--      <input type="text" name="match_captcha" maxlength="6" required class="form-control" id="match_captcha"-->
                  <!--        autocomplete="off" placeholder="Enter Captcha" />-->
                  <!--    </div>-->
                  <!--  </div>-->
                  <!--</div>-->
                  <div class="row">
                    <div class="col-sm-12 formbtnrow">
                      <button type="button" id="submit" onclick="return validatePackageForm()" class="form_btn">
                        Book Packages
                        <div class="spinner-border spinner-border-sm text-white" id="loader" role="status">
                          <span class="visually-hidden">Loading...</span>
                        </div>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
  <?php if($route_list){?>
  <div class="row">
    <section class="rental sec_padd pl-60 pr-30">
      <div class="norml_hdng">
        <h2>Route from <?=$page['from_city_name']?> </h2>
      </div>
      <div class="row">
        <?php foreach($route_list as $rlkey=>$rlvalue){?>
        <div class="col-sm-2 rentalcities">
          <a href="<?=base_url($rlvalue['page_slug'])?>"><?=ucfirst(strtolower($rlvalue['to_city_name']))?></a>
        </div>
        <?php } ?>
      </div>
    </section>
  </div>
  <?php } ?>
  
</div>
<script>
  $('#loader').hide();
  function validatePackageForm(){
   var pickup_location = $('#pickup_location').val();
   var phone =$('#phone').val();
   var csrf= $('#csrf').val();
   var date = $('#datepicker').val();
   var time = $('#time').val();
   var days = $('#days').val();
   var people = $('#people').val();
   var match_captcha= $('#match_captcha').val();
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   if (pickup_location=="") {
     toastr.error("Please Enter Pickup Location");
     return false;
   } else if (phone == "") {
     toastr.error("Please Enter Phone");
     return false;
   } else if (phone.length < 10) {
     toastr.error("Please Enter A Valid Phone Number");
     return false;
   } else if (datepicker == "") {
     toastr.error("Please Select Date");
     return false;
   } else if (time == "") {
     toastr.error("Please Select Time");
     return false;
   } else if (days == "") {
     toastr.error("Please Enter Days");
     return false;
   } else if (people == "") {
     toastr.error("Please Enter No. of People");
     return false;
   }else if (match_captcha == "") {
     toastr.error("Please Enter Captcha");
     return false;
   } else if (match_captcha !== csrf) {
     toastr.error("Captcha Not Match");
     return false;
   } else {
         $.ajax({
           url: '<?= base_url('save-pack-form') ?>',
           type: 'POST',
           data: {
             'pickup_location': pickup_location,
             'phone': phone,
             'match_captcha':match_captcha,
             'csrf':csrf,
             'date':date,
             'time':time,
             'days':days,
             'people':people,
           },
           cache: false,
           dataType: "json",
           beforeSend: function () {
        $('#submit').prop('disabled', true);
        $('#loader').show();
        toastr.warning('Please wait! The form is being submitted.');
    },
           success: function(response) {
             if (response.status === false) {
              $('#submit').prop('disabled', false);
               toastr.error(response.message);
             } else if (response.status === true) {
               toastr.success(response.message);
               setTimeout(function() {
              window.location.reload();
              }, 500);
             }
           },
           error: function() {
             console.log('Error occurred during AJAX request');
           }
         });
   }
  }
</script>