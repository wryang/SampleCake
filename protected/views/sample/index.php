<!-- 商场主界面
包括热卖产品，推荐产品，一周内每日可售商品等信息 -->

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jQueryTimer.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/Shop_js.js"></script>
<link type="text/css" rel=StyleSheet href="<?php echo Yii::app()->request->baseUrl; ?>/css/Product_Css.css"/>
<link type="text/css" rel=StyleSheet href="<?php echo Yii::app()->request->baseUrl; ?>/css/Shop_Css.css"/>


            <div id="displayBoard">
                <img id="goToThere" src="/sampleCake/images/goBtn.png"/>
                <div class="list" id="listbox0" href="#" productID="35"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/wedding1.jpg" border="0" /></div>
                <div class="list" id="listbox1" href="#" productID="36"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/wedding2.jpg" border="0" /></div>
                <div class="list" id="listbox2" href="#" productID="34"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/sacuraChoco.jpg" border="0" /></div>
                <div class="list" id="listbox3" href="#" productID="40"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/wedding7.jpg" border="0" /></div>
            </div>
            
            <div id="recommendation">
                <div id="title">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/cake.png" width="50px" height="45px"/>
                    <p>热卖产品</p>
                </div>
            
                <div id="hotProducts">
                    <p id="hot1" src="#" productID="#"></p>
                    <p id="hot2" src="#" productID="#"></p>
                    <p id="hot3" src="#" productID="#"></p>
                    <p id="hot4" src="#" productID="#"></p>
                    <p id="hot5" src="#" productID="#"></p>
                </div>
            </div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/ProductBox_js.js"></script>
<link type="text/css" rel=StyleSheet href="<?php echo Yii::app()->request->baseUrl; ?>/css/ProductsBox.css"/>            
            <div id="product">
                <!-- <div id="productsHtml" name="productsHtml">
                </div> -->
                <div id="frameChange">
                    <!-- <iframe id="productsHtml" name="productsHtml" src="<?php echo Yii::app()->createUrl('/sample/loadProductBox')?>" frameborder="no" scrolling="no" time="">
                    </iframe> -->
                    <div id="productsBox">
                        <ul>
                        </ul>
                    </div>         
                    <div id="pagination" class="paginate">
                        <div id="page" day="" month="" year="" currentPage="">     
                            <ul>
                                <li value=10 id="prePage" style="font-size=12px; width:50px">上一页</li>
                            </ul>              
                        </div>
                    </div>
                </div>

                <div id="product_menu">
                    <ul class="p-menu">
                        
                    </ul>
                </div>
                
            </div>
