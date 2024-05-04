<style>
    .cstmfld_wrap {
        gap: 4px;
    }
</style>
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
                <h4 class="card-hdng"><?=$title?></h4>
                <a href="<?= base_url(ADMINPATH . 'fare-list') ?>" class="sitebtn">View List</a>
            </div>
            <div class="col-xl-12">
              <div class="nav-align-top mb-4">
                <div class="dflexgp">
                    <div class="navhdng">
                        <h2 class="card-hdng">Choose Trip Type</h2>
                    </div>
                    <ul class="nav nav-pills radiolike mb-3" role="tablist">
                        <?php 
                        if(!empty($triptype)){
                            foreach ($triptype as $key => $value) { ?>
                            <a href="<?=base_url(ADMINPATH)?>add-<?=strtolower($value['trip_type'])?>-fare">
                                <li class="nav-item">
                                    <button 
                                    type="button"
                                    class="nav-link <?=empty($value) || ($value['trip_type'] =="Local")?"active":""?> "
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-top-oneway"
                                    aria-controls="navs-pills-top-oneway"
                                    aria-selected="<?=empty($value) || ($value['trip_type'] =="Local")? true : false ?>">
                                    <?=!empty($value['display_name']) ? $value['display_name'] : ""; ?>
                                    </button>
                                </li>
                            </a>
                      <?php    }
                        }
                        ?>
                    </ul>
                </div>
                <div class="tab-content">
                  <div class="tab-pane fade <?=empty($type) || ($type=="Oneway")?"show active":""?>" id="navs-pills-top-oneway" role="tabpanel">
                    <?=form_open(ADMINPATH . 'save-fare-local',['id'=>'Oneway_form']); ?>
                    <?=form_hidden('id',$id)?>
                    <?=form_hidden('trip_type','Local')?>
                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <?=form_label('Select Pickup City','drop_city',['class'=>'col-form-label'])?>
                        <input type="text" name="pickup_city_name" autocomplete="off" onkeyup="getDropCityList(this.value),getPackage('')" value="<?=$pickup_city_name?>"  class="form-control ucwords restrictedInput " required id="pickup_city_name" placeholder="Pickup City Name" />
                        <input type="hidden" name="pickup_city_id" id="pickup_city_id" value="<?=$pickup_city_id?>">
                        <input type="hidden" name="pickup_state_id" id="pickup_state_id" value="<?=$pickup_state_id?>">
                        <ul class="drop-autocomplete-list list-unstyled list-color" id="drop-suggestion-list1" onclick="return selectDropCityNames(),getLocalPackage()"></ul>
                      </div>
                     
                      
                      <div class="col-sm-3">
                        <?=form_label('Select Package','pickup_city',['class'=>'col-form-label'])?>  
                        <select name="package_id" id="package_id" class="form-control select2" onchange="fetchHoursKm(this.value)"  required>
                          <option value="">--Select Package--</option>
                           <?php 
                                if(!empty($localp)){
                                foreach ($localp as $key => $value) { ?>
                                    <option  <?php if( $value['id'] == $package_id ){echo 'selected';}?> value="<?=!empty($value['id']) ? $value['id'] : ""?>"><?=!empty($value['package_name']) ? $value['package_name'] : ""?></option>  
                                <?php  } }?>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-10">
                    <div class="row mb-2 plusminus">
                       <div class="cstmfld_wrap input_field_wrapper1" id="DiskBlock">
                       <div class="custom_fields">
                        <label class="col-form-label">Select Vehicle Model</label>
                            <select name="key[0][model_id]" id="Oneway_model_id0" class="form-control select2" required>
                                <option value="">--Select Vehicle Model--</option>
                                <?php 
                                if(!empty($vmodellist)){
                                foreach ($vmodellist as $key => $value) { ?>
                                    <option <?php if( $value['id'] == $model_id ){echo 'selected';}?> value="<?=!empty($value['id']) ? $value['id'] : ""?>"><?=!empty($value['model_name']) ? $value['model_name'] : ""?></option>  
                                <?php  } }?>
                            </select>
                            </div>
                            <div class="custom_fields">
                            <label class="col-form-label">Base Fare</label>
                            <input type="text" name="key[0][base_fare]" placeholder="Enter fare" class="form-control" value="<?=$base_fare?>">
                            </div>
                            <div class="custom_fields">
                            <label class="col-form-label">Rate per KM</label>
                            <input type="text" name="key[0][per_km_charge]" placeholder="Enter rate" class="form-control" value="<?=$per_km_charge?>">
                            </div>
                            <div class="custom_fields">
                            <label class="col-form-label">Fixed KM</label>
                            <input type="text" name="key[0][base_covered_km]" value="<?=$base_covered_km?>" placeholder="Enter value" class="form-control base_covered_km">
                            </div>
                            <div class="custom_fields">
                            <label class="col-form-label">Fixed Hrs</label>
                            <input type="text" name="key[0][covered_hours]" value="<?=$covered_hours?>" placeholder="Enter covered hours" class="form-control covered_hours">
                            </div>
                            <div class="custom_fields">
                            <label class="col-form-label">Fare per hour</label>
                            <input type="text" name="key[0][per_hour_charge]" value="<?=$per_hour_charge?>" placeholder="Enter value" class="form-control">
                            </div>

                            <div class="custom_fields">
                            <label class="col-form-label">Driver Charge(DA)</label>
                            <input type="text" name="key[0][driver_charge]" placeholder="Enter value" class="form-control" value="<?=$driver_charge?>">
                            </div>
                            <div class="custom_fields">
                            <label class="col-form-label">Night Charge</label>
                            <input type="text" name="key[0][night_charge]" placeholder="Enter value" class="form-control" value="<?=$night_charge?>">
                            </div>
                       </div>
                    </div>
                    </div>
                        <?php if(empty($id)){?>
                    <div class="col-sm-2">
                        <div style="margin-top: 40px;">
                            <a href="javascript:void(0);" id="addBlock" class="add_button1 btn btn-success" title="Add field"><i class="bx bx-plus"></i></a>
                            <a style="display:none" id="removeBlock" href="javascript:void(0);" class="remove_button1 btn btn-danger" title="Remove field"><i class="bx bx-minus"></i></a>
                        </div>
                    </div>
                        <?php } ?>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="cstmfld_wrap ">
                              <div class="custom_fields datefld">
                                  <label class="col-form-label">Night charge from</label>
                                  <input type="text" name="night_charge_from" placeholder="HH:MM" class="form-control timepicker" value="<?=$night_charge_from?>">
                              </div>
                              <div class="custom_fields datefld">
                                  <label class="col-form-label">Night charge to</label>
                                  <input type="text" name="night_charge_till" placeholder="HH:MM" class="form-control timepicker" value="<?=$night_charge_till?>">
                              </div>
                              <div class="custom_fields col-lg-1">
                                  <label class="col-form-label" for="tollCharge" >Toll</label>
                                  <!--<input type="text" name="toll_charge" placeholder="Enter value" class="form-control" value="<?=$toll_charge?>">-->
                                  <input class="form-check-input" name="toll_charge" type="checkbox" value="1" id="tollCharge"  <?=($toll_charge == 1 || $toll_charge == '' ? 'checked' : '');?> >
                              </div>
                              <div class="custom_fields col-lg-2">
                                  <label class="col-form-label" for="parkingCharge" >Parking Charge</label>
                                  <!--<input type="text" name="parking_charge" placeholder="Enter value" class="form-control" value="<?=$parking_charge?>">-->
                                  <input class="form-check-input" name="parking_charge" type="checkbox" value="1" id="parkingCharge"  <?=($parking_charge == 1 || $parking_charge == '' ? 'checked' : '');?> >
                              </div>
                              <div class="custom_fields col-lg-2">
                                  <label class="col-form-label" for="airportParking">Airport Parking </label>
                                  <!--<input type="text" name="airport_parking" placeholder="Enter value" class="form-control" value="<?=$airport_parking?>">-->
                                  <input class="form-check-input" name="airport_parking" type="checkbox" value="1" id="airportParking"  <?=($airport_parking == 1 || $airport_parking == '' ? 'checked' : '');?> >
                              </div>
                              <div class="custom_fields col-lg-1">
                                  <label class="col-form-label" for="stateEntryCharge">State tax </label>
                                  <!--<input type="text" name="state_entry_charge" placeholder="Enter value" class="form-control" value="<?=$state_entry_charge?>">-->
                                  <input class="form-check-input" name="state_entry_charge" type="checkbox" value="1" id="stateEntryCharge"  <?=($state_entry_charge == 1 || $state_entry_charge == '' ? 'checked' : '');?> >
                              </div>
                          </div>
                    </div>
                    
                    <div class="row mb-3 statusbtnrow align-items-end">
                      <div class="col-sm-6">
                        <?=form_label('Status','status',['class'=>'col-form-label'])?>
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
                          <div class="col-6">
                            <div class="form-check cstmchk">
                              <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                              <label class="form-check-label" for="flexCheckChecked">
                                Pay To Driver
                              </label>
                            </div>
                          </div> 
                        </div>
                      </div>
                      <div class="col-sm-6">
                         <div class="dlfexend">
                            <?php if(!empty($access) || ($user_type != "Role User") ){?>
                                  <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                            <?php } ?>
                         </div>
                      </div>
                    </div>
                    <?=form_close();?>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= view( "admin/fares/dropdown"); ?> 
