<!-- 展现销售商品子页面 -->
<link type="text/css" rel=StyleSheet href="<?php echo Yii::app()->request->baseUrl; ?>/css/ProductsBox.css"/>

	<div id="productsBox">
		<ul>
    	</ul>
	</div>         
	<div id="pagination" class="paginate">
		<!-- <div id="page" data-day=<?php echo $timestamp['day'];?> data-month=<?php echo $timestamp['month'];?> data-year=<?php echo $timestamp['year'];?>>                   
   		</div> -->
   		<div id="page" data-day=<?php echo $timestamp['day'];?> data-month=<?php echo $timestamp['month'];?> data-year=<?php echo $timestamp['year'];?>>     
   			<ul>
   				<li value=10 id="prePage" style="font-size=12px; width:50px">上一页</li>
   			</ul>              
   		</div>
	</div>
	<div id="shopFade">
	</div>
	
