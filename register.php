<?
/**
 * Register.php
 * 
 * Displays the registration form if the user needs to sign-up,
 * or lets the user know, if he's already logged in, that he
 * can't register another name.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 19, 2004
 */
 ob_start();
include("include/session.php");
$betacode = $_GET["code"];
$user_name = "";
$password = "";
$database = "";
$server = "";
$db_handle = mysql_connect($server, $user_name, $password);
$db_found = mysql_select_db($database, $db_handle);
$q = "SELECT * FROM beta_codes WHERE betacode = '".$betacode."'";
      $resulted = mysql_query($q);
      //if (mysql_numrows($resulted) > 0) {
      $q = "SELECT username,email FROM beta_codes WHERE betacode = '".$betacode."'";
      $result = mysql_query($q);
      if($result){
      /* Retrieve password from result, strip slashes */
      $dbarray = mysql_fetch_array($result);
      $dbarray['username'] = stripslashes($dbarray['username']);
      $userbeta = $dbarray['username'];
      
      $dbarray['email'] = stripslashes($dbarray['email']);
      $emailbeta = $dbarray['email'];
      //$emailbeta = 'email';
      };
mysql_close($db_handle);
?>

<html>
<title>Registration Page</title>
<head>
<style>
table {
	position: relative;
width: 0px;
height: 0px;
padding: 0px;
left: 0px;
top: 0px;
margin: 0 auto;
}

form {
	position: relative;
width: 100%;
height: auto;
}

h1 {
	position: relative;
	width: 100%;
	text-align: center;
}

body {
	background: rgba(33, 22, 0, 1);
color: white;
}
</style>
</head>
<body>

<?
/**
 * The user is already logged in, not allowed to register.
 */
if($session->logged_in){
   echo "<h1>Registered</h1>";
   echo "<p>We're sorry <b>$session->username</b>, but you've already registered. "
       ."<a href=\"index.php\">Main</a>.</p>";
}
/**
 * The user has submitted the registration form and the
 * results have been processed.
 */
else if(isset($_SESSION['regsuccess'])){
   /* Registration was successful */
   if($_SESSION['regsuccess']){
      echo "<h1>Registered!</h1>";
      echo "<p>Thank you <b>".$_SESSION['reguname']."</b>, your information has been added to the database, "
          ."you may now <a onclick=\"parent.window.location.href = 'index.php'\">log in</a>.</p>";
   }
   /* Registration failed */
   else{
      echo "<h1>Registration Failed</h1>";
      echo "<p>We're sorry, but an error has occurred and your registration for the username <b>".$_SESSION['reguname']."</b>, "
          ."could not be completed.<br>Please try again at a later time.</p>";
   }
   unset($_SESSION['regsuccess']);
   unset($_SESSION['reguname']);
}
/**
 * The user has not filled out the registration form yet.
 * Below is the page with the sign-up form, the names
 * of the input fields are important and should not
 * be changed.
 */
else{
?>
<div style="position: relative;width: 100px;margin: 0 auto;">
	<img src="http://bludotos.com/images/BluDotlogo.png" style="width: 100px;position: relative;margin: 0 auto;" />
</div>
<h1>Register</h1>
<?
if($form->num_errors > 0){
   echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
}
?>
<form action="process.php" method="POST">
<table border="0" cellspacing="0" cellpadding="3">
<tr><td>Username:</td><td><font type="text" name="user" maxlength="30" value="<? echo $userbeta; ?>"><? echo $userbeta; ?></font><input type="hidden" name="user" maxlength="30" value="<? echo $userbeta; ?>"></td><td><? echo $form->error("user"); ?></td></tr>
<tr><td>Password:</td><td><input type="password" name="pass" maxlength="30" value="<? echo $form->value("pass"); ?>"></td><td><? echo $form->error("pass"); ?></td></tr>
<tr><td>Email:</td><td><font type="text" name="email" maxlength="50" value="<? echo $emailbeta; ?>"><? echo $emailbeta; ?></font><input type="hidden" name="email" maxlength="50" value="<? echo $emailbeta; ?>"></td><td><? echo $form->error("email"); ?></td></tr>
<tr><td colspan="2" align="right">
<input type="hidden" name="subjoin" value="1">
<input type="hidden" name="betacode" value="<? echo $_GET['code'];?>">
<input type="submit" value="Join!"></td></tr>
<tr><td colspan="2" align="left"><a onclick="parent.window.location = 'index.php';">Back to Main</a></td></tr>
</table>
</form>

<?
};
?>
</body>
</html>
<?
//} else {
?>
<script>
//	alert(document.body.innerHTML);
//	window.location = 'http://bludotos.com';
</script>
<?
//};
?>