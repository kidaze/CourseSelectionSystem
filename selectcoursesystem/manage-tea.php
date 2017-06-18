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
  $insertSQL = sprintf("INSERT INTO teacher (teaname, sex, collegename, teapassword) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['teaname'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['collegename'], "text"),
                       GetSQLValueString($_POST['teapassword'], "int"));

  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result1 = mysql_query($insertSQL, $selectcoursesystem) or die(mysql_error());
}

if ((isset($_GET['teaid'])) && ($_GET['teaid'] != "")) {
  $deleteSQL = sprintf("DELETE FROM teacher WHERE teaid=%s",
                       GetSQLValueString($_GET['teaid'], "int"));

  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result1 = mysql_query($deleteSQL, $selectcoursesystem) or die(mysql_error());

  $deleteGoTo = "manage-tea.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
$query_Recordset1 = "SELECT * FROM teacher ORDER BY teaid ASC";
$Recordset1 = mysql_query($query_Recordset1, $selectcoursesystem) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理老师信息</title>
<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
	<div>
    	<p><a href="welcome-admin.php">返回</a></p>
    	<p>插入老师信息</p>
    	<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
    	  <table width="900" border="1" align="center">
    	    <tr>
    	      <td width="91" align="center">教师id</td>
    	      <td width="75" align="center">姓名</td>
    	      <td width="43" align="center">性别</td>
    	      <td width="93" align="center">所属学院</td>
    	      <td width="87" align="center">初始密码</td>
    	      <td width="148" align="center">操作</td>
  	      </tr>
    	    <tr>
    	      <td width="91" align="center">自动添加</td>
    	      <td width="75" align="center"><label for="teaname"></label>
   	          <input name="teaname" type="text" id="teaname" size="10" /></td>
    	      <td width="43" align="center"><input name="sex" type="text" id="sex" size="5" /></td>
    	      <td width="93" align="center"><input name="collegename" type="text" id="collegename" size="5" /></td>
    	      <td width="87" align="center"><input name="teapassword" type="text" id="teapassword" size="10" /></td>
    	      <td width="148" align="center"><input type="submit" name="submit" id="submit" onclick="return confirm('确定要添加吗？')" value="添加" />
   	          <input type="reset" name="submit2" id="submit2" value="重置" /></td>
  	      </tr>
  	    </table>
    	  <input type="hidden" name="MM_insert" value="form1" />
      </form>
    </div>
    <div>
    	<p>查看老师信息：</p>
    	<form id="form2" name="form2" method="post" action="">
    	  <table width="900" border="1" align="center">
    	    <tr>
    	      <td width="91" align="center">教师id</td>
    	      <td width="75" align="center">姓名</td>
    	      <td width="43" align="center">性别</td>
    	      <td width="93" align="center">所属学院</td>
    	      <td width="87" align="center">简介</td>
    	      <td colspan="2" align="center">操作</td>
   	        </tr>
    	    <?php do { ?>
   	        <tr>
   	          <td width="91" align="center"><?php echo $row_Recordset1['teaid']; ?></td>
   	          <td width="75" align="center"><?php echo $row_Recordset1['teaname']; ?></td>
   	          <td width="43" align="center"><?php echo $row_Recordset1['sex']; ?></td>
   	          <td width="93" align="center"><?php echo $row_Recordset1['collegename']; ?></td>
   	          <td width="87" align="center"><?php echo $row_Recordset1['introduction']; ?></td>
   	          <td width="148" align="center"><a href="delect.php?teaid=<?php echo $row_Recordset1['teaid']; ?>" onclick="return confirm('确定要删除吗？')">删除</a></td>
   	          <td width="148" align="center"><a href="modify-tea.php?teaid=<?php echo $row_Recordset1['teaid']; ?>">修改</a></td>
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
