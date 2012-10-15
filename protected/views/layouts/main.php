<!-- 主界面
包括登录注册，预定购买等组件 -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<link rel=StyleSheet type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main_Css.css"/>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/main_js.js"></script>
	
   



	<style>
		body{
			background:url(/sampleCake/images/background.png) repeat;
        	font-family:Arial;
		}
	</style>

    
</head>



<body>
	
	<div style="position:relative;" align="center" width:1300px;>
 		<img id="header_bg" src="<?php echo Yii::app()->request->baseUrl; ?>/images/shopTab.png" style=" position:absolute;z-index:0;left:50%; margin:auto auto auto -482px;"/>
        <div id="navigationDiv">
        	<ul id="header_navigation" uid="">
                <li class="navigation target memberInfoManagement"><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/sample/managePersonalInfo">个人中心</a></li>
                <li class="navigation memberInfoManagement"> | </li>
                <li class="navigation target salesManagement"><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/sample/manageSales">销售管理</a></li>
                <li class="navigation salesManagement"> | </li>
            	<li class="navigation target vipServiceCenter"><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/sample/manageMember">会员管理</a></li>
                <li class="navigation vipServiceCenter"> | </li>
                <li class="navigation target" id="home"><a href="<?php echo Yii::app()->createUrl('/site/turn')?>">商场</a></li>
                <li class="navigation vipServiceCenter"> | </li>
           		<li class="navigation target" id="home"><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php">首页</a></li>
                <li class="navigation vip_hidden"> | </li>
                <li class="navigation target vip_hidden" id="userLogin">登录</li>
                <li class="navigation vip_hidden">/</li>
                <li class="navigation target vip_hidden" id="userRegister">注册</li>
 			 </ul>
        </div>
        
        <div id="overContent"></div>
        
        
        <div id="contents">
        	<?php echo $content; ?>
        </div>
        
        <!--For the products box-->
               
	</div>
<!--For login & register- BEGIN-->   

	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/Login_js.js"></script>
    <link rel=StyleSheet type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/Login_Css.css"/>
    <div class="LR" id="login">
        <img class="close" id="login_close" src="<?php echo Yii::app()->request->baseUrl; ?>/images/window_close_before.png" width="16px" height="16px"/>
        <p class="LR_login_tab" id="Llogin_tab">登录</p>
        <p class="LR_register_tab"  id="Lregister_tab">注册</p>
        
        <form class="inputArea">
        	<p class="inputArea_tab">用户名:</p>
			<input type="text" id="Remail"/>
            <p class="inputArea_tab">密码:</p>
			<input type="password" id="Rpassword"/>
		</form>

            <input type="checkbox" name="jquery_like" id="remberID" value="1" style="margin-left:-155px;"/>
            <label for="jquery_like" style="font-size:12px;">记住登录信息</label>
        
        <p id="faildLogin" style="color:red; margin-top:10px; margin-left:30px; float:left; visibility:hidden;">输入的用户名或密码错误！</p>
        <img class="LR_btn" id="loginBtn" src="<?php echo Yii::app()->request->baseUrl; ?>/images/loginBtn.png"/> 
        
        <img id="loading" src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading1.png" value="1"/>
    </div>
    <div class="LR" id="register">
    	<img class="close" id="register_close" src="<?php echo Yii::app()->request->baseUrl; ?>/images/window_close_before.png" width="16px" height="16px"/>
        <p class="LR_login_tab" id="Rlogin_tab">登录</p>
        <p class="LR_register_tab"  id="Rregister_tab">注册</p>
        <form class="inputArea">
        	<p class="inputArea_tab">用户名:</p>
			<input type="text" id="Lemail"/>
            <p class="inputArea_tab">密码:</p>
			<input type="password" id="Lpassword"/>
		</form>
        <p id="termsArea"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/attention.png">注册前，申明已同意<a id="cooperationTerms" href="#" onclick="window.open('CooperationTerms.html')">《合作条款》</a></p>
        <img class="LR_btn" id="registerBtn" src="<?php echo Yii::app()->request->baseUrl; ?>/images/registerBtn.png"/>
        <p id="succeedSignUp">已注册，可正常登录!</p>
    </div>
    <div id="fade" name='fade'>
    </div>
<!--For login & register- END-->  

    <div id="optionBox">
        <ul id="optionBoxInfo" productID="" day="" month="" year="">
            <li class='optionlable'>会员卡号</li>
            <li><input type="text" id="selectMemberCard" onkeydown="onlyNum();" style="ime-mode:Disabled"/></li>
            <li id="selectMemberCardBtn"></li>
            <li class='optionlable' id="dateLable" style="margin-top:0px;">预定日期</li>
            <!-- <li id="selectDate"><input type="text" name="it" class="it date-pick" id='datePick' readonly="readonly"/></li> -->
            <li id="selectDate"><input type="text" name="it" id='datePick' readonly="readonly"/>
            <li id="selectDateBtn"></li>
            <li class='optionlable' style="margin-top:0px;" id="countLable">预定数量</li>
            <li style="margin-top:0px;"><input type="text" id="selectCount" onkeydown="onlyNum();" style="ime-mode:Disabled" value='1'/></li>

            <!-- 会员卡号下拉框 -->
            <li>
                <ul id='cardMenu'>
                </ul>
            </li>

            <li  class='optionBoxBtn'><img id='confirmPurchaseBtn' class='optionBoxBtn' src="<?php echo Yii::app()->request->baseUrl; ?>/images/okBtn.png" optionState=""></li>
            <li class='optionBoxBtn'><img id='cancelPurchaseBtn' class='optionBoxBtn' src="<?php echo Yii::app()->request->baseUrl; ?>/images/cancelBtn.png"></li>

            <li>
                <ul id='reserveMenu'>
                </ul>
            </li>
        </ul>
        <p id="succeedOptionLable">成功预订</p>
    </div>
 
    <div id="byClass">
        <ul>
            <!-- <li style="font-weight:bolder; font-size:20px; width:100px;">甜品巡礼</li> -->
            <li class="productTypeLable" id="typeCookie" typeID="2">饼干</li>
            <li class="productTypeLable" id="typePatissierCake" typeID="1">小西点</li>
            <li class="productTypeLable" id="typeFruitCake" typeID="3">水果蛋糕</li>
            <li class="productTypeLable" id="typeMulCake" typeID="4">多层蛋糕</li>
            <li class="productTypeLable" id="typePie" typeID="6">果派</li>
        </ul>
    </div>
<!--FORM-->
</body>
</html>
