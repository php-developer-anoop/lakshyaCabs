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
    <?php if(!empty($ratings)){?>
    <div class="d-flex flex-column gap-3">
      <div class="card border-0 rounded-4">
        <div class="card-body px-0">
            <?php foreach($ratings as $rkey=>$rvalue){?>
          <div class="d-flex flex-column gap-3 ">
            <div class="d-flex flex-column gap-2 align-items-start px-3">
              <b class="fw-medium fs-5"><?=$rvalue['customer_name']?></b>
              <div
                class="d-flex gap-2 align-items-center justify-content-between w-100"
                >
                <div class="d-flex gap-2 flex-row stars list-unstyled">
                 <?=showRatings($rvalue['rating'])?>
                </div>
                <p class="text-secondary mb-0"><?=$rvalue['add_date']?></p>
              </div>
              <p class="mb-0">
               <?=$rvalue['description']?>
              </p>
            </div>
            <hr class="line-color mt-0 " />
          </div>
          <?php } ?>
          <!--<div class="container">-->
          <!--  <div-->
          <!--    class="d-flex justify-content-between numerer flex-column gap-3 flex-lg-row pt-3"-->
          <!--    >-->
          <!--    <div class="">-->
          <!--      <div class="d-flex flex-row gap-2 align-items-center">-->
          <!--        <b class="fw-medium">Show</b>-->
          <!--        <input type="number" />-->
          <!--        <b class="fw-medium">Enteries</b>-->
          <!--        <b class="fw-medium ps-3"-->
          <!--          >Showing 1 to 10 of 10 entries</b-->
          <!--          >-->
          <!--      </div>-->
          <!--    </div>-->
          <!--    <div class="d-flex gap-2 flex-row align-items-center">-->
          <!--      <button class="btn btn-secondary py-1">Previous</button>-->
          <!--      <b class="indexer">1</b>-->
          <!--      <button class="btn btn-primary py-1">Next</button>-->
          <!--    </div>-->
          <!--  </div>-->
          <!--</div>-->
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>