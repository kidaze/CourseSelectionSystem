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

if ((isset($_GET['teaid'])) && ($_GET['teaid'] != "")) {
  $deleteSQL = sprintf("DELETE FROM teacher WHERE teaid=%s",
                       GetSQLValueString($_GET['teaid'], "int"));

  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result1 = mysql_query($deleteSQL, $selectcoursesystem) or die(mysql_error());

  $deleteGoTo = "welcome-admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['teaid'])) {
  $colname_Recordset1 = $_GET['teaid'];
}
mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
$query_Recordset1 = sprintf("SELECT * FROM teacher WHERE teaid = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $selectcoursesystem) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script LANGUAGE="JavaScript">

function validate()
{
var tag = confirm('确定修改吗?');
if( tag == true )
dc();
else
return false;
}
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="900" border="1" align="center">
    <tr>
      <td align="center">老师id</td>
      <td align="center">姓名</td>
      <td align="center">性别</td>
      <td align="center">所属学院</td>
      <td align="center">简介</td>
      <td align="center">密码</td>
    </tr>
    <tr>
      <td align="center"><?php echo $row_Recordset1['teaid']; ?></td>
      <td align="center"><?php echo $row_Recordset1['teaname']; ?></td>
      <td align="center"><?php echo $row_Recordset1['sex']; ?></td>
      <td align="center"><?php echo $row_Recordset1['collegename']; ?></td>
      <td align="center"><?php echo $row_Recordset1['introduction']; ?></td>
      <td align="center"><?php echo $row_Recordset1['teapassword']; ?></td>
    </tr>
    <tr>
      <td colspan="6" align="center"><input type="submit" name="delete" id="delete" onclick="validate();return false" value="删除" /></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
