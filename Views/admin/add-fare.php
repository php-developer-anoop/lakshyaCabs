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
        <!--<li class="breadcrumb-item active"><?=$title?></li>-->
      </ol>
    </nav>
    <div class="row">
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-body">
            <div class="dflexbtwn hdngvwall">
                <h4 class="card-hdng">Add Fare</h4>
                <a href="<?= base_url(ADMINPATH . 'fare-list') ?>" class="sitebtn">View List</a>
            </div>
            <div class="col-xl-12">
              <div class="nav-align-top mb-4">
                <div class="dflexgp">
                    <div class="navhdng">
                        <h2 class="card-hdng">Choose Trip Type</h2>
                    </div>
                    <ul class="nav nav-pills radiolike mb-3" role="tablist">
                      <li class="nav-item">
                        <button 
                          type="button"
                          class="nav-link <?=empty($type) || ($type=="Oneway")?"active":""?>  <?=!empty($id) && ($type!="Oneway")?"d-none":""?> "
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-pills-top-oneway"
                          aria-controls="navs-pills-top-oneway"
                          aria-selected="true">
                        Oneway
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link <?=!empty($type) && ($type=="Outstation")?"active":""?> <?=!empty($id) && ($type!="Outstation")?"d-none":""?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-pills-top-outstation"
                          aria-controls="navs-pills-top-outstation"
                          aria-selected="false">
                        Roundtrip
                        </button>
                      </li>
                      <!--<li class="nav-item">-->
                      <!--  <button-->
                      <!--    type="button"-->
                      <!--    class="nav-link <?=!empty($type) && ($type=="Outstation")?"active":""?> <?=!empty($id) && ($type!="Outstation")?"d-none":""?>"-->
                      <!--    role="tab"-->
                      <!--    data-bs-toggle="tab"-->
                      <!--    data-bs-target="#navs-pills-top-outstation"-->
                      <!--    aria-controls="navs-pills-top-outstation"-->
                      <!--    aria-selected="false">-->
                      <!--  Outstation-->
                      <!--  </button>-->
                      <!--</li>-->
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link <?=!empty($type) && ($type=="Local")?"active":""?> <?=!empty($id) && ($type!="Local")?"d-none":""?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-pills-top-local"
                          aria-controls="navs-pills-top-local"
                          aria-selected="false">
                        Local
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link <?=!empty($type) && ($type=="Airport")?"active":""?> <?=!empty($id) &&  ($type!="Airport")?"d-none":""?>"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-pills-top-airport"
                          aria-controls="navs-pills-top-airport"
                          aria-selected="false">
                        Airport
                        </button>
                      </li>
                    </ul>
                </div>
                <div class="tab-content">
                  <div class="tab-pane fade <?=empty($type) || ($type=="Oneway")?"show active":""?>" id="navs-pills-top-oneway" role="tabpanel">
                    <?=form_open(ADMINPATH . 'save-fare',['id'=>'Oneway_form']); ?>
                    <?=form_hidden('id',$id)?>
                    <?=form_hidden('trip_type','Oneway')?>
                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <label class="col-form-label">Select State</label>
                        <select name="model_id" id="#" class="form-control select2" required>
                          <option value="">--Select State--</option>
                        </select>
                      </div>
                      <div class="col-sm-3">
                        <?=form_label('Select Vehicle Category','category',['class'=>'col-form-label'])?>
                        <select name="category_id" id="" class="form-control select2" onchange="<?= !empty($id) || ($trip_type != "Oneway") && !empty($oneway_model_id) ? "getModelsName(this.value, " . $oneway_model_id . ", 'Oneway_model_id')" : "getModelsName(this.value,null,'Oneway_model_id')" ?>" required>
                          <option value="">--Select Vehicle Category--</option>
                          <?php if(!empty($vehicle_categories)){foreach($vehicle_categories as $key=>$value){?>
                          <option value="<?=$value['id']?>" <?=!empty($oneway_category_id) && ($oneway_category_id==$value['id'])?"selected":""?>><?=$value['category_name']?></option>
                          <?php }} ?>
                        </select>
                      </div>
                      
                      <div class="col-sm-3">
                        <?=form_label('Select Pickup City','pickup_city',['class'=>'col-form-label'])?>
                        <!--<input type="text" name="pickup_city" autocomplete="off"  value="<?=$oneway_pickup_city_name?>" onkeyup="getPickupCity(this.value,'Oneway_form')" data-form="Oneway_form"  class="form-control ucwords restrictedInput city-input" required id="Oneway_pickup_city_name" placeholder="Pickup City Name" />-->
                        <!--<input type="hidden" name="pickup_city_id" class="pickup-city-id" value="<?=$oneway_pickup_city_id?>">-->
                        <!--<input type="hidden" name="pickup_state_id" class="pickup-state-id" value="<?=$oneway_pickup_state_id?>">-->
                        <!--<ul class="suggestion-list list-unstyled list-color" id="suggestion-list-Oneway_form"></ul>-->
                        <select class="selectpicker" multiple aria-label="Default select example" data-placeholder="Choose Option" data-live-search="true">
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                        </select>
                      </div>
                      <div class="col-sm-3">
                        <?=form_label('Select Drop City','drop_city',['class'=>'col-form-label'])?>
                        <input type="text" name="drop_city" autocomplete="off" onkeyup="getDropCity(this.value)" value="<?=$oneway_drop_city_name?>"  class="form-control ucwords restrictedInput " required id="drop_city_name" placeholder="Drop City Name" />
                        <input type="hidden" name="drop_city_id" id="drop_city_id" value="<?=$oneway_drop_city_id?>">
                        <input type="hidden" name="drop_state_id" id="drop_state_id" value="<?=$oneway_drop_state_id?>">
                        <ul class="drop-autocomplete-list list-unstyled list-color" id="drop-suggestion-list" onclick="return selectDropCityName()"></ul>
                      </div>
                    </div>
                    
                    <!--<div class="row mb-2">-->
                    <!--  <div class="col-sm-3">-->
                    <!--    <?=form_label('Select Vehicle Model','Oneway_model_id',['class'=>'col-form-label'])?>-->
                    <!--    <select name="model_id" id="Oneway_model_id" class="form-control select2" required>-->
                    <!--      <option value="">--Select Vehicle Model--</option>-->
                    <!--    </select>-->
                    <!--  </div>-->
                    <!--  <div class="col-sm-3">-->
                    <!--    <?=form_label('Base Fare','base_fare',['class'=>'col-form-label'])?>-->
                    <!--    <input type="text" name="base_fare" autocomplete="off" maxlength="5" value="<?=$oneway_base_fare?>"  class="form-control notzero numbersWithZeroOnlyInput" required id="base_fare" placeholder="Base Fare" />-->
                    <!--  </div>-->
                    <!--  <div class="col-sm-3">-->
                    <!--    <?=form_label('Base Covered KM','base_covered_km',['class'=>'col-form-label'])?>-->
                    <!--    <input type="text" name="base_covered_km" autocomplete="off" maxlength="4" value="<?=$oneway_base_covered_km?>"  class="form-control notzero numbersWithZeroOnlyInput" required id="base_covered_km" placeholder="Base Covered KM" />-->
                    <!--  </div>-->
                    <!--  <div class="col-sm-3">-->
                    <!--    <?=form_label('Per KM Charge','per_km_charge',['class'=>'col-form-label'])?>-->
                    <!--    <input type="text" name="per_km_charge" autocomplete="off" maxlength="4" value="<?=$oneway_per_km_charge?>"  class="form-control notzero numbersWithZeroOnlyInput" required id="per_km_charge" placeholder="Per KM Charge" />-->
                    <!--  </div>-->
                    <!--  <div class="col-sm-3">-->
                    <!--    <?=form_label('Night Charge','night_charge',['class'=>'col-form-label'])?>-->
                    <!--    <input type="text" name="night_charge" autocomplete="off" maxlength="4" value="<?=$oneway_night_charge?>"  class="form-control notzero numbersWithZeroOnlyInput"  id="night_charge" placeholder="Night Charge" />-->
                    <!--  </div>-->
                    <!--  <div class="col-sm-3">-->
                    <!--    <?=form_label('Driver Charge','driver_charge',['class'=>'col-form-label'])?>-->
                    <!--    <input type="text" name="driver_charge" autocomplete="off" maxlength="4" value="<?=$oneway_driver_charge?>"  class="form-control notzero numbersWithZeroOnlyInput"  id="driver_charge" placeholder="Driver Charge" />-->
                    <!--  </div>-->
                    <!--</div>-->
                    
                    <div class="row mb-2 plusminus">
                       <div class="cstmfld_wrap input_field_wrapper1" id="DiskBlock">
                              <div class="col-sm-3">
                                <?=form_label('Select Vehicle Model','Oneway_model_id',['class'=>'col-form-label'])?>
                                <select name="model_id" id="Oneway_model_id" class="form-control select2" required>
                                  <option value="">--Select Vehicle Model--</option>
                                </select>
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Base Fare</label>
                                  <input type="text" placeholder="Enter fare" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Rate per KM</label>
                                  <input type="text" placeholder="Enter rate" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Minimum  KM</label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Driver Charge(DA) </label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Night Charge </label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              <a href="javascript:void(0);" id="addBlock" class="add_button1 btn btn-success" title="Add field"><i class="bx bx-plus"></i></a>
                              <a style="display:none" id="removeBlock" href="javascript:void(0);" class="remove_button1 btn btn-danger" title="Remove field"><i class="bx bx-minus"></i></a>
                       </div>
                    </div>

                    <div class="row mb-2">
                        <div class="cstmfld_wrap ">
                              <div class="custom_fields datefld">
                                  <label class="col-form-label">Night charge from</label>
                                  <input type="date" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields datefld">
                                  <label class="col-form-label">Night charge to</label>
                                  <input type="date" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Toll</label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Parking Charge</label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">State tax </label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Airport Parking </label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              
                          </div>
                    </div>
                    <div class="row mb-3 statusbtnrow align-items-end">
                      <div class="col-sm-6">
                        <?=form_label('Status','status',['class'=>'col-form-label'])?>
                        <div class="row mt-2">
                          <div class="col-3">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" name="status" <?= ($oneway_status == 'Active') ? 'checked' : '' ?> type="radio" id="checkStatus1" value="Active">
                              <?=form_label('Active','checkStatus1',['class'=>'custom-control-label'])?>
                            </div>
                          </div>
                          <div class="col-3">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" name="status" <?= ($oneway_status == 'Inactive') ? 'checked' : '' ?> type="radio" id="checkStatus2" value="Inactive">
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
                  
                  <!--Outstation is replaced with roundtrip-->
                  
                  <div class="tab-pane fade <?=!empty($type) && ($type=="Outstation")?"show active":""?>" id="navs-pills-top-outstation" role="tabpanel">
                    <?=form_open(ADMINPATH . 'save-fare',['id'=>'Outstation_form']); ?>
                    <?=form_hidden('id',$id)?>
                    <?=form_hidden('trip_type','Outstation')?>
                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <label class="col-form-label">Select State</label>
                        <select name="model_id" id="#" class="form-control select2" required>
                          <option value="">--Select State--</option>
                        </select>
                      </div>
                      <div class="col-sm-3">
                        <?=form_label('Select Vehicle Category','category',['class'=>'col-form-label'])?>
                        <select name="category_id" id="" class="form-control select2" onchange="<?= !empty($id) ? "getModelsName(this.value, " . $outstation_model_id . ", 'Outstation_model_id')" : "getModelsName(this.value,null, 'Outstation_model_id')" ?>" required>
                          <option value="">--Select Vehicle Category--</option>
                          <?php if(!empty($vehicle_categories)){foreach($vehicle_categories as $key=>$value){?>
                          <option value="<?=$value['id']?>" <?=!empty($outstation_category_id) && ($outstation_category_id==$value['id'])?"selected":""?>><?=$value['category_name']?></option>
                          <?php }} ?>
                        </select>
                      </div>
                      <div class="col-sm-3">
                        <?=form_label('Select Pickup City','pickup_city',['class'=>'col-form-label'])?>
                        <!--<input type="text" name="pickup_city" autocomplete="off"  value="<?=$outstation_pickup_city_name?>" onkeyup="getPickupCity(this.value,'Outstation_form')"  class="form-control ucwords restrictedInput city-input" data-form="Outstation_form" required id="" placeholder="Pickup City Name" />-->
                        <!--<input type="hidden" name="pickup_city_id" class="pickup-city-id" value="<?=$outstation_pickup_city_id?>">-->
                        <!--<input type="hidden" name="pickup_state_id" class="pickup-state-id" value="<?=$outstation_pickup_state_id?>">-->
                        <!--<ul class="suggestion-list list-unstyled list-color" id="suggestion-list-Outstation_form"></ul>-->
                        <select class="selectpicker" multiple aria-label="Default select example" data-placeholder="Choose Option" data-live-search="true">
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                        </select>
                      </div>
                      <div class="col-sm-3">
                        <?=form_label('Select Drop City','drop_city',['class'=>'col-form-label'])?>
                        <input type="text" name="drop_city" autocomplete="off" onkeyup="" value=""  class="form-control ucwords restrictedInput " required id="" placeholder="Drop City Name" />
                      </div>
                    </div>
                    
                    <div class="row mb-2 plusminus">
                       <div class="cstmfld_wrap input_field_wrapper1" id="DiskBlock">
                              <div class="col-sm-3">
                                <?=form_label('Select Vehicle Model','Outstation_model_id',['class'=>'col-form-label'])?>
                                <select name="model_id" id="Outstation_model_id" class="form-control select2" required>
                                  <option value="">--Select Vehicle Model--</option>
                                </select>
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Base Fare</label>
                                  <input type="text" placeholder="Enter fare" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Minimum  KM</label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Driver Charge(DA) </label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Night Charge </label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              <a href="javascript:void(0);" id="addBlock" class="add_button1 btn btn-success" title="Add field"><i class="bx bx-plus"></i></a>
                              <a style="display:none" id="removeBlock" href="javascript:void(0);" class="remove_button1 btn btn-danger" title="Remove field"><i class="bx bx-minus"></i></a>
                       </div>
                    </div>
                    <!--<div class="row mb-2">-->
                      
                    <!--  <div class="col-sm-3">-->
                    <!--    <?=form_label('Base Covered KM','base_covered_km',['class'=>'col-form-label'])?>-->
                    <!--    <input type="text" name="base_covered_km" autocomplete="off" maxlength="4" value="<?=$outstation_base_covered_km?>"  class="form-control notzero numbersWithZeroOnlyInput" required id="base_covered_km" placeholder="Base Covered KM" />-->
                    <!--  </div>-->
                    <!--  <div class="col-sm-3">-->
                    <!--    <?=form_label('Per KM Charge','per_km_charge',['class'=>'col-form-label'])?>-->
                    <!--    <input type="text" name="per_km_charge" autocomplete="off" maxlength="4" value="<?=$outstation_per_km_charge?>"  class="form-control notzero numbersWithZeroOnlyInput" required id="per_km_charge" placeholder="Per KM Charge" />-->
                    <!--  </div>-->
                    <!--  <div class="col-sm-3">-->
                    <!--    <?=form_label('Night Charge','night_charge',['class'=>'col-form-label'])?>-->
                    <!--    <input type="text" name="night_charge" autocomplete="off" maxlength="4" value="<?=$outstation_night_charge?>"  class="form-control notzero numbersWithZeroOnlyInput"  id="night_charge" placeholder="Night Charge" />-->
                    <!--  </div>-->
                    <!--  <div class="col-sm-3">-->
                    <!--    <?=form_label('Driver Charge','driver_charge',['class'=>'col-form-label'])?>-->
                    <!--    <input type="text" name="driver_charge" autocomplete="off" maxlength="4" value="<?=$outstation_driver_charge?>"  class="form-control notzero numbersWithZeroOnlyInput"  id="driver_charge" placeholder="Driver Charge" />-->
                    <!--  </div>-->
                    <!--</div>-->
                    
                    <div class="row mb-2">
                        <div class="cstmfld_wrap ">
                              <div class="custom_fields datefld">
                                  <label class="col-form-label">Night charge from</label>
                                  <input type="date" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields datefld">
                                  <label class="col-form-label">Night charge to</label>
                                  <input type="date" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Toll</label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Parking Charge</label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">State tax </label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              <div class="custom_fields">
                                  <label class="col-form-label">Airport Parking </label>
                                  <input type="text" placeholder="Enter value" class="form-control">
                              </div>
                              
                          </div>
                    </div>
                    
                    
                    <div class="row mb-3 statusbtnrow align-items-end">
                      <div class="col-sm-6">
                        <?=form_label('Status','status',['class'=>'col-form-label'])?>
                        <div class="row mt-2">
                          <div class="col-3">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" name="status" <?= ($outstation_status == 'Active') ? 'checked' : '' ?> type="radio" id="checkStatus1" value="Active">
                              <?=form_label('Active','checkStatus1',['class'=>'custom-control-label'])?>
                            </div>
                          </div>
                          <div class="col-3">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" name="status" <?= ($outstation_status == 'Inactive') ? 'checked' : '' ?> type="radio" id="checkStatus2" value="Inactive">
                              <?=form_label('Inactive','checkStatus2',['class'=>'custom-control-label'])?>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-check cstmchk">
                              <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked1" checked>
                              <label class="form-check-label" for="flexCheckChecked1">
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
                  
                  
                  <!--Local tab-->
                  
                  <div class="tab-pane fade <?=!empty($type) && ($type=="Local")?"show active":""?>" id="navs-pills-top-local" role="tabpanel">
                    <?=form_open(ADMINPATH . 'save-fare',['id'=>'Local_form']); ?>
                    <?=form_hidden('id',$id)?>
                    <?=form_hidden('trip_type','Local')?>
                    <div class="row mb-3">
                     
                      <!--<div class="col-sm-3">-->
                      <!--  <?=form_label('Select Vehicle Category','category',['class'=>'col-form-label'])?>-->
                      <!--  <select name="category_id" id="" class="form-control select2" onchange="<?= !empty($id) ? "getModelsName(this.value, " . $local_model_id . ", 'Local_model_id')" : "getModelsName(this.value, null,'Local_model_id')" ?>" required>-->
                      <!--    <option value="">--Select Vehicle Category--</option>-->
                      <!--    <?php if(!empty($vehicle_categories)){foreach($vehicle_categories as $key=>$value){?>-->
                      <!--    <option value="<?=$value['id']?>" <?=!empty($local_category_id) && ($local_category_id==$value['id'])?"selected":""?>><?=$value['category_name']?></option>-->
                      <!--    <?php }} ?>-->
                      <!--  </select>-->
                      <!--</div>-->
                      <div class="col-sm-3">
                        <?=form_label('Home (Source) City','pickup_city',['class'=>'col-form-label'])?>
                        <!--<input type="text" name="pickup_city" autocomplete="off"  value="<?=$local_pickup_city_name?>" onkeyup="getPickupCity(this.value,'Local_form')" data-form="Local_form"  class="form-control ucwords restrictedInput city-input" required id="" placeholder="Pickup City Name" />-->
                        <!--<input type="hidden" name="pickup_city_id" class="pickup-city-id" value="<?=$local_pickup_city_id?>">-->
                        <!--<input type="hidden" name="pickup_state_id" class="pickup-state-id" value="<?=$local_pickup_state_id?>">-->
                        <!--<ul class="suggestion-list list-unstyled list-color" id="suggestion-list-Local_form"></ul>-->
                        <select class="selectpicker" multiple aria-label="Default select example" data-placeholder="Choose Option" data-live-search="true">
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                        </select>
                      </div>
                      <div class="col-sm-3">
                        <?=form_label('Select Package','package_id',['class'=>'col-form-label'])?>
                        <select name="package_id" id="fetched_packs" class="form-control select2" onchange="fetchHoursKm(this.value)"  required>
                          <option value="">--Select Package--</option>
                        </select>
                      </div>
                      
                    </div>
                    <div class="row mb-2 plusminus">
                       <div class="cstmfld_wrap input_field_wrapper1" id="DiskBlock">
                          <div class="col-sm-3">
                            <?=form_label('Select Vehicle Model','Local_model_id',['class'=>'col-form-label'])?>
                            <select name="model_id" id="Local_model_id" class="form-control select2" required>
                              <option value="">--Select Vehicle Model--</option>
                            </select>
                          </div>
                          <div class="custom_fields">
                            <?=form_label('Base Fare','base_fare',['class'=>'col-form-label'])?>
                            <input type="text" name="base_fare" autocomplete="off" maxlength="5" value="<?=$local_base_fare?>"  class="form-control notzero numbersWithZeroOnlyInput" required id="base_fare" placeholder="Base Fare" />
                          </div>
                          <div class="custom_fields">
                            <?=form_label('Hours','covered_hours',['class'=>'col-form-label'])?>
                            <input type="text" name="covered_hours" autocomplete="off" maxlength="4" value="<?=$local_covered_hours?>"  class="form-control notzero numbersWithZeroOnlyInput" required id="fetched_covered_hours" placeholder="Enter value" />
                          </div>
                          <div class="custom_fields">
                            <?=form_label('Minimum KM','base_covered_km',['class'=>'col-form-label'])?>
                            <input type="text" name="base_covered_km" autocomplete="off" maxlength="4" value="<?=$local_base_covered_km?>"  class="form-control notzero numbersWithZeroOnlyInput" required id="fetched_covered_km" placeholder="Base Covered KM" />
                          </div>
                          <!--<div class="col-sm-3">-->
                          <!--  <?=form_label('Per Minute Charge','per_minute_charge',['class'=>'col-form-label'])?>-->
                          <!--  <input type="text" name="per_minute_charge" autocomplete="off"  value="<?=$local_per_minute_charge?>"  class="form-control notzero numbersWithZeroOnlyInput" required id="per_minute_charge" placeholder="Per Minute Charge" />-->
                          <!--</div>-->
                          <!--<div class="col-sm-3">-->
                          <!--  <?=form_label('Night Charge','night_charge',['class'=>'col-form-label'])?>-->
                          <!--  <input type="text" name="night_charge" autocomplete="off" maxlength="4" value="<?=$local_night_charge?>"  class="form-control notzero numbersWithZeroOnlyInput"  id="night_charge" placeholder="Night Charge" />-->
                          <!--</div>-->
                          <!--<div class="col-sm-3">-->
                          <!--  <?=form_label('Driver Charge','driver_charge',['class'=>'col-form-label'])?>-->
                          <!--  <input type="text" name="driver_charge" autocomplete="off" maxlength="4" value="<?=$local_driver_charge?>"  class="form-control notzero numbersWithZeroOnlyInput"  id="driver_charge" placeholder="Driver Charge" />-->
                          <!--</div>-->
                          <a href="javascript:void(0);" id="addBlock" class="add_button1 btn btn-success" title="Add field"><i class="bx bx-plus"></i></a>
                          <a style="display:none" id="removeBlock" href="javascript:void(0);" class="remove_button1 btn btn-danger" title="Remove field"><i class="bx bx-minus"></i></a>

                        </div>
                    </div>
                    <div class="row mb-3 statusbtnrow align-items-end">
                      <div class="col-sm-6">
                        <div class="row mt-2">
                          <?=form_label('Status','status',['class'=>'col-form-label'])?>
                          <div class="col-3">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" name="status" <?= ($local_status == 'Active') ? 'checked' : '' ?> type="radio" id="checkStatus1" value="Active">
                              <?=form_label('Active','checkStatus1',['class'=>'custom-control-label'])?>
                            </div>
                          </div>
                          <div class="col-3">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" name="status" <?= ($local_status == 'Inactive') ? 'checked' : '' ?> type="radio" id="checkStatus2" value="Inactive">
                              <?=form_label('Inactive','checkStatus2',['class'=>'custom-control-label'])?>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-check cstmchk">
                              <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked2" checked>
                              <label class="form-check-label" for="flexCheckChecked2">
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
                    <div class="row justify-content-start">
                       
                    </div>
                    <?=form_close();?>
                  </div>
                  
                  
                  <!--Airport Tabs-->
                  
                  
                  <div class="tab-pane fade <?=!empty($type) && ($type=="Airport")?"show active":""?>" id="navs-pills-top-airport" role="tabpanel">
                    <?=form_open(ADMINPATH . 'save-fare',['id'=>'Airport_form']); ?>
                    <?=form_hidden('id',$id)?>
                    <?=form_hidden('trip_type','Airport')?>
                    <div class="row mb-3">
                      <div class="col-sm-3">
                        <?=form_label('Select Vehicle Category','category',['class'=>'col-form-label'])?>
                        <select name="category_id" id="" class="form-control select2" onchange="<?= !empty($id) ? "getModelsName(this.value, " . $airport_model_id . ", 'Airport_model_id')" : "getModelsName(this.value, null,'Airport_model_id')" ?>" required>
                          <option value="">--Select Vehicle Category--</option>
                          <?php if (!empty($vehicle_categories)) {
                            foreach ($vehicle_categories as $key => $value) { ?>
                            <option value="<?= $value['id'] ?>" <?= !empty($airport_category_id) && ($airport_category_id == $value['id']) ? "selected" : "" ?>><?= $value['category_name'] ?></option>
                          <?php }
                            } ?>
                        </select>
                      </div>
                      
                      <div class="col-sm-3">
                        <?=form_label('Select Pickup City','pickup_city',['class'=>'col-form-label'])?>
                        <!--<input type="text" name="pickup_city" autocomplete="off"  value="<?=$airport_pickup_city_name?>" onkeyup="getPickupCity(this.value,'Airport_form')"  class="form-control ucwords restrictedInput city-input" data-form="Airport_form" required id="" placeholder="Pickup City Name" />-->
                        <!--<input type="hidden" name="pickup_city_id" class="pickup-city-id" value="<?=$airport_pickup_city_id?>">-->
                        <!--<input type="hidden" name="pickup_state_id" class="pickup-state-id" value="<?=$airport_pickup_state_id?>">-->
                        <!--<ul class="suggestion-list list-unstyled list-color" id="suggestion-list-Airport_form"></ul>-->
                        <select class="selectpicker" multiple aria-label="Default select example" data-placeholder="Choose Option" data-live-search="true">
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                        </select>
                      </div>
                      
                      <div class="col-sm-3">
                        <label class="col-form-label">Select Airport</label>
                        <select name="package_id" id="" class="form-control select2" onchange=""  required>
                          <option value="">--Select Airport--</option>
                        </select>
                      </div>
                    </div>
                    <div class="row mb-2 plusminus">
                       <div class="cstmfld_wrap input_field_wrapper1" id="DiskBlock">
                          <div class="col-sm-3">
                            <?=form_label('Select Vehicle Model','Airport_model_id',['class'=>'col-form-label'])?>
                            <select name="model_id" id="Airport_model_id" class="form-control  select2" required>
                              <option value="">--Select Vehicle Model--</option>
                            </select>
                          </div>
                          <div class="custom_fields">
                            <?=form_label('Base Fare','base_fare',['class'=>'col-form-label'])?>
                            <input type="text" name="base_fare" autocomplete="off" maxlength="5" value="<?=$airport_base_fare?>"  class="form-control notzero numbersWithZeroOnlyInput" required id="base_fare" placeholder="Base Fare" />
                          </div>
                          <div class="custom_fields">
                            <?=form_label('Base Covered KM','base_covered_km',['class'=>'col-form-label'])?>
                            <input type="text" name="base_covered_km" autocomplete="off" maxlength="4" value="<?=$airport_base_covered_km?>"  class="form-control notzero numbersWithZeroOnlyInput" required id="base_covered_km" placeholder="Base Covered KM" />
                          </div>
                          <!--<div class="custom_fields">-->
                          <!--  <?=form_label('Per Minute Charge','per_minute_charge',['class'=>'col-form-label'])?>-->
                          <!--  <input type="text" name="per_minute_charge" autocomplete="off"  value="<?=$airport_per_minute_charge?>"  class="form-control notzero numbersWithZeroOnlyInput" required id="per_minute_charge" placeholder="Per Minute Charge" />-->
                          <!--</div>-->
                          <div class="custom_fields">
                            <?=form_label('Per KM Charge','per_km_charge',['class'=>'col-form-label'])?>
                            <input type="text" name="per_km_charge" autocomplete="off" maxlength="4" value="<?=$airport_per_km_charge?>"  class="form-control notzero numbersWithZeroOnlyInput" required id="per_km_charge" placeholder="Per KM Charge" />
                          </div>
                          <div class="custom_fields">
                            <?=form_label('Night Charge','night_charge',['class'=>'col-form-label'])?>
                            <input type="text" name="night_charge" autocomplete="off" maxlength="4" value="<?=$airport_night_charge?>"  class="form-control notzero numbersWithZeroOnlyInput"  id="night_charge" placeholder="Night Charge" />
                          </div>
                          <!--<div class="custom_fields">-->
                          <!--  <?=form_label('Driver Charge','driver_charge',['class'=>'col-form-label'])?>-->
                          <!--  <input type="text" name="driver_charge" autocomplete="off" maxlength="4" value="<?=$airport_driver_charge?>"  class="form-control notzero numbersWithZeroOnlyInput"  id="driver_charge" placeholder="Driver Charge" />-->
                          <!--</div>-->
                           <a href="javascript:void(0);" id="addBlock" class="add_button1 btn btn-success" title="Add field"><i class="bx bx-plus"></i></a>
                           <a style="display:none" id="removeBlock" href="javascript:void(0);" class="remove_button1 btn btn-danger" title="Remove field"><i class="bx bx-minus"></i></a>
                       </div>
                    </div>
                    <div class="row mb-3 statusbtnrow align-items-end">
                      <div class="col-sm-6">
                        <div class="row mt-2">
                          <?=form_label('Status','status',['class'=>'col-form-label'])?>    
                          <div class="col-3">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" name="status" <?= ($airport_status == 'Active') ? 'checked' : '' ?> type="radio" id="checkStatus1" value="Active">
                              <?=form_label('Active','checkStatus1',['class'=>'custom-control-label'])?>
                            </div>
                          </div>
                          <div class="col-3">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input" name="status" <?= ($airport_status == 'Inactive') ? 'checked' : '' ?> type="radio" id="checkStatus2" value="Inactive">
                              <?=form_label('Inactive','checkStatus2',['class'=>'custom-control-label'])?>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-check cstmchk">
                              <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked4" checked>
                              <label class="form-check-label" for="flexCheckChecked4">
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
<script>
  <?php if (!empty($package_id)) { ?>
getPacks(<?=$pickup_city_id?>,<?= $package_id ?>);
<?php } ?>
  
    function getPacks(city_id,package_id = null) {
    
      $('#fetched_packs').html('');
      $.ajax({
        url: '<?= base_url(ADMINPATH.'getPacksFromAjax') ?>',
        method: 'POST',
        data: {
          city_id: city_id,
          package_id: package_id
        },
        success: function(response) {
          $('#fetched_packs').html(response);
        }
      });
    }

  function fetchHoursKm(package_id){
   
  $.ajax({
      url: '<?= base_url(ADMINPATH.'fetchHoursKm') ?>',
      method: 'POST',
      data: {package_id:package_id},
      dataType:'json',
      success: function (response) {
         // alert(response);
          $('#fetched_covered_hours').val(response.hours);
          $('#fetched_covered_km').val(response.km);
      }
  });

  }
