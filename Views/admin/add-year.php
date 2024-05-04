<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
  <nav aria-label="breadcrumb">
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
        <div class="card-header">
        <a href="<?= base_url(ADMINPATH . 'years-list') ?>" class="btn btn-success m-auto" style="float:right;position:relative;">View Financial Years</a>
      </div>
          <div class="card-body">
            <?=form_open(ADMINPATH . 'save-year'); ?>
            <?=form_hidden('id',$id)?>
            <div class="row mb-3">
            <?=form_label('Start Year','from',['class'=>'col-sm-2 col-form-label'])?>
              <div class="col-sm-3">
                <input type="text" name="start_year" autocomplete="off" value="<?=$start_year?>" maxlength="4" class="form-control numbersWithZeroOnlyInput" required id="from" placeholder="Start Year" />
              </div>
              <?=form_label('End Year','to',['class'=>'col-sm-2 col-form-label'])?>
              <div class="col-sm-3">
                <input type="text" name="end_year" autocomplete="off" value="<?=$end_year?>" maxlength="4" class="form-control numbersWithZeroOnlyInput" required id="to" placeholder="End Year" />
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
            <?php if(!empty($access) || ($user_type != "Admin")){?>
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