/* 公用ready 开始 */

$(document).ready(function(){
	adv_search_init()
	$(".left_menu .tree_menu a").click(function() {
		return click_left_menu($(this));
	})
	
	top_menu=get_cookie("top_menu");
	$('.nav li a[node='+top_menu+']').addClass("active");	
	
	left_menu=get_cookie("left_menu");
	
	$(".left_menu .tree_menu a[node='"+left_menu+"']").addClass("active");
	if($(".left_menu .tree_menu a.active").length == 0){
		url = window.location.pathname;
		$(".left_menu .tree_menu a[href='" + url + "']").addClass("active");
	}

	$("#move_to .drop-down-box li").click(function(){
		move_to($(this).attr("id"));					
	})

	/* 查找联系人input 功能*/
	$(".inputbox .search li").live("click",function(){
		name = $(this).text().replace(/<.*>/,'');
		email=$(this).find("a").attr("title");
		html="<span email=\""+email+"\"><nobr><b  title=\""+email+"\">"+name+"</b><a class=\"del\" title=\"删除\">&#10005</a></nobr></span>";
		inputbox=$(this).parents(".inputbox");
		inputbox.find("span.address_list").append(html);
		inputbox.find("input.letter").val("");
		inputbox.find(".search ul").html("");
		inputbox.find(".search ul").hide();		
		inputbox.find(".search").hide();
	})
	
/* 查找联系人input 功能*/
	$(".inputbox .letter").keyup(function(e){				
		switch(e.keyCode)
		 {
		 case 40:
			var $curr = $(this).parents(".inputbox").find(".search li.active").next();
			if ($curr.html()!=null)
			{
				 $(this).parents(".inputbox").find(".search li").removeClass("active");
				$curr.addClass("active");
			}
		 break
		 case 38:
			var $curr =  $(this).parents(".inputbox").find(".search li.active").prev();
			if ($curr.html()!=null){
				 $(this).parents(".inputbox").find(".search li").removeClass("active");
				 $curr.addClass("active");					
			}
		 break
		 case 13:
			if ($(this).parents(".inputbox").find(".search ul").html()!="") {
				name = $(".search li.active").text().replace(/<.*>/,'');
				email=$(".search li.active a").attr("title");
				html="<span email=\""+email+"\"><nobr><b  title=\""+email+"\">"+name+"</b><a class=\"del\" title=\"删除\">&#10005</a></nobr></span>";
				$(this).parents(".inputbox").find("span.address_list").append(html);
				$(this).parents(".inputbox").find(".search ul").html("");
				$(this).val("");
				$(this).parents(".inputbox").find(".search ul").hide();
			}else{
				email=$(this).val();
				if(validate(email,'email')){
					name = email;
					html="<span email=\""+email+"\"><nobr><b  title=\""+email+"\">"+name+"</b><a class=\"del\" title=\"删除\">&#10005</a></nobr></span>";
					$(this).parents(".inputbox").find("span.address_list").append(html);
					$(this).val("");						
				}else{
					alert("邮件格式错误");
				}
			}
		 break
		 default:
			var search=$(this).parents(".inputbox").find("div.search ul");               
			 if ($(this).val().length > 1){
			$.getJSON("/contact/json", {
				key: $(this).val()
			}, function(json){
				if (json!=undefined){
					if(json.length>0){					
						search.html("");
						$.each(json, function(i){
							search.append('<li><a title="' + json[i].email + '">' + json[i].name +'&lt;'+ json[i].email+'&gt;</a></li>')										
						})
						search.children("li:first").addClass("active");		
						search.show();
					}
				}else{
					search.html("");
					search.hide();
				}
			});
		}else {					
			 search.hide();
		}
	}
	});

	$("label.checkbox :checkbox").click(function(){
		if($(this).attr("checked")=="checked"){
			$(this).parent().find("i").removeClass("icon-check-empty");
			$(this).parent().find("i").addClass("icon-check");
		}else{
			$(this).parent().find("i").removeClass("icon-check");
			$(this).parent().find("i").addClass("icon-check-empty");
		}
	})
	/* 自动完成功能*/
	$(".controls .search li").live("click",function(){
		inputbox=$(this).parents(".controls");

		data=$(this).data("data");
		key_field=inputbox.find("input.val").attr("key_field");
		if (key_field==undefined){
			key_field="id";
		}
		inputbox.find("input.key").val(data[key_field]);			

		val=$(this).text();
		inputbox.find("input.val").val(val);							
		try{
			callback=eval(inputbox.find("input.val").attr("process"));
			if(typeof(callback)=="function"){
				callback($(this),data);
			}
		}catch(e){
			//alert("yy");
		}
		inputbox.find(".search ul").html("");
		inputbox.find(".search ul").hide();		
	})
	/* 自动完成功能*/
	$(".controls .val").live("keyup",function(e){
		switch(e.keyCode)
		 {
		 case 40:
			var $curr = $(this).parents(".controls").find(".search li.active").next();
			if ($curr.html()!=null)
			{
				 $(this).parents(".controls").find(".search li").removeClass("active");
				$curr.addClass("active");
			}
		 break
		 case 38:
			var $curr =  $(this).parents(".controls").find(".search li.active").prev();
			if ($curr.html()!=null){
				 $(this).parents(".controls").find(".search li").removeClass("active");
				 $curr.addClass("active");					
			}
		 break
		 case 13:
			if ($(this).parents(".controls").find(".search ul").html()!=""){
				inputbox=$(this).parents(".controls");

				data=inputbox.find(".search li.active").data("data");
				key_field=inputbox.find("input.val").attr("key_field");
				if (key_field==undefined){
					key_field="id";
				}
				inputbox.find("input.key").val(data[key_field]);			

				val=inputbox.find(".search li.active").text();
				inputbox.find("input.val").val(val);							
				try{
					callback=eval($(this).attr("process"));
					if(typeof(callback)=="function"){						
						callback($(this),data);
					}
				}catch(e){
					//alert("yy");
				}
				inputbox.find(".search ul").html("");
				inputbox.find(".search ul").hide();		
			}
		 break
		 default:
			var search=$(this).parents(".controls").find("div.search ul");               
			if ($(this).val().length > 1){
				$.getJSON($(this).attr("source"),{
					keyword: $(this).val(),
					condition:$("#"+$(this).attr("condition")).val()
				}, function(json){
					if(json!=undefined){
						if(json.length>0){		
							search.html("");
							$.each(json, function(i){
								html=$('<li><a>' + json[i].name+'</a></li>');
								html.data("data",json[i]);
								html.appendTo(search);
							})
							search.children("li:first").addClass("active");						
							search.show();
						}
					}else{
						search.html("");
						search.hide();
					}
				});
			}else {					
				 search.hide();
			}
		 }
	});

/* 查找联系人input 功能*/
	$(".inputbox").live("click",function(e){
		$(this).find(".letter").focus();				
		$(this).addClass("focus");
	})
/* 查找联系人input 功能*/
	$(".inputbox input.letter").blur(function(e){		
		$(this).parents(".inputbox").removeClass("focus");
	})

/* select 可以手动输入*/
	$("select.writeable").keypress(function(e){
		if(this.options[0].text=="选择或录入"){
			this.options[0].text='';
		}
				this.options[0].selected = "selected";
				this.options[0].text = this.options[0].text + String.fromCharCode(event.keyCode);
		this.options[0].value=this.options[0].text;
				e.returnValue=false;
	});
/* select 可以手动输入*/
	$("select.writeable").keydown(function(e){
		if(e.keyCode == 46){this.options[0].text = '';}
	});
	
	 /* 双击删除已选联系人*/
	 $(".inputbox .address_list span").live("dblclick", function() {
		$(this).remove();
		});

	 /*单击删除已选联系人*/
	 $(".inputbox .address_list a.del").live("click", function() {
		$(this).parent().parent().remove();
	});	

/* combo 标签 获取焦点时隐藏label功能 */
	$("div.combo input").focus(function(){
		$(this).parent().find("label").hide();
	})
})

