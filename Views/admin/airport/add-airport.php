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
                <h4 class="cardhdng">Add Airport</h4>
                <a href="<?= base_url(ADMINPATH . 'airport-list') ?>" class="sitebtn">View Airport Master</a>
            </div>  
            <?=form_open(ADMINPATH . 'save-airport'); ?>
            <?=form_hidden('id',$id)?>
            <div class="row mb-3">
              
              <div class="col-sm-6">
                <?=form_label('Select City','city',['class'=>'col-form-label'])?>
                <div class="position-relative">
                  <div class="position-absolute end-0 mt-2 pe-2">
                  </div>
                  <input type="text" name="city" autocomplete="off" onkeyup="getCity(this.value)" value="<?=$city_name?>"  class="form-control ucwords restrictedInput" required id="city_name" placeholder="City Name" />
                  </div>
                
                <input type="hidden" name="city_id" id="cityid" value="<?=$city_id?>">
                <ul class="autocomplete-list list-unstyled list-color" id="suggestion-list" onclick="return selectCityName()"></ul>
              </div>
                <div class="col-sm-6">
                <?=form_label('Airport Name','airport_name',['class'=>'col-form-label'])?>
                <input type="text" name="airport_name" autocomplete="off" onkeyup="return checkDuplicate(this.value,'hourly_package','package_name')" value="<?=$airport_name?>"  class="form-control" required id="package_name" placeholder="Airport Name" />
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