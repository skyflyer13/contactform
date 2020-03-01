<?php
  //message vars
  $msg = '';
  $msgClass = '';

  // check for submit
  if(filter_has_var(INPUT_POST, 'submit')){
    //get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    //check required fields
    if(!empty($email) && !empty($name) && !empty($message)){
      // passed
      //check email
      if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        //failed
        $msg = 'Please use a valid email';
        $msgClass = 'alert-danger';
      } else {
        //passed
        $toEmail = 'skyflyer@skyflyer.si';
        $subject = 'Contact Request From '.$name;
        $body = '<h2>Contact request</h2>
                <h4>Name</h4><p>'.$name.'</p>
                <h4>Email</h4><p>'.$email.'</p>
                <h4>Message</h4><p>'.$message.'</p>
        ';

        //email headers
        $headers = "MIME-Version: 1.0" ."\r\n";
        $headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";

        //additional headers
        $headers .= "From: " .$name. "<".$email.">". "\r\n";

        if(mail($toEmail, $subject, $body, $headers)){
          // email sent
          $msg = 'your email has been sent';
          $msgClass = 'alert-success';
        } else {
          $msg = 'your email was not sent';
          $msgClass = 'alert-danger';
        }
      }
    } else {
      //failed
      $msg = 'Please fill all fields';
      $msgClass = 'alert-danger';
    }
  }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/cosmo/bootstrap.min.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">My Website</a>
    </nav>

    <div class="container">
      <?php if($msg != ''): ?>
        <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
      <?php endif; ?>
      <br>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
        </div>
        <div class="form-group">
          <label>Message</label>
          <textarea name="message" class="form-control"><?php echo isset($_POST['message']) ? $message : ''; ?></textarea>
        </div>
        <br>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </body>
</html>
