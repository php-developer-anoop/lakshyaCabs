<script>
    function changestate(s,c){
        $('#'+c).html('');
        let id = $('#'+s).val();
        $.ajax({
            url: '<?= base_url(ADMINPATH.'getCitiesFromAjax') ?>',
            method: 'POST',
            data: { state_id: id ,city: '',cityid:'<?=$pickup_city_id?>'},
            success: function (response) {
            $('#'+c).html(response);
            $('button.btn.dropdown-toggle.bs-placeholder.btn-light').hide();
              // Initialize Select2 on the select element
              $('#'+c).select2({
                placeholder: 'Choose Option',
                allowClear: true // If you want to allow clearing the selection
            });
            }
        });
    }
    <?php 
    if(!empty($id)){ ?>
        changestate('pickup_state_id','pickup_city_id');
   <?php }  ?>
    function getDropCityList(val){
      //  alert(val);
        $('#drop-suggestion-list1').show();
            $('#drop-suggestion-list1').html('');
            if (val !== "" && val.length > 2) {
                $.ajax({
                url: '<?= base_url(ADMINPATH.'getCityList') ?>',
                type: "POST",
                data: { 'val': val},
                cache: false,
                dataType:"html",
                success: function (response) {
                    if (response.length < 20) {
                    toastr.error(response);
                    return false;
                    } else if (response.length > 20) {
                    $('#drop-suggestion-list1').html(response);
                    }
                }
                }); 
            }
    } 

    function selectDropCityNames() {
        
        var selectedItem = $(event.target);
        var itemValue = selectedItem.text();
        var itemId = selectedItem.val();
        var stateId = selectedItem.attr('data-stateid');
        
        if (itemValue !== "" && itemId !== "") {
            $('#pickup_city_name').val(itemValue);
            $('#pickup_city_id').val(itemId);
            $('#pickup_state_id').val(stateId);
            $('#drop-suggestion-list1').hide();
            loadpackage(itemId,stateId)
        }
        }

        $("#drop-suggestion-list1").on("click", "li", selectDropCityNames());

         
        function loadpackage(c,s){
        $('#package_id').html('');
        $.ajax({
            url: '<?= base_url(ADMINPATH.'getPacksFromAjax') ?>',
            method: 'POST',
            data: { city_id: c, state_id: s },
            success: function (response) {
                $('#package_id').html(response);
           
            }
        });
    }
    function fetchHoursKm(package_id){
   $.ajax({
       url: '<?= base_url(ADMINPATH.'fetchHoursKm') ?>',
       method: 'POST',
       data: {package_id:package_id},
       dataType:'json',
       success: function (response) {
          // alert(response);
           $('.covered_hours').val(response.hours);
           $('.base_covered_km').val(response.km);
       }
   });
 
   }
</script>