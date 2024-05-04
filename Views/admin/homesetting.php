<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="javascript:void(0);">Home</a>
        </li>
        <li class="breadcrumb-item active"><?=$title?></li>
      </ol>
    </nav>
    <div class="row">
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-body">
            <?=form_open_multipart(ADMINPATH . 'save-home-setting'); ?>
            <?=form_hidden('id',!empty($home['id'])?$home['id']:"")?>
            <?=form_hidden('old_top_banner_jpg',!empty($home['top_banner_jpg'])?$home['top_banner_jpg']:"")?>
            <?=form_hidden('old_top_banner_webp',!empty($home['top_banner_webp'])?$home['top_banner_webp']:"")?>
            <?=form_hidden('old_mid_banner_jpg',!empty($home['mid_banner_jpg'])?$home['mid_banner_jpg']:"")?>
            <?=form_hidden('old_mid_banner_webp',!empty($home['mid_banner_webp'])?$home['mid_banner_webp']:"")?>
            <?=form_hidden('old_bottom_banner_jpg',!empty($home['bottom_banner_jpg'])?$home['bottom_banner_jpg']:"")?>
            <?=form_hidden('old_bottom_banner_webp',!empty($home['bottom_banner_webp'])?$home['bottom_banner_webp']:"")?>
            <?=form_hidden('old_tour_package_mid_banner_jpg',!empty($home['tour_package_mid_banner_jpg'])?$home['tour_package_mid_banner_jpg']:"")?>
            <?=form_hidden('old_tour_package_mid_banner_webp',!empty($home['tour_package_mid_banner_webp'])?$home['tour_package_mid_banner_webp']:"")?>
            <?=form_hidden('old_tour_package_bottom_banner_jpg',!empty($home['tour_package_bottom_banner_jpg'])?$home['tour_package_bottom_banner_jpg']:"")?>
            <?=form_hidden('old_tour_package_bottom_banner_webp',!empty($home['tour_package_bottom_banner_webp'])?$home['tour_package_bottom_banner_webp']:"")?>
            <div class="row mb-3">
              <div class="col-sm-6">
                <label class="col-form-label" for="top_heading">Top Heading</label>
                <input type="text" name="top_heading" value="<?=!empty($home['top_heading']) ? $home['top_heading']:''?>" class="form-control ucwords restrictedInput" required id="top_heading" placeholder="Top Heading" />
              </div>
              <div class="col-sm-6">
                <label class="col-form-label" for="top_sub_heading">Top Sub Heading</label>
                <input type="text" name="top_sub_heading" value="<?=!empty($home['top_sub_heading']) ? $home['top_sub_heading']:''?>" class="form-control ucwords restrictedInput" required id="top_sub_heading" placeholder="Top Sub Heading" />
              </div>
              <div class="col-sm-6">
                <label class="col-form-label" for="trending_package_heading">Trending Package Heading</label>
                <input type="text" name="trending_package_heading" value="<?=!empty($home['trending_package_heading']) ? $home['trending_package_heading']:''?>" class="form-control ucwords restrictedInput" required id="trending_package_heading" placeholder="Trending Package Heading" />
              </div>
              <div class="col-sm-6">
                <label class="col-form-label" for="about_heading">About Heading</label>
                <input type="text" name="about_heading" value="<?=!empty($home['about_heading']) ? $home['about_heading']:''?>" class="form-control ucwords restrictedInput" required id="about_heading" placeholder="About Heading" />
              </div>
              <div class="col-sm-6">
                <label class="col-form-label" for="about_sub_heading">About Sub Heading</label>
                <input type="text" name="about_sub_heading" value="<?=!empty($home['about_sub_heading']) ? $home['about_sub_heading']:''?>" class="form-control ucwords restrictedInput" required id="about_sub_heading" placeholder="About Sub Heading" />
              </div>
              <div class="col-sm-6">
                <label class="col-form-label" for="taxi_heading">Taxi Heading</label>
                <input type="text" name="taxi_heading" value="<?=!empty($home['taxi_heading']) ? $home['taxi_heading']:''?>" class="form-control ucwords restrictedInput" required id="taxi_heading" placeholder="Taxi Heading" />
              </div>
              <div class="col-sm-6">
                <label class="col-form-label" for="testimonial_heading">Testimonial Heading</label>
                <input type="text" name="testimonial_heading" value="<?=!empty($home['testimonial_heading']) ? $home['testimonial_heading']:''?>" class="form-control ucwords restrictedInput" required id="testimonial_heading" placeholder="Testimonial Heading" />
              </div>
              <div class="col-sm-6">
                <label class="col-form-label" for="faq_heading">FAQ Heading</label>
                <input type="text" name="faq_heading" value="<?=!empty($home['faq_heading']) ? $home['faq_heading']:''?>" class="form-control ucwords restrictedInput" required id="faq_heading" placeholder="FAQ Heading" />
              </div>
              <div class="col-sm-6">
                <label class="col-form-label" for="faq_sub_heading">FAQ Sub Heading</label>
                <input type="text" name="faq_sub_heading" value="<?=!empty($home['faq_sub_heading']) ? $home['faq_sub_heading']:''?>" class="form-control ucwords restrictedInput" required id="faq_sub_heading" placeholder="FAQ Sub Heading" />
              </div>
              <div class="col-sm-6">
                <label class="col-form-label" for="taxi_rental_heading">Taxi Rental Heading</label>
                <input type="text" name="taxi_rental_heading" value="<?=!empty($home['taxi_rental_heading']) ? $home['taxi_rental_heading']:''?>" class="form-control ucwords restrictedInput" required id="taxi_rental_heading" placeholder="Taxi Rental Heading" />
              </div>
              <div class="col-sm-6">
                <label class="col-form-label" for="taxi_rental_sub_heading">Taxi Rental Sub Heading</label>
                <input type="text" name="taxi_rental_sub_heading" value="<?=!empty($home['taxi_rental_sub_heading']) ? $home['taxi_rental_sub_heading']:''?>" class="form-control ucwords restrictedInput" required id="taxi_rental_sub_heading" placeholder="Taxi Rental Sub Heading" />
              </div>
              <div class="col-sm-6">
                <label class="col-form-label" for="popular_heading">Popular Heading</label>
                <input type="text" name="popular_heading" value="<?=!empty($home['popular_heading']) ? $home['popular_heading']:''?>" class="form-control ucwords restrictedInput" required id="popular_heading" placeholder="Popular Heading" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
                <label class="col-form-label" for="logo">Top Banner</label>
                <input type="file" name="top_banner" class="form-control" id="top_banner"  accept="image/png, image/jpg, image/jpeg" />
              </div>
              
              <div class="col-sm-4">
                <label class="col-form-label" for="mid_banner">Mid Banner</label>
                <input type="file" name="mid_banner" class="form-control"  id="mid_banner" accept="image/png, image/jpg, image/jpeg"  />
              </div>
              <div class="col-sm-4">
                <label class="col-form-label" for="bottom_banner">Bottom Banner</label>
                <input type="file" name="bottom_banner" class="form-control"  id="bottom_banner" accept="image/png, image/jpg, image/jpeg"  />
              </div>
            </div>
            <div class="row mb-3">
              <?php if(!empty($home['top_banner_jpg'])){?>
              <div class="col-sm-4">
                <img src="<?= base_url('uploads/') . $home['top_banner_jpg']; ?>" height="70px" width="120px" alt="Logo">
              </div>
              <?php } ?>
              <?php if(!empty($home['mid_banner_jpg'])){?>
              <div class="col-sm-4">
                <img src="<?= base_url('uploads/') . $home['mid_banner_jpg']; ?>" height="70px" width="120px" alt="Logo">
              </div>
              <?php } ?>
              <?php if(!empty($home['bottom_banner_jpg'])){?>
              <div class="col-sm-4">
                <img src="<?= base_url('uploads/') . $home['bottom_banner_jpg']; ?>" height="70px" width="120px" alt="Logo">
              </div>
              <?php } ?>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
                <label class="col-form-label" for="logo">Tour Package Mid Banner</label>
                <input type="file" name="tour_package_mid_banner" class="form-control" id="tour_package_mid_banner"  accept="image/png, image/jpg, image/jpeg" />
              </div>
              <?php if(!empty($home['tour_package_mid_banner_jpg'])){?>
              <div class="col-sm-2">
                <img src="<?= base_url('uploads/') . $home['tour_package_mid_banner_jpg']; ?>" height="70px" width="120px" alt="Logo">
              </div>
              <?php } ?>
              <div class="col-sm-4">
                <label class="col-form-label" for="tour_package_bottom_banner">Tour Package Bottom Banner</label>
                <input type="file" name="tour_package_bottom_banner" class="form-control"  id="tour_package_bottom_banner" accept="image/png, image/jpg, image/jpeg"  />
              </div>
              <?php if(!empty($home['tour_package_bottom_banner_jpg'])){?>
              <div class="col-sm-2">
                <img src="<?= base_url('uploads/') . $home['tour_package_bottom_banner_jpg']; ?>" height="70px" width="120px" alt="Logo">
              </div>
              <?php } ?>
            </div>
            <div class="row justify-content-start">
              <?php if(!empty($access) || ($user_type!="Role User")){?>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
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