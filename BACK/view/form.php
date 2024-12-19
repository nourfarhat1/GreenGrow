<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90680653-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() { dataLayer.push(arguments); }
      gtag('js', new Date());
      gtag('config', 'UA-90680653-2');
    </script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="BootstrapDash">
    <title>Green Grow Signup</title>

    <!-- Vendor CSS -->
    <link href="/BACK/view/task2/lib/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="/BACK/view/task2/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="/BACK/view/task2/lib/typicons.font/typicons.css" rel="stylesheet">

    <!-- Azia CSS -->
    <link rel="stylesheet" href="/BACK/view/task2/css/azia.css">
    <style>
      body {
        background-image: url('/BACK/view/task2/css/bgg.jpg');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
      }
    </style>

    <!-- Facebook SDK -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '554347700781312', // Replace with your Facebook App ID
          cookie     : true,
          xfbml      : true,
          version    : 'v13.0'
        });

        FB.AppEvents.logPageView();
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "https://connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>
  </head>
  <body class="az-body">

    <div class="az-signup-wrapper">
      <div class="az-column-signup-left">
        <div>
          <img src="/BACK/view/task2/img/logo.png" alt="Green Grow Logo">
          <h5>Responsive Modern Dashboard &amp; Admin Template</h5>
          <p>Welcome to Green Grow! We're excited to have you on board.</p>
          <a href="index.html" class="btn btn-outline-indigo">Learn More</a>
        </div>
      </div><!-- az-column-signup-left -->

      <div class="az-column-signup">
        <h1 class="az-logo"></h1><h1>Green Grow</h1>
        <div class="az-signup-header">
          <h2>Get Started</h2>
          <h4>It's free to signup and only takes a minute.</h4>

          <form action="/BACK/index.php?action=createUser" method="post" id="registrationForm" novalidate>
            <div class="form-group">
              <label>User Name</label>
              <input type="text" class="form-control" placeholder="Enter a username" id="Username" name="Username" required>
              <span id="nameError" class="error-message" style="color: red;"></span>
              <?php if (!empty($errorMessageUsername)): ?>
                <div style="color: red; text-align: center; margin-bottom: 10px;">
                  <?= htmlspecialchars($errorMessageUsername) ?>
                </div>
              <?php endif; ?>
            </div><!-- form-group -->

            <div class="form-group">
              <label>Firstname</label>
              <input type="text" class="form-control" placeholder="Enter your firstname" id="prenom" name="prenom" required>
              <?php if (!empty($errorMessagePrenom)): ?>
                <div style="color: red; text-align: center; margin-bottom: 10px;">
                  <?= htmlspecialchars($errorMessagePrenom) ?>
                </div>
              <?php endif; ?>
            </div><!-- form-group -->

            <div class="form-group">
              <label>Last Name</label>
              <input type="text" class="form-control" placeholder="Enter your Lastname" id="nom" name="nom" required>
              <?php if (!empty($errorMessageNom)): ?>
                <div style="color: red; text-align: center; margin-bottom: 10px;">
                  <?= htmlspecialchars($errorMessageNom) ?>
                </div>
              <?php endif; ?>
            </div><!-- form-group -->

            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" placeholder="Enter your email" id="email" name="email" required>

              <?php if (!empty($errorMessageEmail)): ?>
                <div style="color: red; text-align: center; margin-bottom: 10px;">
                  <?= htmlspecialchars($errorMessageEmail) ?>
                </div>
              <?php endif; ?>
            </div><!-- form-group -->

            <div class="form-group">
              <label>Address</label>
              <input type="text" class="form-control" placeholder="Enter your address" id="Adresse" name="Adresse" required>
              <?php if (!empty($errorMessageAdresse)): ?>
                <div style="color: red; text-align: center; margin-bottom: 10px;">
                  <?= htmlspecialchars($errorMessageAdresse) ?>
                </div>
              <?php endif; ?>
            </div><!-- form-group -->

            <div class="form-group">
              <label>Phone number</label>
              <input type="text" class="form-control" placeholder="Enter your phone number" id="Tel" name="Tel" pattern="\d{8}" title="Phone number must be exactly 8 digits" required>
              <span id="phoneError" class="error-message" style="color: red;"></span>
              <?php if (!empty($errorMessagePhone)): ?>
                <div style="color: red; text-align: center; margin-bottom: 10px;">
                  <?= htmlspecialchars($errorMessagePhone) ?>
                </div>
              <?php endif; ?>
            </div><!-- form-group -->

            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" placeholder="Enter your password" id="Mdp" name="Mdp" minlength="8" title="Password must be at least 8 characters long" required>
              <input type="checkbox" class="toggle-password" onclick="togglePassword()"> Show Password
              <span id="passwordError" class="error-message" style="color: red;"></span>
              <?php if (!empty($errorMessageMdp)): ?>
                <div style="color: red; text-align: center; margin-bottom: 10px;">
                  <?= htmlspecialchars($errorMessageMdp) ?>
                </div>
              <?php endif; ?>
            </div><!-- form-group -->

            <button type="submit" class="btn btn-az-primary btn-block">Create Account</button>

            <div class="row row-xs">
              <div class="col-sm-6">
                <button class="btn btn-block" onclick="fbLogin()">
                  <i class="fab fa-facebook-f"></i> Signup with Facebook
                </button>
              </div>
              <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                <button class="btn btn-primary btn-block">
                  <i class="fab fa-twitter"></i> Signup with Twitter
                </button>
              </div>
            </div><!-- row -->

            <div style="text-align: center; margin-top: 20px;">

            </div>
          </form>
        </div><!-- az-signup-header -->

        <div class="az-signup-footer">
          <p>Already have an account? <a href="/BACK/view/page-signin.php">Sign In</a></p>
        </div><!-- az-signin-footer -->
      </div><!-- az-column-signup -->
    </div><!-- az-signup-wrapper -->

    <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript for additional validation and password toggle -->
    <script>
      document.getElementById('registrationForm').addEventListener('submit', function(event) {
        var phoneInput = document.getElementById('Tel');
        var passwordInput = document.getElementById('Mdp');
        var phoneError = document.getElementById('phoneError');
        var passwordError = document.getElementById('passwordError');

        phoneError.textContent = '';
        passwordError.textContent = '';

        if (!phoneInput.validity.valid) {
          phoneError.textContent = 'Phone number must be exactly 8 digits.';
          event.preventDefault();
        }

        if (!passwordInput.validity.valid) {
          passwordError.textContent = 'Password must be at least 8 characters long.';
          event.preventDefault();
        }
      });

      function togglePassword() {
        var passwordInput = document.getElementById('Mdp');
        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
        } else {
          passwordInput.type = 'password';
        }
      }

      function fbLogin() {
        FB.login(function(response) {
          if (response.authResponse) {
            FB.api('/me', {fields: 'id,name,email'}, function(response) {
              console.log('Successful login for: ' + response.name);

              // Send data to your server
              var xhr = new XMLHttpRequest();
              xhr.open('POST', '/your-server-endpoint', true);
              xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
              xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                  console.log(xhr.responseText);
                }
              };
              xhr.send(JSON.stringify({ name: response.name, email: response.email }));
            });
          } else {
            console.log('User cancelled login or did not fully authorize.');
          }
        }, {scope: 'public_profile,email'});
      }
    </script>
  </body>
</html>
