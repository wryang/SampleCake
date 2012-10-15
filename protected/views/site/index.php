<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Simple Cake</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="Beautiful Background Image Navigation with jQuery" />
        <meta name="keywords" content="jquery, background image, animate, menu, navigation, css3, cross-browser compatible"/>
        
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/Home_Css.css" type="text/css" media="screen"/>
        
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.bgpos.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/Home_js.js"></script>
         
        <style>
        
            *{
                margin:0;
                padding:0;
            }
            body{
                font-family:Arial;
                padding-top:0px;
                background:url(/sampleCake/images/background.png) repeat;
            }
        </style>
        <!--[if lte IE 6]>
             <link rel="stylesheet" href="css/styleIE6.css" type="text/css" media="screen"/>
        <![endif]-->
    </head>
    <body>
        
        <div id="content" style="position:relative;">
            <div id="border"style="position:absolute; z-index:1; left:50%; margin-left:-500px;">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/border.png" />
                
        <!-- <a class="tab" id="change_bg1" href="Shop_html.html">商城</a>
                                <a class="tab" id="change_bg2" href="Location_html.html">门店分布</a>
                                                        <a class="tab" id="change_bg3" href="EnterpriseCulture_html.html">企业文化</a>-->

            </div>
            <div style="z-index:3; position:absolute; left:50%; margin-left:-453px; margin-top:543px; width:1000px;">
                <ol class="tab_menu" id="tab_menu">
                    <li class="tab_bg" style="background-position:0 0;">
                        <a class="tab" id="change_bg1" href="<?php echo Yii::app()->createUrl('/site/turn')?>">商城</a>
                 
                    </li>
                    <li class="tab_bg" style="background-position:0px 0px; left:30px;">
                        <a class="tab" id="change_bg2" href="<?php echo Yii::app()->createUrl('/site/turnToMemberIntro')?>">会员说明</a>
                        
                    </li>
                    <li class="tab_bg" style="background-position:0px 0px; left:60px;">
                        <a class="tab" id="change_bg3" href="<?php echo Yii::app()->createUrl('/site/turnToCulture')?>">企业文化</a>
                        
                    </li>                
                </ol>
            </div>
            <div id="menuWrapper" class="menuWrapper bg1"  style="position:absolute; left:50%; margin-left:-454px; margin-top:52px;">
                <ul class="menu" id="menu" >
                    <li class="bg1" style="background-position:0 0;">
                        <a id="bg1" href="#"></a>
                 
                    </li>
                    <li class="bg1" style="background-position:-299px 0px;">
                        <a id="bg2" href="#"></a>
                        
                    </li>
                    <li class="last bg1" style="background-position:-598px 0px;">
                        <a id="bg3" href="#"></a>
                        
                    </li>
                </ul>
  </div>
</div>
        <!-- The JavaScript -->
      <!--  <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.bgpos.js"></script>
        <script type="text/javascript" src="js/Home_js.js"></script>-->
    </body>
</html>