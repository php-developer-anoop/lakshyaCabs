<div class="container-fluid">
  <div class="row">
    <div class="col-sm-7 pl-0 pr-0">
      <section class="contact_sec sec_padd pl-60 pr-30">
        <div class="norml_hdng">
          <h1><?=!empty($page['h_one_heading'])?$page['h_one_heading']:""?></h1>
        </div>
        <div class="content">
          <?=!empty($page['content_data'])?$page['content_data']:""?>
        </div>
      </section>
    </div>
    <?=view('frontend/common_cms_form')?>
  </div>
</div>