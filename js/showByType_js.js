$(function(){
	var typeID = $("#showByTypeBox").attr('typeID');
	//alert(typeID);
	setPagination();
	setProductsByType(typeID, 1);

	$('.cakeImgByType').live('click' , function(){
		var productID = $(this).attr('productID');
		var currentDate = new Date();
		var date = currentDate.getDate();
		var month = parseInt(currentDate.getMonth())+1;
		var year = currentDate.getFullYear();

		console.log(productID);

		/*window.open("http://localhost/sampleCake/index.php/sample/loadCakeDetail?id=" + productID + 
			"&date=" + date + "&month=" + month + "&year=" + year + "&purchaseable=true");*/
		window.open("http://localhost/sampleCake/index.php/sample/loadCakeDetail?id=" + productID + 
			"&date=" + date + "&month=" + month + "&year=" + year);

	});

	$('.accuratepage').live('click',function(){
		var page = $(this).attr('value');
		setProductsByType(typeID, page);
		$('#pagination').attr({currentPage:page});
	});

	$('#prePage').live('click', function(){
		var currentPage = $('#pagination').attr('currentPage');
		if(currentPage > 1){
			var page = parseInt(currentPage) - 1;
			setProductsByType(typeID, page);
			$('#pagination').attr({currentPage:page});
		}
	});

	$('#nextPage').live('click', function(){
		var currentPage = $('#pagination').attr('currentPage');
		var pageCount = $(this).attr('pageCount');
		if(currentPage < pageCount){
			var page =  parseInt(currentPage) + 1;
			setProductsByType(typeID, page);
			$('#pagination').attr({currentPage:page});
		}
	});
});

function setPagination(){
	var pageCount = $('#pagination').attr('pageCount');
	//alert(pageCount);
	var page = 1;
	if(0 == pageCount%9){
		page = pageCount/9;
	}else{
		page += pageCount/9;
	}
	
	//alert(page);
	if(page>=1){
		$('#pagination ul').empty().html('<li value=10 id="prePage" style="font-size=12px; width:50px">上一页</li>');
		var i;
		for(i=1; i<=page; i++){
			$('#pagination ul').append('<li value='+i+' class="accuratepage">'+i+'</li>');
		}
		pageCount = i-1;
		$('#pagination ul').append('<li id="nextPage" style="font-size=12px; width:50px" pageCount="'+pageCount+'">下一页</li>');
	}

	$('#pagination').attr({currentPage:1});
}

function setProductsByType(typeID, page){
	$('#showByTypeBox ul').empty();
	var startIndex = (page-1)*9;
	var endIndex = startIndex + 9;
	$.post('http://localhost/sampleCake/index.php/sample/getProductsByType',
		{typeID:typeID, startIndex:startIndex, endIndex:endIndex},
			function(products){
				if(products == 0){
					$("#showByTypeBox").children("ul").append("<p style='font-size:36px;'>该种类还未有商品</p>");
				}else{
					products = eval( "(" + products + ")");
					for(var i=0; i<products.length && i<9; i++){
						var product = products[i];
						placeProduct(product.imgurl, product.id, product.pname);
					}
				}
			});
}

function placeProduct(imgurl, productID, pname){
	$('#showByTypeBox ul').append('<li><div><img class="cakeImgByType" src = "/sampleCake/images/'+imgurl+'" productID="'+productID+'"/><p class="pname">'+pname+'</p></div></li>');
}