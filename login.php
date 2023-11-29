<?php 
  include "config.php";
  session_start();

  if(isset($_SESSION["page"])){
    unset($_SESSION["page"]);
  }

if($_SESSION["vc_id"]){
  header("customerhomepage.php");
}

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $userid = $_POST["userid"];
    $stmt = $conn->prepare("SELECT `user_name`, `vc_id`, `password` FROM `users` WHERE `vc_id` = ?");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        if (password_verify($_POST["password"], $row["password"])) {
          $_SESSION["vc_id"] = $row["vc_id"];
          $_SESSION["user_name"] = $row["user_name"];
        }
      }
      header("location:customerhomepage.php");
    }else{
      $error = "Invalid Credentials".password_hash("test1234",PASSWORD_DEFAULT);
    }
    $stmt->close();
    $conn->close();
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    
    <section class="vh-100" style="background-color: #253238;">
        <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                  <img src="login.avif"
                  alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">
                  
                  <form action="" method="post">
                      
                      <div class="d-flex align-items-center mb-3 pb-1">
                          <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <span class="h1 fw-bold mb-0">Logo</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>
                  
                  <div class="form-outline mb-4">
                      <label class="form-label" for="userid">User ID</label>
                      <input type="text" id="userid" name="userid" class="form-control form-control-lg" required/>
                  </div>

                  <div class="form-outline mb-4">
                      <label class="form-label" for="password">Password</label>
                      <input type="password" id="password" name="password" minlength="8" class="form-control form-control-lg" required/>
                  </div>
                  <p class="text-danger"><?php echo $error ?></p>
                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                </div>
                
                  <a class="small text-muted" href="forgotpassword.php">Forgot password?</a>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
