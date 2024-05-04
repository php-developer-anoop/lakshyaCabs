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
                <h4 class="cardhdng">Add Vehicle Category</h4>
                <a href="<?= base_url(ADMINPATH . 'vehicle-category-list') ?>" class="sitebtn">View List</a>
            </div>
            <?=form_open_multipart(ADMINPATH . 'save-vehicle-category'); ?>
            <?=form_hidden('id',$id)?>
            <input type="hidden" name="old_jpg_image" value="<?= !empty($jpg_image) ? $jpg_image : ''; ?>">
            <input type="hidden" name="old_webp_image"value="<?= !empty($webp_image) ? $webp_image : ''; ?>">
            <div class="form_img">
                <div class="row mb-3 mw65">
                  <div class="col-sm-6 mb-3">
                    <?=form_label('Category Name','category_name',['class'=>'col-form-label'])?>
                    <input type="text" name="category_name" autocomplete="off" onkeyup="return checkDuplicate(this.value,'vehicle_category','category_name')" value="<?=$category_name?>"  class="form-control ucwords restrictedInput" required id="category_name" placeholder="Category Name" />
                  </div>
                  <div class="col-sm-6 mb-3">
                    <?=form_label('Priority','priority',['class'=>'col-form-label'])?>
                    <?= form_input(['name' => 'priority','autocomplete'=>'off','required' => 'required', 'placeholder' => 'Enter Priority','maxlength'=>'2', 'id' => 'priority', 'class' => 'form-control numbersWithZeroOnlyInput','value'=>$priority]); ?>
                  </div>
                  <div class="col-sm-6 mb-3">
                     <label for="image_alt" class="col-form-label">Banner Image Alt</label>
                    <?= form_input(['name' => 'image_alt', 'required' => 'required', 'placeholder' => 'Enter Image Alt', 'id' => 'image_alt', 'class' => 'form-control','value'=>$image_alt]); ?>
                  </div>
    
                  <div class="col-sm-6 mb-3">
                      <label for="banner_image" class="col-form-label">Banner Image</label>
                    <?= form_upload([
                      'name' => 'banner_image',
                      'class' => 'form-control',
                      'accept' => 'image/png, image/jpg, image/jpeg'
                      ]); ?>
                  </div>
                  
                 
                  <div class="col-sm-2">
                     
                  </div>
                 
                  <?=form_label('Status','status',['class'=>'col-form-label'])?>
                  <div class="col-sm-8 mb-3">
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
                              <th>Vehicle Category</th>
                              <th>Image</th>
                              <th>Sorting</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>1</td>
                              <td>Sedan</td>
                              <td>
                                  <div class="vehclimg"> <img src="https://lakshyacabs.nshops.in/uploads/vehical.png">  </div>
                              </td>
                              <td>1</td>
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
                              <td>SUV</td>
                              <td>
                                  <div class="vehclimg"> <img src="https://lakshyacabs.nshops.in/uploads/vehical.png">  </div>
                              </td>
                              <td>1</td>
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