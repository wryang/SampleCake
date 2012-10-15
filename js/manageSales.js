$(function(){
	$('.date-pick').datePicker({clickInput:true});
    $('a.dp-choose-date').empty().html('<img src="/sampleCake/images/calendar.png" width=20px height=20px/>');

    initiateManageMenu();
	$('#uploadImgBtn').click(function(){
		$('#productImg').click();
	});

    $('#apSubmitBtn').click(function(){
    	var productName = $('#productName').attr('value');
    	var productPrice = $('#productPrice').attr('value');
    	var description = $('#productIntroduce').attr('value');
    	var productImg = $('#uploadImgBtn').attr('fileName');
    	var productType = $('#productType').attr('typeID');


    	if("" == productName){
    		alert("商品名称不能为空！");
    	}else{
    		if("" == productPrice){
    			alert('商品价格不能为空！');
    		}else{
    			if("" == description){
    				alert("商品描述不能为空！");
    			}else{
    				if("" == productImg){
    					alert("商品图片不能为空！");
    				}else{
    					if("" == productType){
    						alert("商品种类不能为空！");
    					}else{
    						$.post('http://localhost/sampleCake/index.php/sample/addProduct',
    						{productName:productName, productPrice:productPrice, productImg:productImg, productType:productType,description:description},
    						function(result){
    							if(result){
    								alert("成功添加商品！");
    								document.location.reload();
    							}
    						});
    					}
    				}
    			}
    		}
    	}
    });

	$('.checkBtn').live('click',function(){
		var oid = $(this).attr('oid');
		$.post('http://localhost/sampleCake/index.php/sample/reachOrder',
			{oid:oid},function(result){
				if(result){
					$('#roMenuBtn').click();
				}
			});
	});

	
	$('.manageSales-menu').children('li').click(function(){

		var currentForm = $('.manageSales-menu').attr('currentForm');
		$('#'+currentForm).css({'display':'none'});
		var changeForm = $(this).children('div').attr('control');
		$('#'+changeForm).css({'display':'block'});
		if("reservationOrders" == changeForm){
			getAllReservationOrders();
		}
		if("finishedOrders" == changeForm){
			getAllFinishedOrder();
		}
		if("rsStatistic" == changeForm){
			showRSChar();
		}
		if("setSales" == changeForm){
			getAllProducts();
		}
		if("typeManage" == changeForm){
			getProductTypes();
		}
		$('.manageSales-menu').attr({currentForm:changeForm});
	});

	$('#selectTypeBtn').toggle(
		function(){
			$('#productTypeMenu').css({'display':'block'});
		},
		function(){
			$('#productTypeMenu').css({'display':'none'});
		}
	);

	$('#productType').click(function(){
		$('#selectTypeBtn').click();
	});

	$('#productTypeMenu ul li').click(function(){
		var type = $(this).html();
		var typeID = $(this).attr('typeID');
		$('#productType').attr({value:type, typeID:typeID});
		$('#selectTypeBtn').click();
	});

	$('#productsMenu').change(function(){
		
		// $('#productsMenu').attr({'pid'})
	});
	$('#sSubmitBtn').click(function(){
		var pid = $("#productsMenu").find("option:selected").attr('pid');
		var saleDate = $('#saleDate').attr('value');
		if("" != $("#productsMenu").find("option:selected").text()){
			if("" !=  saleDate){
				saleDate = saleDate.split('/');
    			var year = saleDate[2];
    			var month = saleDate[1];
    			var day = saleDate[0];
    			saleDate = year + "-" + month + "-" + day;
    			var saleCount = $('#saleCount').attr('value');

    			if("" != saleCount){
    				$.post('http://localhost/sampleCake/index.php/sample/addSales',
						{pid:pid, saleDate:saleDate, saleCount:saleCount},
						function(result){
							if(result){
								$('#MenuBtnSetSales').click();
							}else{
								alert("当日已有该商品出售，请重新选择！");
							}
					});
    			}else{
    				alert("销售数量不能为空！");
    			}
    			
			}else{
				alert("销售日期不能为空！");
			}
		}else{
			alert("销售商品不能为空！");
		}
	});

	$('#typeSubmitBtn').click(function(){
		var ptypeName = $('#typename').attr('value');
		// alert(ptypeName);
		if("" != ptypeName){
			$.post('http://localhost/sampleCake/index.php/sample/addProductType',
				{ptypeName:ptypeName},
				function(result){
					// result = eval( "(" + result + ")");
					if(!result){
						alert('此商品种类名称已存在！');
					}else{
						$('#typename').attr({value:""});
						document.location.reload();
						$('#MenuBtnTypeManage').click();
					}
					// alert(result);
				})
		}else{
			alert('商品种类名称不能为空！');
		}
	});

	$('#deleteTypeBtn').click(function(){
		var typeID = $("#typesMenu").find("option:selected").attr('typeID');
		$.post('http://localhost/sampleCake/index.php/sample/deleteType',
			{typeID:typeID},
			function(result){
				if(result){
					$('#MenuBtnTypeManage').click();
				}else{
					alert("没有此商品种类！");
				}
			});
	});

})

