<div class="wd_dashcontent">
  <div class="container bookingpg">
    <div class="row">
      <h3>My Booking</h3>
    </div>
    <div class="row bookngwrpr">
      <div class="col-sm-12">
        <?php if(!empty($list)){  
          foreach($list as $key=>$value ){?>
        <div class="bookingbox">
          <div class="d-flex justify-content-between">
            <p class="bookid">Booking ID: <?=$value['booking_id']?></p>
            <p class="bookdate">Booking Date: <?=date('d/m/Y h:i A',strtotime($value['created_date']))?></p>
          </div>
          <div class="bkngloc">
            <p><?=$value['via_routes']?></p>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <div class="bookftrs d-flex justify-content-between">
              <div class="booktexts">
                <span>Trip Type</span>
                <p><?=$value['trip_type']?></p>
              </div>
              <div class="booktexts">
                <span>Pickup Date & Time</span>
                <p><?=date('d/m/Y h:i A',strtotime($value['pickup_date_time']))?></p>
              </div>
              <div class="booktexts">
                <span>Vehicle</span>
                <p><?=$value['model_name']?></p>
              </div>
            </div>
            <div class="bookbtns d-flex justify-content-around">
              <a href="view-booking.php" class="lgyellow">View</a>
              <a href="javascript:void(0)" onclick="return printInvoiceSlip('<?=$value['booking_id']?>')" class="lggrn">Invoice</a>
              <?php if( $value['is_rated'] == 'no' && $value['booking_status']=='completed'){ ?>
              <a href="javascript:void(0)" data-bs-toggle="modal"
                data-bs-target="#exampleModal" id="rate_<?=$value['booking_id']?>" onclick="return rateUs('<?=$value['booking_id']?>',<?=$value['partner_id']?>)" class="lgblue">Rate Us</a>
              <?php } ?>
              <a href="" class="lgorng">Cancel</a>
            </div> 
          </div>
        </div>
        <?php }}?>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content rounded-4">
      <div class="modal-header border-0">
        <h1 class="modal-title fs-4 w-100 text-center" id="exampleModalLabel">Rate Us</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0">
        <div class="d-flex  align-items-center flex-column gap-2 px-4">
          <div class="d-flex flex-row  gap-2">
            <div class="star-img" onclick="return addActiveClass(1)"></div>
            <div class="star-img" onclick="return addActiveClass(2)"></div>
            <div class="star-img" onclick="return addActiveClass(3)"></div>
            <div class="star-img" onclick="return addActiveClass(4)"></div>
            <div class="star-img" onclick="return addActiveClass(5)"></div>
          </div>
          <input type="hidden" id="booking_id" value="" />
          <input type="hidden" id="customer_id" value="<?=!empty($userprofile['id'])?$userprofile['id']:''?>" />
          <input type="hidden" id="partner_id" value="" />
          <input type="hidden" id="ratings" value="" />
          <div class="mt-3 w-100 ">
            <label for="customer_name" class="form-label">Name</label>
            <input type="text" class="form-control" id="customer_name" readonly placeholder="Name" value="<?=!empty($userprofile['name'])?$userprofile['name']:''?>">
          </div>
          <div class="mt-2 w-100 ">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="3"></textarea>
          </div>
          <button class="btn btn-success w-100 py-2 mb-3" id="submitRating" onclick="return validateRating()">
          Submit
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    function rateUs(booking_id,partner_id){
        $('#booking_id').val(booking_id);
        $('#partner_id').val(partner_id);
    }
  function validateRating() {
    var booking_id = $('#booking_id').val();
    var partner_id = $('#partner_id').val();
    var customer_name = $('#customer_name').val();
    var description = $('#description').val();
    var customer_id = $('#customer_id').val();
    var ratings = $('#ratings').val();
    if(ratings == ""){
        toastr.error('Select Rating');
        return false;
    }
    if(description == ""){
        toastr.error('Enter Description');
        return false;
    }
	$.ajax({
		url: "<?=base_url(USERPATH.'rateUs')?>",
		cache: false,
		method: 'POST',
		data: {
			booking_id: booking_id,
			partner_id: partner_id,
			customer_name:customer_name,
			ratings : ratings,
			description:description,
			customer_id:customer_id
		},
		dataType: 'json',
		beforeSend: () => {
			$('#submitRating').text('Please Wait ...').prop('disabled', true);
		},
		success: function(res) {
			if (res.status == true) {
				toastr.success(res.message);
				$('#booking_id').val('');
				$('#partner_id').val('');
				$('#ratings').val('');
				$('#description').val('');
				$('#rate_'+booking_id).hide();
				$('.star-img').removeClass('active',true);
				$('#exampleModal').modal('hide');
				$('#submitRating').text('Submit').prop('disabled', false);
			} else {
				$('#submitRating').text('Submit').prop('disabled', false);
				toastr.error(res.message);
			}
		}
	});
}

function addActiveClass(starIndex) {
    $('#ratings').val(starIndex);
	var stars = document.querySelectorAll('.star-img');
	for (var i = 0; i <= stars.length; i++) {
		if (i < starIndex) {
			stars[i].classList.add('active');
		} else {
			stars[i].classList.remove('active');
		}
	}
}

function printInvoiceSlip(booking_id){
    window.location.href = '<?= base_url(USERPATH . 'printInvoiceSlip?booking_id=') ?>' + booking_id;
}

</script>