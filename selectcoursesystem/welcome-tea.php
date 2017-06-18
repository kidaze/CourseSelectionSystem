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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO course (coursename, teaid, selected, total, classtime, classroom, credit, shangketime, shiyantime) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['coursename'], "text"),
                       GetSQLValueString($_POST['teaid'], "int"),
                       GetSQLValueString($_POST['selected'], "int"),
                       GetSQLValueString($_POST['total'], "int"),
                       GetSQLValueString($_POST['classtime'], "text"),
                       GetSQLValueString($_POST['classroom'], "text"),
                       GetSQLValueString($_POST['credit'], "int"),
                       GetSQLValueString($_POST['shangketime'], "int"),
                       GetSQLValueString($_POST['shiyantime'], "int"));

  mysql_select_db($database_selectcoursesystem, $selectcoursesystem);
  $Result1 = mysql_query($insertSQL, $selectcoursesystem) or die(mysql_error());

  $insertGoTo = "welcome-tea.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>欢迎您，老师！</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div>
    	<h1>欢迎您，老师！请选择您要进行的操作：</h1>
    </div>
    <div>
      <p><a href="course-tea.php">查询已发布课程</a></p>
        <p><a href="search-tea.php">查询选课学生信息</a></p>
        <p><a href="changed-tea.php">修改密码</a></p>
        <p>&nbsp;</p>
      <p><a href="<?php echo $logoutAction ?>" onclick="return confirm('确定要注销吗？')">注销</a></p>
</div>
<div>
  <p>请发布课程：</p>
    	<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
    	  <table width="1000" border="1" align="center">
    	    <tr>
    	      <td width="88" align="center" nowrap="nowrap">课程代码</td>
    	      <td width="78" align="center">课程名称</td>
    	      <td width="96" align="center">教师编号</td>
    	      <td width="96" align="center">已选人数</td>
    	      <td width="96" align="center">总人数</td>
    	      <td width="96" align="center">上课时间</td>
    	      <td width="96" align="center">地点</td>
    	      <td width="96" align="center">讲授学时</td>
    	      <td width="96" align="center">实验学时</td>
    	      <td width="98" align="center">学分</td>
   	        </tr>
    	    <tr>
    	      <td width="88" align="center" nowrap="nowrap"><label for="courseid"></label>
    	        自动添加</td>
    	      <td align="center"><input name="coursename" type="text" id="coursename" size="10" /></td>
    	      <td align="center"><input name="teaid" type="text" id="teaid" value="<?php echo $_SESSION['TEA_Username']; ?>" size="10" readonly="readonly" /></td>
    	      <td align="center"><input name="selected" type="text" id="selected" size="10" /></td>
    	      <td align="center"><input name="total" type="text" id="total" size="10" /></td>
    	      <td align="center"><input name="classtime" type="text" id="classtime" size="10" /></td>
    	      <td align="center"><input name="classroom" type="text" id="classroom" size="10" /></td>
    	      <td align="center"><input name="shangketime" type="text" id="shangketime" size="10" /></td>
    	      <td align="center"><input name="shiyantime" type="text" id="shiyantime" size="10" /></td>
    	      <td align="center"><input name="credit" type="text" id="credit" size="10" /></td>
   	        </tr>
    	    <tr>
    	      <td colspan="10" align="center"><input type="submit" name="submit" id="submit"   onclick="return confirm('确定要添加吗？')" value="添加" /></td>
   	        </tr>
  	      </table>
    	  <input type="hidden" name="MM_insert" value="form1" />
      </form>
  </div>
</body>
</html>