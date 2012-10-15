<!--
    会员信息管理界面
    对管理员及店员展示，帮助其管理会员信息等
    包含充值，会员卡绑定等业务
    针对管理员，管理员能够管理店员信息，查看统计数据，店员不能执行此操作
-->

<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/calendar.css" >
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/calendar.js" ></script>  
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/calendar-zh.js" ></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/calendar-setup.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/manageMemCards_js.js"></script>
<link type="text/css" rel=StyleSheet href="<?php echo Yii::app()->request->baseUrl; ?>/css/manageMemCards_Css.css"/>
<link rel=StyleSheet type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/datePicker.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.datePicker-min.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/exporting.js"></script>

<!-- 会员信息管理菜单 -->
<div id="manageMember">
	<ul class="manageM-menu" currentForm="membershipCard">
        <li>
            <div class="manageM-content" id="ManageMC" control="membershipCard">
                <h2 class="manageM-main">会员卡</h2>
                <h3 class="manageM-sub">绑定会员卡</h3>
            </div>
        </li>
        <li>
            <div class="manageM-content" id="ManageCH" control="recharge">
                <h2 class="manageM-main">充值</h2>
                <h3 class="manageM-sub">为会员卡充值</h3>
            </div>
        </li>
        <li>
            <div class="manageM-content" id="ManageMEM" control="addMember">
                <h2 class="manageM-main">会员管理</h2>
                <h3 class="manageM-sub">添加会员</h3>
            </div>
        </li>
        <li>
            <div class="manageM-content" id="ManageAct" control="activeDiv">
                <h2 class="manageM-main">激活</h2>
                <h3 class="manageM-sub">将会员卡激活</h3>
            </div>
        </li>
        <li  id="liManageClerks">
            <div class="manageM-content" id="ManageClerks" control="addClerk">
                <h2 class="manageM-main">管理店员</h2>
                <h3 class="manageM-sub">增加、删除店员</h3>
            </div>
        </li>  
        <li id="listatisticsMember">
            <div class="manageM-content"   control="memberStatistic">
                <h2 class="manageM-main">会员统计</h2>
                <h3 class="manageM-sub">统计会员信息</h3>
            </div>
        </li> 
        <li id="listatisticsAddr">
            <div class="manageM-content"  control="addrStatistic">
                <h2 class="manageM-main" style="font-size:18px">会员卡统计</h2>
                <h3 class="manageM-sub">会员卡使用情况</h3>
            </div>
        </li> 
    </ul>
</div>

<!-- 会员卡绑定 -->
    <div id="membershipCard">
        <ul>
            <li class="mLable">用户登录名:</li>
            <li><input class="input_text" type="text" name="username" id="username"/></li>
            <li class="mLable">会员卡号:</li>
            <li><input class="input_text" type="text" name="mCard" id="mCard" onkeydown="onlyNum();" style="ime-mode:Disabled"/></li>
            <li style="float:right;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/submitBtn.png" id="mSubmitBtn" class="submitBtn"/></li>
        </ul>
    </div>

<!-- 充值 -->
<div id="recharge">
        <ul>
            <li class="chargeLable">会员卡号:</li>
            <li><input class="input_text" type="text" id="chargeMCard" onkeydown="onlyNum();" style="ime-mode:Disabled"/></li>
            <li class="chargeLable">充值金额:</li>
            <li><input class="input_text" type="text" id="amount" onkeydown="onlyNum();" style="ime-mode:Disabled"/></li>
            <li style="float:right;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/submitBtn.png" id="cSubmitBtn" class="submitBtn"/></li>
        </ul>
</div>

