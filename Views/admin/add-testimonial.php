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
        <li class="breadcrumb-item active"><?=$maintitle?></li>
      </ol>
      <a href="<?= base_url(ADMINPATH . 'testimonial-list') ?>" class="btn btn-success mb-3" style="float:right;position:relative;">View Testimonials</a>
    </nav>
    <div class="row">
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-body">
            <?=form_open_multipart(ADMINPATH . 'save-testimonial'); ?>
            <?=form_hidden('id',$id)?>
            <input type="hidden" name="old_jpg_image" value="<?= !empty($jpg_image) ? $jpg_image : ''; ?>">
            <input type="hidden" name="old_webp_image"value="<?= !empty($webp_image) ? $webp_image : ''; ?>">
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Person Name','person_name',['class'=>'col-form-label'])?>
                <input type="text" name="person_name" autocomplete="off"  value="<?=$person_name?>"  class="form-control ucwords restrictedInput" required id="person_name" placeholder="Person Name" />
              </div>
              <div class="col-sm-3">
                <?=form_label('Place','place',['class'=>'col-form-label'])?>
                <input type="text" name="place" autocomplete="off"  value="<?=$place?>"  class="form-control ucwords restrictedInput" required id="place" placeholder="Place" />
              </div>
              <div class="col-sm-3">
                <?=form_label('Title','title',['class'=>'col-form-label'])?>
                <input type="text" name="title" autocomplete="off"  value="<?=$title?>"  class="form-control ucwords restrictedInput" required id="title" placeholder="Title" />
              </div>
              <div class="col-sm-3">
                <?=form_label('Rating','rating',['class'=>'col-form-label'])?>
                <select name="rating" id="rating" class="form-control select2">
                    <option value="">Select Rating</option>
                    <?php for($i=1;$i<=5;$i++){?>
                        <option value="<?=$i?>" <?=!empty($rating) && ($rating==$i)?"selected":""?>><?=$i?></option>
                    <?php } ?>
                </select>
              </div>
              <div class="col-sm-12">
                <?=form_label('Description','description',['class'=>'col-form-label'])?>
                <input type="text" name="description" autocomplete="off"  value="<?=$description?>"  class="form-control ucwords restrictedInput" required id="" placeholder="Description" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
                <label for="image" class="col-form-label">Image</label>
                <?= form_upload([
                  'name' => 'image',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <div class="col-sm-2">
                <?php if (!empty($jpg_image)) { ?>
                <img src="<?= base_url('uploads/') . $jpg_image; ?>" height=70px width=100px>
                <?php } ?>
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