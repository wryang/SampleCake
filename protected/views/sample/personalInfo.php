<!-- 
    会员个人信息管理界面
    展现给会员
    会员能够对查看修改个人信息
    会员能够查看个人订单等
 -->


<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/calendar.css" >
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/calendar.js" ></script>  
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/calendar-zh.js" ></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/calendar-setup.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/personalInfo.js"></script>
<link type="text/css" rel=StyleSheet href="<?php echo Yii::app()->request->baseUrl; ?>/css/personalInfo.css"/>
<link rel=StyleSheet type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/datePicker.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.datePicker-min.js"></script>
<div id="psersonal">
    <ul class="psersonal-menu" currentForm="updateInfo">
        <li>
            <div class="psersonal-content" control="updateInfo">
                <h2 class="psersonal-main">个人信息</h2>
                <h3 class="psersonal-sub">更新个人资料</h3>
            </div>
        </li>  
        <li>
            <div class="psersonal-content" control="orderManage">
                <h2 class="psersonal-main">订单管理</h2>
                <h3 class="psersonal-sub">查看我的订单</h3>
            </div>
        </li>
        <li>
            <div class="psersonal-content" control="cardManage">
                <h2 class="psersonal-main">会员卡</h2>
                <h3 class="psersonal-sub">查看我的会员卡</h3>
            </div>
        </li>
    </ul>
</div>
    <div id="updateInfo">
        <ul>
            <li class="uLable">用户登录名:</li>
            <li><input class="input_text" type="text" id="personalName"/></li>
            <li class="uLable">密码:</li>
            <li><input class="input_text" type="text" id="password"/></li> 
            <li class="uLable">性别:</li>
            <li style="font-size:18px; width:60px; ">男性</li>
            <li><input type="radio" checked="checked" name="gender" value="male" id="radioMale"/></li>
            <li style="font-size:18px; width:60px; ">女性</li>
            <li><input type="radio" name="gender" value="female" id="radioFemale"/></li>
            <li class="uLable">出生日期:</li>
            <li><input type="text" id="EntTime" name="birthday" class="input_text"  onclick="return showCalendar('EntTime', 'y-mm-dd');"  /></li>
            <!-- <li><input type="text" id="EntTime" name="EntTime" onclick="return showCalendar('EntTime', 'y-mm-dd');"  /></li> -->

            <!-- <li><input type="text" name="birthday" class="it date-pick input_text" id='datePick'/></li> -->
            <li class="uLable">居住地址:</li>
            <li><input class="input_text" type="text" id="address"  readonly="readonly"/></li>
            <li id="selectAddrBtn"></li>
            <li style="float:right; margin-top:-40px;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/submitBtn.png" id="uSubmitBtn" class="submitBtn"/></li>
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

<div id="orderManage">
        <table border="1" id="ordersTable">
            <col width="100"/>
            <col width="100"/>
            <col width="100"/>
            <col width="100"/>
            <col width="100"/>
            <col width="100"/>
            <tr>
                <th>订单号</th>
                <th>商品名称</th>
                <th>商品单价</th>
                <th>商品数量</th>
                <th>订单金额</th>
                <th>成交日期</th>
                <th>状态</th>
            </tr>
        </table>
</div>

<div id="cardManage">
        <table border="1" id="cardTable">
            <col width="100px"/>
            <col width="100px"/>
            <col width="100px"/>
            <col width="100px"/>
            <col width="100px"/>
            <col width="100px"/>
            <tr>
                <th>会员卡号</th>
                <th>余额</th>
                <th>累计消费</th>
                <th>级别</th>
                <th>使用状态</th>
                <th>使用期限</th>
            </tr>
        </table>
</div>