<!-- 添加会员 -->
    <div id="addMember">
        <ul>
            <li class="aLable">用户登录名:</li>
            <li><input class="input_text" type="text" id="registername"/></li>
            <li class="aLable">性别:</li>
            <li style="font-size:18px; width:60px; ">男性</li>
            <li><input type="radio" checked="checked" name="gender" value="male" id="radioMale"/></li>
            <li style="font-size:18px; width:60px; ">女性</li>
            <li><input type="radio" name="gender" value="female" id="radioFemale"/></li>
            <li class="aLable">出生日期:</li>
            <li><input type="text" id="EntTime" name="birthday" class="input_text"  onclick="return showCalendar('EntTime', 'y-mm-dd');"  /></li>
            <!-- <li><input type="text" name="birthday" class="it date-pick input_text" id='datePick' readonly="readonly"/></li> -->
            <li class="aLable">居住地址:</li>
            <li><input class="input_text" type="text" id="address"  readonly="readonly"/></li>
            <li id="selectAddrBtn"></li>
            <li class="aLable" style="color:#AA0004; width:200px; margin-top:-40px;">*初始密码为：123</li>
            <li style="float:right; margin-top:-40px;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/submitBtn.png" id="aSubmitBtn" class="submitBtn"/></li>
        </ul>
        <div id="addrMenu">
            <ul>
                <li>玄武区</li>
                <li>白下区</li>
                <li>建邺区</li>
                <li>秦淮区</li>
                <li>雨花台区</li>
                <li>下关区</li>
                <li>浦口区</li>
                <li>鼓楼区</li>
                <li>栖霞区</li>
                <li>江宁区</li>
                <li>六合区</li>
                <li>溧水县</li>
                <li>高淳县</li>
            </ul>
        </div>
    </div>

<!-- 激活 -->
<div id="activeDiv">
        <ul>
            <li class="activeLable">会员卡号:</li>
            <li><input class="input_text" type="text" id="activeMCard" onkeydown="onlyNum();" style="ime-mode:Disabled"/></li>  
            <li class="activeLable">当前状态:</li>
            <li id="search"></li>
            <li id="state" class="activeLable"></li>
            <!-- <li style="float:right;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/activeBtn.png" id="activeBtn" class="submitBtn"/></li> -->
        </ul>
</div>

<!-- 统计数据 -->
<div id="memberStatistic">
    <div id="chartOfMember"></div>
    <div id="addressStatistic"></div>
</div>

<div id="addrStatistic">
    <div id="cardsStatistic"></div>
</div>

<!-- 添加店员 -->
<div id="addClerk">
    <p style="color:#AA0004; border-bottom:2px solid #AA0004; font-size:18px; font-weight:bolder;">添加店员</p>
        <ul>
            <li class="aLable">用户登录名:</li>
            <li><input class="input_text" type="text" id="clerkname"/></li>
            <li class="aLable">密码:</li>
            <li><input type="text" id="clerkPassword" name="clerkPassword" class="input_text"/></li>
            <li class="aLable">性别:</li>
            <li style="font-size:18px; width:60px; ">男性</li>
            <li><input type="radio" checked="checked" name="gender" value="male" id="clerkMale"/></li>
            <li style="font-size:18px; width:60px; ">女性</li>
            <li><input type="radio" name="gender" value="female" id="clerkFemale"/></li>
            <!-- <li class="aLable">出生日期:</li>
            <li><input type="text" id="clerkdatePick" name="clerkbirthday" class="input_text"  onclick="return showCalendar('EntTime', 'y-mm-dd');"  /></li> -->
            <!-- <li><input type="text" name="clerkbirthday" class="it date-pick input_text" id='clerkdatePick' readonly="readonly"/></li> -->
            <li class="aLable">居住地址:</li>
            <li><input class="input_text" type="text" id="clerkaddress"  readonly="readonly"/></li>
            <li id="clerkselectAddrBtn"></li>
            <!-- <li class="aLable" style="color:#AA0004; width:200px; margin-top:-40px;">*初始密码为：123</li> -->
            <li style="float:right; margin-top:-40px;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/submitBtn.png" id="clerkaSubmitBtn" class="submitBtn"/></li>
        </ul>
        <div id="clerkaddrMenu">
            <ul>
                <li>玄武区</li>
                <li>白下区</li>
                <li>建邺区</li>
                <li>秦淮区</li>
                <li>雨花台区</li>
                <li>下关区</li>
                <li>浦口区</li>
                <li>鼓楼区</li>
                <li>栖霞区</li>
                <li>江宁区</li>
                <li>六合区</li>
                <li>溧水县</li>
                <li>高淳县</li>
            </ul>
        </div>

        <p style="color:#AA0004; border-bottom:2px solid #AA0004; font-size:18px; font-weight:bolder; margin-top:350px;">删除店员</p>

        <div>
            <select name="ClerksMenu" id="ClerksMenu" ></select>
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/delete.png" id="deleteClerkBtn"/>
        </div>
    </div>