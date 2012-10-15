// JavaScript Document

$(function(){
	var userName = 'vip';
	var userID = '09125';
	var userIdentity = 0;  /*0 for administrator , and 1 for vip*/
	
	/*initialHotProducts("慕斯",0911,"CakeDetail_html.html",1);
	initialHotProducts("慕斯",0912,"CakeDetail_html.html",2);
	initialHotProducts("慕斯",0913,"CakeDetail_html.html",3);
	initialHotProducts("慕斯",0914,"CakeDetail_html.html",4);
	initialHotProducts("慕斯",0915,"CakeDetail_html.html",5);*/

	
	var date = new Date();
	$.post("http://localhost/sampleCake/index.php/sample/loadHot", {"date":date.getDate(), "month":date.getMonth()+1, "year":date.getFullYear()},
		function(hot){
			hot = eval( "(" + hot + ")");
			for(var i=0; i<hot.length && i<5; i++){
				var h = hot[i];
				console.log("hot = "+h.name+" " +h.id+" "+h.imgurl);
				initialHotProducts(h.name, h.id, h.imgurl, i+1);
			}
	});


	/*将productsHtml的name属性变为当前日期*/
	var m = parseInt(date.getMonth())+1;
	//var fdate = date.getFullYear()+"-"+m+"-"+date.getDate();
	//$('#productsHtml').attr({time:fdate});

	//配置上平展示模块
	$('#page').attr({day:date.getDate(), month:m, year:date.getFullYear(), currentPage:1}) ;
	/*$('#page').attr('data-month') = parseInt(date.getMonth())+1;
	$('#page').attr('data-year') = data.getFullYear();*/
	/*$.post('/sampleCake/index.php/sample/loadproductbox', {year:date.getFullYear(), month:m, day:date.getDate()}, function(view) {
			console.log($("#frameChange"));
			//$("#frameChange").empty().html(view);
	});*/
	
	/*displayboard*/
	$("div[id*='listbox']").hover(
		function(){$(this).animate({"margin-top":"-10px"},200)},
		function(){$(this).animate({"margin-top":"0px"},200);}
	);

	var tmp=$("div[id*='listbox']").eq(0).children("img").attr("src");
	//鼠标点击过程
	$("div[id*='listbox']").click(function(){
		  if(parseInt($(this).css("z-index"))<=3){
			  var curZindex = parseInt($(this).css("z-index"));
			  //通过z-index差计算该层需要经过几次轮换效果置顶，
			  var  fntimes = 4-curZindex;
			  //对于当前处于第一位的图片点击无效果.
			  $(document).everyTime(300,function(){
				  $("div[id*='listbox']").each(function(){
					  if(parseInt($(this).css("z-index"))==4){$(this).css("z-index","1");}
					  else{$(this).css("z-index",""+(parseInt($(this).css("z-index"))+1)+"");}
					  $(this).css("margin-top","0px");
					  $(this).animate({"margin-left":((4-parseInt($(this).css("z-index")))*29)+"px"},300);
				  });
			  },fntimes);
		  }
	  });
	


	setInterval(function(){
		$("div[id*='listbox']").each(function(){
				if(parseInt($(this).css("z-index"))==4){$(this).css("z-index","1");}
				else{$(this).css("z-index",""+(parseInt($(this).css("z-index"))+1)+"");}
				$(this).animate({"margin-left":((4-parseInt($(this).css("z-index")))*29)+"px"},100);
			});
	},6000);
	
	$('#goToThere').click(function(){
		$("div[id*='listbox']").each(function(){
			if(parseInt($(this).css("z-index"))==4){
				var href = $(this).attr('href');
				var productID = $(this).attr('productID');
				console.log(productID);
				var date = new Date();
				var month = date.getMonth()+1;
				window.open("http://localhost/sampleCake/index.php/sample/loadCakeDetail?id=" + productID + "&date=" + date.getDate() + "&month=" + month + "&year=" + date.getFullYear() + "&purchaseable=true");
			}
		});
	});
	
	/*displayboard end*/
	
	$('#hotProducts').children('p').hover(function(){
			$(this).css({"color":"white","background":"#AA0004"});
		}, function(){
			$(this).css({"color":"black","background":"none"});
			});
	$('#hotProducts').children('p').click(function(){
		var productID = $(this).attr('productID');
		console.log(productID);
		var date = new Date();
		var month = date.getMonth()+1;
		window.open("http://localhost/sampleCake/index.php/sample/loadCakeDetail?id=" + productID + "&date=" + date.getDate() + "&month=" + month + "&year=" + date.getFullYear() + "&purchaseable=true");
		// $.post("http://localhost/sampleCake/index.php/sample/loadCakeDetail", {id:productID},
		// 	function(para){
		// 		console.log(para);
		// 	});
	});
	
	
		
	/*product-menu*/
	var currentDate =new Date();
	var currentDay = currentDate.getDay();
	var weekDay = new Array(7);
	weekDay[0] = 'Sun';
	weekDay[1] = 'Mon';
	weekDay[2] = 'Tue';
	weekDay[3] = 'Wed';
	weekDay[4] = 'Thu';
	weekDay[5] = 'Fri';
	weekDay[6] = 'Sat';
	
	
	var index = currentDay;
	var indexDate = currentDate;
	if(index == 0){
		$('#product_menu').children('.p-menu').append('<li day='+indexDate.getDate()+' month='+indexDate.getMonth()+' year='+indexDate.getFullYear()+'><span class="p-icon">7</span><div class="p-content"><h2 class="p-main">'+weekDay[index]+'</h2></div></li>');
		index++;
		var time =  indexDate.getTime() + 1*24000*3600;
		indexDate.setTime(time);
	}
	if(index>0&&index<7){
		for(index; index<=6; index++){
			$('#product_menu').children('.p-menu').append('<li day='+indexDate.getDate()+' month='+indexDate.getMonth()+' year='+indexDate.getFullYear()+'><span class="p-icon">'+index+'</span><div class="p-content"><h2 class="p-main">'+weekDay[index]+'</h2></div></li>');
			var time =  indexDate.getTime() + 1*24000*3600;
			indexDate.setTime(time);
		}
		if(currentDay>0){
			$('#product_menu').children('.p-menu').append('<li day='+indexDate.getDate()+' month='+indexDate.getMonth()+' year='+indexDate.getFullYear()+'><span class="p-icon">7</span><div class="p-content"><h2 class="p-main">'+weekDay[0]+'</h2></div></li>');
			index = 1;
			var time =  indexDate.getTime() + 1*24000*3600;
			indexDate.setTime(time);
			for(index; index<currentDay; index++){
				$('#product_menu').children('.p-menu').append('<li day='+indexDate.getDate()+' month='+indexDate.getMonth()+' year='+indexDate.getFullYear()+'><span class="p-icon">'+index+'</span><div class="p-content"><h2 class="p-main">'+weekDay[index]+'</h2></div></li>');
				var time =  indexDate.getTime() + 1*24000*3600;
				indexDate.setTime(time);
			}
		}
	}
	
	$('.p-menu').children('li').click(function(){
		var day = $(this).attr('day');
		var month = parseInt($(this).attr('month'))+1;
		var year = $(this).attr('year');
		$('#page').attr({day:day, month:month, year:year, currentPage:1}) ;
		setPagination(day, month, year);
		setProducts(1, day, month, year);
		//alert('p-menu' +year+"-"+month+"-"+day);
	//	date.setFullYear(year, month-1, day);

		
		/*调用后台方法，显示选择日期的产品*/
	//	alert(date);
		/*后台调用方法setProducts(page)(productsBox_html)*/

	/*	$.post('http://localhost/sampleCake/index.php/sample/loadProductsByDate', 
			{"date":day, "month":month, "year":year, "startIndex":0, "endIndex":6},
				function(products){
					products = eval( "(" + products + ")");

					$('#productsHtml').children('li').remove('.each');
					for(var i=0; i<products.length && i<6; i++){
						var product = products[i];
						purchaseable = false;
						if(day == currentDate.getDate() && month == currentDate.getMonth()+1 && year == currentDate.getFullYear)
							purchaseable = true;
						placeProduct('/sampleCake/images/'+product.imgurl, 'CakeDetail', i+1, product.id, purchaseable);
					}
				}
		);
		/**/
		//window.frames.getElementById('page').attr({date:day, month:month, year:year});
		//document.getElementById('productsHtml').children('#page').attr({date:day, month:month, year:year});
		// var fdate = "" + year + "-" + month + "-" + day;

		/*$.post('/sampleCake/index.php/sample/loadproductbox', {year:year, month:month, day:day}, function(view) {
			
			$("#frameChange").empty().html(view);
			//$('#productHtml').attr({src:'/sampleCake/index.php/sample/loadproductbox'});
			//alert(window.frames["productHtml"].getElementById('page').date('year'));
			//$("#productHtml").empty();
		})*/
		// $('#productsHtml').attr({time:fdate});
		// alert("____" + $('#productsHtml').attr('time'));
		// //window.frames.location.reload();
		// document.frames['productsHtml'].location.reload();
	});
	/*product-menu end*/

	
});

