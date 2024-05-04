<?=script_tag(base_url('assets/toastr/toastr.min.js')). "\n" ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

<?= script_tag(base_url('assets/select2/js/select2.full.min.js')) . "\n" ?>
<?=script_tag(base_url('assets/sweetalert2/sweetalert2.min.js')) . "\n" ?>
<script src="<?=base_url('assets/common.js')?>"></script>
  <script type="text/javascript">
  
  $(function () {
      <?php if (session()->getFlashdata('success')) { ?>
  
        setTimeout(function () {
            toastr.success('<?php echo session()->getFlashdata('success'); ?>');
        }, 500);
  
  <?php } ?>
  <?php if (session()->getFlashdata('failed')) { ?>
  
        setTimeout(function () {
            toastr.error('<?php echo session()->getFlashdata('failed'); ?>');
        }, 500);
  
  <?php } ?>
         });
  	$(document).ready(function(){
  		 $('.backbtn i').on('click', function(){
  	        window.history.back();
  	     });
              $('.togglemenu').on('click', function(){
  	        $('.sidebarmenu').addClass('sideopen');
  	     }); 
  	     $('.closemenu').on('click', function(){
  	        $('.sidebarmenu').removeClass('sideopen');
  	     }); 
      });
      
         
</script>
</body>
</html>