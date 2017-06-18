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
  $insertSQL = sprintf("INSERT INTO student (stuname, collogeid, major, sex, `class`, stupassword) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['stuname'], "text"),
                       GetSQLValueString($_POST['collegeid'], "int"),
                       GetSQLValueString($_POST['major'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['class'], "text"),
                       GetSQLValueString($_POST['stupassword'], "int"));

  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result1 = mysql_query($insertSQL, $selectcoursesystem) or die(mysql_error());

  $insertGoTo = "manage-stu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_GET['stuid'])) && ($_GET['stuid'] != "")) {
  $deleteSQL = sprintf("DELETE FROM student WHERE stuid=%s",
                       GetSQLValueString($_GET['stuid'], "int"));

  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result1 = mysql_query($deleteSQL, $selectcoursesystem) or die(mysql_error());

  $deleteGoTo = "manage-stu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
$query_Recordset1 = "SELECT * FROM student";
$Recordset1 = mysql_query($query_Recordset1, $selectcoursesystem) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理学生信息</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div>
  <p><a href="welcome-admin.php">返回</a></p>
  <p>插入学生信息：</p>
    	<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
    	  <table width="900" border="1" align="center">
    	    <tr>
    	      <td width="91" align="center">学生id</td>
    	      <td width="75" align="center">姓名</td>
    	      <td width="93" align="center">所在院系id</td>
    	      <td width="130" align="center">专业</td>
    	      <td width="43" align="center">性别</td>
    	      <td width="130" align="center">班级</td>
    	      <td width="87" align="center">初始密码</td>
    	      <td width="148" align="center">操作</td>
  	        </tr>
    	    <tr>
    	      <td align="center">自动添加</td>
    	      <td align="center"><label for="stuname"></label>
   	          <input name="stuname" type="text" id="stuname" size="10" /></td>
    	      <td align="center"><input name="collegeid" type="text" id="collegeid" size="5" /></td>
    	      <td align="center"><input name="major" type="text" id="major" size="15" /></td>
    	      <td align="center"><input name="sex" type="text" id="sex" size="5" /></td>
    	      <td align="center"><input name="class" type="text" id="class" size="15" /></td>
    	      <td align="center"><label for="stupassword"></label>
   	          <input name="stupassword" type="text" id="stupassword" size="10" /></td>
    	      <td align="center"><input type="submit" name="submit" id="submit" onclick="return confirm('确定要添加吗？')" value="添加" />
              <input type="reset" name="submit2" id="submit2" value="重置" /></td>
  	        </tr>
  	    </table>
    	  <input type="hidden" name="MM_insert" value="form1" />
      </form>
  </div>
  <div>
  	<p>查看学生信息：</p>
  	<form id="form2" name="form2" method="post" action="">
  	  <table width="1000" border="1" align="center">
  	    <tr>
  	      <td width="120" align="center">学生id</td>
  	      <td width="143" align="center">姓名</td>
  	      <td width="162" align="center">所在院系id</td>
  	      <td width="166" align="center">专业</td>
  	      <td width="125" align="center">性别</td>
  	      <td width="135" align="center">班级</td>
  	      <td colspan="2" align="center">操作</td>
        </tr>
  	    <?php do { ?>
        <tr>
          <td align="center"><?php echo $row_Recordset1['stuid']; ?></td>
          <td align="center"><?php echo $row_Recordset1['stuname']; ?></td>
          <td align="center"><?php echo $row_Recordset1['collogeid']; ?></td>
          <td align="center"><?php echo $row_Recordset1['major']; ?></td>
          <td align="center"><?php echo $row_Recordset1['sex']; ?></td>
          <td align="center"><?php echo $row_Recordset1['class']; ?></td>
          <td width="103" align="center"><a href="delete-stu.php?stuid=<?php echo $row_Recordset1['stuid']; ?>" onclick="return confirm('确定要删除吗？')" >删除</a></td>
          <td width="103" align="center"><a href="modify-stu.php?stuid=<?php echo $row_Recordset1['stuid']; ?>">修改</a></td>
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
