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
              <h4 class="cardhdng"><?=$title?></h4>
              <a href="<?= base_url(ADMINPATH . 'configure-city-page') ?>" class="sitebtn">View List</a>
            </div>
            <?=form_open_multipart(ADMINPATH . 'save-tab-city-seo-page'); ?>
            <?=form_hidden('id',$id)?>
            <?=form_hidden('tab_id',$tab_id)?>
            <?=form_hidden('parent_id',$parent_id)?>
            <?=form_hidden('from_city_id',$from_city_id)?>
            <?=form_hidden('from_city_name',$from_city_name)?>
            <input type="hidden" name="old_banner_image_jpg" value="<?= !empty($banner_image_jpg) ? $banner_image_jpg : ''; ?>">
            <input type="hidden" name="old_banner_image_webp"value="<?= !empty($banner_image_webp) ? $banner_image_webp : ''; ?>">
            <div class="row mb-3">
              <div class="col-sm-6">
                <?=form_label('Page Name','page_name',['class'=>'col-form-label'])?>
                <input type="text" name="page_name" autocomplete="off" value="<?= $page_name ?>" <?= empty($id) ? "onkeyup=\"return checkDuplicate(this.value,'all_cms_data','page_name')\"" : '' ?> class="form-control ucwords restrictedInput" required id="page_name" placeholder="Page Name" />

              </div>
              <div class="col-sm-6">
                <?=form_label('Page Slug(URL)','page_slug',['class'=>'col-form-label'])?>
                <input type="text" name="page_slug" autocomplete="off" value="<?=$page_slug?>"  class="form-control restrictedInput" required id="url" placeholder="URL" />
              </div>
              
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Heading H1','h_one_heading',['class'=>'col-form-label'])?>
                <input type="text" name="h_one_heading" autocomplete="off" value="<?=$h_one_heading?>"  class="form-control" required id="h_one_heading" placeholder="H1 Heading" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Description','content_data',['class'=>'col-form-label'])?>
                <textarea  name="content_data" autocomplete="off" class="form-control" required id="description" placeholder="Description"><?=$content_data?></textarea>
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
                <?=form_label('Meta Keywords','meta_keywords',['class'=>'col-form-label'])?>
                <textarea name="meta_keywords" autocomplete="off" class="form-control" required id="meta_keywords" placeholder="Meta Keywords"><?=$meta_keywords?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Page Business Schema','page_schema',['class'=>'col-form-label'])?>
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
            <div class="row mt-3">
                <div class="col-sm-3">
                <label for="banner_image_jpg" class="col-form-label">Banner Image</label> 
                <?= form_upload([
                  'name' => 'banner_image_jpg',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
                <div class="col-sm-3">
                <label for="banner_image_alt" class="col-form-label">Banner Image Alt</label>
                <?= form_input(['name' => 'banner_image_alt', 'required' => 'required', 'placeholder' => 'Enter Image Alt', 'id' => 'banner_image_alt', 'class' => 'form-control','value'=>$banner_image_alt]); ?>
              </div>
              
              <div class="col-sm-2">
                <?php if (!empty($banner_image_jpg)) { ?>
                <img src="<?= base_url('uploads/') . $banner_image_jpg; ?>" height="70px" width="100px" >
                <?php } ?>
              </div>
            </div>
            <div class="row mt-3">
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
            <div class="row justify-content-start mt-3">
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
    $(document).ready(function(){
        var slug_value=$('#page_name').val();
        getSlug(slug_value);
    });
</script>