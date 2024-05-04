<?php if (!empty($faqs)) { ?>
<section class="faqs sec_padd pl-60 pr-30 os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
  <div class="hdng_btn d-flex">
    <div class="norml_hdng">
      <h2>FAQs</h2>
      <!-- <p class="sub_hdng">Outstation Taxi Service in Lucknow | Local cabs in Lucknow Airport</p> -->
    </div>
    <!--<a href="<?=base_url('faqs')?>" class="viewall">View All</a>-->
  </div>
  
  <div class="faqs_txt">
    <?php $i = 1; ?>
    <div class="accordion" id="accordionExample">
      <?php foreach ($faqs as $key => $value) { ?>
      <div class="accordion-item faqs_column">
        <h2 class="accordion-header <?= ($i !== 1) ? 'collapsed' : '' ?>" id="heading<?= $i ?>">
          <button class="accordion-button faq_qstn"  type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>" aria-expanded="<?= ($i === 1) ? 'true' : 'false' ?>" aria-controls="collapse<?= $i ?>">
          <?= $i ?>- <?= $value['question'] ?>
          </button>
        </h2>
        <div id="collapse<?= $i ?>" class="accordion-collapse <?= ($i !== 1) ? 'collapse' : 'show' ?>" aria-labelledby="heading<?= $i ?>" data-bs-parent="#accordionExample">
          <div class="accordion-body faq_answr">
            <p><?= $value['answer'] ?></p>
          </div>
        </div>
      </div>
      <?php $i++; ?>
      <?php } ?>
    </div>
  </div>
  
</section>
<?php } ?>