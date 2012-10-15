/*$(function(){
	$('.date-pick').datePicker({clickInput:true});
    $('a.dp-choose-date').empty().html('<img src="/sampleCake/images/calendar.png" width=20px height=20px/>');

	$('#infoSubmitBtn').click(function(){
		var username = $("#registername").attr('value');
		//alert(username);
		var password = $('#password').attr('value');
		var birthday = $(document.getElementsByName('birthday')).attr('value');
		if("" !=  birthday){
			birthday = birthday.split('/');
    		var year = birthday[2];
    		var month = birthday[1];
    		var day = birthday[0];
    		birthday = year + "-" + month + "-" + day;
		}

    	var gender = $(document.getElementsByName('gender')).attr('value');
    	if("male" == gender){
    		gender = 1;
    	}else{
    		gender = 0;
    	}

    	var address = $('#address').attr('value');
    	if("" == username){
    		alert("用户登录名不能为空！");
    	}else{
    		if("" == password){
    			alert("密码不能为空！");
    		}else{
    			$.post('http://localhost/sampleCake/index.php/sample/updatePersonalInfo',
    			{username:username, password:password, birthday:birthday, gender:gender, address:address},
    				function(result){
    					result = eval( "(" + result + ")");
						if(!result['UsernameError']){
							alert("成功添加会员！");
						}else{
							alert("该用户名已存在，请重新输入！");
						}
    			});
    		}
    		
    	}
	});

	$('.personalInfo-menu').children('li').click(function(){
		var currentForm = $('.personalInfo-menu').attr('currentForm');
		$('#'+currentForm).css({'display':'none'});
		var changeForm = $(this).children('div').attr('control');
		$('#'+changeForm).css({'display':'block'});
		$('.personalInfo-menu').attr({currentForm:changeForm});
	});

	$('#selectAddrBtn').toggle(
		function(){
			alert("y");
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
});*/

$(function(){
	// $('#firstManageM').focus();
	// $('.date-pick').datePicker({clickInput:true});
 //    $('a.dp-choose-date').empty().html('<img src="/sampleCake/images/calendar.png" width=20px height=20px/>');
    $(document.getElementsByName('gender')).attr({value:"male"});
    getPersonalInfo();


	$('#uSubmitBtn').click(function(){
		var username = $("#personalName").attr('value');
		var password = $('#password').attr('value');
		var birthday = $(document.getElementsByName('birthday')).attr('value');

		// if("" !=  birthday){
			// var date = birthday.split('/');
   //  		var year = date[2];
   //  		var month = date[1];
   //  		var day = date[0];
   			// var date = birthday.split('-');
    		// var year = date[0];
    		// var month = date[1];
    		// var day = date[2];
    		// birthday = year + "-" + month + "-" + day;
  //   		alert(birthday);
		// }

    	//var gender = $(document.getElementsByName('gender')).attr('value');
    	//alert(gender);
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
    		if("" == password){
    			alert("密码不能为空！");
    		}else{
    			$.post('http://localhost/sampleCake/index.php/sample/updatePersonalInfo',
    				{username:username, birthday:birthday, gender:gender, address:address, password:password},
    					function(result){
    						result = eval( "(" + result + ")");
							if(!result['UsernameError']){
								alert("资料修改成功！");
							}else{
								alert("该用户名已存在，请重新输入！");
							}
    					});
    		}
    		
    	}

    	
	});

	$('.psersonal-menu').children('li').click(function(){
		var currentForm = $('.psersonal-menu').attr('currentForm');
		$('#'+currentForm).css({'display':'none'});
		var changeForm = $(this).children('div').attr('control');
		$('#'+changeForm).css({'display':'block'});
		if("updateInfo" == changeForm){
			getPersonalInfo();
		}else if("orderManage" == changeForm){
			getPersonalOrders();
		}else if("cardManage" == changeForm){
			getPersonalCards();
		}
		$('.psersonal-menu').attr({currentForm:changeForm});


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
})

function onlyNum() 
{ 
	if(!(event.keyCode==46)&&!(event.keyCode==8)&&!(event.keyCode==37)&&!(event.keyCode==39)) 
		if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105))) 
			event.returnValue=false; 
} 

function getPersonalInfo(){
	$.post('http://localhost/sampleCake/index.php/sample/getPersonalInfo',
		function(personalInfo){
			if(null != personalInfo){
				personalInfo = eval( "(" + personalInfo + ")");
				$("#personalName").attr({value:personalInfo.username});
				$('#password').attr({value:personalInfo.password});
				if(0 == personalInfo.gender){
					document.getElementById('radioFemale').checked = true;
					document.getElementById('radioMale').checked = false;
				}else{
					document.getElementById('radioMale').checked = true;
					document.getElementById('radioFemale').checked = false;
				}
				var birthday = personalInfo.birthday;
				if("" != birthday){
					// birthday = birthday.split("-");
					// var year = birthday[0];
					// var month = birthday[1];
					// var day = birthday[2];
					// birthday = day+'/'+month+"/"+year;
					$(document.getElementsByName('birthday')).attr({value:birthday});
				}
				
				$("#address").attr({value:personalInfo.address});
			}else{
				$("#personalName").attr({value:""});
				$('#password').attr({value:""});

				$(document.getElementsByName('birthday')).attr({value:""});
				$("#address").attr({value:""});
			}
		});
}

function getPersonalOrders(){
	$('tr').remove('.ordersInfo');
	$.post('http://localhost/sampleCake/index.php/sample/getPersonalOrders',
		function(orders){
			if(null != orders){
				orders = eval( "(" + orders + ")");
				for(var i=0; i<orders.length; i++){
					var state = orders[i]['state'];
					if(1 == state){
						state = '已完成';
					}else{
						state = '未完成';
					}
					$("#ordersTable").append("<tr class='ordersInfo'><td>"+orders[i]['oid']+"</td><td>"+
						orders[i]['productName']+"</td><td>"+orders[i]['productPrice']+"</td><td>"+
						orders[i]['count']+"</td><td>"+orders[i]['amount']+"</td><td>"+
						orders[i]['timestamp']+"</td><td>"+state+"</td></tr>");
				}
			}
		});
}

function getPersonalCards(){
	$('tr').remove('.cardsInfo');
	$.post('http://localhost/sampleCake/index.php/sample/getPersonalCards',
		function(cards){
			if(null != cards){
				cards = eval( "(" + cards + ")");
				for(var i=0; i<cards.length; i++){
					var state = cards[i]['state'];
					if(1 == state){
						state = "正在使用";
					}else{
						state = "停止使用";
					}
					$('#cardTable').append("<tr class='cardsInfo'><td>"+cards[i]['cardnumber']+"</td><td>"+
						cards[i]['balance']+"</td><td>"+cards[i]['accumulated']+"</td><td>"+cards[i]['level']+"</td><td>"+
						state+"</td><td>"+cards[i]['deadline']+"</td></tr>");
				}
			}
		});
}