/* 公用函数开始=========================================== */

/* 回车进行搜索 */
function key_search(){
	if (event.keyCode == 13)
	{
		$("#form_search").submit();
		return false;				
	}
}

/* 点击按钮搜索 */
function btn_search(){
	$("#form_search").submit();
	return false;
}

function adv_search_init(){
	if(get_cookie("adv_search")=="open"){
		$("div.adv_search").show();
	};
	if(get_cookie("adv_search")=="close"){
		$("div.adv_search").hide();
	};
}
/* 点击高级搜索 */
function adv_search(){
	$("#form_search").submit();
	set_cookie("adv_search","open");	
	return false;
}

/* 打开高级搜索 */
function open_search(){
	$("div.adv_search").show();
	set_cookie("adv_search","open");	
	return false;
}
/* 打开关闭搜索 */
function close_search(){	
	$("div.adv_search").hide();
	set_cookie("adv_search","close");		
	return false;
}

/* 判断是否是移动设备 */
function is_mobile(){
	return navigator.userAgent.match(/mobile/i);
}

/* 在iframe里显示textarea的内容*/
function show_content(){
		var iframe=$("#content_iframe").get(0).contentWindow;
		var div=document.createElement("div");
		div.innerHTML=$("#content_1").val();
		div.className="height";
		iframe.document.body.appendChild(div);
		height=$(iframe.document.body).find("div.height").height();
		if(height<300){
			height=300;
		}
		iframe.height =  height;
		$("#content_wrap").height(height+30);
		$("#content_wrap").parent().height(height+40);
		$("#content_iframe").height(height+30);
	}
	

