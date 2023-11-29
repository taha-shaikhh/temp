<?php 
  include "config.php";

  if($_SERVER["REQUEST_METHOD"] == "POST"){

    $vc_id = $_POST["vc_id"];
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    date_default_timezone_set("Asia/Calcutta");
    $expiry = date("Y-m-d H:i:s", time() + 60 * 10);


    $sql = "UPDATE users
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE vc_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sss", $token_hash, $expiry, $vc_id);

    $stmt->execute();
    if ($conn->affected_rows) {
      $error = "Password reset link have been sent to your registered email";
      echo 'Click <a href="'.$base_url.'reset-password.php?token='.$token.'">here</a> 
      to reset your password.';
    }

    // $vc_id = $conn -> real_escape_string($_POST['vc_id']);
    // $sql = "SELECT `vc_id`,`email`,`password` FROM `users` WHERE `vc_id` = '$vc_id'";
    // $result = $conn->query($sql);
    // $row = $result->fetch_assoc();
    // $vc = $row["vc_id"];
    // $email = $row["email"];
    // $password = $row["password"];
    // if($vc){
    //   $msg = "This is a mail containing your password of your cable account.\n\nYour password is".$password." .\n\nThis mail is only shared with you.\n\n Thanks.";
    //   $msg= wordwrap($msg,70);
    //   mail($email,"Forgot Password",$msg);
    // }

  }
$conn->close();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
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
                  
                  <form method="post">
                      
                      <div class="d-flex align-items-center mb-3 pb-1">
                          <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <span class="h1 fw-bold mb-0">Forgot Password</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">We get it, stuff happens. Just enter your VC ID below
                                            and we'll send you your password on your email!</h5>
                  
                  <div class="form-outline mb-4">
                      <label class="form-label" for="vc_id">VC ID</label>
                      <input type="text" id="vc_id" name="vc_id" class="form-control form-control-lg" required/>
                  </div>
                  <p class="text-danger"><?php echo $error ?></p>
                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit">Submit</button>
                </div>
                
                  <a class="small text-muted" href="login.php">Login</a>
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