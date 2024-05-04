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
              <h4 class="cardhdng"><?=$menu?></h4>
              <a href="<?= base_url(ADMINPATH . 'vehicle-page-list' ) ?>" class="sitebtn">View List</a>
            </div>
            <?=form_open_multipart(ADMINPATH.'save-vehicle-page'); ?>
            <?=form_hidden('id',$id)?>
            <input type="hidden" name="old_banner_image_jpg" value="<?=$banner_image_jpg?>">
            <input type="hidden" name="old_banner_image_webp" value="<?=$banner_image_webp?>">
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Display Name','display_name',['class'=>'col-form-label'])?>
                <input type="text" name="display_name" autocomplete="off" value="<?=$display_name?>" onchange="return checkDuplicate(this.value,'dt_vehicle_page_master','')"  class="form-control" required id="display_name" placeholder="Display Name" />
              </div>
              <div class="col-sm-3">
                <?=form_label('Page Slug(URL)','slug',['class'=>'col-form-label'])?>
                <input type="text" name="slug" autocomplete="off" value="<?=$slug?>"  class="form-control" required id="url" placeholder="URL" />
              </div>
              <div class="col-sm-3">
                <?=form_label('State','state_id',['class'=>'col-form-label'])?>
               <select name="state_id" class="form-control select2" id="state_id" onchange="getCities(this.value,<?=!empty($stateid)?$stateid:''?>)">
                   <option value="">Select State</option>
                   <?php if(!empty($states)){foreach($states as $slkey=>$slvalue){?>
                   <option value="<?=$slvalue['id']?>" <?=!empty($state_id) && ($state_id == $slvalue['id']) ?"selected":""?>><?=$slvalue['state_name']?></option>
                   <?php }} ?>
               </select>
              </div>
              <div class="col-sm-3">
                <?=form_label('City','city',['class'=>'col-form-label'])?>
                <select name="city" id="city" class="form-control select2">
                    <option value="">Select City</option>
                    
                </select>
              </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                <?=form_label('Select Model','model_id',['class'=>'col-form-label'])?>
               <select name="model_id" class="form-control select2" id="model_id">
                   <option value="">Select Model</option>
                   <?php if(!empty($model_list)){foreach($model_list as $mlkey=>$mlvalue){?>
                   <option value="<?=$mlvalue['id']?>" <?=!empty($model_id) && ($model_id == $mlvalue['id']) ?"selected":""?>><?=$mlvalue['model_name']?></option>
                   <?php }} ?>
               </select>
              </div>
              <div class="col-sm-9">
                <?=form_label('Heading H1','h1_heading',['class'=>'col-form-label'])?>
                <input type="text" name="h1_heading" autocomplete="off" value="<?=$h1_heading?>"  class="form-control" required id="h1_heading" placeholder="H1 Heading" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Short Description','short_description',['class'=>'col-form-label'])?>
                <textarea  name="short_description" autocomplete="off" class="form-control" required id="short_description" placeholder="Short Description"><?=$short_description?></textarea>
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
                <?=form_label('Meta Keyword','meta_keyword',['class'=>'col-form-label'])?>
                <textarea name="meta_keyword" autocomplete="off" class="form-control" required id="meta_keyword" placeholder="Meta Keyword"><?=$meta_keyword?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Page Schema','page_schema',['class'=>'col-form-label'])?>
                <textarea name="page_schema" autocomplete="off" class="form-control"  id="page_schema" placeholder="Page Schema"><?=$page_schema?></textarea>
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
              <label for="banner_image_jpg" class="col-sm-2 col-form-label">Banner Image</label>
              <div class="col-sm-3">
                <?= form_upload([
                  'name' => 'banner_image',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <?php if (!empty($banner_image_jpg)) { ?>
              <div class="col-sm-2">
                <img src="<?= base_url('uploads/') . $banner_image_jpg; ?>" height=70px width=100px>
              </div>
              <?php } ?>
              <label for="banner_image_alt" class="col-sm-2 col-form-label">Banner Image Alt</label>
              <div class="col-sm-3">
                <?= form_input(['name' => 'banner_image_alt', 'required' => 'required', 'placeholder' => 'Enter Banner Image Alt', 'id' => 'banner_image_alt', 'class' => 'form-control','value'=>$banner_image_alt]); ?>
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
    <?php if(!empty($city_id)){ ?>
    getCities(<?= !empty($state_id) ? $state_id : '' ?>, <?= $city_id ?>)
<?php } ?>

function getCities(id, cityvalue){
    $('#city').html('');
    $.ajax({
        url: '<?= base_url('getCities') ?>',
        method: 'POST',
        data: { state_id: id, city: cityvalue },
        success: function (response) {
            $('#city').html(response);
        }
    });
}
</script>