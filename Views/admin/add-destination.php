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
                <h4 class="cardhdng">Add Destinations</h4>
                <a href="<?= base_url(ADMINPATH . 'destination-list') ?>" class="sitebtn">View List</a>
            </div>
            <?=form_open_multipart(ADMINPATH . 'save-destination'); ?>
            <?=form_hidden('id',$id)?>
            <input type="hidden" name="old_jpg_image" value="<?= !empty($jpg_image) ? $jpg_image : ''; ?>">
            <input type="hidden" name="old_webp_image"value="<?= !empty($webp_image) ? $webp_image : ''; ?>">
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Select State','state',['class'=>'col-form-label'])?>
                <select name="state" id="state" class="form-control select2" required onchange="getCities(this.value,'<?=$city_id.','.$city_name?>')">
                  <option value="">--Select State--</option>
                  <?php if(!empty($states)){foreach($states as $key=>$value){?>
                  <option value="<?=$value['id'].','.$value['state_name']?>" <?=!empty($state_id) && ($state_id==$value['id'])?"selected":""?>><?=$value['state_name']?></option>
                  <?php }} ?>
                </select>
              </div>
              <div class="col-sm-3">
                <?=form_label('Select City','city',['class'=>'col-form-label'])?>
                <select name="city" id="city" class="form-control select2" required>
                  <option value="">--Select City--</option>
                </select>
              </div>
              <div class="col-sm-6">
                <?=form_label('Destination Name','destination',['class'=>'col-form-label'])?>
                <input type="text" name="destination" autocomplete="off" onkeyup="return checkDuplicate(this.value,'destinations','destination')" value="<?=$destination?>"  class="form-control ucwords restrictedInput" required id="destination" placeholder="Destination Name" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
                <?=form_label('URL','url',['class'=>'col-form-label'])?>
                <input type="text" name="url" autocomplete="off" value="<?=$url?>"  class="form-control" required id="url" placeholder="URL" />
              </div>
              <div class="col-sm-8">
                <?=form_label('H1','h1',['class'=>'col-form-label'])?>
                <input type="text" name="h1" autocomplete="off" value="<?=$h1?>"  class="form-control" required id="h1" placeholder="H1 Heading" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Description','description',['class'=>'col-form-label'])?>
                <textarea  name="description" autocomplete="off" class="form-control" required id="description" placeholder="Description"><?=$description?></textarea>
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
              <label for="banner_image" class="col-sm-2 col-form-label">Banner Image</label>
              <div class="col-sm-3">
                <?= form_upload([
                  'name' => 'banner_image',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <?php if (!empty($jpg_image)) { ?>
              <div class="col-sm-2">
                <img src="<?= base_url('uploads/') . $jpg_image; ?>" height=70px width=100px>
              </div>
              <?php } ?>
              <label for="image_alt" class="col-sm-2 col-form-label">Banner Image Alt</label>
              <div class="col-sm-3">
                <?= form_input(['name' => 'image_alt', 'required' => 'required', 'placeholder' => 'Enter Image Alt', 'id' => 'image_alt', 'class' => 'form-control','value'=>$image_alt]); ?>
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