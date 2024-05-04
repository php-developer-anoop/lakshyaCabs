<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?=$meta_title?></title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <?=link_tag('https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap')."\n";?>
    <?=link_tag(base_url('assets/vendor/fonts/boxicons.css'))."\n";?>
    <?=link_tag(base_url('assets/vendor/css/core.css'))."\n";?>
    <?=link_tag(base_url('assets/vendor/css/theme-default.css'))."\n";?>
    <?=link_tag(base_url('assets/css/demo.css'))."\n";?>
    <?=link_tag(base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css'))."\n";?>
    <?=link_tag(base_url('assets/vendor/css/pages/page-auth.css'))."\n";?>
    <?=script_tag(base_url('assets/vendor/js/helpers.js'))?>
    <?=script_tag(base_url('assets/js/config.js'))?>
    <?=link_tag(base_url('assets/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'))."\n";?>
    <?=link_tag(base_url('assets/toastr/toastr.min.css'))."\n";?>
    <style>
      .swal2-popup.swal2-toast .swal2-title {
      font-size: 15px;
      margin: 10px;
      color: #6c757d;
      }
    </style>
  </head>
  <body>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <div class="card">
            <div class="card-body">
              <h2 class="mb-2 text-center">Admin Panel</h2>
              <p class="mb-2">Please sign-in to your account and start the adventure</p>
              <form>
                <div class="mb-3">
                  <label for="email" class="form-label">Email or Username</label>
                  <input type="email" class="form-control" autocomplete="off" id="email" name="email" required placeholder="Username" autofocus />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password" required>Password</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" autocomplete="off" class="form-control" name="password" placeholder="Password" aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3 d-none">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_remember" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                </div>
                <div class="mb-3">
                  <button id="btnLogin" class="btn btn-primary d-grid w-100" onclick="return validate()" >Sign in</button>
                </div>
              </form>
              <div class="text-center d-none">
                <a href="<?=base_url(ADMINPATH.'forgot-password')?>" class="d-flex align-items-center justify-content-center">
                Forgot Password
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?=script_tag(base_url('assets/vendor/libs/jquery/jquery.js'))."\n"?>
    <?=script_tag(base_url('assets/vendor/libs/popper/popper.js'))."\n"?>
    <?=script_tag(base_url('assets/vendor/js/bootstrap.js'))."\n"?>
    <?=script_tag(base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'))."\n"?>
    <?=script_tag(base_url('assets/vendor/js/menu.js'))."\n"?>
    <?=script_tag(base_url('assets/js/main.js'))."\n"?>
    <?=script_tag('https://buttons.github.io/buttons.js')."\n"?>
    <?=script_tag(base_url('assets/sweetalert2/sweetalert2.min.js'))?>
    <?=script_tag(base_url('assets/toastr/toastr.min.js'))?>
    <script>
      var Toast = Swal.mixin({
     toast: true,
     position: 'top-end',
     showConfirmButton: false,
     timer: 1000
   });

   function validate() {
     var email = $('#email').val();
     var password = $('#password').val();
     var is_remember = document.querySelector('#is_remember').checked;
     if (email.trim() == "") {
       Toast.fire({
         icon: 'error',
         title: 'Please Fill Email'
       })
       return false;
     } else if (password.trim() == "") {
       Toast.fire({
         icon: 'error',
         title: 'Please Fill Password'
       })
       return false;
     } else {
       $.ajax({
         type: 'POST',
         url: '<?=base_url(ADMINPATH.'checkLogin')?>',
         data: {
           'email': email,
           'password': password,
           'is_remember': is_remember
         },
         dataType: 'json',
         beforeSend: () => {
           document.getElementById('btnLogin').value = 'Please Wait...';
           document.getElementById('btnLogin').setAttribute("disabled", "disabled");
         },
         success: (res) => {
           if (res.status) {
               Toast.fire({
               icon: 'success',
               title: res.message
             })
             window.location.href = '' + res.goto;
           } else {
             document.getElementById('btnLogin').value = 'Login';
             document.getElementById("btnLogin").removeAttribute("disabled");
             Toast.fire({
               icon: 'error',
               title: res.message
             })
           }
         }
       });
     }
   }
    </script>
  </body>
</html>