$(function(){
	// $('#firstManageM').focus();
	// $('.date-pick').datePicker({clickInput:true});
 //    $('a.dp-choose-date').empty().html('<img src="/sampleCake/images/calendar.png" width=20px height=20px/>');

    initiateManageMenu();

    $('#mSubmitBtn').click(function(){
    	var username = $('#username').attr('value');
    	var mCard = $('#mCard').attr('value');
    	

    	if("" == $('#membershipCard #username').attr('value')){
    		alert("用户登录名不能为空！");
    	}else{
    		if("" == $('#mCard').attr('value')){
    			alert('会员卡号不能为空！');
    		}else{
    			$.post('http://localhost/sampleCake/index.php/sample/bindingMCard',
    				{username:username, mCard:mCard},
    				function(result){
    					result = eval( "(" + result + ")");
    					if(result['hasUsername']){
    						if(!result['cardError']){
    							alert("会员卡与该用户已成功绑定！");
    							document.location.reload();
    						}else{
    							alert("该会员卡已绑定其他用户！");
    						}
    					}else{
    						alert("不存在该用户！");
    					}
    				});
    		}
    	}
    });

	$('#cSubmitBtn').click(function(){
		var mCard = $('#chargeMCard').attr('value');
		var amount = $('#amount').attr('value');

		if("" != mCard){
			if("" != amount){
				if("0" != amount.substr(0,1)){
					amount = parseInt(amount);
					$.post('http://localhost/sampleCake/index.php/sample/recharge',
						{mCard:mCard, amount:amount},
							function(result){
								result = eval( "(" + result + ")");
								if(result['hasMembershipCard']){
									alert("充值成功！");
									document.location.reload();
								}else{
									alert("该会员卡不存在！");
								}
							});
				}else{
					alert("输入充值金额有误，请重新输入！");
				}
			}else{
				alert("请输入充值金额！");
			}
		}else{
			alert("请输入充值卡号！");
		}
	});

	$('#aSubmitBtn').click(function(){
		var identity = 1;
		var username = $("#registername").attr('value');
		var birthday = $(document.getElementsByName('birthday')).attr('value');
		// if("" !=  birthday){
		// 	birthday = birthday.split('/');
  //   		var year = birthday[2];
  //   		var month = birthday[1];
  //   		var day = birthday[0];
  //   		birthday = year + "-" + month + "-" + day;
		// }

		var gender ;
    	if(document.getElementById('radioMale').checked){
    		gender = 1;
    	}else{
    		gender = 0;
    	}

    	var address = $('#address').attr('value');
    	if("" == username){
    		alert("用户登录名不能为空！");
    	}else{
    		var password = "";//为用户注册密码设为默认值；
    		$.post('http://localhost/sampleCake/index.php/sample/addUser',
    			{username:username, birthday:birthday, gender:gender, address:address, identity:identity, password:password},
    				function(result){
    					result = eval( "(" + result + ")");
						if(!result['UsernameError']){
							alert("成功添加会员！");
							document.location.reload();
						}else{
							alert("该用户名已存在，请重新输入！");
						}
    		});
    	}

    	
	});

	$('.manageM-menu').children('li').click(function(){
		var currentForm = $('.manageM-menu').attr('currentForm');
		$('#'+currentForm).css({'display':'none'});
		var changeForm = $(this).children('div').attr('control');
		$('#'+changeForm).css({'display':'block'});
		if("memberStatistic" == changeForm){
			showChartOfMember();
			showChartOfAddr();
		}
		if("addrStatistic" == changeForm){
			showCardsState();
		}
		if('addClerk' == changeForm){
			getAllClerks();
		}
		$('.manageM-menu').attr({currentForm:changeForm});
	});

	$('#selectAddrBtn').toggle(
		function(){
			$('#addrMenu').css({'display':'block'});
		},
		function(){
			$('#addrMenu').css({'display':'none'});
		}
	);

	$('#address').click(function(){
		$('#selectAddrBtn').click();
	});

	$('#addrMenu ul li').click(function(){
		var addr = $(this).html();
		$('#address').attr({value:addr});
		$('#selectAddrBtn').click();
	});

	$('#clerkaSubmitBtn').click(function(){
		var identity = 2;
		var username = $("#clerkname").attr('value');
		var birthday = "";
		var password = $('#clerkPassword').attr('value');
		// var birthday = $(document.getElementsByName('clerkbirthday')).attr('value');
		// if("" !=  birthday){
		// 	birthday = birthday.split('/');
  //   		var year = birthday[2];
  //   		var month = birthday[1];
  //   		var day = birthday[0];
  //   		birthday = year + "-" + month + "-" + day;
		// }

		var gender ;
    	if(document.getElementById('clerkMale').checked){
    		gender = 1;
    	}else{
    		gender = 0;
    	}

    	var address = $('#clerkaddress').attr('value');
    	if("" == username){
    		alert("店员登录名不能为空！");
    	}else{
    		$.post('http://localhost/sampleCake/index.php/sample/addUser',
    			{username:username, birthday:birthday, gender:gender, address:address, identity:identity, password:password},
    				function(result){
    					result = eval( "(" + result + ")");
						if(!result['UsernameError']){
							alert("成功添加店员！");
							// document.location.reload();
							$('#clerkname').attr({value:""});
							$('#clerkaddress').attr({value:""});
							$('#clerkPassword').attr({value:""});
							$('#ManageClerks').click();
						}else{
							alert("该用户名已存在，请重新输入！");
						}
    		});
    	}

    	
	});

	$('#clerkselectAddrBtn').toggle(
		function(){
			$('#clerkaddrMenu').css({'display':'block'});
		},
		function(){
			$('#clerkaddrMenu').css({'display':'none'});
		}
	);

	$('#clerkaddress').click(function(){
		$('#clerkselectAddrBtn').click();
	});

	$('#clerkaddrMenu ul li').click(function(){
		var addr = $(this).html();
		$('#clerkaddress').attr({value:addr});
		$('#clerkselectAddrBtn').click();
	});

	$('#deleteClerkBtn').click(function(){
		var clerkID = $("#ClerksMenu").find("option:selected").attr('uid');
		$.post('http://localhost/sampleCake/index.php/sample/deleteClerk',
			{uid:clerkID},
			function(result){
				if(result){
					$('#ManageClerks').click();
				}else{
					alert("没有此店员！");
				}
			});
	});

	$("#search").click(function(){
		var mCard = $('#activeMCard').attr("value");

		if("" == mCard){
			alert("会员卡号不能为空！");
		}else{
			$.post('http://localhost/sampleCake/index.php/sample/getMCardState',
				{mCard:mCard},
					function(result){
						result = eval( "(" + result + ")");
						if(!result.mCardError){
							if(result.state){
								$('#state').empty().html("使用中");
							}else{
								$('#state').empty().html("停止使用");
							}
						}else{
							alert("该会员卡不存在！");
						}
					});
		}
	});
})