function show(name){
	$(name).show();
}

function hide(name){
	$(name).slideUp(100);	
}

/* 关闭弹出窗口*/
function myclose(){
	parent.winclose();
}
/* 关闭弹出窗口*/
function myclose2(){
	window.opener=null;
	window.open('','_self');
	window.close();
}

/* 单击top菜单*/

function click_top_menu(node){
	set_cookie("left_menu","");	
	url=$(node).attr("url");
	node=$(node).attr("node")	
	set_cookie("top_menu",node);
	form = $("<form></form>");
	form.attr('action',url);
	form.attr('method','post');
	form.appendTo("body");
	form.css('display','none');
	form.submit();
}

/* 单击left_menu菜单*/

function click_left_menu(obj_node){
	url=$(obj_node).attr("href");

	if (url.length>0 && (url!="#"))
	{
		node=$(obj_node).attr("node");
		set_cookie("left_menu",node);
	}else{
		node=$(obj_node).parent().find("li a:first").attr("node");	
		set_cookie("left_menu",node);
		url=$(obj_node).parent().find("li a:first").attr("href");
		if (url!==undefined){
			location.href=url;
		}
		return false;
	}
}

function click_home_list(obj_node){
	node=$(obj_node).attr("node");
	set_cookie("top_menu",node);
	return_url=$(obj_node).attr("return_url");
	set_cookie("return_url",return_url);
}


/* 填充时间*/

function fill_time(id) {
	for (var i = 5; i < 22; i++) {
		val = ("0" + i);
		val = val.substring(val.length - 2)
		$("#" + id).append("<option value='" + val + ":00'>" + val + ":00</option>");
		$("#" + id).append("<option value='" + val + ":30'>" + val + ":30</option>");
	}
}

/* 获取日历背景颜色*/
function schedule_bg(j) {
	var myArray = new Array(5);

	myArray[0] = "#d9534f";
	myArray[1] = "#bbe9ff";
	myArray[2] = "#ffc6ff";
	myArray[3] = "#ffddbb";
	myArray[4] = "#ffc6c6";
	return myArray[j - 1];
}

/* 验证数据类型*/
function validate(data, datatype) {
	switch (datatype) {
		case "require":
			if (data == "") {
				return false;
			} else {
				return true;
			}
			break;
		case "email":
			var reg = /^([0-9A-Za-z\-_\.]+)@([0-9a-z]+\.[a-z]{2,3}(\.[a-z]{2})?)$/g;
			return reg.test(data);
			break;
		case "number":
			var reg = /^[0-9]+\.{0,1}[0-9]{0,3}$/;
			return reg.test(data);
			break;
		case "html":
			var reg = /<...>/;
			return reg.test(data);
			break;
	}
}

/* 检查表单*/


function check_form(sform){
		var check_flag=true;
		$("#"+sform+" :input").each(function(i){
				if($(this).attr("check")){
			if(!validate($(this).val(),$(this).attr("check"))){
				alert($(this).attr("msg"));
				$(this).focus();
				check_flag=false;
				return check_flag;
			}
		}
		})
		return check_flag;
}

/* 打开新窗口*/

function winopen2(url,width,height){
	var arr=new Array();
	var ss=url.split('?');
	url=ss[0];
	for(var i=1;i<ss.length;i++){
		url+="&"+ss[i];
	}
	 var parm = "";  
	 var dialogHeight = "dialogHeight:"+height+"px";  
	 var dialogWidth = "dialogWidth:"+width+"px";  
	
 if(navigator.userAgent.toLowerCase().indexOf('msie')>0){  
			parm = dialogHeight+";"+dialogWidth+";center=yes";  
 }else{  
			var x = (window.screen.width/2)-(width/2)+"px";  
			var y = (window.screen.height/2)-(height/2)+"px";  
			parm = dialogHeight+";"+dialogWidth+";dialogLeft:"+ x +";dialogTop:"+y+";";  
	 }
	 title="smeoa"
	 var returnValue = window.showModalDialog(url,title,parm);  
	 return returnValue;  
		}


