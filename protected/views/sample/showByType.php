<!-- 
	根据商品种类展现商品
 -->
<link rel=StyleSheet type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/showByType_Css.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/showByType_js.js"></script>

<div id='showByTypeBox' typeID=<?php echo $typeID; ?>>
	<ul>

	</ul>
</div>

<div id="pagination" pageCount=<?php echo $pageCount; ?> currentPage="">
	<ul>
	</ul>
</div>