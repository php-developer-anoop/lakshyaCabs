<div class="container-fluid">
  <div class="row">
    <div class="col-sm-7 pl-0 pr-0">
      <section class="contact_sec sec_padd pl-60 pr-30">
	  <?=!empty($page['content_data'])?$page['content_data']:""?>
      </section>
    </div>
    <?=view('frontend/common_cms_form')?>
  </div>
</div>