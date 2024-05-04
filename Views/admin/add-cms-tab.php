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
      <div class="col-sm-12">
        <a href="<?= base_url(ADMINPATH . 'cms-tab-list') ?>" class="sitebtn mb-3" style="float:right;position:relative;">View CMS Tabs</a>
      </div>
    </div>
    <div class="row">
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-body">
            <?=form_open_multipart(ADMINPATH . 'save-cms-tab'); ?>
            <?=form_hidden('id',$id)?> 
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Tab Name','tab_name',['class'=>'col-form-label'])?>
                <input type="text" name="tab_name" autocomplete="off"  value="<?=$tab_name?>"  class="form-control" required id="tab_name" placeholder="Tab Name" />
              </div>
              <div class="col-sm-3">
                <?=form_label('Trip Type','trip_type',['class'=>'col-form-label'])?>
                <?=form_dropdown(['name'=>'trip_type','class'=>'form-control select2', 'required' => 'required', 'id'=>'trip_type'],$trip_type_list,set_value('trip_type',$trip_type) ); ?> 
              </div>
              <div class="col-sm-3">
                <?=form_label('Sequence','priority',['class'=>'col-form-label'])?>
                <input type="text" name="priority" autocomplete="off"  value="<?=$priority?>"  class="form-control numbersOnly" required id="priority" placeholder="Sequence No" />
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