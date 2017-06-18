<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改您的密码</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div>
    	<p><a href="welcome-stu.php">返回</a></p>
    	<p>目前您的个人信息：</p>
    	<form id="form1" name="form1" method="post" action="">
    	  <table width="400" border="1" align="center">
    	    <tr>
    	      <td align="center">您的学生ID：</td>
    	      <td align="center"><?php echo $_SESSION['STU_Username']; ?></td>
  	      </tr>
    	    <tr>
    	      <td align="center">您目前的密码：</td>
    	      <td align="center"><?php echo $_SESSION['STU_Userpassword']; ?></td>
  	      </tr>
  	    </table>
    	  <p><a href="password-stu.php?<?php echo $_SESSION['STU_Username']; ?>=<?php echo $_SESSION['STU_Username']; ?>">修改密码</a></p>
      </form>
    </div>
</body>
</html>