function onlyNum() 
{ 
	if(!(event.keyCode==46)&&!(event.keyCode==8)&&!(event.keyCode==37)&&!(event.keyCode==39)) 
		if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105))) 
			event.returnValue=false; 
} 

function showChartOfMember(){

	$.post('http://localhost/sampleCake/index.php/sample/showChartOfMember',
		function(result){
			if(null != result){
				result = eval( "(" + result + ")");
				var chart,
	categories = ['0-9', '10-19', '20-29', '30-39',
		'40-49', '50-59', '60-69', '70-79', '80-89',
		'90-100', '100 +'];

	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'chartOfMember',
			defaultSeriesType: 'bar'
		},
		title: {
			text: '会员年龄分布(男/女)'
		},
		// subtitle: {
		// 	text: ''
		// },
		xAxis: [{
			categories: categories,
			reversed: false
		}, { // mirror axis on right side
			opposite: true,
			reversed: false,
			categories: categories,
			linkedTo: 0
		}],
		yAxis: {
			title: {
				text: null
			},
			labels: {
				formatter: function(){
					return Math.abs(this.value) + '人';
				}
			}
			,
			min: -50,
			max: 50
		},

		plotOptions: {
			series: {
				stacking: 'normal'
			}
		},

		tooltip: {
			formatter: function(){
				return '<b>'+ this.series.name +', age '+ this.point.category +'</b><br/>'+
					'Population: '+ Highcharts.numberFormat(Math.abs(this.point.y), 0);
			}
		},

		series: [{
			name: 'Male',
			color:'#97CBFF',
			data: [-result[1][0], -result[1][1], -result[1][2], -result[1][3], -result[1][4], -result[1][5], 
				-result[1][6], -result[1][7], -result[1][8], -result[1][9], -result[1][10]]
		}, {
			name: 'Female',
			color:'#FFFF6F',
			data: [result[0][0], result[0][1], result[0][2], result[0][3], result[0][4], result[0][5], 
				result[0][6], result[0][7], result[0][8], result[0][9], result[0][10]]
			// data: [result[0][0], result[0][1], result[0][2], result[0][3], result[0][4], result[0][5], 
			// 	result[0][6], result[0][7], result[0][8], result[0][9], result[0][10]]
		}]
	});
			}
		});

}

