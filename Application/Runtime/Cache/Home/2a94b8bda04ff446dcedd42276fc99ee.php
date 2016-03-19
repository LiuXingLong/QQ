<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>网络聊天系统</title>
	<script type="text/javascript" src="/QQ/Application/Home/View/Public/bootstrap/js/jquery-2.0.0.min.js"></script>
	<script type="text/javascript" src="/QQ/Application/Home/View/Public/bootstrap/js/jquery-ui"></script>
	<link href="/QQ/Application/Home/View/Public/bootstrap/css/bootstrap-combined.min.css" rel="stylesheet" media="screen">
	<script type="text/javascript" src="/QQ/Application/Home/View/Public/bootstrap/js/bootstrap.min.js"></script>	
   <style type="text/css">
   		.dbtn{   			
		    border: 0px;
		    float: right;		    
		    background-color:#B8E0B8;
		    color:#08C;
   		}
   </style>
    <script type="text/javascript">    
    var count=<?php echo ($count); ?>;    
    // 改变部件编辑按钮颜色
	var buttonclass=null;
	$(function(){
		$(".btn1 .btn").click(function(){
			if(buttonclass!=null){
				$(buttonclass).removeClass("btn-info");
			}
			$(this).addClass("btn-info");
			buttonclass=this;
		});		
		//设置好友列表滚动调
		if(count>=8){			
			$("#friendlist").css({"height":"386px","overflow-y":"auto"});			
		}
	});		
	
	var fid=null;  //  发送人  ID 
	var fname=null;//  发送人  name	
	var myVar=null;
	//选择发送消息人
    function setfriend(flag){
    	clearInterval(myVar); // 重新选择聊天好友时关闭更新聊天信息    	
    	document.getElementById("info").value="";
    	data=flag.split(":");    	   	
    	fid=data[0];fname=data[1]; //alert(fid); alert(fname); 
    	$("#fname").html(fname);
    	$.ajax({
   	        type: "POST",
   	        url: '<?php echo U('Index/setfriend');?>',
   	        data: {fid:fid},   //  传入数组数据 
   	        success: function(data){   	        	
   	        	var xiaoxi=eval(data);   // json  转对象
   	        	var str="";
   	        	for(var i=0;i<xiaoxi.length;i++){   
   	        		if(xiaoxi[i].fid1==fid){
   	        			str+='<div class="btn1"style="margin-bottom:20px;border-radius:3px;padding:8px 5px 8px 5px;background-color:rgba(239, 142, 3, 0.71);white-space:normal;word-break:break-all;overflow:hidden;">'+fname+'：'+xiaoxi[i].info+'</div>';
   	        		}else{
   	        			str+='<div class="btn1"style="margin-bottom:20px;border-radius:3px;padding:8px 5px 8px 5px;background-color:rgba(93, 185, 93, 0.43);white-space:normal;word-break:break-all;overflow:hidden;">'+'我：'+xiaoxi[i].info+'</div>';
   	        		}	
   	        	}
   	        	$("#showchat").html(str);
   	        	overflow();
   	        }
    	});    
    	$("#chat").fadeOut();
    	$("#chat").fadeIn();
    	myVar=setInterval(message, 1000);
    }	
	function  message(){
		if(fid!=null){
			$.ajax({
	   	        type: "POST",
	   	        url: '<?php echo U('Index/setfriend');?>',
	   	        data: {fid:fid},   //  传入数组数据 
	   	        success: function(data){   	        	
	   	        	var xiaoxi=eval(data);   // json  转对象
	   	        	var str="";
	   	        	for(var i=0;i<xiaoxi.length;i++){    	        		
	   	        		if(xiaoxi[i].fid1==fid){
	   	        			str+='<div class="btn1"style="margin-bottom:20px;border-radius:3px;padding:8px 5px 8px 5px;background-color:rgba(239, 142, 3, 0.71);white-space:normal;word-break:break-all;overflow:hidden;">'+fname+'：'+xiaoxi[i].info+'</div>';
	   	        		}else{
	   	        			str+='<div class="btn1"style="margin-bottom:20px;border-radius:3px;padding:8px 5px 8px 5px;background-color:rgba(93, 185, 93, 0.43);white-space:normal;word-break:break-all;overflow:hidden;">'+'我：'+xiaoxi[i].info+'</div>';
	   	        		}
	   	        	}
	   	        	$("#showchat").html(str);
	   	        }
	    	});
		}	
	}
	
	// 设置滚动调到底部
	function overflow(){
		var div = document.getElementById('showchat');
		div.scrollTop = div.scrollHeight;
	}
	// 发送消息
    function info(){
        var info=document.getElementById("info").value.trim();
        if(info==""){
        	alert("发送消息不能为空！");       	
        }else{
        	$.ajax({
       	        type: "POST",
       	        url: '<?php echo U('Index/info');?>',
       	        data: {info:info},   //  传入数组数据 
       	        success: function(data){ 
       	        	if(data!="true"){
       	        		alert("发送失败！");
       	        	}else{
       	        		document.getElementById("info").value="";
       	        		overflow();
       	        	}
       	        }
        	});
        }      
    }
	
	//好友管理
    function guanli(flag){		
		if(flag==0){	    		
			$(buttonclass).removeClass("btn-info");
			$("#selectlist").html("");
			$("#chat").fadeOut();
		}else if(flag==1){
			$(".tab-content").css("height","168px");
			$("#selectlist").html("");
		}else{
			$(".tab-content").css("height","100px");
		}   	
    }
	
	// 删除好友
	function deletefriend(did){		
		var r=confirm("确认删除该好友吗？");
		if(r==true){
			$.ajax({
       	        type: "POST",
       	        url: '<?php echo U('Index/remove');?>',
       	        data: {did:did},   //  传入数组数据 
       	        success: function(data){ 
       	        	if(data!="true"){
       	        		alert("删除失败！");
       	        	}else{
       	        		$("#id"+did).remove();
	       	 			$("#idd"+did).remove();
	       	 			count-=1;			
	       	 			//去掉好友列表滚动调
	       	 			if(count<8){			
	       	 				$("#friendlist").css({"height":"","overflow-y":""});			
	       	 			}
       	        	}
       	        }
        	});	
		}	
	}	
	
	//查找好友
	function selectfriend(){
		var name=$("#selectid").val().trim();
		if(name==""){
			alert("查询用户不能为空！");
		}else{
			$("#selectlist").html("");
			$.ajax({
	   	        type: "POST",
	   	        url: '<?php echo U('Index/selectfriend');?>',
	   	        data: {name:name},   //  传入数组数据 
	   	        success: function(data){ 
	   	        	//alert(data);
	   	        	if(data=="no"){       			   	        		
	   	        		alert("抱歉，没有找到该好友！");
	   	        	}else{
	   	        		var name1=eval(data);   // json  转对象   	  username   id        		   	        		  	        		
	   	        		str='<div class="btn1"style="margin-top: 8px;margin-bottom:20px;border-radius:3px;padding:8px 5px 8px 5px;background-color:rgba(93, 185, 93, 0.43);">'+name1[0].username+'<button class="dbtn" onclick="addfriend('+"'"+name1[0].id+':'+name1[0].username+"'"+')">添加好友</button></div>';	
	   	        		$("#selectlist").html(str); 
	   	        	}
	   	        }
	    	});	
			$("#selectid").val("");
		}	
	}
	
	// 添加好友
	function addfriend(did){
		var data1=did.split(":");		
		if(data1[1]=="<?php echo ($_SESSION['username']); ?>"){
			alert("不能添加自己为好友！");
		}else{
		 	var friend=$("td").text();
		 	fname=friend.split("聊天");
		 	len=fname.length-1;
		 	flag=null;
		 	for(var i=0;i<len;i++){			 		
		 		if(data1[1]==fname[i].trim()){   //fname[i].indexOf(data[1])!=-1   data[1]==fname[i].trim();		 			
		 			flag=1;break;		 		
		 		}		 		
		 	}
		    if(flag!=null){
		    	alert("已经是好友了，请不要重复添加！");
		    }else{
		    	$.ajax({
		   	        type: "POST",
		   	        url: '<?php echo U('Index/addfriend');?>',
		   	        data: {fid2:data1[0],fid2name:data1[1]},   //  传入数组数据 
		   	        success: function(data){   	        	
		   	        	if(data!="true"){
		   	        		alert("添加好友失败！");
		   	        	}else{
		   	        		str='<tr class="success" id="id'+data1[0]+'"><td class="btn1">'+data1[1]+'<button class="btn" style="float: right;" type="button" onclick="setfriend('+"'"+data1[0]+':'+data1[1]+"'"+')">聊天</button></td></tr>';		
			  	 			str1='<div class="btn1" id="idd'+data1[0]+'" style="margin-bottom:20px;border-radius:3px;padding:8px 5px 8px 5px;background-color:rgba(93, 185, 93, 0.43);">'+data1[1]+'<button class="dbtn" onclick="deletefriend('+data1[0]+')">删除好友</button></div>';
			  	 			$("#panel-1").append(str1);
			  	 			$("tbody").append(str);	   	     			
			  	     		count+=1;		   	 		
			  	 	 		if(count>=8){	//设置好友列表滚动调		
			  	 	 			$("#friendlist").css({"height":"386px","overflow-y":"auto"});			
			  	 	 		}	
		   	        	}	
		   	        }
		    	});			    			    	
		    }
		}
	}	
    </script>
