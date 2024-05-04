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
            <?=form_open_multipart(ADMINPATH.'importFile')?>
            <div class="row mb-3">
            <div class="col-sm-4">
                  <label for="banner_image" class="col-form-label">CSV File</label>
                <?= form_upload([
                  'name' => 'csv_file',
                  'class' => 'form-control',
                  'accept' => '.csv',
                  'required'=>'required'
                  ]); ?>
              </div>
            </div>
            <div class="row justify-content-start">
              <div class="col-sm-10">
                <button type="submit" id="export" class="btn btn-primary" >Import</button>
              </div>
            </div>
            <?=form_close()?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
