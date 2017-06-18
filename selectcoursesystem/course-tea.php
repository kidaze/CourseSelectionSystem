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
if (isset($_SESSION['TEA_Username'])) {
  $colname_Recordset1 = $_SESSION['TEA_Username'];
}
mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
$query_Recordset1 = sprintf("SELECT * FROM course WHERE teaid = %s ORDER BY courseid ASC", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $selectcoursesystem) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>您已发布的课程</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div>
    	<p><a href="welcome-tea.php">返回</a></p>
    	<p>您已发布的课程：</p>
    	<form id="form1" name="form1" method="post" action="">
    	  <table width="1000" border="1" align="center">
    	    <tr>
    	      <td align="center">课程代码</td>
    	      <td align="center">课程名称</td>
    	      <td align="center">教师编号</td>
    	      <td align="center">已选人数</td>
    	      <td align="center">总人数</td>
    	      <td align="center">上课时间</td>
    	      <td align="center">地点</td>
    	      <td align="center">讲授学时</td>
    	      <td align="center">实验学时</td>
    	      <td align="center">学分</td>
  	      </tr>
    	    <?php do { ?>
   	        <tr>
   	          <td align="center"><?php echo $row_Recordset1['courseid']; ?></td>
   	          <td align="center"><?php echo $row_Recordset1['coursename']; ?></td>
   	          <td align="center"><?php echo $row_Recordset1['teaid']; ?></td>
   	          <td align="center"><?php echo $row_Recordset1['selected']; ?></td>
   	          <td align="center"><?php echo $row_Recordset1['total']; ?></td>
   	          <td align="center"><?php echo $row_Recordset1['classtime']; ?></td>
   	          <td align="center"><?php echo $row_Recordset1['classroom']; ?></td>
   	          <td align="center"><?php echo $row_Recordset1['shangketime']; ?></td>
   	          <td align="center"><?php echo $row_Recordset1['shiyantime']; ?></td>
   	          <td align="center"><?php echo $row_Recordset1['credit']; ?></td>
  	        </tr>
    	      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  	      </table>
      </form>
    </div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