function showChartOfAddr(){

	$.post('http://localhost/sampleCake/index.php/sample/showChartOfAddr',
		function(result){
			if(null != result){
				result = eval( "(" + result + ")");
				// alert(eval( "(" + result + ")"));

				// alert(result);
				var chart;
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'addressStatistic',
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false
		},
		title: {
			text: 'SampleCake会员居住地统计'
		},
		tooltip: {
			formatter: function() {
				return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					color: '#000000',
					connectorColor: '#000000',
					formatter: function() {
						return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
					}
				}
			}
		},
		series: [{
			type: 'pie',
			name: 'Browser share',
			data: [
				['玄武区',   result['玄武区']],
				['白下区',   result['白下区']],
				{
					name: '建邺区',
					y: result['建邺区'],
					sliced: true,
					selected: true
				},
				['秦淮区',    result['秦淮区']],
				['雨花台区',     result['雨花台区']],
				['下关区',     result['下关区']],
				['浦口区',     result['浦口区']],
				['鼓楼区',     result['鼓楼区']],
				['栖霞区',     result['栖霞区']],
				['江宁区',     result['江宁区']],
				['六合区',     result['六合区']],
				['溧水县',     result['溧水县']],
				['高淳县',   result['高淳县']]
			]
		}]
	});
			}
		});
	
}

function showCardsState(){
		$.post('http://localhost/sampleCake/index.php/sample/showCardsState',
			function(result){
				result = eval( "(" + result + ")");
				var chart;
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'cardsStatistic',
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false
		},
		title: {
			text: '会员卡使用情况'
		},
		tooltip: {
			formatter: function() {
				return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					color: '#000000',
					connectorColor: '#000000',
					formatter: function() {
						return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
					}
				}
			}
		},
		series: [{
			type: 'pie',
			name: 'Browser share',
			data: [
				['正常使用',   result['isUsing']],
				{
					name: '停止使用',
					y: result['disuse'],
					sliced: true,
					selected: true
				}
			]
		}]
	});
			});
}

function getAllClerks(){
	$.post('http://localhost/sampleCake/index.php/sample/getAllClerks',
		function(result){
			$('#ClerksMenu').empty();
			// $('#saleCount').attr({value:""});
			// $('#saleDate').attr({value:""});
			if(null!=result){
				result = eval( "(" + result + ")");
				for(var index=0; index<result.length; index++){
					$('#ClerksMenu').append('<option value='+result[index]['clerkname']+' uid='+result[index]['uid']+'>'+result[index]['clerkname']+'</option>');
				}
			}
		});
}

function initiateManageMenu(){
	$.post('http://localhost/sampleCake/index.php/sample/getIdentity',
		function(identity){
			if(0 != identity){
				$('#listatisticsMember').css({'display':'none'});
				$('#listatisticsAddr').css({'display':'none'});
				$('#liManageClerks').css({'display':'none'});
			}
		})
}


