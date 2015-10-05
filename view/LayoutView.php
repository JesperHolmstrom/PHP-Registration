<?php
/**
  * Solution for assignment 2
  * @author Daniel Toll
  */
class LayoutView {
  public function render($isLoggedIn, LoginView $v, DateTimeView $dtv, RegisterView $rv) {
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login Example</title>
  </head>
  <body>
    <h1>Assignment 2</h1>
    <?php
      if($rv->userClickedOnRegister())
        echo $rv->getBackLink();
      else if(!$isLoggedIn)
        echo $rv->getRegistrationLink();

      if ($isLoggedIn) {
        echo "<h2>Logged in</h2>";
      } else {
        echo "<h2>Not logged in</h2>";
    }
  ?>
    <div class="container" >
      <?php

        if($rv->userClickedOnRegister() && $rv->registrationSucceeded() === FALSE)
          echo $rv->response();
        else
          echo $v->response();

        $dtv->show();
      ?>
    </div>

    <div>
      <em>This site uses cookies to improve user experience. By continuing to browse the site you are agreeing to our use of cookies.</em>
    </div>
   </body>
</html>
<?php
  }
}
