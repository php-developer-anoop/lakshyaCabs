<div class="container-fluid">
  <div class="row">
    <div class="col-sm-7 pl-0 pr-0">
      <section class="contact_sec sec_padd pl-60 pr-30">
        <div class="norml_hdng">
          <h1><?=!empty($page['h1'])?$page['h1']:""?></h1>
        </div>
        <div class="content">
          <?=!empty($page['description'])?$page['description']:""?>
        </div>
        <div class="contct_row d-flex">
          <div class="contct-itm">
            <div class="c_icon">
              <i class="fa fa-phone"> </i>
              <h6>Call Us</h6>
              <p>
                <?=!empty($company['care_mobile'])?'+91'.$company['care_mobile']:''?>
              </p>
            </div>
          </div>
          <div class="contct-itm">
            <div class="c_icon">
              <i class="fa fa-map-marker"> </i>
              <h6>Address</h6>
              <p>
                <?=!empty($company['office_address'])?$company['office_address']:''?> 
              </p>
            </div>
          </div>
          <div class="contct-itm">
            <div class="c_icon">
              <i class="fa fa-envelope"> </i>
              <h6>Email</h6>
              <p>
                <?=!empty($company['care_email'])?$company['care_email']:''?> 
              </p>
            </div>
          </div>
        </div>
      </section>
      <section class="maps sec_padd pl-60 pr-30">
        <?=!empty($company['map_script'])?$company['map_script']:''?> 
      </section>
      <?=view('frontend/popular-city-taxi')?>
    </div>
    <?=view('frontend/common_cms_form')?>
  </div>
</div>