</head>
<body style="background:url(/QQ/Application/Home/View/Public/css/background.jpg);background-size: cover; background-attachment:fixed;background-repeat:no-repeat;">
   <div style="margin-top: 50px;"> 
   		<div style="float: right;margin-right: 6%;  color:#FFF200;">
			<span><?php echo ($_SESSION['username']); ?>,欢迎您！</span>                             
			<button class="btn btn-success" type="button" onclick="window.location.href='<?php echo U('Login/logout');?>'">退出</button>
		</div>     
       <h3 class="text-center" style="color:rgb(255, 242, 0);margin-left: 18%;">网络聊天系统</h3> 
   </div>
   <div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid">
				<div class="span2">
				</div>
				
				<!-- 好友列表 -->
				<div class="span3">
					<div class="panel panel-default">
						<div class="panel-heading" style="border-bottom:0;">
						<h3 class="panel-title text-center" style="font-size: 20px;">好友列表</h3>
						</div>						
						<div class="panel-body" id="friendlist" style="background-color:rgba(223, 240, 216, 0.64);padding: 0px;"> <!--   8   height:386px;overflow-y :auto -->
							<table class="table table-bordered" style="border-radius:0px;margin-bottom: 0px;border-bottom-width: 0px;">								
								<tbody>									
									 <?php if(is_array($id)): foreach($id as $key=>$v): ?><tr class="success" id="id<?php echo ($v["id"]); ?>">
											<td class="btn1"><?php echo ($v["friend"]); ?>
												<button class="btn" style="float: right;" type="button" onclick="setfriend('<?php echo ($v["id"]); ?>:<?php echo ($v["friend"]); ?>')">聊天</button>
											</td>
										</tr><?php endforeach; endif; ?>																																																		
								</tbody>
							</table>					
						</div>
						<div class="panel-body" style="height:20px;background-color:rgba(223, 240, 216, 0.64);border-top-style:solid;border-top-width:1px;border-color:rgb(221, 221, 221);padding-top: 6px;">
							<button data-toggle="modal" id="modal-1" href="#modal-container-1" class="btn" style="float: right;" type="button" onclick="guanli(0)">好友管理</button>														
						</div>					
					</div>	
				</div>
				<!-- 好友列表 -->
				
				<!-- 好友管理 -->				
				<div id="modal-container-1" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width: 380px;  margin-left: -160px;">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="myModalLabel">
							好友管理
						</h3>
					</div>
					<div class="modal-body">
						<div class="tabbable" id="tabs-1"> 
							<ul class="nav  nav-pills">
								<li class="active"><a href="#panel-1" data-toggle="tab" onclick="guanli(1)">我的好友</a></li>
								<li class=""><a href="#panel-2" data-toggle="tab" onclick="guanli(2)">查找好友</a></li>
							</ul>
							<div class="tab-content" >
								<div class="tab-pane active" id="panel-1">
									<?php if(is_array($id)): foreach($id as $key=>$v): ?><div class="btn1" id="idd<?php echo ($v["id"]); ?>" style="margin-bottom:20px;border-radius:3px;padding:8px 5px 8px 5px;background-color:rgba(93, 185, 93, 0.43);"><?php echo ($v["friend"]); ?><button class="dbtn" onclick="deletefriend('<?php echo ($v["id"]); ?>')">删除好友</button></div><?php endforeach; endif; ?>
								</div>
								<div class="tab-pane" id="panel-2">
									<input class="input-medium search-query" type="text" id="selectid" name="selectid" value=""/>
									<button class="btn" onclick="selectfriend()">查找</button>	
									<div id="selectlist"></div>
								</div>
							</div>
						</div>						
					</div>
					
					<div class="modal-footer">
						 <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button> 
						 <button class="btn btn-primary"  data-dismiss="modal" aria-hidden="true">确认</button>
					</div>
				</div>
				<!-- 好友管理 -->
				
				<!-- 聊天记录 -->
				<div class="span4" id="chat"  style="display:none;">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title text-center" style="font-size: 20px;"><span id="fname"></span></h3>
						</div>						
						<div id="showchat" class="panel-body" style="height: 260px;background-color:rgba(223, 240, 216, 0.64);overflow-y:auto;">																	
						</div>
						<div class="panel-body" style="height:80px;background-color:rgba(223, 240, 216, 0.64);border-top-style:solid;border-top-width:1px;border-color:rgb(221, 221, 221);">							
							<textarea id="info"name="comment" maxlength="500" required  style="height: 80px;width: 97%;resize: none;"></textarea>							
						</div>		
						<div class="panel-body" style="height:20px;background-color:rgba(223, 240, 216, 0.64);border-top-style:solid;border-top-width:1px;border-color:rgb(221, 221, 221);padding-top: 6px;">
							<button class="btn" style="float: right;" type="button" onclick="info()">发送</button>														
						</div>					
					</div>
				</div>				
				<!-- 聊天记录 -->
				
			</div>
		</div>
	</div>
  </div>   
</body>
</html>