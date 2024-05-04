<section class="popular_routes sec_padd">
  <div class="container os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
    <div class="row">
      <div class="col-sm-12 site_hdng text-center">
        <h2> <?=!empty($homesetting['popular_heading'])?$homesetting['popular_heading']:""?></h2>
      </div>
    </div>
    <?php $routesname = getPopularRoutesName(); ?>
    <div class="row poplr_routes">
      <?php if(!empty($routesname)){ 
        foreach($routesname as $rnkey=>$rnvalue){  
         ?>
      <div class="popl_column">
        <ul>
          <li><a href="<?=!empty($rnvalue['page_slug'])?base_url($rnvalue['page_slug']):'javascript:void(0)'?>"><?=!empty($rnvalue['page_name'])?$rnvalue['page_name']:''?></a></li>
        </ul>
      </div>
      <?php }} ?> 
    </div>
    <div class="readmoremain">
      <button id="read-more" class="readmore">View More</button>
    <button id="read-less" style="display: none;" class="readmore">View Less</button>   
    </div>

  </div>
</section>
<section class="footer sec_padd">
  <div class="container os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
    <div class="row" id="footer_list">
      <div class="col-md-4 footer_list1">
        <div class="flogo">
          <img src="<?=$logo?>">
        </div>
        <p style="color:#fff;">
          <?=getAboutDescription()?>
        </p>
      </div>
      <div class="col-md-2 col-6 footer_list1">
        <h6 class="heading">Company</h6>
        <ul>
          <li><a href="<?=base_url('about-us')?>">Who we are</a></li>
          <li><a href="<?=base_url('contact-us')?>">Contact Us</a></li>
          <li><a href="<?=base_url('faqs')?>">Faq</a></li>
        </ul>
      </div>
      <div class="col-md-2 col-6 footer_list1">
        <h6 class="heading">Our Policy</h6>
        <ul>
          <li><a href="<?=base_url('terms-and-conditions')?>">Terms &amp; Conditions</a></li>
          <li><a href="<?=base_url('privacy-policy')?>">Privacy Policy</a></li>
          <li><a href="<?=base_url('refund-policy')?>">Refund Policy</a></li>
        </ul>
      </div>
      <div class="col-md-2 col-6 footer_list1">
        <h6 class="heading">Business With Us</h6>
        <ul>
          <li><a href="<?=base_url('drive-with-us')?>">Drive With Us</a></li>
          <li><a href="<?=base_url('attach-taxi')?>">Attach Taxi</a></li>
          <li><a href="<?=base_url(VENDORPATH.'login')?>">Partner Login</a></li>
        </ul>
      </div>
      <div class="col-md-2 col-6 footer_list1">
        <h6 class="heading">Connects</h6>
        <ul>
          <li><a href="mailto:<?=!empty($company['care_email'])?$company['care_email']:""?>"><?=!empty($company['care_email'])?$company['care_email']:""?></a></li>
          <li><a href="tel:<?=!empty($company['care_mobile'])?'+91'.$company['care_mobile']:""?>"><?=!empty($company['care_mobile'])?'+91'.$company['care_mobile']:""?></a></li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="copyright">
  <div class="container">
    <div class="row copyright" id="footer_list2">
      <p>Copyright © <?=date('Y')?>-<?=date('Y')+1?>. <a href="https://duplextech.com/"> Duplex Technologies Pvt. Ltd. </a> All rights Reserved.</p>
    </div>
  </div>
</section>
<div class="fixed-bottom fix_foot py-2 bg-light shadow-lg border-top d-block d-md-none d-lg-none">
  <div class="row bottom-icon">
    <div class="col-6">
      <a href="tel:8090060608">
        <div class="text-center">
          <div class="text-icon concert_now"> <i class="fa fa-phone color-w"></i></div>
        </div>
      </a>
    </div>
    <div class="col-6">
      <a href="https://wa.me/918090060608">
        <div class="text-center">
          <i class="fa-brands fa-whatsapp color-whats"></i>
        </div>
      </a>
    </div>
  </div>
</div>
<script type="text/javascript"></script>
<!-- Modal --> 
<div class="modal fade logtop_modal" id="loginmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="txtimg_mdl">
          <div class="mdltxt phnnumber_screen">
            <img src="<?=$logo?>">
            <h4>Welcome to Lakshya Cabs</h4>
            <form>
              <label for="basic-url" class="form-label">Your Email</label>
              <div class="input-group mb-5 d-none">
                <span class="input-group-text" id="basic-addon3">+91</span>
                <input type="text" class="form-control" placeholder="Enter Mobile number"  id="basic-url" aria-describedby="basic-addon3">
              </div>
              <div class="input-group mb-5">
                <input type="email" class="form-control emailInput" autocomplete="off" placeholder="Enter Email"  id="usermail" aria-describedby="basic-addon3">
              </div>
              <button type='button' class="cstm_mdbtns" id="btnOtp">Proceed</button>
            </form>
          </div>
          <div class="mdltxt otp_screen">
            <img src="<?=$logo?>">
            <h4>Verify OTP</h4>
            <form>
              <label for="basic-url" class="form-label">Enter OTP send on entered mail</label>
              <div class="d-flex otpwrpr mt-2 mb-3">
                <div class="otpfilds">
                  <input id="first" class="otp numbersOnly" type="text" oninput="digitValidate(this)" autocomplete="off" onkeyup="tabChange(1)" maxlength="1">
                  <input id="second" class="otp numbersOnly" type="text" oninput="digitValidate(this)" autocomplete="off" onkeyup="tabChange(2)" maxlength="1">
                  <input id="third" class="otp numbersOnly" type="text" oninput="digitValidate(this)" autocomplete="off" onkeyup="tabChange(3)" maxlength="1">
                  <input id="fourth" class="otp numbersOnly" type="text" oninput="digitValidate(this)" autocomplete="off" onkeyup="tabChange(4)" maxlength="1">
                </div>
              </div>
              <div class="mb-5">
                <a href="javascript:void(0)" id="resendBtn" class="btn btn-primary text-white">Resend </a><span id="countdown"></span>
              </div>
              <button type="button" onclick="return validateOtp()"  class="cstm_mdbtns">Login</button>
            </form>
          </div>
          <div class="mdlimg">
            <img src="<?=base_url('assets/frontend/images/modalimg.png')?>">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    var columns = document.querySelectorAll('.popl_column');
    var readMoreBtn = document.getElementById('read-more');
    var readLessBtn = document.getElementById('read-less');
    
    // Initially hide all but the first 10 lists
    for (var i = 50; i < columns.length; i++) {
        columns[i].style.display = 'none';
    }
    
    // Event listener for Read More button
    readMoreBtn.addEventListener('click', function() {
        for (var i = 50; i < columns.length; i++) {
            columns[i].style.display = 'block';
        }
        readMoreBtn.style.display = 'none';
        readLessBtn.style.display = 'block';
    });
    
    // Event listener for Read Less button
    readLessBtn.addEventListener('click', function() {
        for (var i = 50; i < columns.length; i++) {
            columns[i].style.display = 'none';
        }
        readMoreBtn.style.display = 'block';
        readLessBtn.style.display = 'none';
    });
});

