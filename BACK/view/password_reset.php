

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Page Title -->
    <title>GreenGrow</title>

    <!-- Vendor CSS -->
    <link href="/BACK/view/task2/lib/fontawesome-free/css2/all.min.css" rel="stylesheet">
    <link href="/BACK/view/task2/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="/BACK/view/task2/lib/typicons.font/typicons.css" rel="stylesheet">
    <link rel="stylesheet" href="/BACK/view/task2/css2/azia.css">

    <!-- Inline Style for Input Fields -->
    <style>
        /* From Uiverse.io by alexruix */ 
.group {
  display: flex;
  line-height: 28px;
  align-items: center;
  position: relative;
  max-width: 130px;
}

.input {
  height: 40px;
  line-height: 28px;
  padding: 0 1rem;
  width: 100%;
  padding-left: 2.5rem;
  border: 2px solid transparent;
  border-radius: 8px;
  outline: none;
  background-color: #D9E8D8;
  color: #0d0c22;
  box-shadow: 0 0 5px #C1D9BF, 0 0 0 10px #f5f5f5eb;
  transition: .3s ease;
}

.input::placeholder {
  color: #777;
}

.icon {
  position: absolute;
  left: 1rem;
  fill: #777;
  width: 1rem;
  height: 1rem;
}






    </style>
</head>
<body class="az-body">

    <div class="az-signin-wrapper">
      <div class="az-card-signin">
        <h1>G<span>reen</span>G<span>row</span></h1>
        <img src="/BACK/view/task2/img/logo.png" height="120" width="120" alt="GreenGrow Logo">
        <div class="az-signin-header">
          
          <h2>Reinitialisation </h2>
          <h4>Veuillez fournir le Username que vous avez utilisé lors de la création de votre compte.</h4>

          <form action="/BACK/index.php?action=verifyUsername" method="post">
            
            <div class="form-group">
            <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger">
            <?php echo htmlspecialchars($errorMessage); ?>
            </div>
            <?php endif; ?>

              <input type="text" autocomplete="off" name="Username" class="input" placeholder="Username">
            </div>
            Nous vou enverrons un e-mail de réinitialisation
            <br>
            
                </div>
            
            
            
            <button type="submit" class="btn btn-az-primary btn-block">Reinitialiser</button>
            <div class="az-signin-footer">
          
          <p>Pas de compte? <a href="/BACK/view/form.php">Créer un compte</a></p>
        </div>
          </form>
          
        </div>
        
       
      </div>
    </div>


    



















  










    <!-- JS Libraries -->
    <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/ionicons/ionicons.js"></script>
    <script src="../js/jquery.cookie.js"></script>
    <script src="../js/azia.js"></script>

</body>
</html>
