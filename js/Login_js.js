// JavaScript Document

$(function(){
	
	var loadingTimeOut;
		
		
	$('#login_close').click(function(){
		document.getElementById('login').style.display='none';
		document.getElementById('fade').style.display='none';
		document.getElementById('faildLogin').style.visibility='hidden';
		stopLoading();
	});
	
	$('#register_close').click(function(){
		document.getElementById('register').style.display='none';
		document.getElementById('fade').style.display='none';
	});
	
	$('.close').hover(function(){
		$(this).attr("src" , "/sampleCake/images/window_close_clicked.png");
	}
	,function(){
		$(this).attr("src" , "/sampleCake/images/window_close_before.png");
	});
		
	$('.LR_login_tab').click(function(){
		document.getElementById('register').style.display='none';
		document.getElementById('login').style.display='block';
		$(document.getElementById('login')).css({'margin-top':document.body.scrollTop});
		document.getElementById('faildLogin').style.visibility='hidden';
		stopLoading();
		$("#loading").css({"display":"none"});

	});
	
	$('.LR_register_tab').click(function(){
		document.getElementById('login').style.display='none';
		document.getElementById('faildLogin').style.visibility='hidden';
		document.getElementById('register').style.display='block';
		$(document.getElementById('register')).css({'margin-top':document.body.scrollTop});
		$('#succeedSignUp').css({"display" : "none"});
	});
	
	$('#loginBtn').hover(function(){
		$(this).css({"margin-top":"48px"});
	},function(){
		$(this).css({"margin-top":"50px"});
	});
	
	$('#registerBtn').click(function(){
		/*if you are succeed in signing up , then it will call the function "succeedSignUp" for next step;*/
	
        var username = $('#Lemail').attr('value');
        var password = $('#Lpassword').attr('value');
        // var identity = 1;
        // var gender = 0;
        var date = new Date();
        var month = parseInt(date.getMonth()) + 1;
        var birthday = date.getFullYear() + "-" + month + "-" + date.getDate();
        // var address = "玄武区";
		$.post('http://localhost/sampleCake/index.php/sample/register',
			{username:username, birthday:birthday, password:password},
			function(result){
				if(result){
					result = eval( "(" + result + ")");
					if(result['UsernameError']){
						alert("此用户名已注册！");
					}else{
						succeedSignUp();
					}
				}
			});
		
	});
	
	$('#loginBtn').click(function(){
		$('#loading').css({"display" : "block"});
		/*登录系统，调用后台方法*/
		var username = $('#Remail').attr('value');
		
		var password = $('#Rpassword').attr('value');
		var currentDate = new Date();
		$.post('/sampleCake/index.php/site/login',
			{username:username, password:password, remember:false},
			function(para){
				startLoading();
				para =  eval( "(" + para + ")");
				if(para.result == 'true'){
				// if(para.result){
					if(1 == para.identity){
						succeedLogin(username , para.Uid);
						$('.memberInfoManagement').css({'display':'block'});
					//	var month = currentDate.getMonth() +１；
					}
					else if(0 == para.identity || 2 == para.identity){
						succeedLogin(username , para.Uid);
						$(".vipServiceCenter").css({'display':'block'});
						$(".salesManagement").css({'display':'block'});
						location.reload();
					}

				}else{
					faildLogin();
				}
			});
		/*document.getElementById('login').style.display='none';
		document.getElementById('fade').style.display='none';*/
	});
	
	/*模拟后台登录成功时*/
/*	$('#loading').click(function(){
		succeedLogin('vip' , '091250');
		});*/
	
	
});

function succeedLogin(vipName, vipID){
	stopLoading();
	$("#loading").css({"display":"none"});
	document.getElementById('login').style.display='none';
	document.getElementById('fade').style.display='none';
	document.getElementById('faildLogin').style.visibility='hidden';
	
	/*welcome th vip of login name*/
	
	console.log("login");
	$('.vip_hidden').css({"display":"none"});

	console.log($('#header_navigation'));
	$('#header_navigation').append("<li class='navigation vip'>|</li><li class='navigation target vip' id='exit' style='color:#AA0004'><a href='http://localhost/sampleCake/index.php/site/logout' style='color:#AA0004'>退出</a></li><li class='navigation target vip' id='"+vipID+"'>欢迎您，"+vipName+"， </li>");
	}

function faildLogin(){
	stopLoading();
	$("#loading").css({"display":"none"});
	document.getElementById('faildLogin').style.visibility='visible';
}

function startLoading(){
	var src = "/sampleCake/images/loading1.png";
	$('#loading').attr("src" , src);
	$('#loading').attr("value","1");
	changeLoadingImg();
	}

function stopLoading(){
	var src = "/sampleCake/images/loading1.png";
	$('#loading').attr("src" , src);
	$('#loading').attr("value","0");
	window.clearTimeout(loadingTimeOut);
	}
	
function changeLoadingImg(){
	var index = document.getElementById("loading").getAttribute("value");
	/*index is 1 for first*/
	if(index<8 && index>0){
		//alert(index);
		index++;
		var src = "/sampleCake/images/loading"+index+".png";
		$('#loading').attr("src" , src);
		$('#loading').attr("value",index);
		loadingTimeOut = window.setTimeout(changeLoadingImg, 150);
		}
	if(index >=8){
		var src = "/sampleCake/images/loading1.png";
		$('#loading').attr("src" , src);
		$('#loading').attr("value","1");
		}
	}

function succeedSignUp(){
	$('#succeedSignUp').css({"display" : "block"});
	window.setTimeout(function(){$('.LR_login_tab').click();},2000);	
	}


