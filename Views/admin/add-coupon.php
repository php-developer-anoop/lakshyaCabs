<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="d-flex flex-row justify-content-between ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="javascript:void(0);">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="javascript:void(0);"><?=$menu?></a>
        </li>
        <li class="breadcrumb-item active"><?=$title?></li>
      </ol>
    </nav>
    <div class="row">
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-body">
            <div class="dflexbtwn hdngvwall">
              <h4 class="cardhdng">Add Coupon</h4>
              <a href="<?= base_url(ADMINPATH . 'coupon-list') ?>" class="sitebtn">View List</a>
            </div>
            <?=form_open(ADMINPATH . 'save-coupon'); ?>
            <?=form_hidden('id',$id)?>
            <div class="row mb-3">
              <div class="col-lg-3">
                <?=form_label('Package Name','package_name',['class'=>'col-form-label'])?>
                <select name="trip_type" class="form-control select2">
                  <option value="">Select Trip Type</option>
                  <option value="Local" <?=!empty($trip_type) && ($trip_type=="Local") ? "selected" :""?>>Local</option>
                  <option value="Oneway" <?=!empty($trip_type) && ($trip_type=="Oneway") ? "selected" :""?>>Oneway</option>
                  <option value="Outstation" <?=!empty($trip_type) && ($trip_type=="Outstation") ? "selected" :""?>>Outstation</option>
                  <option value="Airport" <?=!empty($trip_type) && ($trip_type=="Airport") ? "selected" :""?>>Airport</option>
                </select>
              </div>
              <div class="col-lg-3">
                <?=form_label('Select State','state_id',['class'=>'col-form-label'])?>
                <select name="state_id" class="form-control select2" required>
                  <option value="">Select State</option>
                  <?php if(!empty($state_list)){foreach($state_list as $slkey=>$slvalue){?>
                  <option value="<?=$slvalue['id']?>" <?=!empty($state_id) && ($state_id==$slvalue['id']) ? "selected" :""?>><?=$slvalue['state_name']?></option>
                    <?php }} ?>
                </select>
              </div>
              <div class="col-lg-3">
                <?=form_label('Select City','city',['class'=>'col-form-label'])?>
                <div class="position-relative">
                  <div class="position-absolute end-0 mt-2 pe-2">
                  </div>
                  <input type="text" name="city" autocomplete="off" onkeyup="getCity(this.value)" value="<?=$city_name?>"  class="form-control ucwords restrictedInput" id="city_name" placeholder="City Name" />
                </div>
                <input type="hidden" name="city_id" id="cityid" value="<?=$city_id?>">
                <ul class="autocomplete-list list-unstyled list-color" id="suggestion-list" onclick="return selectCityName()"></ul>
              </div>
              <div class="col-lg-3">
                <?=form_label('Coupon Type','coupon_type',['class'=>'col-form-label'])?>
                 <select name="coupon_type" class="form-control select2" onchange="return showMaxDisc(this.value)">
                     <option value="">Select Coupon Type</option>
                     <option value="fix" <?=!empty($coupon_type) && ($coupon_type=="fix") ? "selected" :""?>>Fixed</option>
                     <option value="percent" <?=!empty($coupon_type) && ($coupon_type=="percent") ? "selected" :""?>>Percent</option>
                 </select> 
              </div>
              <div class="col-lg-3 position-relative">
                <?=form_label('Valid From','from_date',['class'=>'col-form-label'])?>
                <input type="date" name="valid_from" id="from_date" onchange="validate_to()" class="form-control" max="" value="<?=$valid_from?>" />
              </div>
              <div class="col-lg-3 position-relative">
                <?=form_label('Valid Till','to_date',['class'=>'col-form-label'])?>
                <input type="date" name="valid_till" id="to_date" onchange="validate_from()" class="form-control"  min=""  value="<?=$valid_till?>" >
              </div>
              <div class="col-lg-3">
                <?=form_label('Coupon Code','coupon_code',['class'=>'col-form-label'])?>
                  <input type="text" name="coupon_code" autocomplete="off" value="<?=$coupon_code?>"  class="form-control" required id="coupon_code" placeholder="Coupon Code" />
              </div>
              <div class="col-lg-3">
                <?=form_label('Coupon Value','coupon_value',['class'=>'col-form-label'])?>
                  <input type="text" name="coupon_value" autocomplete="off" value="<?=$coupon_value?>"  class="form-control numbersWithZeroOnlyInput" required id="coupon_value" placeholder="Coupon Value" />
              </div>
              

              <div class="col-lg-6">
                <?=form_label('Title','title_name',['class'=>'col-form-label'])?>
                  <input type="text" name="title_name" autocomplete="off" value="<?=$title_name?>"  class="form-control" required id="title_name" placeholder="Title"  />
              </div>
              <div class="col-lg-6">
                <?=form_label('Description','description',['class'=>'col-form-label'])?>
                  <input type="text" name="description" autocomplete="off" value="<?=$description?>"  class="form-control" required id="" placeholder="Description"  />
              </div>
              <div class="col-lg-3">
                <?=form_label('Minimum Cart Value','minimum_cart_value',['class'=>'col-form-label'])?>
                  <input type="text" name="minimum_cart_value" autocomplete="off" value="<?=$minimum_cart_value?>"  class="form-control numbersWithZeroOnlyInput" required id="minimum_cart_value" placeholder="Minimum Cart Value"   />
              </div>
              <div class="col-lg-3 d-none" id="maxDisc">
                <?=form_label('Maximum Discount','maximum_discount',['class'=>'col-form-label'])?>
                  <input type="text" name="maximum_discount" autocomplete="off" value="<?=$maximum_discount?>"  class="form-control numbersWithZeroOnlyInput"  id="maximum_discount" placeholder="Maximum Discount"  />
              </div>
            </div>
            <div class="row mb-3">
              <?=form_label('Status','status',['class'=>'col-sm-2 col-form-label'])?>
              <div class="col-sm-6">
                <div class="row mt-2">
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" name="status" <?= ($status == 'Active') ? 'checked' : '' ?> type="radio" id="checkStatus1" value="Active">
                      <?=form_label('Active','checkStatus1',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" name="status" <?= ($status == 'Inactive') ? 'checked' : '' ?> type="radio" id="checkStatus2" value="Inactive">
                      <?=form_label('Inactive','checkStatus2',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-start">
              <?php if(!empty($access) || ($user_type != "Role User") ){?>
              <div class="col-sm-10">
                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
              </div>
              <?php } ?>
            </div>
            <?=form_close()?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    function showMaxDisc(val){
        if(val=="percent"){
            $('#maxDisc').removeClass('d-none');
        }else{
            $('#maxDisc').addClass('d-none');
        }
    }
</script>