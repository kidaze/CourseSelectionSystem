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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO stucourse (stuid, stuname, institute, major, `class`, teaid, courseid, classtime) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['stuid'], "int"),
                       GetSQLValueString($_POST['stuname'], "text"),
                       GetSQLValueString($_POST['collegename'], "text"),
                       GetSQLValueString($_POST['major'], "text"),
                       GetSQLValueString($_POST['class'], "text"),
                       GetSQLValueString($_POST['teaid'], "int"),
                       GetSQLValueString($_POST['courseid'], "int"),
                       GetSQLValueString($_POST['classtime'], "text"));

  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result1 = mysql_query($insertSQL, $selectcoursesystem) or die(mysql_error());

  $insertGoTo = "welcome-stu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
$query_Recordset1 = "SELECT * FROM course ORDER BY courseid ASC";
$Recordset1 = mysql_query($query_Recordset1, $selectcoursesystem) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_Recordset2 = "-1";
if (isset($_SESSION['STU_Username'])) {
  $colname_Recordset2 = $_SESSION['STU_Username'];
}
mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
$query_Recordset2 = sprintf("SELECT * FROM student WHERE stuid = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $selectcoursesystem) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>请选择课程</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div>
	<p><a href="welcome-stu.php">返回</a></p>
</div>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  选课前请确认您的个人信息：
    <table width="400" border="1" align="center">
      <tr>
        <td align="center">学号：</td>
        <td align="center"><label for="stuid"></label>
        <input name="stuid" type="text" id="stuid" value="<?php echo $_SESSION['STU_Username']; ?>" size="15" readonly="readonly" /></td>
      </tr>
      <tr>
        <td align="center">姓名：</td>
        <td align="center"><input name="stuname" type="text" id="stuname" value="<?php echo $row_Recordset2['stuname']; ?>" size="15" readonly="readonly" /></td>
      </tr>
      <tr>
        <td align="center">所在学院ID：</td>
        <td align="center"><input name="collegename" type="text" id="collegename" value="<?php echo $row_Recordset2['collogeid']; ?>" size="15" readonly="readonly" /></td>
      </tr>
      <tr>
        <td align="center">所在专业：</td>
        <td align="center"><input name="major" type="text" id="major" value="<?php echo $row_Recordset2['major']; ?>" size="15" readonly="readonly" /></td>
      </tr>
      <tr>
        <td align="center">所在班级：</td>
        <td align="center"><input name="class" type="text" id="class" value="<?php echo $row_Recordset2['class']; ?>" size="15" readonly="readonly" /></td>
      </tr>
    </table>
  <p>&nbsp;</p>
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
      <td align="center" nowrap="nowrap">操作</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" nowrap="nowrap"><label for="courseid"></label>
          <label for="courseid"></label>
          <input name="courseid" type="text" id="courseid" value="<?php echo $row_Recordset1['courseid']; ?>" size="10" readonly="readonly" /></td>
        <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['coursename']; ?></td>
        <td align="center" nowrap="nowrap"><label for="teaid"></label>
          <input name="teaid" type="text" id="teaid" value="<?php echo $row_Recordset1['teaid']; ?>" size="10" readonly="readonly" /></td>
        <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['selected']; ?></td>
        <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['total']; ?></td>
        <td align="center" nowrap="nowrap"><label for="classtime"></label>
          <input name="classtime" type="text" id="classtime" value="<?php echo $row_Recordset1['classtime']; ?>" size="12" readonly="readonly" /></td>
        <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['classroom']; ?></td>
        <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['credit']; ?></td>
        <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['shangketime']; ?></td>
        <td align="center" nowrap="nowrap"><?php echo $row_Recordset1['shiyantime']; ?></td>
        <td align="center" nowrap="nowrap"><a href="add-class.php?courseid=<?php echo $row_Recordset1['courseid']; ?>">添加</a></td>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    
  </table>
  
  <p>&nbsp;</p>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
