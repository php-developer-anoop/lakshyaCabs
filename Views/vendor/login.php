<?=view(VENDORPATH.'includes/top-links')?>
<div class="MainSectionPage onlyform" id="loginSection">
  <div class="registerPage">
    <div class="Login-Sec">
      <h1>Welcome</h1>
      <p>Please sign in to your account.</p>
      <form>
        <div class="input-SecLogIn">
          <div class="EmailId-Sec mt-4">
            <label>Email</label>
            <input type="email" class="form-control emailOnly" autocomplete="off" required name="email" id="email" placeholder="Email ID">
          </div>
          <div class="password-Sec mt-4">
            <label>Password</label>
            
              <div class="position-relative">
                  <input type="password" class="form-control" autocomplete="off" required name="password"
              placeholder="Enter password" id="password">
              <span class="position-absolute end-0 me-3 cursor-pointer top-0 mt-2" id="showHidePassword" onclick="return openPassword()"><i class="bx bx-hide" ></i></span>
              </div>
            <div class="text-end"><a href="<?=base_url(VENDORPATH.'forgot-password')?>">Forgot password ?</a></div>
          </div>
          <input type="hidden" id="otp" value="">
          <div class="mt-4">
            <button class="Otp_requestBtn" id="submit" onclick="return verifyVendor()">Request OTP</button>
            <p class="text">New to our platform ? <a href="<?=base_url(VENDORPATH.'register')?>">Create account</a></p>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="MainSectionPage onlyform" id="otpSection">
  <div class="registerPage otpSection">
    <div class="Login-Sec">
      <h1 class="mb-1">Verify OTP</h1>
      <p class="digitOTp"></p>
      <form>
        <div class="otp-field mb-4">
            <input type="text" id="digit-1" name="digit-1" autocomplete="off" data-next="digit-2" maxlength="1">
            <input type="text" id="digit-2" name="digit-2" autocomplete="off" data-next="digit-3" data-previous="digit-1" maxlength="1">
            <input type="text" id="digit-3" name="digit-3" autocomplete="off" data-next="digit-4" data-previous="digit-2" maxlength="1">
            <input type="text" id="digit-4" name="digit-4" autocomplete="off" data-next="digit-5" data-previous="digit-3" maxlength="1">
          </div>
        <span class="text-end">
          <p class="text text-end">Resend OTP in <a href="javascript:void(0)" class="text-success" id="timer">60s</a></p>
        </span>
      </form>
        <div class="mt-4 buttun-sec">
            <button class="Otp_requestBtn resendsotp" disabled onclick="return resendOtp()">Resend OTP</button>
            <button class="Otp_requestBtn" id="startButton" onclick="return validateOtp()">Submit OTP</button>
        </div>
    </div>
  </div>
</div>
<script>
$('#otpSection').hide();
  function verifyVendor(){
      var email= $('#email').val().trim();
      var password= $('#password').val().trim();
      
      if(email == ""){
          toastr.error("Enter Email");
          return false;
      } else if(password == ""){
          toastr.error("Enter Password");
          return false;
      } else {
          $.ajax({
       type: 'POST',
       url: '<?=base_url(VENDORPATH.'checkLogin')?>',
       data: {
         'email': email,
         'password': password
       },
       dataType: 'json',
       beforeSend: () => {
        $('#submit').text('Please Wait ...').prop('disabled', true);
       },
       success: (res) => {
         if (res.status == true) {
            toastr.success(res.message);
            $('#submit').text('Submit').prop('disabled', false);
            $('.digitOTp').text(res.message);
            $('#otp').val(res.otp);
            $('#loginSection').hide();
            $('#otpSection').show();
            startTimer();
         } else {
           $('#submit').text('Submit').prop('disabled', false);
           toastr.error(res.message);
         }
       }
     });
      }
  }
  
  function resendOtp(){
        var email= $('#email').val().trim();

          $.ajax({
       type: 'POST',
       url: '<?=base_url(VENDORPATH.'resendOtp')?>',
       data: {
         'email': email
       },
       dataType: 'json',
       beforeSend: () => {
        $('.resendsotp').text('Please Wait ...').prop('disabled', true);
       },
       success: (res) => {
         if (res.status == true) {
            toastr.success(res.message);
            $('.resendsotp').text('Resend OTP').prop('disabled', false);
            $('#otp').val(res.otp);

            startTimer();
         } else {
           $('.resendsotp').text('Resend OTP').prop('disabled', false);
           toastr.error(res.message);
         }
       }
     });
      
  }
  
  
  function validateOtp(){
        var email= $('#email').val().trim();
        var sent_otp= $('#otp').val().trim();
        var entered_otp= $('#digit-1').val()+$('#digit-2').val()+$('#digit-3').val()+$('#digit-4').val();
        
        if(entered_otp !== sent_otp){
           toastr.error('Incorrect OTP');
           return false;
        }
          $.ajax({
       type: 'POST',
       url: '<?=base_url(VENDORPATH.'validateOtp')?>',
       data: {
         email: email,
         sent_otp:sent_otp,
         entered_otp:entered_otp
       },
       dataType: 'json',
       beforeSend: () => {
        $('#startButton').text('Please Wait ...').prop('disabled', true);
       },
       success: (res) => {
         if (res.status == true) {
            toastr.success(res.message);
            $('#startButton').text('Submit OTP').prop('disabled', false);
            window.location.href = '' + res.goto;

         } else {
           $('#startButton').text('Submit OTP').prop('disabled', false);
           toastr.error(res.message);
         }
       }
     });
      
  }
</script>
<script>
  // OTP focus
  $('.otp-field').find('input').each(function() {
    $(this).attr('maxlength', 1);
    $(this).on('keyup', function(e) {
        var parent = $(this).parent();
        var keyCode = e.keyCode || e.which;

        if (keyCode === 8 || keyCode === 37) { // Backspace or Left arrow
            var prev = parent.find('input#' + $(this).data('previous'));
            if (prev.length) {
                prev.focus();
            }
        } else if ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 96 && keyCode <= 105) || keyCode === 39) { // Numbers, letters, right arrow
            var next = parent.find('input#' + $(this).data('next'));
            if (next.length) {
                next.focus();
            } else {
                var autosubmit = parent.data('autosubmit');
                if (autosubmit) {
                    parent.submit();
                }
            }
        }
    });
});

</script>
<script>
  // Set the initial time in seconds
let time = 60;
let timerInterval;

// Function to update the timer every second
function updateTimer() {
    // Display the current time
    document.getElementById('timer').innerText = time;

    // Decrease time by 1
    time--;

    // Check if time is up
    if (time < 0) {
        $('.resendsotp').prop('disabled', false);
        clearInterval(timerInterval); // Stop the timer
        document.getElementById('timer').innerText = "60s"; // Display a message
    }
}

// Function to start the timer
function startTimer() {
    // Call updateTimer function every second
    timerInterval = setInterval(updateTimer, 1000); // Changed from 500 to 1000 for one second intervals

    // Disable the start button to prevent multiple clicks
   // document.getElementById('startButton').disabled = true;
}

  
  // Add event listener to start button
  document.getElementById('startButton').addEventListener('click', startTimer);
  
  function openPassword() {
    var passwordField = $('#password');
    var passwordFieldType = passwordField.attr('type');
    
    if (passwordFieldType === 'password') {
        passwordField.attr('type', 'text');
        $('#showHidePassword').html('<i class="bx bx-show"></i>');
    } else {
        passwordField.attr('type', 'password');
        $('#showHidePassword').html('<i class="bx bx-hide"></i>');
    }
}


</script>
<?=view(VENDORPATH.'includes/footer')?>