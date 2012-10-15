// JavaScript Document
$(function(){
	//window.opener.document."&upload.form("FormName")&"."& upload.form("EditName")&".value='文件名.gif';
	})
var AllowImgFileSize=2000;        //允许上传图片文件的大小 0为无限制  单位：KB
var AllowImgWidth=3000;            //允许上传的图片的宽度  0为无限制　单位：px(像素)
var AllowImgHeight=3000;            //允许上传的图片的高度  0为无限制　单位：px(像素)
function load(Obj){
    var tempImg=new Image();
    tempImg.onerror=function(){                   //不是图片
        thisform.button.disabled=true;            //提交不可用
        Obj.outerHTML=Obj.outerHTML;              //清除表单
        document.getElementById("err_msg").innerHTML="目标类型格式不正确或者图片已损坏!"
        document.getElementById("ErrMsg").innerHTML=""
    };

    tempImg.onreadystatechange=function(){
      thisform.button.disabled=false;          //提交可用
      document.getElementById("err_msg").innerHTML="&nbsp;&nbsp;&nbsp; 图片宽度：<font color=red>" +this.width + "</font><br>&nbsp;&nbsp;&nbsp; 图片高度：<font color=red>" + this.height + "</font><br>&nbsp;&nbsp;&nbsp; 图片大小：<font color=red>" + parseInt(this.fileSize*0.001) + "K</font>";

        if(AllowImgWidth!=0&&AllowImgWidth<this.width ||AllowImgHeight!=0&&AllowImgHeight<this.height ||AllowImgFileSize!=0&&AllowImgFileSize*1024<this.fileSize ){
            document.execCommand("Delete");
            Obj.outerHTML=Obj.outerHTML;
            document.getElementById("ErrMsg").innerHTML="\n图片不要超过<font color=red>"+AllowImgFileSize+"</font>KB。<font color=red>"+AllowImgWidth+"</font>X<font color=red>"+AllowImgHeight+"</font>"
            thisform.button.disabled=true;
        }else{
            document.getElementById("ErrMsg").innerHTML=""
            document.all.err_msg.style.display='';
        }
    };
    tempImg.src=Obj.value;
}

function up(){
  if(thisform.button.disabled) event.returnValue=false;
}

var flag=false;
function DrawImage(ImgD){
    var image=new Image();
    image.src=ImgD.src;
    if(image.width>0 && image.height>0)
        {
    flag=true;
    if(image.width/image.height>= 350/300){
     if(image.width>350){
     ImgD.width=350;
     ImgD.height=(image.height*350)/image.width;
     }else{
     ImgD.width=image.width;
     ImgD.height=image.height;
     }
     }
    else
        {
     if(image.height>300)
         {
       ImgD.height=300;
       ImgD.width=(image.width*300)/image.height;
     }
         else
         {
     ImgD.width=image.width;
     ImgD.height=image.height;
     }
     }
    }
}
function FileChange(Value){
    flag=false;
    document.getElementById("uploadimage").width=0;
    document.getElementById("uploadimage").height=0;
    document.getElementById("uploadimage").alt="";
    document.getElementById("uploadimage").src=Value;
}
function mysub()
{
    esave.style.visibility="visible";
}

var i=11;
function addNew()
{
    tr=document.getElementById("t136").insertRow();
    tr.insertCell().innerHTML='图片说明<input type=text name=fileName>选择<input type=file name=pic'+i+' style=width:100 content Editable=false value onpropertychange=javascript:load(this); onchange=javascript:FileChange(this.value);><a href=javascript:void(0) onclick=del()>删除</a>'
}
function del()
{
    document.all.t136.deleteRow(window.event.srcElement.parentElement.parentElement.rowIndex);
}

function checkData()
{
   var fileName=document.getElementById("FileUp").value;
   if(fileName=="")
     return;
     //检查文件类型
   var exName=fileName.substr(fileName.lastIndexOf(".")+1).toUpperCase()
      if(exName=="JPG"||exName=="BMP"||exName=="GIF")
       {
          //document.getElementById("myimg").src=fileName;
          document.getElementById("previewImage").innerHTML='<img src=\''+fileName+'\' width=100 height=100 >';
       }
     else
       if(exName=="SWF")
        {
          document.getElementById("previewImage").innerHTML='<embed src=\''+fileName+'\' width=\'100\' height=\'100\' quality=\'high\' bgcolor=\'#f5f5f5\' ></embed>';
         }
     else
        if(exName=="WMV"||exName=="MPEG"||exName=="ASF"||exName=="AVI")
         {
            var strcode='<embed src=\''+fileName+'\' border=\'0\' width=\'100\' height=\'100\'  quality=\'high\' ';
            strcode+=' autoStart=\'1\' playCount=\'0\' enableContextMenu=\'0\' type=\'application/x-mplayer2\'></embed>';
            document.getElementById("previewImage").innerHTML=strcode;
         }
    else
       {
          alert("请选择正确的图片文件");
          document.getElementById("FileUp").value="";
        }
     }