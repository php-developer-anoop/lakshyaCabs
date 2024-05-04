<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="d-flex flex-row justify-content-between ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="javascript:void(0);">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="javascript:void(0);">
          <?= $menu ?>
          </a>
        </li>
        <li class="breadcrumb-item active">
          <?= $title ?>
        </li>
      </ol>
    </nav>
    <div class="dflexbtwn hdngvwall">
                <h4 class="cardhdng"><?=$title?></h4>
                <a href="<?= base_url(VENDORPATH . 'tickets') ?>" class="sitebtn">View List</a>
          </div>
    <div class="row gy-3">
      <div class="col-lg-3">
        <div class="card sideticket border-0 rounded-3">
          <div class="card-body px-0 pad-text">
            <div class="d-flex-flex-column gap-0">
              <p class="mb-0 text-start"><?=$user_name?></p>
              <p class="mb-0 text-start"><?=$user_mobile_no?></p>
              <hr class="line-color" />
            </div>
            <div class="d-flex-flex-column gap-0">
              <p class="mb-0 text-start">Ticket ID</p>
              <p class="mb-0 text-start text-primary"><?=$ticket_id?></p>
              <hr class="line-color" />
            </div>
            <div class="d-flex-flex-column gap-0">
              <p class="mb-0 text-start">Subject</p>
              <p class="mb-0 text-start"><?=$subject?></p>
              <hr class="line-color" />
            </div>
            <div class="d-flex-flex-column gap-0">
              <p class="mb-0 text-start">Status</p>
              <p class="mb-0 text-start text-green"><?=$status?></p>
              <hr class="line-color" />
            </div>
            <div class="d-flex-flex-column gap-0">
              <p class="mb-0 text-start">Urgency</p>
              <p class="mb-0 text-start text-danger"><?=$urgency_type?></p>
              <hr class="line-color" />
            </div>
            <div class="d-flex-flex-column gap-0">
              <p class="mb-0 text-start">Submitted On</p>
              <p class="mb-0 text-start"><?=$add_date?></p>
            </div>
            <?php if(!empty($update_date)){?>
            <hr class="line-color" />
            <div class="d-flex-flex-column gap-0">
              <p class="mb-0 text-start">Updated On</p>
              <p class="mb-0 text-start"><?=$update_date?></p>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="d-flex flex-column gap-3">
          <div class="card border-0 rounded-3">
            <?php if(($is_final_closed == "no")){ ?>
            <div class="card-body">
              <div class="d-flex justify-content-between px-2" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <div class="">
                  <a href="#" class="text-decoration-none d-flex flex-row gap-2">
                  <span><img src="<?=base_url('assets/vendor/images/reply.png')?>"></span>
                  <span>Reply</span>
                  </a>
                </div>
                <div class="">
                  <i class="fa-solid fa-caret-down"></i>
                </div>
              </div>
              <?=form_open_multipart(base_url(VENDORPATH.'save-ticket'))?>
              <?=form_hidden('parent_id',$id)?>
              <?=form_hidden('ticket_id',$ticket_id)?>
              <div class="collapse" id="collapseExample">
                <!--<hr class="line-color mt-4" />-->
                <div class="mt-3 d-flex flex-column gap-3">
                  <div class="d-flex flex-column gap-1">
                    <p class="mb-0">Message</p>
                    <textarea class="form-control" name="description" id="floatingTextarea2"
                      style="height: 140px" required></textarea>
                  </div>
                  <div class="d-flex flex-row gap-3">
                    <button class="btn btn-theme px-4">Submit</button>
                    <!--<button class="btn btn-theme-secondary px-4">Cancel</button>-->
                  </div>
                </div>
              </div>
              <?=form_close()?>
            </div>
            <?php } ?>
          </div>
          <?php if(!empty($reply_list)){foreach($reply_list as $rlkey=>$rlvalue){?>
          <div class="card border-0 rounded-3">
            <div class="card-body px-0">
              <div class="d-flex flex-row justify-content-between px-3">
                <h5 class="mb-0"><?=!empty($rlvalue['user_name'])?$rlvalue['user_name']:''?></h5>
                <p class="text-secondary mb-0"><?=!empty($rlvalue['add_date'])?date('d/m/Y, h:i a',strtotime($rlvalue['add_date'])):''?></p>
              </div>
              <hr class="line-color mt-3 p-0" />
              <div class="px-3 width-text d-flex flex-column py-3">
                <p class="mb-0"><?=!empty($rlvalue['description'])?$rlvalue['description']:''?></p>
                <!--<hr class="line-color-text  mt-3 p-0" />-->
                <!--<p class="mb-0">IP Address: 2041:4900:1f3d:82a6</p>-->
              </div>
              <?php if(!empty($rlvalue['image'])){?>
              <hr class="line-color  p-0" />
              <div class="px-3">
                <p>Attachment</p>
                <div class="">
                  <p class="mb-0">
                    <a href="<?=base_url('uploads/'.$rlvalue['image'])?>" download>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        viewBox="0 0 16 16" fill="none">
                        <rect width="16" height="16" fill="white" style="mix-blend-mode:multiply" />
                        <path
                          d="M13 12V14H3V12H2V14C2 14.2652 2.10536 14.5196 2.29289 14.7071C2.48043 14.8946 2.73478 15 3 15H13C13.2652 15 13.5196 14.8946 13.7071 14.7071C13.8946 14.5196 14 14.2652 14 14V12H13Z"
                          fill="#2562C2" />
                        <path
                          d="M13 7L12.295 6.295L8.5 10.085V1H7.5V10.085L3.705 6.295L3 7L8 12L13 7Z"
                          fill="#2562C2" />
                      </svg>
                    <a href="<?=base_url('uploads/'.$rlvalue['image'])?>" target="_anoop"><i class="fa fa-eye"></i></a>
                  </p>
                  </a>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
          <?php }} ?>
        </div>
      </div>
    </div>
  </div>
</div>