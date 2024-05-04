<?=view(VENDORPATH.'includes/top-links')?>
<div class="MainSectionPage onlyform">
  <div class="registerPage">
    <div class="text-center">
      <img src="<?=$logo?>" class="img-fluid">
    </div>
    <div class="RegistermainSec">
      <div class="Register-title">
        <h4>Register as Vendor</h4>
      </div>
      <div class="Register-title2">
        <a class="reg_btn" href="<?=base_url(VENDORPATH.'register_as_vendor')?>">Register as Vendor</a>
      </div>
    </div>
    <div class="register-bottom">
      <p>Already registered ?</p>
      <a href="<?=base_url(VENDORPATH.'login')?>">Login</a>
    </div>
  </div>
</div>
<?=view(VENDORPATH.'includes/footer')?>