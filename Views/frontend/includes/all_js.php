
<?=script_tag(base_url('assets/toastr/toastr.min.js')). "\n" ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<?= script_tag(base_url('assets/select2/js/select2.full.min.js')) . "\n" ?>
<script src="<?=base_url('assets/frontend/')?>js/main.js"></script>
<script src="<?=base_url('assets/')?>common.js"></script>
<script src="<?=base_url('assets/frontend/')?>js/custom.js"></script>
<script type="text/javascript">
	 $(function () {
		<?php if (session()->getFlashdata('success')) { ?>
			setTimeout(function () {
				toastr.success('<?php echo session()->getFlashdata('success'); ?>')
			}, 1000);
		<?php } ?>
		<?php if (session()->getFlashdata('failed')) { ?>
			setTimeout(function () {
				toastr.failed('<?php echo session()->getFlashdata('failed'); ?>')
			}, 1000);
		<?php } ?>
	});
	
$("#airids").click(function () {
    var e = $("div#mainvias").length;
    var t = '<div class="removes' + e + '" id="mainvias">' +
        '<input type="text" name="destination[]" onkeyup="return getAddress(this.value,\'locations' + e + '\')" id="locations' + e + '" class="form-control" placeholder="Destination">' +
        '<a href="#" onclick="removeitx(' + e + ');return false;" class="remove-field btn-remove-customer heading-add red-c"> ' +
        '<span class="material-icons f-16"> close </span> </a></div><ul  class="append_searches" id="append_locations' + e + '"></ul>';
    $(".city_records_dynamic").append(t);

    // $("input[id*='locations']").each(function () {
    //     var autocomplete = new google.maps.places.Autocomplete(this, {
    //         types: ["(cities)"]
    //     });
    //     autocomplete.setComponentRestrictions({
    //         country: "IN"
    //     });
    //     google.maps.event.addListener(autocomplete, "place_changed", function () {
    //         fillInAddress();
    //     });
    // });
    return false;
});


	function removeit(e) {
		$(".flmenu").height($(".flmenu").height() - 1), $(".appendhere > br").remove(), $(".remove" + e + " > br >").remove(), $(".remove" + e).remove()
	}	
	function removeitx(e) {
		$(".flmenu").height($(".flmenu").height() - 1), $(".appendhere > br").remove(), $(".removes" + e + " > br >").remove(), $(".removes" + e).remove()
	}
	$(function() {
		$(".datepicker").datepicker();
		$('input.timepicker').timepicker({});
	});

	function getRandomCaptcha(){
    $.ajax({
       url: "<?=base_url('getRandomCaptcha')?>",
       cache: false,
       method: 'POST',
       success: function(html) {
           $('.csrf').val(html);
           $('.bgreprat').html(html);
           
       }
   });
  }
</script>
</body>
</html>