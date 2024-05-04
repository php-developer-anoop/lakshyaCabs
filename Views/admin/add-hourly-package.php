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
       <!--<a href="<?= base_url(ADMINPATH . 'hourly-package-list') ?>" class="btn btn-success mb-3" style="float:right;position:relative;">View Hourly Packages</a>-->
    </nav>
    <div class="row">
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-body">
            <div class="dflexbtwn hdngvwall">
                <h4 class="cardhdng">Add Hourly Package</h4>
                <a href="<?= base_url(ADMINPATH . 'hourly-package-list') ?>" class="sitebtn">View List</a>
            </div>
            <?=form_open(ADMINPATH . 'save-hourly-package'); ?>
            <?=form_hidden('id',$id)?>
            <div class="row mb-3">
              <div class="col-sm-4">
                <?=form_label('Package Name','package_name',['class'=>'col-form-label'])?>
                <input type="text" name="package_name" autocomplete="off" onkeyup="return checkDuplicate(this.value,'hourly_package','package_name')" value="<?=$package_name?>"  class="form-control" required id="package_name" placeholder="Package Name" />
              </div>
              <div class="col-sm-3">
                <?=form_label('Select City','city',['class'=>'col-form-label'])?>
                <div class="position-relative">
               
                  <div class="position-absolute end-0 mt-2 pe-2">
                  <!-- <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
  <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
</svg> -->
                  </div>
                  <input type="text" name="city" autocomplete="off" onkeyup="getCity(this.value)" value="<?=$city_name?>"  class="form-control ucwords restrictedInput" required id="city_name" placeholder="City Name" />
                  </div>
                
                <input type="hidden" name="city_id" id="cityid" value="<?=$city_id?>">
                <ul class="autocomplete-list list-unstyled list-color" id="suggestion-list" onclick="return selectCityName()"></ul>
              </div>
              <div class="col-sm-2">
                <?=form_label('Covered Hours','covered_hours',['class'=>'col-form-label'])?>
                <?= form_input(['name' => 'covered_hours','autocomplete'=>'off','required' => 'required', 'placeholder' => 'Enter Hours','maxlength'=>'4', 'id' => 'covered_hours', 'class' => 'form-control numbersWithZeroOnlyInput','value'=>$covered_hours]); ?>
              </div>
              <div class="col-sm-2">
                <?=form_label('Covered KM','covered_km',['class'=>'col-form-label'])?>
                <?= form_input(['name' => 'covered_km','autocomplete'=>'off','required' => 'required', 'placeholder' => 'Enter KM','maxlength'=>'4', 'id' => 'covered_km', 'class' => 'form-control numbersWithZeroOnlyInput','value'=>$covered_km]); ?>
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