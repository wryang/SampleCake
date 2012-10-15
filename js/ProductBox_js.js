// JavaScript Document
$(function(){
	var pageCount = 1;
	var pageDisplay = 1;
	var currentDate = new Date();

	var year = $("#page").attr('year');
	var month = $("#page").attr('month');
	var day = $("#page").attr('day');
	// fdate = fdate.split("-");
	/*var day = currentDate.getDate();
	var month = currentDate.getMonth()+1;
	var year = currentDate.getFullYear();*/
	// setPagination(5, 10, fdate[2], fdate[1], fdate[0]);
	// setPagination(5, 10, day, month, year);
	setPagination(day, month, year);

	//setProducts(1, currentDate.getDate(), currentDate.getMonth()+1, currentDate.getFullYear());
	// setProducts(1, fdate[2], fdate[1], fdate[0]);
	setProducts(1, day, month, year);
	
	/*buy a cake*/
	$('.each_purchase').live('click',function(){
		var optionState = 1;
		var href = $(this).parents('.each').attr('href');
		var productID = $(this).parents('.each').attr('productID');
		var day = $(this).parents('.each').attr('date');
		var month = $(this).parents('.each').attr('month');
		var year = $(this).parents('.each').attr('year');
		var orderCount = 1;
		var timestamp = year+"-"+month+"-"+day;


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
	/*reservation a cake;*/
	$('.each_reservation').live('click', function(){
		var optionState = 0;
		var href = $(this).parents('.each').attr('href');
		var productID = $(this).parents('.each').attr('productID');
		var day = $(this).parents('.each').attr('date');
		var month = $(this).parents('.each').attr('month');
		var year = $(this).parents('.each').attr('year');
		var orderCount = 1;
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
					$(document.getElementById('selectDateBtn')).css({'background':"url(/sampleCake/images/downarrow.png) no-repeat"});
					$(document.getElementById('countLable')).empty().html("预定数量");
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
	
	/*click a product*/
	$('.each_product').live('click' , function(){
		var href = $(this).parents('.each').attr('href');
		var productID = $(this).parents('.each').attr('productID');
		var date = $(this).parents('.each').attr('date');
		var month = $(this).parents('.each').attr('month');
		var year = $(this).parents('.each').attr('year');

		console.log(productID);

		/*window.open("http://localhost/sampleCake/index.php/sample/loadCakeDetail?id=" + productID + 
			"&date=" + date + "&month=" + month + "&year=" + year + "&purchaseable=true");*/
		window.open("http://localhost/sampleCake/index.php/sample/loadCakeDetail?id=" + productID + 
			"&date=" + date + "&month=" + month + "&year=" + year);

	});

	$('.accuratepage').live('click',function(){
			var year = $("#page").attr('year');
			var month = $("#page").attr('month');
			var day = $("#page").attr('day');
			//alert('accuratepage' +year+"-"+month+"-"+day);
			var page = $(this).attr('value');
			setProducts(page, day, month, year);
			$('#page').attr({currentPage:page});
	});

	$('#prePage').live('click', function(){
		var currentPage = $('#page').attr('currentPage');
		if(currentPage > 1){
			var year = $("#page").attr('year');
			var month = $("#page").attr('month');
			var day = $("#page").attr('day');
			var page = parseInt(currentPage) - 1;
			setProducts(page, day, month, year);
			$('#page').attr({currentPage:page});
		}
	});

	$('#nextPage').live('click', function(){
		var currentPage = $('#page').attr('currentPage');
		var pageCount = $(this).attr('pageCount');
		if(currentPage < pageCount){
			var year = $("#page").attr('year');
			var month = $("#page").attr('month');
			var day = $("#page").attr('day');
			var page =  parseInt(currentPage) + 1;
			setProducts(page, day, month, year);
			$('#page').attr({currentPage:page});
		}
	});
});

/*initiate parameters of the pagination*/	
/*function setPagination(display, count, date, month, year){
	pageCount = count;
	pageDisplay = display;
	
	if(pageCount>5)
		pageDisplay = 5;
	else
		pageDisplay = pageCount;
		
	$("#page").paginate({
				count 		: pageCount,
				start 		: 1,
				display     : pageDisplay,
				border					: true,
				border_color			: '#fff',
				text_color  			: '#fff',
				background_color    	: 'black',	
				border_hover_color		: '#ccc',
				text_hover_color  		: '#000',
				background_hover_color	: '#fff', 
				images					: false,
				mouse					: 'press',
				onChange				: function(page){
											setProducts(page, date, month, year);
										  }
			});
	
	}*/
	
/*href is uniform resource locator of the cake;*/
function placeProduct(imgSrc, href, index, productID, purchaseable, date, month, year){
	var button = "";
	if(purchaseable)
		button = '<img class="each_purchase" src="/sampleCake/images/purchaseBtn.png" style="padding-right:10px;"/><img class="each_reservation" src="/sampleCake/images/reservationBtn.png"/>';
		
	else
		button = '<img class="each_reservation" src="/sampleCake/images/reservationBtn.png"/>';
	//$("#productsBox").children("ul").append('<li class="each" id="each'+index+'" href="'+href+'" productID="'+productID+'"><div class="each_div"><img class="each_product" src="'+imgSrc+'"/><div class="productBtn"><img class="each_purchase" src="/sampleCake/images/purchaseBtn.png"/><img class="each_reservation" src="/sampleCake/images/reservationBtn.png"/></div></div></li>');
		$("#productsBox").children("ul").append('<li class="each" id="each'+index+'" href="'+href+'" productID="'+productID+'" date="'+ date +'" month="'+ month +'" year="'+ year +'"><div class="each_div"><img class="each_product" src="'+imgSrc+'"/><div class="productBtn">' + button + '</div></div></li>');
	}

function setProducts(page, date, month, year){
		/*调用后台方法，更新新的一页糕点图片，后台掉通用placeProduct(),更新每一张糕点图片*/
		//alert('setProducts');
		/*删除原本的页面图片*/
		$('li').remove('.each');
		$('#productsBox ul').empty();
		/*加载（模拟）*/
		//调用后台方法，传送参数page
		//getProductsOfPage(page);
		//后台调用方法placeProduct(imgSrc, href, index)；
		//模拟调用
	/*	placeProduct('/sampleCake/images/displayBoard1.jpg', 'CakeDetail', 1, 01, true);
		placeProduct('/sampleCake/images/displayBoard2.jpg', 'CakeDetail', 2, 02, true);
		placeProduct('/sampleCake/images/displayBoard1.jpg', 'CakeDetail', 3, 03, true);
		placeProduct('/sampleCake/images/displayBoard1.jpg', 'CakeDetail', 4, 04, true);
		placeProduct('/sampleCake/images/displayBoard1.jpg', 'CakeDetail', 5, 05, true);
		placeProduct('/sampleCake/images/displayBoard1.jpg', 'CakeDetail', 6, 06, true);*/
		var currentDate = new Date();
		var startIndex = (page-1)*6;
		var endIndex = startIndex + 6;

		//alert(year+"-"+month+"-"+date);
		$.post('http://localhost/sampleCake/index.php/sample/loadProductsByDate', 
			{"date":date, "month":month, "year":year, "startIndex":startIndex, "endIndex":endIndex},
				function(products){
					if(products == 1){
						$("#productsBox").children("ul").append("<p style='font-size:36px; margin-top:100px; margin-left:200px; position:absolute;'>当日没有待售商品</p>");
					}
					else
					//if(products)
					{
						products = eval( "(" + products + ")");
						/*for(var i=0; i<products.length && i<6; i++){
						var product = products[i];*/
						var purchaseable = false;
						// var m = currentDate.getMonth()+1;

						$.post('http://localhost/sampleCake/index.php/sample/isguest',
							function(result){
								result = eval( "(" + result + ")");
								
								if(!result.isguest){

									if(date == currentDate.getDate() && month == currentDate.getMonth()+1 && year == currentDate.getFullYear() && result.identity != 1)
										purchaseable = true;
									//alert("i");
								}

								for(var i=0; i<products.length && i<6; i++){
									var product = products[i];
									var m = currentDate.getMonth()+1;
									placeProduct('/sampleCake/images/'+product.imgurl, 'CakeDetail', i+1, product.id, purchaseable, date, month, year);
								}
							});
						//}


					}
					/*else{
						alert("i");
						
					}*/
				}
		);
	}

function setPagination(day, month, year){
		var timestamp = year+"-"+month+"-"+day;

		$.post('http://localhost/sampleCake/index.php/sample/getPagination',
			{'timestamp':timestamp},
			function(result){
				//result 是后台返回的当前提起的商品排列页数
				result = eval( "(" + result + ")");
				var page = 1;
				if(0 == result%6){
					page = result/6;
				}else{
					page += result/6;
				}
				$('#page ul').empty();
				if(page>=1){
					$('#page ul').empty().html('<li value=10 id="prePage" style="font-size=12px; width:50px">上一页</li>');
					var i;
					for(i=1; i<=page; i++){
						$('#page ul').append('<li value='+i+' class="accuratepage">'+i+'</li>');
					}
					var pageCount = i-1;
					$('#page ul').append('<li id="nextPage" style="font-size=12px; width:50px" pageCount="'+pageCount+'">下一页</li>');
				}
			});
	}