<?php $category_id = '';
$model_id = '';
 if (!empty($oneway_category_id)) {
    $category_id = $oneway_category_id;
    $model_id = !empty($oneway_model_id) ? $oneway_model_id : '';
} elseif (!empty($outstation_category_id)) {
    $category_id = $outstation_category_id;
    $model_id = !empty($outstation_model_id) ? $outstation_model_id : '';
} elseif (!empty($local_category_id)) {
    $category_id = $local_category_id;
    $model_id = !empty($local_model_id) ? $local_model_id : '';
} elseif (!empty($airport_category_id)) {
    $category_id = $airport_category_id;
    $model_id = !empty($airport_model_id) ? $airport_model_id : '';
}
 if (!empty($model_id)) { 
// Ensure $category_id and $model_id have default values if all checks fail
$category_id = $category_id ?: '';
$model_id = $model_id ?: '';
?>
$(document).ready(function() {
    getModelsName(<?= $category_id ?>, <?= $model_id ?>,'<?=$trip_type?>_model_id');
});
<?php } ?>
function getModelsName(id, modelvalue, append_id) {
    $('#' + append_id).html('');
    $.ajax({
      url: '<?= base_url(ADMINPATH.'getModelsFromAjax') ?>',
      method: 'POST',
      data: { category_id: id, model_id: modelvalue },
      success: function(response) {
          $('#' + append_id).html(response);
      }
    });
}
<?php if(!empty($local_package_id) && !empty($local_pickup_city_id)){?>
getPacks(<?=!empty($local_pickup_city_id)?$local_pickup_city_id:null?>,<?=!empty($local_package_id)?$local_package_id:null?>);
<?php } ?>
    </script>

