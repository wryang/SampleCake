<!-- 管理销售数据
管理员能够查看统计数据，店员不能执行此操作 -->

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/manageSales.js"></script>
<link type="text/css" rel=StyleSheet href="<?php echo Yii::app()->request->baseUrl; ?>/css/manageSales.css"/>
<link rel=StyleSheet type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/datePicker.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.datePicker-min.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/exporting.js"></script>

<!-- 商品管理菜单 -->
<div id="manageSales">
	<ul class="manageSales-menu" currentForm="addProduct">
        <li>
            <div class="manageSales-content" control="addProduct">
                <h2 class="manageSales-main">添加商品</h2>
                <h3 class="manageM-sub">添加商品信息</h3>
            </div>
        </li>
        <li>
            <div class="manageSales-content" control="typeManage" id='MenuBtnTypeManage'>
                <h2 class="manageSales-main">种类管理</h2>
                <h3 class="manageSales-sub">添加、删除种类</h3>
            </div>
        </li>
        <li>
            <div class="manageSales-content" id="MenuBtnSetSales" control="setSales">
                <h2 class="manageSales-main">出售安排</h2>
                <h3 class="manageSales-sub">设定出售商品</h3>
            </div>
        </li>
        <li>
            <div class="manageSales-content" control="reservationOrders" id="roMenuBtn">
                <h2 class="manageSales-main">预定订单</h2>
                <h3 class="manageSales-sub">查看预定订单</h3>
            </div>
        </li>  
        <li>
            <div class="manageSales-content" control="finishedOrders">
                <h2 class="manageSales-main">售出订单</h2>
                <h3 class="manageSales-sub">查看已完成订单</h3>
            </div>
        </li>  
        <li id="listaticsSale">
            <div class="manageSales-content" control="rsStatistic">
                <h2 class="manageSales-main">销售统计</h2>
                <h3 class="manageSales-sub">预定、售出情况</h3>
            </div>
        </li>  
    </ul>
</div>

<!-- 添加商品 -->
    <div id="addProduct">
        <ul>
            <li class="apLable">商品名称:</li>
            <li><input class="input_text" type="text" name="productName" id="productName"/></li>
            <li class="apLable">价格:</li>
            <li><input class="input_text" type="text" name="productPrice" id="productPrice" onkeydown="onlyNum();" style="ime-mode:Disabled"/></li>
            <li class="apLable">商品种类:</li>
            <li><input class="input_text" type="text" id="productType"  readonly="readonly" typeID=""/></li>
            <li id="selectTypeBtn"></li>
            <li class="apLable" style="margin-top:-40px">商品图片:</li>
            <li><img id="uploadImgBtn" src="<?php echo Yii::app()->request->baseUrl; ?>/images/uploadImg.png" fileName="" width="50px" height="50px" style="position:absolute; margin-top:-50px; margin-left:0px; cursor:pointer;"/>
        <INPUT id="productImg" type="file" style="visibility:hidden" name="File1" runat="server"
  onchange="checkImg()"></li>
           
            <li class="apLable"  style="margin-top:-40px">描述:</li>
            <li><textarea id="productIntroduce" name="productIntroduce" cols="60" rows="27" tabindex="101"  style="margin-top:-40px"></textarea></li>
            <li style="float:right;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/submitBtn.png" id="apSubmitBtn" class="submitBtn"/></li>
        </ul>
        <div id="productTypeMenu">
            <ul>
                <li typeID=2>饼干</li>
                <li typeID=1>小西点</li>
                <li typeID=3>水果蛋糕</li>
                <li typeID=4>多层蛋糕</li>
                <li typeID=6>果派</li>
            </ul>
        </div>
    </div>

<!-- 设置销售 -->
    <div id="setSales">
        <ul>
            <li class="sLable">商品:</li>
            <li><select name="productsMenu" id="productsMenu"></select></li>
            <li class="sLable">数量:</li>
            <li><input class="input_text" type="text" name="saleCount" id="saleCount" onkeydown="onlyNum();" style="ime-mode:Disabled"/></li>
            <li class="sLable">销售日期:</li>
            <li><input type="text" name="saleDate" class="it date-pick input_text" id='saleDate' readonly="readonly"/></li> 
            <li style="float:right;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/submitBtn.png" id="sSubmitBtn" class="submitBtn"/></li>
        </ul>
    </div>

<!-- 订单管理 -->
    <div id="reservationOrders">
        <table border="1" id="reOrdersTable">
            <col width="100px"/>
            <col width="100px"/>
            <col width="100px"/>
            <col width="100px"/>
            <col width="100px"/>
            <tr>
                <th>订单号</th>
                <th>会员号</th>
                <th>商品名称</th>
                <th>商品数量</th>
                <th>取货日期</th>
            </tr>
        </table>
    </div>

    <div id="finishedOrders">
        <table border="1" id="fOrdersTable">
            <col width="100px"/>
            <col width="100px"/>
            <col width="100px"/>
            <col width="100px"/>
            <col width="100px"/>
            <tr>
                <th>订单号</th>
                <th>会员号</th>
                <th>商品名称</th>
                <th>商品数量</th>
                <th>取货日期</th>
            </tr>
        </table>
    </div>

<!-- 统计数据 -->
    <div id="rsStatistic">
        <div id="rechart"></div>
    </div>

    <div id="typeManage">
        <p style="color:#AA0004; border-bottom:2px solid #AA0004; font-size:18px; font-weight:bolder;">添加商品种类</p>
        <ul>
            <li class="aLable">商品种类名:</li>
            <li><input class="input_text" type="text" id="typename"/></li>
            <li style="float:right; margin-top:-40px;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/submitBtn.png" id="typeSubmitBtn" class="submitBtn"/></li>
        </ul>

        <p style="color:#AA0004; border-bottom:2px solid #AA0004; font-size:18px; font-weight:bolder; margin-top:200px;">删除商品种类</p>

        <div>
            <select name="typesMenu" id="typesMenu" ></select>
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/delete.png" id="deleteTypeBtn"/>
        </div>
    </div>