function onlyNum() 
{ 
	if(!(event.keyCode==46)&&!(event.keyCode==8)&&!(event.keyCode==37)&&!(event.keyCode==39)) 
		if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105))) 
			event.returnValue=false; 
} 

function checkImg()
{
   var fileName=document.getElementById("productImg").value;
   // alert(fileName);
   if(fileName=="")
     return;
     //检查文件类型
   var exName=fileName.substr(fileName.lastIndexOf(".")+1).toUpperCase()
      if(exName=="JPG"||exName=="BMP"||exName=="GIF")
       {
		 fileName = fileName.substr(fileName.lastIndexOf("\\")+1);
		 // alert(fileName);
		 $('#uploadImgBtn').attr({fileName:fileName});
       }
     else
       if(exName=="SWF")
        {
		  fileName = fileName.substr(fileName.lastIndexOf("\\")+1);
		  $('#uploadImgBtn').attr({fileName:fileName});
         }
     else
        if(exName=="WMV"||exName=="MPEG"||exName=="ASF"||exName=="AVI")
         {
            var strcode='<embed src=\''+fileName+'\' border=\'0\' width=\'100\' height=\'100\'  quality=\'high\' ';
            strcode+=' autoStart=\'1\' playCount=\'0\' enableContextMenu=\'0\' type=\'application/x-mplayer2\'></embed>';
			fileName = fileName.substr(fileName.lastIndexOf("\\")+1);
			$('#uploadImgBtn').attr({fileName:fileName});
         }
    else
       {
          alert("请选择正确的图片文件");
          document.getElementById("productImg").value="";
        }
}

function getAllReservationOrders(){
	$.post('http://localhost/sampleCake/index.php/sample/getAllOrdersByM',
		{state:0},
		function(result){
			if(result){
				result = eval( "(" + result + ")");
				$('tr').remove('.reserveOrder');

				for(var i=0; i<result.length; i++){
					var checkBtn = "<img src='/sampleCake/images/check_mark.png' class='checkBtn' oid="+result[i]['oid']+" width:30px height:30px />";
					$("#reOrdersTable").append("<tr class='reserveOrder'><td>"+result[i]['oid']+"</td><td>"+
						result[i]['cardnumber']+"</td><td>"+result[i]['productName']+"</td><td>"+
						result[i]['count']+"</td><td>"+result[i]['timestamp']+"</td><td>"+checkBtn+"</td></tr>");
				}
				
			}
		});
}

function getAllFinishedOrder(){
	$.post('http://localhost/sampleCake/index.php/sample/getAllOrdersByM',
		{state:1},
		function(result){
			if(result){
				result = eval( "(" + result + ")");
				$('tr').remove('.finishedOrder');

				for(var i=0; i<result.length; i++){
					$("#fOrdersTable").append("<tr class='finishedOrder'><td>"+result[i]['oid']+"</td><td>"+
						result[i]['cardnumber']+"</td><td>"+result[i]['productName']+"</td><td>"+
						result[i]['count']+"</td><td>"+result[i]['timestamp']+"</td></tr>");
				}
				
			}
		});
}

