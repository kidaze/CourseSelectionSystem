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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE admin SET adminpassword=%s WHERE adminid=%s",
                       GetSQLValueString($_POST['adminpassword'], "int"),
                       GetSQLValueString($_POST['adminid'], "int"));

  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result1 = mysql_query($updateSQL, $selectcoursesystem) or die(mysql_error());

  $updateGoTo = "login-admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div>
	<p><a href="welcome-admin.php">返回</a></p>
</div>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="400" border="1" align="center">
    <tr>
      <td align="center">管理员id</td>
      <td align="center">管理员密码</td>
    </tr>
    <tr>
      <td align="center"><label for="adminid"></label>
      <input name="adminid" type="text" id="adminid" value="<?php echo $row_Recordset1['adminid']; ?>" size="16" readonly="readonly" /></td>
      <td align="center"><label for="adminpassword"></label>
      <input name="adminpassword" type="text" id="adminpassword" value="<?php echo $row_Recordset1['adminpassword']; ?>" size="16" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" onclick="return confirm('确定要修改吗？')" value="确定" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
