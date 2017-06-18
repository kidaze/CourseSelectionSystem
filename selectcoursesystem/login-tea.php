<?php require_once('Connections/selectcoursesystem.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['teaid'])) {
  $loginUsername=$_POST['teaid'];
  $password=$_POST['teapassword'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "welcome-tea.php";
  $MM_redirectLoginFailed = "loginfailed.php";
  $_SESSION['TEA_Username'] = $loginUsername;
  $_SESSION['TEA_Userpassword'] = $password;	      
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  
  $LoginRS__query=sprintf("SELECT teaid, teapassword FROM teacher WHERE teaid=%s AND teapassword=%s",
    GetSQLValueString($loginUsername, "int"), GetSQLValueString($password, "int")); 
   
  $LoginRS = mysql_query($LoginRS__query, $selectcoursesystem) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['TEA_Username'] = $loginUsername;
    $_SESSION['TEA_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>老师登录</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div>
  <p>请输入您的账号和密码：</p>
  <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
    <table width="400" border="1" align="center">
      <tr>
        <td width="200" align="center">老师id：</td>
        <td width="200" align="center"><label for="teaid"></label>
        <input name="teaid" type="text" id="teaid" size="15" /></td>
      </tr>
      <tr>
        <td width="200" align="center">老师密码：</td>
        <td width="200" align="center"><input name="teapassword" type="password" id="teapassword" size="15" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="登录" /></td>
      </tr>
    </table>
  </form>
</div>
</body>
</html>