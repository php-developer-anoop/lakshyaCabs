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
                <h4 class="cardhdng">Add Package</h4>
                <a href="<?= base_url(ADMINPATH . 'taxi-packages-list') ?>" class="sitebtn">View Packages</a>
            </div>  
              
            <?=form_open_multipart(ADMINPATH . 'save-taxi-package'); ?>
            <?=form_hidden('id',$id)?>
            <input type="hidden" name="old_jpg_image" value="<?= !empty($jpg_image) ? $jpg_image : ''; ?>">
            <input type="hidden" name="old_webp_image"value="<?= !empty($webp_image) ? $webp_image : ''; ?>">
            <input type="hidden" name="old_bottom_banner_jpg" value="<?= !empty($bottom_banner_jpg) ? $bottom_banner_jpg : ''; ?>">
            <input type="hidden" name="old_bottom_banner_webp"value="<?= !empty($bottom_banner_webp) ? $bottom_banner_webp : ''; ?>">
            <div class="row mb-3">
              <div class="col-sm-4">
                <?=form_label('Package Name','package_name',['class'=>'col-form-label'])?>
                <input type="text" name="package_name" autocomplete="off"  value="<?=$package_name?>"  class="form-control ucwords restrictedInput" required id="package_name" placeholder="Package Name" />
              </div>
              <div class="col-sm-4">
                <?=form_label('Package Display Name','package_title',['class'=>'col-form-label'])?>
                <input type="text" name="package_title" autocomplete="off" onkeyup="return checkDuplicate(this.value,'taxi_package_list','package_title')" value="<?=$package_title?>"  class="form-control ucwords restrictedInput" required id="package_title" placeholder="Package Display Name" />
              </div>
              <div class="col-sm-4">
                <?=form_label('URL','url',['class'=>'col-form-label'])?>
                <input type="text" name="url" autocomplete="off" value="<?=$url?>"  class="form-control" required id="url" placeholder="URL" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('H1 Heading','h1',['class'=>'col-form-label'])?>
                <input type="text" name="h1" autocomplete="off" value="<?=$h1?>"  class="form-control" required id="h1" placeholder="H1 Heading" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Meta Title','meta_title',['class'=>'col-form-label'])?>
                <textarea name="meta_title" autocomplete="off" class="form-control" required id="meta_title" placeholder="Meta Title"><?=$meta_title?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Meta Description','meta_description',['class'=>'col-form-label'])?>
                <textarea name="meta_description" autocomplete="off" class="form-control" required id="meta_description" placeholder="Meta Description"><?=$meta_description?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Meta Keywords','meta_keyword',['class'=>'col-form-label'])?>
                <textarea name="meta_keyword" autocomplete="off" class="form-control" required id="meta_keyword" placeholder="Meta Keywords"><?=$meta_keyword?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Meta Schema','page_schema',['class'=>'col-form-label'])?>
                <textarea name="page_schema" autocomplete="off" class="form-control"  id="page_schema" placeholder="Meta Schema"><?=$page_schema?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Short Description','short_description',['class'=>'col-form-label'])?>
                <input type="text" name="short_description" autocomplete="off" value="<?=$short_description?>"  class="form-control" required id="short_description" placeholder="Short Description" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Description','description',['class'=>'col-form-label'])?>
                <textarea  name="package_description" autocomplete="off" class="form-control" required id="description" placeholder="Description"><?=$description?></textarea>
              </div>
            </div>
            <label for="itd_description">Itinerary Description</label>
             <div class="itd_wrapper">
                      <?php if(!empty($itd_list)){
                        $i=1;
                        foreach($itd_list as $ikey=>$ivalue){
                        ?>
                      <div id="itddiv_<?=$i?>">
                        <div class="row mb-3">
                          <div class="col-sm-2">
                          <label for="day" class="col-form-label">Day</label>
                          <input type="text" class="form-control" id="day" placeholder="Day" value="<?=$ivalue['day']?>" name="day[]">
                        </div>
                        <div class="col-sm-4">
                          <label for="title" class="col-form-label">Title</label>
                          <input type="text" class="form-control" id="title" placeholder="Title" value="<?=$ivalue['title']?>" name="title[]">
                        </div>
                        <div class="col-sm-6">
                          <label for="description" class="col-form-label">Description</label>
                          <input type="text" class="form-control itd_description"  placeholder="Description" value="<?=$ivalue['description']?>" name="description[]">
                        </div>
                          
                        </div>
                      </div>
                      <?php if($i==1){?>
                      <a href="javascript:void(0);" class="add_itd_button btn btn-success btn-sm" title="Add field"><i class="bx bx-plus"></i></a>
                      <?php }else{?>
                      <a href="javascript:void(0);" class="btn btn-danger btn-sm"  title="Remove field" id="itd_<?=$i?>" onclick="del_itd(<?=$i?>)"><i class="bx bx-minus"></i></a>
                      <?php } ?>
                      <?php $i++;} }else{ ?>
                      <div class="row mb-3">
                        <div class="col-sm-2">
                          <label for="day" class="col-form-label">Day</label>
                          <input type="text" class="form-control" id="day" placeholder="Day" value="" name="day[]">
                        </div>
                        <div class="col-sm-4">
                          <label for="title" class="col-form-label">Title</label>
                          <input type="text" class="form-control" id="title" placeholder="Title" value="" name="title[]">
                        </div>
                        <div class="col-sm-6">
                          <label for="description" class="col-form-label">Description</label>
                          <input type="text" class="form-control itd_description"  placeholder="Description" value="" name="description[]">
                        </div>
                      </div>
                      <a href="javascript:void(0);" class="add_itd_button btn btn-success btn-sm" title="Add field"><i class="bx bx-plus"></i></a>
                      <?php } ?>
                    </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Inclusion','inclusion',['class'=>'col-form-label'])?>
                <textarea  name="inclusion" autocomplete="off" class="form-control" required id="inclusion"><?=$inclusion?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Exclusion','exclusion',['class'=>'col-form-label'])?>
                <textarea  name="exclusion" autocomplete="off" class="form-control" required id="exclusion"><?=$exclusion?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Cancellation Terms And Conditions','cancellation_terms_conditions',['class'=>'col-form-label'])?>
                <textarea  name="cancellation_terms_conditions" autocomplete="off" class="form-control" required id="cancellation_terms_conditions" ><?=$cancellation_terms_conditions?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('FAQ Schema','faq_schema',['class'=>'col-form-label'])?>
                <textarea name="faq_schema" autocomplete="off" class="form-control"  id="faq_schema" placeholder="FAQ Schema"><?=$faq_schema?></textarea>
              </div>
            </div>
            <div class="input_field_wrapper">
              <?php if(!empty($faqs)){
                $i=1;
                foreach($faqs as $key=>$value){
                ?>
              <div id="faq_<?=$i?>">
                <div class="row mb-3">
                  <label for="faq_question" class="col-sm-2 col-form-label">Question</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="faq_question" placeholder="Question" value="<?=$value['question']?>" name="faq_question[]" >
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="faq_answer" class="col-sm-2 col-form-label">Answer</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="faq_answer" placeholder="Answer" value="<?=$value['answer']?>" name="faq_answer[]">
                  </div>
                </div>
              </div>
              <?php if($i==1){?>
              <a href="javascript:void(0);" class="add_button btn btn-success btn-sm" title="Add field"><i class="bx bx-plus"></i></a>
              <?php }else{?>
              <a href="javascript:void(0);" class="btn btn-danger btn-sm"  title="Remove field" id="bt_<?=$i?>" onclick="del_faq(<?=$i?>)"><i class="bx bx-minus"></i></a>
              <?php } ?>
              <?php $i++;} }else{ ?>
              <div class="row mb-3">
                <label for="faq_question" class="col-sm-2 col-form-label">Question</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="faq_question" placeholder="Question" value="" name="faq_question[]" >
                </div>
              </div>
              <div class="row mb-3">
                <label for="faq_answer" class="col-sm-2 col-form-label">Answer</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="faq_answer" placeholder="Answer" value="" name="faq_answer[]">
                </div>
              </div>
              <a href="javascript:void(0);" class="add_button btn btn-success btn-sm" title="Add field"><i class="bx bx-plus"></i></a>
              <?php } ?>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
                <label for="priority" class="col-form-label">Priority</label>
                <?= form_input(['name' => 'priority','autocomplete'=>'off','required' => 'required', 'placeholder' => 'Enter Priority','maxlength'=>'2', 'id' => 'priority', 'class' => 'form-control notzero numbersWithZeroOnlyInput','value'=>$priority]); ?>
              </div>
             <div class="col-sm-4">
                <label for="covered_kms" class="col-form-label">Covered KMs</label>
                <?= form_input(['name' => 'covered_kms','maxlength'=>'4', 'required' => 'required', 'placeholder' => 'Enter Covered KMs', 'id' => 'covered_kms', 'class' => 'form-control notzero numbersWithZeroOnlyInput','value'=>$covered_kms]); ?>
              </div>
              <div class="col-sm-4">
                <label for="image_alt" class="col-form-label">Banner Image Alt</label>
                <?= form_input(['name' => 'image_alt', 'required' => 'required', 'placeholder' => 'Enter Image Alt', 'id' => 'image_alt', 'class' => 'form-control','value'=>$image_alt]); ?>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
                <label for="from_city" class="col-form-label">From City</label>
                <select name="from_city" id="from_city" class="form-control select2" required>
                  <option value="">Select City</option>
                  <?php if(!empty($cities)){foreach($cities as $frckey=>$frcvalue){?>
                  <option value="<?=$frcvalue['city_name']?>" <?=!empty($from_city) && ($from_city==$frcvalue['city_name'])?'selected':''?>><?=$frcvalue['city_name']?></option>
                  <?php }} ?>
                </select>
              </div>
              <div class="col-sm-8">
                <label for="to_city" class="col-form-label">To City</label>
                <select name="to_city[]" id="to_city" class="form-control select2" multiple required>
                  <option value="">Select City</option>
                  <?php if(!empty($cities)){foreach($cities as $tockey=>$tocvalue){?>
                  <option value="<?=$tocvalue['city_name']?>" <?=!empty($to_city) && in_array($tocvalue['city_name'],$to_city)?"selected":""?>><?=$tocvalue['city_name']?></option>
                  <?php }} ?>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
              <label for="banner_image" class="col-form-label">Banner Image</label>
                <?= form_upload([
                  'name' => 'banner_image',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <div class="col-sm-4">
              <label for="bottom_banner" class="col-form-label">Bottom Banner</label>
                <?= form_upload([
                  'name' => 'bottom_banner',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              
            </div>
            <div class="row mb-3">
           
              <?php if (!empty($jpg_image)) { ?>
              <div class="col-sm-4">
                <img src="<?= base_url('uploads/') . $jpg_image; ?>" height=70% width=70%>
              </div>
              <?php } ?>
              <?php if (!empty($bottom_banner_jpg)) { ?>
              <div class="col-sm-4">
                <img src="<?= base_url('uploads/') . $bottom_banner_jpg; ?>" height=70% width=70%>
              </div>
              <?php } ?>
             
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
            <div class="row mb-3">
              <?=form_label('Is Home','is_home',['class'=>'col-sm-2 col-form-label'])?>
              <div class="col-sm-6">
                <div class="row mt-2">
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" name="is_home" <?= ($is_home == 'Yes') ? 'checked' : '' ?> type="radio" id="checkHome1" value="Yes">
                      <?=form_label('Yes','checkHome1',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" name="is_home" <?= ($is_home == 'No') ? 'checked' : '' ?> type="radio" id="checkHome2" value="No">
                      <?=form_label('No','checkHome2',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <?=form_label('Is Popular','is_popular',['class'=>'col-sm-2 col-form-label'])?>
              <div class="col-sm-6">
                <div class="row mt-2">
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" name="is_popular" <?= ($is_popular == 'Yes') ? 'checked' : '' ?> type="radio" id="checkPopular1" value="Yes">
                      <?=form_label('Yes','checkPopular1',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" name="is_popular" <?= ($is_popular == 'No') ? 'checked' : '' ?> type="radio" id="checkPopular2" value="No">
                      <?=form_label('No','checkPopular2',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-start">
              <div class="col-sm-10 mb-2">
                <button type="button"
                  class="btn btn-info"
                  data-bs-toggle="modal"
                  data-bs-target="#modalCenter">Add Price</button>
              </div>
              <?php if(!empty($access) || ($user_type != "Role User") ){?>
              <div class="col-sm-10">
                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
              </div>
                <?php } ?>
            </div>
            <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Vehicle Price</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="vehicle_price_wrapper">
                      <?php if(!empty($vehicle_price_list)){
                        $i=1;
                        foreach($vehicle_price_list as $key=>$value){
                        ?>
                      <div id="vpfaq_<?=$i?>">
                        <div class="row mb-3">
                          <div class="col-sm-5">
                            <label for="model_id" class="col-form-label">Select Model</label>
                            <select name="model_id[]" id="model_id" class="form-control">
                              <option value="">--Select Model--</option>
                              <?php if(!empty($models)){foreach($models as $mkey=>$mvalue){?>
                              <option value="<?=$mvalue['id']?>" <?=$value['model_id']==$mvalue['id']?'selected':''?>><?=$mvalue['model_name']?></option>
                              <?php } }?>
                            </select>
                          </div>
                          <div class="col-sm-3">
                            <label for="fixed_price" class="col-form-label">Fixed Price</label>
                            <input type="text" class="form-control numbersWithZeroOnlyInput" maxlength="4" id="fixed_price" placeholder="Fixed Price" value="<?=$value['fixed_price']?>" name="fixed_price[]">
                          </div>
                          <div class="col-sm-3">
                            <label for="per_km_price" class="col-form-label">Per KM Price</label>
                            <input type="text" class="form-control numbersWithZeroOnlyInput" maxlength="2"  id="per_km_price" placeholder="Per KM Price" value="<?=$value['per_km_price']?>" name="per_km_price[]">
                          </div>
                        </div>
                      </div>
                      <?php if($i==1){?>
                      <a href="javascript:void(0);" class="add_vehicle_price_button btn btn-success btn-sm" title="Add field"><i class="bx bx-plus"></i></a>
                      <?php }else{?>
                      <a href="javascript:void(0);" class="btn btn-danger btn-sm"  title="Remove field" id="vpbt_<?=$i?>" onclick="del_vp_faq(<?=$i?>)"><i class="bx bx-minus"></i></a>
                      <?php } ?>
                      <?php $i++;} }else{ ?>
                      <div class="row mb-3">
                        <div class="col-sm-4">
                          <label for="model_id" class="col-form-label">Select Model</label>
                          <select name="model_id[]" id="model_id" class="form-control ">
                            <option value="">--Select Model--</option>
                            <?php if(!empty($models)){foreach($models as $mkey=>$mvalue){?>
                            <option value="<?=$mvalue['id']?>" ><?=$mvalue['model_name']?></option>
                            <?php } }?>
                          </select>
                        </div>
                        <div class="col-sm-4">
                          <label for="fixed_price" class="col-form-label">Fixed Price</label>
                          <input type="text" class="form-control numbersWithZeroOnlyInput" maxlength="4" id="fixed_price" placeholder="Fixed Price" value="" name="fixed_price[]">
                        </div>
                        <div class="col-sm-4">
                          <label for="per_km_price" class="col-form-label">Per KM Price</label>
                          <input type="text" class="form-control numbersWithZeroOnlyInput" maxlength="2" id="per_km_price" placeholder="Per KM Price" value="" name="per_km_price[]">
                        </div>
                      </div>
                      <a href="javascript:void(0);" class="add_vehicle_price_button btn btn-success btn-sm" title="Add field"><i class="bx bx-plus"></i></a>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <?=form_close()?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<script>
   $(document).ready(function(){
    var maxFieldLimit = 10; 
    var add_more_button = $('.add_vehicle_price_button'); 
    var Fieldwrapper = $('.vehicle_price_wrapper');
    var fieldHTML = '<div><div class="row mb-3">' +
                    '<div class="col-sm-4">' +
                    '<label for="model_id" class="col-form-label">Select Model</label>' +
                    '<select name="model_id[]" id="model_id" class="form-control ">' +
                    '<option value="">--Select Model--</option>' +
                    '<?php if(!empty($models)){foreach($models as $mkey=>$mvalue){?>' +
                    '<option value="<?=$mvalue["id"]?>" ><?=$mvalue["model_name"]?></option>' +
                    '<?php } }?>' +
                    '</select>' +
                    '</div>' +
                    '<div class="col-sm-4">' +
                    '<label for="fixed_price" class="col-form-label">Fixed Price</label>' +
                    '<input type="text" class="form-control numbersWithZeroOnlyInput" maxlength="4" id="fixed_price" placeholder="Fixed Price" value="" name="fixed_price[]">' +
                    '</div>' +
                    '<div class="col-sm-4">' +
                    '<label for="per_km_price" class="col-form-label">Per Km Price</label>' +
                    '<input type="text" class="form-control numbersWithZeroOnlyInput" maxlength="2" id="per_km_price" placeholder="Per KM Price" value="" name="per_km_price[]">' +
                    '</div>' +
                    '</div><a href="javascript:void(0);" class="remove_vehicle_price_button btn btn-danger btn-sm"  title="Remove field"><i class="bx bx-minus"></i></a></div><br>'; //New input field HTML 
    var x = 1; 
    $(add_more_button).click(function(){ 
        if(x < maxFieldLimit){ 
            x++;
            $(Fieldwrapper).append(fieldHTML);
        }
    });
    $(Fieldwrapper).on('click', '.remove_vehicle_price_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });
});

function del_vp_faq(a) {
    $('#vpfaq_' + a).remove(); 
    $('#vpbt_' + a).remove(); 
}

   $(document).ready(function(){
    var maxFieldLimit = 10; 
    var add_more_button = $('.add_itd_button'); 
    var Fieldwrapper = $('.itd_wrapper');
    var fieldHTML = '<div><div class="row mb-3">' +
                    '<div class="col-sm-2">' +
                    '<label for="day" class="col-form-label">Day</label>' +
                    '<input type="text" class="form-control" id="day" placeholder="Day" value="" name="day[]">'+
                    '</div>' +
                    '<div class="col-sm-4">' +
                    '<label for="title" class="col-form-label">Title</label>' +
                    '<input type="text" class="form-control" id="title" placeholder="Title" value="" name="title[]">' +
                    '</div>' +
                    '<div class="col-sm-6">' +
                    '<label for="description" class="col-form-label">Description</label>' +
                    '<input type="text" class="form-control itd_description" placeholder="Description" value="" name="description[]">' +
                    '</div>' +
                    '</div><a href="javascript:void(0);" class="remove_itd_button btn btn-danger btn-sm"  title="Remove field"><i class="bx bx-minus"></i></a></div>'; //New input field HTML 
    var x = 1; 
    $(add_more_button).click(function(){ 
        if(x < maxFieldLimit){ 
            x++;
            $(Fieldwrapper).append(fieldHTML);
        }
    });
    $(Fieldwrapper).on('click', '.remove_itd_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });
});

function del_itd(a) {
    $('#itddiv_' + a).remove(); 
    $('#itd_' + a).remove(); 
}



</script>