<script>
document.addEventListener('DOMContentLoaded', function() {
  const addBlockBtn = document.getElementById('addBlock');
  const removeBlockBtn = document.getElementById('removeBlock');
  const fieldsContainer = document.querySelector('.plusminus');

  let fieldIndex = 0;

  addBlockBtn.addEventListener('click', function() {
    fieldIndex++;
    const newField = `
      <div class="cstmfld_wrap input_field_wrapper1" id="DiskBlock">
      <div class="custom_fields">
          <label class="col-form-label">Select Vehicle Model</label>
          <select name="key[${fieldIndex}][model_id]" id="Oneway_model_id${fieldIndex}" class="form-control select2" required>
            <option value="">--Select Vehicle Model--</option>
            <?php 
            if(!empty($vmodellist)){
            foreach ($vmodellist as $key => $value) { ?>
                <option value="<?=!empty($value['id']) ? $value['id'] : ""?>"><?=!empty($value['model_name']) ? $value['model_name'] : ""?></option>  
            <?php  } }?>
          </select> 
        </div>
        <div class="custom_fields">
        <label class="col-form-label">Base Fare</label>
        <input type="text" name="key[${fieldIndex}][base_fare]" placeholder="Enter fare" class="form-control" value="">
        </div>
        <div class="custom_fields">
        <label class="col-form-label">Rate per KM</label>
        <input type="text" name="key[${fieldIndex}][per_km_charge]" placeholder="Enter rate" class="form-control" value="">
        </div>
        <div class="custom_fields">
        <label class="col-form-label">Fixed KM</label>
        <input type="text" name="key[${fieldIndex}][base_covered_km]" value="" placeholder="Enter value" class="form-control base_covered_km">
        </div>
        <div class="custom_fields">
        <label class="col-form-label">Fixed Hrs</label>
        <input type="text" name="key[${fieldIndex}][covered_hours]" value="" placeholder="Enter covered hours" class="form-control covered_hours">
        </div>
        <div class="custom_fields">
        <label class="col-form-label">Fare per hour</label>
        <input type="text" name="key[${fieldIndex}][per_hour_charge]" value="" placeholder="Enter value" class="form-control">
        </div>

        <div class="custom_fields">
        <label class="col-form-label">Driver Charge(DA)</label>
        <input type="text" name="key[${fieldIndex}][driver_charge]" placeholder="Enter value" class="form-control" value="">
        </div>
        <div class="custom_fields">
        <label class="col-form-label">Night Charge</label>
        <input type="text" name="key[${fieldIndex}][night_charge]" placeholder="Enter value" class="form-control" value="">
        </div>
      </div>
    `;
    fieldsContainer.insertAdjacentHTML('beforeend', newField);
    // Initialize Select2 for the newly added dropdown
    $('#Oneway_model_id' + fieldIndex).select2();
    if (fieldIndex > 0) {
      removeBlockBtn.style.display = 'inline-block';
    }
  });

  removeBlockBtn.addEventListener('click', function() {
    const lastField = fieldsContainer.lastElementChild;
    if (lastField && lastField.classList.contains('cstmfld_wrap')) {
      fieldsContainer.removeChild(lastField);
      fieldIndex--;
    }
    if (fieldIndex === 0) {
      removeBlockBtn.style.display = 'none';
    }
  });
});


function getLocalPackage(){ 
    var cityName = $('#pickup_city_name').val();
    var package_id = '';
    setTimeout( ()=>{
        alert( cityName ); 
        $.ajax({
        url: '<?=base_url('get-local-package')?>',
        type: 'POST',
        data: { city_name: cityName, package_id: package_id  }, 
        success: function( response ) {
            $('#package_id').html( response );
            $('#package_id').select2();
         }
        });
    },200);
}
</script>