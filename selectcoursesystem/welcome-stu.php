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
$query_Recordset1 = "SELECT * FROM course ORDER BY courseid ASC";
$Recordset1 = mysql_query($query_Recordset1, $selectcoursesystem) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>欢迎您，学生！</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div>
    	<h1>欢迎您，学生！请选择您要进行的操作：</h1>
    </div>
    <div>
   	  <p><a href="course-stu.php">选择课程</a></p>
      <p><a href="course-stu2.php">查询已选课程</a></p>
      <p><a href="course-stu3.php">退选课程</a></p>
      <p><a href="changed-stu.php">修改密码</a></p>
      <p>&nbsp;</p>
      <p><a href="<?php echo $logoutAction ?>" onclick="return confirm('确定要注销吗？')">注销</a></p>
    </div>
    <div>
    	<p>您可以选择的课程：</p>
    	<form id="form1" name="form1" method="post" action="">
    	  <table width="1000" border="1" align="center">
    	    <tr>
    	      <td align="center" nowrap="nowrap">课程代码</td>
    	      <td align="center" nowrap="nowrap">课程名称</td>
    	      <td align="center" nowrap="nowrap">教师编号</td>
    	      <td align="center" nowrap="nowrap">已选人数</td>
    	      <td align="center" nowrap="nowrap">总人数</td>
    	      <td align="center" nowrap="nowrap">上课时间</td>
    	      <td align="center" nowrap="nowrap">地点</td>
    	      <td align="center" nowrap="nowrap">学分</td>
    	      <td align="center" nowrap="nowrap">讲授学时</td>
    	      <td align="center" nowrap="nowrap">实验学时</td>
  	      </tr>
    	    <?php do { ?>
   	        <tr>
   	          <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['courseid']; ?></td>
   	          <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['coursename']; ?></td>
   	          <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['teaid']; ?></td>
   	          <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['selected']; ?></td>
   	          <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['total']; ?></td>
   	          <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['classtime']; ?></td>
   	          <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['classroom']; ?></td>
   	          <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['credit']; ?></td>
   	          <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['shangketime']; ?></td>
   	          <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['shiyantime']; ?></td>
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
