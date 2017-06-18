<?php require_once('Connections/selectcoursesystem.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
$query_Recordset1 = "SELECT * FROM `admin`";
$Recordset1 = mysql_query($query_Recordset1, $selectcoursesystem) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>欢迎您，管理员！</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div>
    	<h1>欢迎您，管理员！请选择您要进行的操作：</h1>
    </div>
<div>
  <p><a href="manage-tea.php">管理老师信息</a></p>
  <p><a href="manage-stu.php">管理学生信息</a></p>
  <p>&nbsp;</p>
  <p><a href="<?php echo $logoutAction ?>" onclick="return confirm('确定要注销吗？')">注销</a></p>
  <form id="form1" name="form1" method="post" action="">
    <table width="400" border="1" align="center">
      <tr>
        <td align="center">管理员id</td>
        <td align="center">管理员密码</td>
      </tr>
      <tr>
        <td align="center"><?php echo $row_Recordset1['adminid']; ?></td>
        <td align="center"><?php echo $row_Recordset1['adminpassword']; ?></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><a href="changed-admin.php?<?php echo $row_Recordset1['adminid']; ?>=<?php echo $row_Recordset1['adminid']; ?>">修改</a></td>
      </tr>
    </table>
  </form>
  <p>&nbsp;</p>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
