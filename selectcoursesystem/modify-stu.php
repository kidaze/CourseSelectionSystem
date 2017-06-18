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
  $updateSQL = sprintf("UPDATE student SET stuname=%s, collogeid=%s, major=%s, sex=%s, `class`=%s WHERE stuid=%s",
                       GetSQLValueString($_POST['stuname'], "text"),
                       GetSQLValueString($_POST['collegeid'], "int"),
                       GetSQLValueString($_POST['major'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['class'], "text"),
                       GetSQLValueString($_POST['stuid'], "int"));

  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result1 = mysql_query($updateSQL, $selectcoursesystem) or die(mysql_error());

  $updateGoTo = "welcome-admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['stuid'])) {
  $colname_Recordset1 = $_GET['stuid'];
}
mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
$query_Recordset1 = sprintf("SELECT * FROM student WHERE stuid = %s", GetSQLValueString($colname_Recordset1, "int"));
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
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="1000" border="1" align="center">
    <tr>
      <td align="center">学生id</td>
      <td align="center">姓名</td>
      <td align="center">所在院系id</td>
      <td align="center">专业</td>
      <td align="center">性别</td>
      <td align="center">班级</td>
      <td align="center">操作</td>
    </tr>
    <tr>
      <td align="center"><label for="stuid"></label>
      <input name="stuid" type="text" id="stuid" value="<?php echo $row_Recordset1['stuid']; ?>" size="10" readonly="readonly" /></td>
      <td align="center"><input name="stuname" type="text" id="stuname" value="<?php echo $row_Recordset1['stuname']; ?>" size="10" /></td>
      <td align="center"><input name="collegeid" type="text" id="collegeid" value="<?php echo $row_Recordset1['collogeid']; ?>" size="10" /></td>
      <td align="center"><input name="major" type="text" id="major" value="<?php echo $row_Recordset1['major']; ?>" size="10" /></td>
      <td align="center"><input name="sex" type="text" id="sex" value="<?php echo $row_Recordset1['sex']; ?>" size="10" /></td>
      <td align="center"><input name="class" type="text" id="class" value="<?php echo $row_Recordset1['class']; ?>" size="10" /></td>
      <td align="center"><input name="submit" type="submit" id="submit" onclick="validate();return false" value="修改" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
