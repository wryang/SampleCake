// JavaScript Document

$(function(){
	$('#uploadImgBtn').click(function(){
		$('#productImg').click();
		
	});
	
	$("#submitBtn").click(function(){
		$('#submit').click();
	});
});


function checkImg()
{
   var fileName=document.getElementById("productImg").value;
   if(fileName=="")
     return;
     //检查文件类型
   var exName=fileName.substr(fileName.lastIndexOf(".")+1).toUpperCase()
      if(exName=="JPG"||exName=="BMP"||exName=="GIF")
       {
          //document.getElementById("myimg").src=fileName;
          //document.getElementById("previewImage").innerHTML='<img src=\''+fileName+'\' width=100 height=100 >';
		  showImg();
       }
     else
       if(exName=="SWF")
        {
         // document.getElementById("previewImage").innerHTML='<embed src=\''+fileName+'\' width=\'100\' height=\'100\' quality=\'high\' bgcolor=\'#f5f5f5\' ></embed>';
		  showImg();
         }
     else
        if(exName=="WMV"||exName=="MPEG"||exName=="ASF"||exName=="AVI")
         {
            var strcode='<embed src=\''+fileName+'\' border=\'0\' width=\'100\' height=\'100\'  quality=\'high\' ';
            strcode+=' autoStart=\'1\' playCount=\'0\' enableContextMenu=\'0\' type=\'application/x-mplayer2\'></embed>';
           // document.getElementById("previewImage").innerHTML=strcode;
			showImg();
         }
    else
       {
          alert("请选择正确的图片文件");
          document.getElementById("productImg").value="";
        }
}

function showImg()
{
	var src = document.getElementById('productImg').value;
	alert(src);
	//$('#imgSlide').attr({'src':src});
	$('#imgSlide').show().slideDown(5000);
}

function onlyNum()
{
if(!(event.keyCode==46)&&!(event.keyCode==8)&&!(event.keyCode==37)&&!(event.keyCode==39))
if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105)))
event.returnValue=false;
}