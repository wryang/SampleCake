// JavaScript Document
/*
	用于主页面的js文件
	包含商品的登录注册，购买预定组件等
*/
$(function(){
	var userName = 'vip';
	var userID = '09125';
	var userIdentity = 0;  /*0 for administrator , and 1 for vip*/

	//检查是否有会员卡要停止使用
	$.post('http://localhost/sampleCake/index.php/sample/checkMCard');
	getProductTypes_mainMenu();


	$.post('http://localhost/sampleCake/index.php/sample/isguest',
		function(result){
			result = eval( "(" + result + ")");
			if(!result.isguest){
				userName = result.username;
				userID = result.uid;
				userIdentity = result.identity;
				$('.vip_hidden').css({"display":"none"});
				$('#header_navigation').append("<li class='navigation vip'>|</li><li class='navigation target vip' id='exit' style='color:#AA0004'><a href='http://localhost/sampleCake/index.php/site/logout' style='color:#AA0004;'>退出</a></li><li class='navigation target vip' id='"+result.uid+"'>欢迎您，"+result.username+"， </li>");
				if(1 == result.identity){
						//succeedLogin(result.username , result.uid);
						$('.memberInfoManagement').css({'display':'block'});
					}
					else if(0 == result.identity || 2 == result.identity){
						//succeedLogin(result.username , result.uid);
						$(".vipServiceCenter").css({'display':'block'});
						$(".salesManagement").css({'display':'block'});
					}
			}
		});

	
	$('#userLogin').click(function(){
		document.getElementById('login').style.display='block';
		$('#login').css({'margin-top':document.body.scrollTop});
		// document.getElementById('fade').style.display='block';
		$('#fade').css({'display':'block', 'width':document.body.clientWidth, 'height':document.body.scrollHeight});
		// document.getElementById('fade').style.height=document.height+'px';
		$('#loading').css({"display" : "none"});
	}); 
	
	$('#userRegister').click(function(){
		document.getElementById('register').style.display='block';
		$('#register').css({'margin-top':document.body.scrollTop});
		// document.getElementById('fade').style.display='block';
		// document.getElementById('fade').style.height=document.height+'px';
		$('#fade').css({'display':'block', 'width':document.body.clientWidth, 'height':document.body.scrollHeight});
		$('#succeedSignUp').css({"display" : "none"});
	});


	$('#selectMemberCardBtn').toggle(
		function(){
		
		$.post('http://localhost/sampleCake/index.php/sample/isguest',
			function(result){
				result = eval( "(" + result + ")");
				if(!result.isguest){
					if(1 == result.identity){
						$('#cardMenu').css({'display':'block'});
						$.post('http://localhost/sampleCake/index.php/sample/getMembershipCards',
							function(cardNumbers){
								if(null != cardNumbers){
									cardNumbers = eval( "(" + cardNumbers + ")");
									$(document.getElementById('cardMenu')).empty();
									for(var i=0; i<cardNumbers.length; i++){
										$(document.getElementById('cardMenu')).append('<li>'+cardNumbers[i]+'</li>');
									}
								}
							});
					}
				}
			});
		},
		function(){
			$('#cardMenu').css({'display':'none'});
		}
	);

	$('#cardMenu li').live("click", 
		function(){
			$('#selectMemberCard').attr({value:$(this).html()});
			$('#selectMemberCardBtn').click();
	});

	$('#selectDateBtn').toggle(
		function(){
		var productID = $('#optionBoxInfo').attr('productID'); 
		$.post('http://localhost/sampleCake/index.php/sample/isguest',
			function(result){
				result = eval( "(" + result + ")");
				if(!result.isguest){
					$('#reserveMenu').css({'display':'block'});
						$.post('http://localhost/sampleCake/index.php/sample/getRerservableDate',
							{'productID':productID},
							function(timestamps){
								if(null != timestamps){
									timestamps = eval( "(" + timestamps + ")");
									$(document.getElementById('reserveMenu')).empty();
									for(var i=0; i<timestamps.length; i++){
										$(document.getElementById('reserveMenu')).append('<li>'+timestamps[i]+'</li>');
									}
								}
						});
				}
			});
		},
		function(){
			$('#reserveMenu').css({'display':'none'});
		}
	);
	
	$('#reserveMenu li').live("click", 
		function(){
			$('#datePick').attr({value:$(this).html()});
			$('#selectDateBtn').click();
	});

	$('#confirmPurchaseBtn').click(function(){
		var membershipCard = $('#selectMemberCard').attr('value');
		var date = $('#datePick').attr('value');
		var count = $('#selectCount').attr('value');
		var optionState = $(this).attr('optionState');

		var productID = $('#optionBoxInfo').attr('productID');
		if("" != membershipCard){
			if("" != date){
				if("" != count){
					$.post('http://localhost/sampleCake/index.php/sample/purchaseByPid',
						{'productID':productID, 'date':date, 'orderCount':count, 'membershipCard':membershipCard, 'optionState':optionState},
						function(result){
							result = eval( "(" + result + ")");
							if(result.succeed){
								$('#succeedOptionLable').fadeIn(1000, function(){
									$('#succeedOptionLable').fadeOut(1000, function(){
										$('#fade').css({'display':'none'});
										$('#optionBox').css({'display':'none'});
									});
								});
							}else{
								if(result.hasMembershipCard){
									if(result.mCardState){
										if(result.hasEnoughProducts){
											if(!result.hasEnoughAccount){
												alert("账户余额不足");
											}
										}else{
											alert("商品余量不足");
										}

									}else{
										alert('该会员卡已停止使用');
									}
									
								}else{
									alert("不存在此会员卡");
								}
							}
						});
				}else{
					alert("请输入数量");
				}
			}else{
				alert("请输入日期");
			}
		}else{
			alert("请输入会员卡号");
		}
	});

	$('#cancelPurchaseBtn').click(function(){
		$('#fade').css({'display':'none'});
		$('#optionBox').css({'display':'none'});
	});

//甜品巡礼
	$('.productTypeLable').live('click',function(){
		var typeID = $(this).attr('typeID');
		// alert(typeID);
		/*$.post('http://localhost/sampleCake/index.php/sample/showcookie',
			{'typeID':typeID}, function(){*/
		window.open("http://localhost/sampleCake/index.php/sample/showByType?typeID="+typeID);

			/*});*/
	});
});

function reloadThie(element){
	window.element.location.reload();
}

/*
	数量等输入框准许输入数字
*/
function onlyNum() 
{ 
	if(!(event.keyCode==46)&&!(event.keyCode==8)&&!(event.keyCode==37)&&!(event.keyCode==39)) 
		if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105))) 
			event.returnValue=false; 
} 
/*
	获得商品种类
*/
function getProductTypes_mainMenu(){
	$.post('http://localhost/sampleCake/index.php/sample/getProductTypes',
		function(types){
			$('#byClass ul').empty();
			if(null != types){
				types = eval( "(" + types + ")");
				for(var index=0; index<types.length; index++){
					// <li class="productTypeLable" id="typeCookie" typeID="2">饼干</li>
					$('#byClass ul').append('<li class="productTypeLable" id="typeCookie" typeID="'+types[index]['typeID']+'">'+types[index]['ptypeName']+'</li>');
				}
			}
		});
}
