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
                <h4 class="cardhdng">Add Vehicle Model</h4>
                <a href="<?= base_url(ADMINPATH . 'vehicle-model-list') ?>" class="sitebtn">View List</a>
            </div>
            <?=form_open_multipart(ADMINPATH . 'save-vehicle-model'); ?>
            <?=form_hidden('id',$id)?>
            <input type="hidden" name="old_jpg_image" value="<?= !empty($jpg_image) ? $jpg_image : ''; ?>">
            <input type="hidden" name="old_webp_image"value="<?= !empty($webp_image) ? $webp_image : ''; ?>">
            <div class="form_img">
                <div class="row mb-3 mw75">
                  <div class="col-sm-4 mb-3">
                    <?=form_label('Select Category','category',['class'=>'col-form-label'])?>
                    <select name="category" id="category" class="form-control select2" required>
                      <option value="">--Select Category--</option>
                      <?php if(!empty($vehicle_categories)){foreach($vehicle_categories as $key=>$value){?>
                      <option value="<?=$value['id'].','.$value['category_name']?>" <?=!empty($category_id) && ($category_id==$value['id'])?"selected":""?>><?=$value['category_name']?></option>
                      <?php }} ?>
                    </select>
                  </div>
                  <div class="col-sm-4 mb-3">
                    <?=form_label('Model Name','model_name',['class'=>'col-form-label'])?>
                    <input type="text" name="model_name" autocomplete="off" onkeyup="return checkDuplicate(this.value,'vehicle_model','model_name')" value="<?=$model_name?>"  class="form-control" required id="model_name" placeholder="Model Name" />
                  </div>
                  <div class="col-sm-4 mb-3">
                    <?=form_label('Seat Segment','seat_segment',['class'=>'col-form-label'])?>
                    <input type="text" name="seat_segment" autocomplete="off" maxlength="10" value="<?=$seat_segment?>"  class="form-control" required id="seat_segment" placeholder="Seat Segment" />
                  </div>
                  <div class="col-sm-4 mb-3">
                    <?=form_label('Select Fuel Type','fuel_type',['class'=>'col-form-label'])?>
                    <select name="fuel_type" id="fuel_type" class="form-control select2" required>
                      <option value="">--Select Fuel Type--</option>
                      <option value="Petrol" <?=!empty($fuel_type) && ($fuel_type=="Petrol") ? "selected":""?>>Petrol</option>
                      <option value="Diesel" <?=!empty($fuel_type) && ($fuel_type=="Diesel") ? "selected":""?>>Diesel</option>
                      <option value="CNG" <?=!empty($fuel_type) && ($fuel_type=="CNG") ? "selected":""?>>CNG</option>
                    </select>
                  </div>
                  
                  <div class="col-sm-4 mb-3">
                    <?=form_label('Luggage','luggage',['class'=>'col-form-label'])?>
                    <input type="text" name="luggage" autocomplete="off" maxlength="100" value="<?=$luggage?>"  class="form-control address" required id="luggage" placeholder="Luggage" />
                  </div>
                  <div class="col-sm-4 mb-3"> 
                    <?=form_label('Select AC/Non AC','ac_or_non_ac',['class'=>'col-form-label'])?>
                    <select name="ac_or_non_ac" id="ac_or_non_ac" class="form-control select2" required>
                      <option value="">--Select AC/Non AC--</option>
                      <option value="AC" <?=!empty($ac_or_non_ac) && ($ac_or_non_ac=="AC") ? "selected":""?>>AC</option>
                      <option value="Non AC" <?=!empty($ac_or_non_ac) && ($ac_or_non_ac=="Non AC") ? "selected":""?>>Non AC</option>
                    </select>
                  </div>
                  <div class="col-sm-4 mb-3">
                    <?=form_label('Select Water Bottle','water_bottle',['class'=>'col-form-label'])?>
                    <select name="water_bottle" id="water_bottle" class="form-control select2" required>
                      <option value="">--Select Water Bottle--</option>
                      <option value="Yes" <?=!empty($water_bottle) && ($water_bottle=="Yes") ? "selected":""?>>Yes</option>
                      <option value="No" <?=!empty($water_bottle) && ($water_bottle=="No") ? "selected":""?>>No</option>
                    </select>
                  </div>
                  <div class="col-sm-4 mb-3">
                    <?=form_label('Select Carrier','carrier',['class'=>'col-form-label'])?>
                    <select name="carrier" id="carrier" class="form-control select2" required>
                      <option value="">--Select Carrier--</option>
                      <option value="Yes" <?=!empty($carrier) && ($carrier=="Yes") ? "selected":""?>>Yes</option>
                      <option value="No" <?=!empty($carrier) && ($carrier=="No") ? "selected":""?>>No</option>
                    </select>
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label for="banner_image" class=" col-form-label">Banner Image</label>
                    <?= form_upload([
                      'name' => 'banner_image',
                      'class' => 'form-control',
                      'accept' => 'image/png, image/jpg, image/jpeg'
                      ]); ?>
                  </div>
                  
                  <div class="col-sm-4 mb-3">
                    <label for="image_alt" class="col-form-label">Banner Image Alt</label>
                    <?= form_input(['name' => 'image_alt', 'required' => 'required', 'placeholder' => 'Enter Image Alt', 'id' => 'image_alt', 'class' => 'form-control','value'=>$image_alt]); ?>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <?=form_label('Status','status',['class'=>'col-form-label'])?>
                    <div class="row mt-2">
                      <div class="col-4">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" name="status" <?= ($status == 'Active') ? 'checked' : '' ?> type="radio" id="checkStatus1" value="Active">
                          <?=form_label('Active','checkStatus1',['class'=>'custom-control-label'])?>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" name="status" <?= ($status == 'Inactive') ? 'checked' : '' ?> type="radio" id="checkStatus2" value="Inactive">
                          <?=form_label('Inactive','checkStatus2',['class'=>'custom-control-label'])?>
                        </div>
                      </div>
                     </div>
                   </div>
                </div>
                <div class="imageview">
                    <?php if (!empty($jpg_image)) { ?>
                        <img src="<?= base_url('uploads/') . $jpg_image; ?>" height=70px width=100px>
                    <?php }
                    else { ?>
                     <img src="https://lakshyacabs.nshops.in/uploads/imgicon.png">                      
                    <?php } ?>
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
            
                <div class="mt-5">
                   <h4 class="cardhdng">Recent Entry</h4>
                </div>
                <div class="table-responsive text-nowrap">
                  <table id="tabless" class="table mb-0">
                      <thead>
                          <tr>
                              <th>Sr. No.</th>
                              <th>Model</th>
                              <th>Category</th>
                              <th>Segment</th>
                              <th>Image</th>
                              <th>GPS</th>
                              <th>LCD</th>
                              <th>Music</th>
                              <th>Vehical Type</th>
                              <th>No. of bags</th>
                              <th>Newspaper</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>1</td>
                              <td>Etios or Similar</td>
                              <td>Sedan</td>
                              <td>4+1</td>
                              <td>
                                  <div class="vehclimg"> <img src="https://lakshyacabs.nshops.in/uploads/vehical.png">  </div>
                              </td>
                              <td>Yes</td>
                              <td>-</td>
                              <td>-</td>
                              <td>AC</td>
                              <td>2</td>
                              <td>-</td>
                              <td>
                                  <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                      <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                  </div>
                              </td>
                              <td>
                                  <a href="javascript:void(0)" class="btn actnbtn btn-orange" title=""><i class="tf-icons bx bx-edit"></i></a>
                                  <a class="btn actnbtn btn-red" href="javascript:void(0)"><i class="tf-icons bx bx-trash"></i></a>
                              </td>
                          </tr>
                           <tr>
                              <td>2</td>
                              <td>Etios or Similar</td>
                              <td>Sedan</td>
                              <td>4+1</td>
                              <td>
                                  <div class="vehclimg"> <img src="https://lakshyacabs.nshops.in/uploads/vehical.png">  </div>
                              </td>
                              <td>Yes</td>
                              <td>-</td>
                              <td>-</td>
                              <td>AC</td>
                              <td>2</td>
                              <td>-</td>
                              <td>
                                  <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                      <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                  </div>
                              </td>
                              <td>
                                  <a href="javascript:void(0)" class="btn actnbtn btn-orange" title=""><i class="tf-icons bx bx-edit"></i></a>
                                  <a class="btn actnbtn btn-red" href="javascript:void(0)"><i class="tf-icons bx bx-trash"></i></a>
                              </td>
                          </tr>
                           <tr>
                              <td>3</td>
                              <td>Etios or Similar</td>
                              <td>SUV</td>
                              <td>4+1</td>
                              <td>
                                  <div class="vehclimg"> <img src="https://lakshyacabs.nshops.in/uploads/vehical.png">  </div>
                              </td>
                              <td>Yes</td>
                              <td>-</td>
                              <td>-</td>
                              <td>AC</td>
                              <td>2</td>
                              <td>-</td>
                              <td>
                                  <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                      <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                  </div>
                              </td>
                              <td>
                                  <a href="javascript:void(0)" class="btn actnbtn btn-orange" title=""><i class="tf-icons bx bx-edit"></i></a>
                                  <a class="btn actnbtn btn-red" href="javascript:void(0)"><i class="tf-icons bx bx-trash"></i></a>
                              </td>
                          </tr>
                      </tbody>
                  </table>
                </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>