/* ajax提交*/
function sendAjax(url,vars,callback) {
		return $.ajax({
				type: "POST",
				url: url,
				data: vars+"&ajax=1",
				dataType: "json",
				success: callback
		});
}

function getHtml(url,vars,callback) {
		return $.ajax({
				type: "POST",
				url: url,
				data: vars+"&ajax=1",
				dataType: "text",
				success: callback
		});
}

/*提交表单*/
function sendForm(formId,post_url,return_url){
		if($("#ajax").val()==1){
				var vars=$("#"+formId).serialize();
				$.ajax({
						type: "POST",
						url: post_url,
						data: vars,
						dataType: "json",
						success: function(data){
				alert(data.info);
				if(return_url)
				{	
					location.href=return_url;
				}
						}
				});
		}else{
				$("#"+formId).attr("action",post_url);
				input1 = $("<input type='hidden' name='return_url' />");
				input1.attr('value',return_url);
				$("#"+formId).append(input1);
				$("#"+formId).submit();
		}
}

/*全选*/
function select_all(name){
		if ($("form #chk_select_all").attr("checked"))		
		{
			var val='';
			$("form input[name=\""+name+"\"]:checkbox").each( function() {
				$(this).attr("checked",true);
			});
		}else{
			$("form input[name=\""+name+"\"]:checkbox").each( function() {
				$(this).attr("checked",false);
			});
		}
}

/*文件大小计量显示*/
function reunit(filesize) {
		var unit;
		filesize=parseInt(filesize);
		if (filesize>1024) {
				filesize=filesize/1024;
				unit="KB"
		}
		if (filesize>1024) {
				filesize=filesize/1024;
				unit="MB"
		}
		if (filesize>1024) {
				filesize=filesize/1024;
				unit="GB"
		}
		return	Math.round(filesize*100)/100+unit;
}

 /*赋值*/

function set_val(name,val){
	if($("#" + name +" option").length>0){
		$("#" + name + " option[value='" + val + "']").attr("selected", "selected");
		return;
	}

	if(($("#" + name).attr("type")) === "checkbox"){
		if(val==1){
			$("#"+name).attr("checked",true);
			return;
		}
	}
	if(($("#" + name).attr("type")) === "text"){
		$("#" + name).val(val);
		return;
	}
	if(($("#" + name).attr("type")) === "hidden"){
		$("#" + name).val(val);
		return;
	}
	if(name == "remark"){
		$("#" + name).val(val);
		return;
	}
}

 /*联系人显示格式转换*/
function contact_conv(val){
	var arr_temp=val.split(";");
	var html="";
	for(key in arr_temp){		
		if (arr_temp[key]!='')
		{
			html+='<span title="'+arr_temp[key].split("|")[1]+'" emp_no="'+arr_temp[key].split("|")[1]+'" onmousedown="return false">'+arr_temp[key].split("|")[0]+';</span>';
		}
	}
	return html;
}

 /*设置要返回的URL*/
function set_return_url(url){
	if (url!=undefined)
	{
		set_cookie("return_url",url);
	}else{
		set_cookie("return_url",document.location);
	}
}

 /*返回到上一页*/
function go_return_url(){
	window.open(get_cookie("return_url"),"_self");
	return false;
}

 /*设置当前节点*/
function set_current_node(key,val){
	set_cookie("current_node_"+key,val);
}

 /*获取当前节点*/
function get_current_node(key){
	return	get_cookie("current_node_"+key);
}

 /*设置 cookie*/
function set_cookie(key, value, exp, path, domain, secure )
 {  
		path="/";
	 var cookie_string = key + "=" + escape ( value );
	 if (exp)
	 {
		 cookie_string += "; expires=" + exp.toGMTString();
	 }
	 if (path)
		 cookie_string += "; path=" + escape(path);
	 if (domain)
		 cookie_string += "; domain=" + escape(domain);
	 if (secure)
		 cookie_string += "; secure";
	 document.cookie = cookie_string;
 }
 
/*读取 cookie*/
function get_cookie(cookie_name)
 {
	 var results =
		 document.cookie.match('(^|;) ?' + cookie_name + '=([^;]*)(;|$)');
	if (results)
		 return (unescape(results[2]));
	 else
		 return null;
 }
 
 /*删除 cookie*/
function delete_cookie(cookie_name)
 {
	 var cookie_date = new Date(); //current date & time
	 cookie_date.setTime(cookie_date.getTime() -1);
	 document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
 }

function winclose(){		
		$("html,body").css("overflow","auto");
		$("div.shade").hide();
		$("#dialog").remove();
}

