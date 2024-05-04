<section class="py-4 py-md-5">
  <div class="container">
    <div class="row os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
      <div class="col-md-12">
        <div class="site_hdng mb-4 mb-md-5">
          <h1><?=!empty($page['h_one_heading'])?$page['h_one_heading']:""?></h1>
          <?=!empty($page['content_data'])?$page['content_data']:""?>
        </div>
        <?php if (!empty($faqs)) { ?>
        <div class="accordion new_accordion" id="accordionExample">
          <?php $i = 1; ?>
          <?php foreach ($faqs as $key => $value) { ?>
          <div class="accordion-item faqs_column">
            <h2 class="accordion-header <?= ($i !== 1) ? 'collapsed' : '' ?>" id="heading<?= $i ?>">
              <button class="accordion-button faq_qstn" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>" aria-expanded="<?= ($i === 1) ? 'true' : 'false' ?>" aria-controls="collapse<?= $i ?>">
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
        <?php } ?>
      </div>
    </div>
  </div>
</section>