function showRSChar(){
	var currentDate = new Date();
	var year = currentDate.getFullYear();
	var month = parseInt(currentDate.getMonth())+1;
	var day = currentDate.getDay();
	var timestamp = year+"-"+month+"-"+day;

	var count_PatissierCake = new Array();
	var count_cookie = new Array();
	var count_fruitcake = new Array();
	var count_mulcake = new Array();
	var count_pie = new Array();
	count_PatissierCake[0] = 0;
				count_PatissierCake[1] = 0;
				count_cookie[0] = 0;
				count_cookie[1] = 0;
				count_fruitcake[0] = 0;
				count_fruitcake[1] = 0;
				count_mulcake[0] = 0;
				count_mulcake[1] = 0;
				count_pie[0] = 0;
				count_pie[1] = 0;
	$.post('http://localhost/sampleCake/index.php/sample/showRSChar',
		{timestamp:timestamp},
		function(result){
			if(null != result){
				result = eval( "(" + result + ")");
				count_PatissierCake[0] = result['purchased'][0];
				count_PatissierCake[1] = result['reservation'][0];
				count_cookie[0] = result['purchased'][1];
				count_cookie[1] = result['reservation'][1];
				count_fruitcake[0] = result['purchased'][2];
				count_fruitcake[1] = result['reservation'][2];
				count_mulcake[0] = result['purchased'][3];
				count_mulcake[1] = result['reservation'][3];
				count_pie[0] = result['purchased'][4];
				count_pie[1] = result['reservation'][4];

				var chart;
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'rechart'
		},
		title: {
			text: '销售统计'
		},
		xAxis: {
			categories: ['小西点', '饼干', '水果蛋糕', '多层蛋糕', '果派']
		},
		yAxis: {
			title: {
				text: '数量 (个/片)',
				color:'black'
			}
		},
		tooltip: {
			formatter: function() {
				var s;
				if (this.point.name) { // the pie chart
					s = ''+
						this.point.name +': '+ this.y ;
				} else {
					s = ''+
						this.x  +': '+ this.y;
				}
				return s;
			}
		},
		labels: {
			items: [{
				html: '总计',
				style: {
					left: '10px',
					top: '-25px',
					color: 'black'
				}
			}]
		},
		series: [{
			type: 'column',
			name: '预定',
			color: '#FFFF6F',			
			data: [count_PatissierCake[1], count_cookie[1], count_fruitcake[1], count_mulcake[1], count_pie[1]]
		}, {
			type: 'column',
			name: '售出',
			color: '#97CBFF',
			data: [count_PatissierCake[0], count_cookie[0], count_fruitcake[0], count_mulcake[0], count_pie[0]]
		}, {
			type: 'pie',
			name: 'Total consumption',
			data: [{
				name: '预定',
				y: count_PatissierCake[1]+count_cookie[1]+count_fruitcake[1]+count_mulcake[1]+count_pie[1],
				color: '#FFFF37' // Jane's color
			}, {
				name: '售出',
				y: count_PatissierCake[0]+count_cookie[0]+count_fruitcake[0]+count_mulcake[0]+count_pie[0],
				color: '#2894FF' // John's color
			}],
			center: [20, 20],
			size: 50,
			showInLegend: false,
			dataLabels: {
				enabled: false
			}
		}]
	});
			}
		});

	
}

function getAllProducts(){
	$.post('http://localhost/sampleCake/index.php/sample/getAllProducts',
		function(result){
			$('#productsMenu').empty();
			$('#saleCount').attr({value:""});
			$('#saleDate').attr({value:""});
			if(null!=result){
				result = eval( "(" + result + ")");
				for(var index=0; index<result.length; index++){
					$('#productsMenu').append('<option value='+result[index]['pname']+' pid='+result[index]['pid']+'>'+result[index]['pname']+'</option>');
				}
			}
		});
}

function getProductTypes(){
	$.post('http://localhost/sampleCake/index.php/sample/getProductTypes',
		function(types){
			$('#typesMenu').empty();
			if(null != types){
				types = eval( "(" + types + ")");
				for(var index=0; index<types.length; index++){
					$('#typesMenu').append('<option value='+types[index]['ptypeName']+' typeID='+types[index]['typeID']+'>'+types[index]['ptypeName']+'</option>');
				}
			}
		});
}

function initiateManageMenu(){
	$.post('http://localhost/sampleCake/index.php/sample/getIdentity',
		function(identity){
			if(0 != identity){
				$('#listaticsSale').css({'display':'none'});
			}
		})
}