function initialHotProducts(productsName , productID , href , index){
	$('#hot'+index).html(productsName);
	$('#hot'+index).attr({src:href, productID:productID});
	}

function reloadThie(element){
	window.element.location.reload();
}

/*href is uniform resource locator of the cake;*/
/*function placeProduct(imgSrc, href, index, productID, purchaseable, date, month, year){
	var button = "";
	if(purchaseable)
		button = '<img class="each_purchase" src="/sampleCake/images/purchaseBtn.png"/>';
		
	else
		button = '<img class="each_reservation" src="/sampleCake/images/reservationBtn.png"/>';
	//$("#productsBox").children("ul").append('<li class="each" id="each'+index+'" href="'+href+'" productID="'+productID+'"><div class="each_div"><img class="each_product" src="'+imgSrc+'"/><div class="productBtn"><img class="each_purchase" src="/sampleCake/images/purchaseBtn.png"/><img class="each_reservation" src="/sampleCake/images/reservationBtn.png"/></div></div></li>');
		$('#productsHtml').children("#productsBox").children("ul").append('<li class="each" id="each'+index+'" href="'+href+'" productID="'+productID+'" date="'+ date +'" month="'+ month +' year="'+ year +'"><div class="each_div"><img class="each_product" src="'+imgSrc+'"/><div class="productBtn">' + button + '</div></div></li>');
	}
*/
