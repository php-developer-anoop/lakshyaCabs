<script>
     function fareSummary( id ){
         var newData = JSON.parse( localStorage.getItem("searchData") ); 
         var rowData = newData.find( (e)=>e.id == id );
         $.ajax({
             type: 'POST',
             data: rowData,
             url: '<?=base_url('fare-details')?>',
             success: (res)=>{
                 $('#summaryData').html( res ); 
                 $('#faresummary').modal('show');
             }
         })
    }
    
    function saveBookingData( id ){
        var is_loggedin = '<?=(!empty($is_logged_in) ? $is_logged_in : '')?>';
        if(!is_loggedin){ 
            $('#loginmodal').modal('show');  
            return;
        }
        
         var newData = JSON.parse( localStorage.getItem("searchData") ); 
         var rowData = newData.find( (e)=>e.id == id );
         $.ajax({
             type: 'POST',
             data: rowData,
             url: '<?=base_url('save-booking-search-data')?>',
             success: (res)=>{
                  localStorage.removeItem("searchData");
                  window.location.href='<?=base_url('booking-details')?>'; 
             }
         })
    }
</script>