function fix_url(url){
	var ss=url.split('?');
	url=ss[0]+"?";
	for(var i=1;i<ss.length;i++){
		url+=ss[i]+"&";
	}
	if(ss.length>0){
		url=url.substring(0,url.length-1);
	}
	return url;
}

 function trim(str){ //删除左右两端的空格
     return str.replace(/(^\s*)|(\s*$)/g, "");
 }

 /*打开弹出窗口*/
function winopen(url,w,h){
		url=fix_url(url);
		$("html,body").css("overflow","hidden");
		$("div.shade").show();
		var _body = $("body").eq(0);
		if($("#dialog").length == 0){
			if(!is_mobile()){
				_body.append("<div id=\"dialog\"><iframe src='"+url+"' style='width:"+w+"px;height:100%' scrolling='auto' ></iframe></div>");
				$("#dialog").css({width:w,height:h,position:"fixed","z-index":"101",top:($(window).height()/ 2 - h/2),left:(_body.width() / 2 - w/2),"background-color":"#ffffff"});
			}else{
				$("div.shade").css("width",_body.width());
				_body.append("<div id=\"dialog\"><iframe src='"+url+"' style='width:100%;height:100%' scrolling='auto' ></iframe></div>");
				$("#dialog").css({width:_body.width(),height:h,position:"fixed","z-index":"101",top:0,left:0,"background-color":"#ffffff"});
			}
		}else{
			$("#dialog").show();			
		}
	}

	function dec_mul(num1, num2) {
		var reg = /\./i;
		if (!reg.test(num1) && !reg.test(num2)) {
			return num1 * num2;
		}
		var len = 0,
			str1 = num1.toString(),
			str2 = num2.toString();
		if (str1.indexOf('.') >= 0) {
			len += str1.split('.')[1].length;
		}
		if (str2.indexOf('.') >= 0) {
			len += str2.split('.')[1].length;
		}
		return Number(str1.replace('.', '')) * Number(str2.replace('.', '')) / Math.pow(10, len)　　
	}


    function dec_div(num1, num2) {
    	var reg = /\./i;
    	if (!reg.test(num1) && !reg.test(num2)) {
    		return num1 / num2;
    	}
    	var len1 = 0,
    		len2 = 0;
    	var str1 = num1.toString(),
    		str2 = num2.toString(); //计算位数差 
    	if (str1.indexOf('.') > -1) {
    		len1 = str1.split('.')[1].length;
    	}
    	if (str2.indexOf('.') > -1) {
    		len2 = str2.split('.')[1].length;    		
    	}
    	return dec_mul(Number(str1.replace('.', '')) / Number(str2.replace('.', '')), Math.pow(10, len2 - len1));
    }

    function dec_add(num1, num2) {
    	var reg = /\./i;
    	if (!reg.test(num1) && !reg.test(num2)) {
    		return parseInt(num1) + parseInt(num2);
    	}
    	var r1 = 0,
    		r2 = 0,
    		m;
    	var str1 = num1.toString(),
    		str2 = num2.toString();
    	if (str1.indexOf('.') > -1) {
    		r1 = str1.split('.')[1].length;
    	}
    	if (str2.indexOf('.') > -1) {
    		r2 = str2.split('.')[1].length;
    	}
    	m = Math.pow(10, Math.max(r1, r2));
    	return (dec_mul(num1, m) + dec_mul(num2, m)) / m;
    }

	function formatMoney(numStr,separator){
		s=numStr;
		if (/[^0-9\.\-]/.test(s)) return "　";
		s = s.replace(/^(-)?(\d*)$/, "$1$2.");
		s = (s + "00").replace(/(-)?(\d*\.\d\d)\d*/, "$1$2");
		s = s.replace(".", ",");
		var re = /(\d)(\d{3},)/;
		while (re.test(s)) s = s.replace(re, "$1,$2");
		s = s.replace(/,(\d\d)$/, ".$1");
		return s.replace(/^\./, "0.")
	}

	function formatQty(numStr,separator){
		s=numStr;
		if (/[^0-9\.\-]/.test(s)) return "　";
		s = s.replace(/^(-)?(\d*)$/, "$1$2.");
		s = (s + "00").replace(/(-)?(\d*\.\d\d)\d*/, "$1$2");
		s = s.replace(".", ",");
		var re = /(\d)(\d{3},)/;
		while (re.test(s)) s = s.replace(re, "$1,$2");
		s = s.replace(/,(\d\d)$/, ".$1");
		s=s.replace(/^\./, "0.");
		if(s.split(".")[1]=="00") s=s.split(".")[0];
		return s
	}