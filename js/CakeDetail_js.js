// JavaScript Document
$(function(){
	var userName='游客';
	var userID = 'undefine';
	var productName = '';
	var productPrice = 0;
	var productID = 0;
	
	document.title = "Sample糕点";
	
	
	//initiate(productName , 120 , productID);
	
	/*得到用户名和用户ID*/
	
	/*userName = 
	  userID = */
	  
/*	$('#userLogin').click(function(){
		document.getElementById('login').style.display='block';
		document.getElementById('fade').style.display='block';
		document.getElementById('fade').style.height=document.height+'px';
		$('#loading').css({"display" : "none"});
		
		
	}); 
	
	$('#userRegister').click(function(){
		document.getElementById('register').style.display='block';
		document.getElementById('fade').style.display='block';
		document.getElementById('fade').style.height=document.height+'px';
		$('#succeedSignUp').css({"display" : "none"});
	});
	
	$('#exit').live('click', function(){
		$('li').remove('.vip');
		$('.vip_hidden').css({"display":"block"});
		location.reload();
	});
	
	$('#shoppingCart').click(function(){
		if(userID == 'undefine'){
			$(this).children('a').attr({href:'#'});
		}
	});
	*/
	
	$('#purchaseBtn').live("click", function(){
		var optionState = 1;
		var href = $(this).parents('.each').attr('href');
		//var productID = $(this).parents('#introduce').attr('productID');
		/*var day = $(this).parents('.each').attr('date');
		var month = $(this).parents('.each').attr('month');
		var year = $(this).parents('.each').attr('year');*/
		var productID = $(document.getElementById('introduce')).attr('pid');
		var currentDate = new Date();
		var day = currentDate.getDate();
		var month = currentDate.getMonth()+1;
		var year = currentDate.getFullYear();
		var orderCount = $('#pNum').html();
		var timestamp = year+"-"+month+"-"+day;
		orderCount = $('#pNum').html();


		$.post('http://localhost/sampleCake/index.php/sample/isguest',
			function(result){
				result = eval( "(" + result + ")");
				if(!result.isguest){
					$(document.getElementById('fade')).css({'display':'block', 'width':document.body.clientWidth, 'height':document.body.scrollHeight});
					$(document.getElementById('optionBox')).css({'display':'block', 'margin-top':document.body.scrollTop});
					$(document.getElementById('selectMemberCard')).attr({value:""});
					$(document.getElementById('dateLable')).empty().html("购买日期");
					$(document.getElementById('datePick')).attr({value:timestamp});
					$(document.getElementById('selectDateBtn')).css({'background':"none"});
					$(document.getElementById('countLable')).empty().html("购买数量");
					
					$(document.getElementById('selectCount')).attr({value:orderCount});
					$(document.getElementById('optionBoxInfo')).attr({productID:productID, day:day, month:month, year:year});
					$(document.getElementById('succeedOptionLable')).empty().html("成功购买");
					$(document.getElementById('confirmPurchaseBtn')).attr({optionState:optionState});
					
				}else{
					//提醒登录
					alert("游客，请先登录！");
					$(document.getElementById('userLogin')).click();
				}
			});
	});
	
	$('#reservationBtn').live("click", function(){
		var optionState = 0;
		var href = $(this).parents('.each').attr('href');
		var productID = $(document.getElementById('introduce')).attr('pid');
		var currentDate = new Date();
		var day = currentDate.getDate();
		var month = parseInt(currentDate.getMonth())+1;
		var year = currentDate.getFullYear();
		var orderCount = $('#pNum').html();
		var timestamp = year+"-"+month+"-"+day;


		$.post('http://localhost/sampleCake/index.php/sample/isguest',
			function(result){
				result = eval( "(" + result + ")");
				if(!result.isguest){
					// $('#shopFade').css({'display':'block', 'width':document.body.scrollWidth, 'height':document.body.scrollHeight, 'margin-top':-document.body.scrollTop});
					// alert(document.body.scrollLeft);
					// $('#optionBox').css({'display':'block'});

					$(document.getElementById('fade')).css({'display':'block', 'width':document.body.clientWidth, 'height':document.body.scrollHeight});
					$(document.getElementById('optionBox')).css({'display':'block', 'margin-top':document.body.scrollTop});
					$(document.getElementById('selectMemberCard')).attr({value:""});
					$(document.getElementById('dateLable')).empty().html("预定日期");
					$(document.getElementById('datePick')).attr({value:timestamp});
					$(document.getElementById('countLable')).empty().html("预定数量");
					$(document.getElementById('selectCount')).attr({value:orderCount});
					$(document.getElementById('optionBoxInfo')).attr({productID:productID, day:day, month:month, year:year});
					$(document.getElementById('succeedOptionLable')).empty().html("成功预订");
					$(document.getElementById('confirmPurchaseBtn')).attr({optionState:optionState});
/*					if(1 == result.identity){
						//用户预定框
						$.post('');
					}else{
						//店员或管理员预定框
					}*/
				}else{
					//提醒登录
					alert("游客，请先登录！");
					$(document.getElementById('userLogin')).click();
				}
			});
	});
	
	/*the amount product*/
	$('#increaseNum').click(function(){
		var count = document.getElementById('pNum').innerHTML;
		if(count < 100)
			count++;
		$('#pNum').html(count);
	});
	
	$('#decreaseNum').click(function(){
		var count = document.getElementById('pNum').innerHTML;
		if(count >　0)
			count--;
		$('#pNum').html(count);
	});
});

function initiate(productName, productPrice, productID){
	$(this).productName = productName;
	$(this).productPrice = productPrice;
	
	$('#productPrice').html(productPrice);
	$('#productName').html(productName);
}