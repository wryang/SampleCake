<!-- 商品详细展示界面 
    包含商品图片等基本信息-->
    
<link rel=StyleSheet type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/CakeDetail_Css.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/CakeDetail_js.js"></script>
            <table>
            	<tr>
                	<td>
                    	<div id="productImg">
            				<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $productInfo['imgurl'];?>"/>
            			</div>
                    </td>
                    <td>
                    	<ul id="introduce" pid=<?php echo $productInfo['id'];?>>
                        	<li style="width:100px">甜品名称:</li>
                            <li style="width:240px" id="productName">
                                <?php echo $productInfo['name'];?>
                            </li>
                            <li style="width:60px">价格:</li>
                            <li style="width:250px" id="productPrice">
                                <?php echo $productInfo['price'];?>
                            </li>
                            <li style="width:60px">数量:</li>
                            <li style="width:250px">
                            	<ul style="list-style:none">
                                	<li style="float:left;margin-left:-40px; margin-top:-20px;">
                                    	<p id="pNum">1</p>
                                    </li>
                                    <li style="float:left;">
                                    	<ul style="list-style:none">
                                        	<li style="float:left; margin-left:-25px; margin-top:-10px;">
                                            	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/uparrow.png" id="increaseNum"  width="15px" height="9px" style="cursor:pointer"/>
                                            </li>
                                            <li style="float:left; margin-left:-25px; margin-top:4px;">
                                            	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/downarrow.png" id="decreaseNum"  width="15px" height="9px" style="cursor:pointer"/>
                                            </li>
                                        </ul>
                                        <ul style="list-style:none">
                                            <li style="float:left;">
                                                (剩余：<p style="float:right; margin-top:0px;">)</p><p id="residualCakeCount" style="float:right; margin-top:0px;"><?php echo $productInfo['count'];?></p>
                                            </li>
                                        </ul>
                                    </li>
                                </ul> 
                            </li>
                            <li>
                                <?php echo $productInfo['purchaseBtns'];?>
                            </li>
                         </ul>
                    </td>
                </tr>
            </table>
        	
            <div id="detail">
            	<span>甜品介绍</span>
                <p id="detailIntruduce">
                    <?php echo $productInfo['description'];?>
                </p>
            </div>