</script>
<script>
  $(document).ready(function() {
      
     $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll > 200) {
                $(".fixed-bottom").addClass("shwbtm");
            }
            else{
               $(".fixed-bottom").removeClass("shwbtm");
            }
        }); 
      
      
  $('.phnnumber_screen .cstm_mdbtns').click(function() {
    var useremail = $('#usermail').val().trim();  // Corrected variable name

    if (useremail == "") {
      toastr.error('Please Enter Email');
      return false;
    }

    $.ajax({
      url: "<?=base_url('validateUser')?>",
      method: 'POST',
      dataType: 'json',
      data: {
        useremail: useremail
      },
      beforeSend: () => {
        $('.phnnumber_screen .cstm_mdbtns').prop('disabled', true) ;
        $('.phnnumber_screen .cstm_mdbtns').text('Please Wait...');
      },
      success: function(response) {
        if (response.status) {
          toastr.success(response.message);
          $('#usermail').val('');
          $('.phnnumber_screen').hide();
          $('.otp_screen').show();
        } else {
          toastr.error(response.message);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        // Handle AJAX request error, you can customize this part
        console.log('Error validating email: ' + errorThrown);
      }
    });
  });
});

  
  
  let digitValidate = function(ele) {
   ele.value = ele.value.replace(/[^0-9]/g, '');
  }
  
  let tabChange = function(val) {
   let ele = document.querySelectorAll('input.otp');
   if (ele[val - 1].value != '') {
     ele[val].focus()
   } else if (ele[val - 1].value == '') {
     ele[val - 2].focus()
   }
  }
  
  
  var countdownTimer;
  var countdownSeconds = 65; // Set the countdown duration in seconds
  
  function startCountdown() {
   $('#resendBtn').addClass('disabled', true); // Disable the resend button during countdown
  
   countdownTimer = setInterval(function() {
     if (countdownSeconds <= 0) {
         $('#countdown').text('');
       clearInterval(countdownTimer);
       $('#resendBtn').removeClass('disabled', false); // Enable the resend button after countdown
     } else {
       $('#countdown').text('  OTP in '+countdownSeconds + ' seconds');
       countdownSeconds--;
     }
   }, 1000); // Update every second
  }
  
  function resendOTP() {
      $("#first").val('');
      $("#second").val('');
      $("#third").val('');
      $("#fourth").val('');
   $.ajax({
     url: "<?=base_url('resendOtp')?>",
     method: 'POST',
     dataType: 'json',
     success: function(response) {
       if (response.status) {
         // Handle success case, you can customize this part
         toastr.success(response.message);
        
  
       } else {
         // Handle failure case, you can customize this part
         toastr.error(response.message);
  
       }
     },
     error: function(jqXHR, textStatus, errorThrown) {
       // Handle AJAX request error, you can customize this part
       console.log('Error sending otp: ' + errorThrown);
     }
   });
  
   // Restart the countdown
   countdownSeconds = 60;
   startCountdown();
  }
  
  // Trigger the countdown when the page loads
  $(document).ready(function() {
   startCountdown();
   $('#resendBtn').click(function() {
     resendOTP();
   });
  });
  
   
  //alert( qParam );
 function validateOtp() {
    var otp = $("#first").val() + $("#second").val() + $("#third").val() + $("#fourth").val();
    var qParam = window.location.href;;
    if (otp.trim() == "") {
      toastr.error('Please Enter OTP');
      return false;
    }
   
  $.ajax({
    url: "<?=base_url('validateOtp')?>",
    method: 'POST',
    data: { otp: otp,'current_page': qParam },
    dataType: 'json', 
    beforeSend: function() {
      $('.otp_screen .cstm_mdbtns').prop('disabled', true).text('Please Wait...');
    },
    success: function(response) {
      if (response.status) {
        toastr.success(response.message);
        window.location.href = response.goto; // Corrected line
      } else {
        toastr.error(response.message);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      // Handle AJAX request error, you can customize this part
      console.log('Error sending otp: ' + errorThrown);
    },
    complete: function() {
      // This block will be executed after the request completes, whether it is successful or not.
      $('.otp_screen .cstm_mdbtns').prop('disabled', false).text('Submit'); // Reset button text and enable it
    }
  });
}

  
</script>