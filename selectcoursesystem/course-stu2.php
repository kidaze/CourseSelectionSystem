<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
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

$colname_Recordset1 = "-1";
if (isset($_SESSION['STU_Username'])) {
  $colname_Recordset1 = $_SESSION['STU_Username'];
}
mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
$query_Recordset1 = sprintf("SELECT * FROM stucourse WHERE stuid = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $selectcoursesystem) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>您选择的课程</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div>
	<p><a href="welcome-stu.php">返回</a></p>
</div>
<form id="form1" name="form1" method="post" action="">
  <table width="1000" border="1" align="center">
    <tr>
      <td align="center">学号</td>
      <td align="center">姓名</td>
      <td align="center">所在学院</td>
      <td align="center">所在专业</td>
      <td align="center">班级</td>
      <td align="center">教师编号</td>
      <td align="center">课程编码</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center"><?php echo $row_Recordset1['stuid']; ?></td>
        <td align="center"><?php echo $row_Recordset1['stuname']; ?></td>
        <td align="center"><?php echo $row_Recordset1['institute']; ?></td>
        <td align="center"><?php echo $row_Recordset1['major']; ?></td>
        <td align="center"><?php echo $row_Recordset1['class']; ?></td>
         <td align="center"><?php echo $row_Recordset1['teaid']; ?></td>
        <td align="center"><?php echo $row_Recordset1['courseid']; ?></td>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
