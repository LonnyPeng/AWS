$.ajaxSetup({abortOnRetry:!0});var currentRequests={};$.ajaxPrefilter(function(options,originalOptions,jqXHR){options.abortOnRetry&&(currentRequests[options.url]&&currentRequests[options.url].abort(),currentRequests[options.url]=jqXHR)}),$.ajaxTransport("json",function(options,origOptions,jqXHR){if(origOptions.files){if("undefined"!=typeof FormData){for(var xhr=new XMLHttpRequest,fd=new FormData,uploadFiles=$(options.files).filter(":file:enabled"),filterFiles=new Array,i=0;i<uploadFiles.length;i++)tempfile=uploadFiles[i].files[0],tempName=$(uploadFiles[i]).attr("name"),tempfile&&(filterFiles[tempName]=tempfile,fd.append(tempName,tempfile));return $.each(origOptions.data,function(i,field){fd.append(field.name,field.value)}),fd.append("X-Requested-With","XMLHttpRequest"),{send:function(headers,completeCallback){xhr.open("POST",options.url,!0),xhr.onload=function(){var allResponseHeaders="Content-Length: "+xhr.responseText.length+"\r\nContent-Type: "+xhr.contentType,status={code:200,message:"success"},responses={text:xhr.responseText};200==this.status&&completeCallback(status.code,status.message,responses,allResponseHeaders)},xhr.send(fd)},abort:function(){xhr.abort()}}}var form=null,iframe=null,name="iframe-"+$.now(),files=$(options.files).filter(":file:enabled"),markers=null,cleanUp=function(){markers.replaceWith(function(idx){return files.get(idx)}),form.remove(),iframe.attr("src","javascript:false;").remove()};return options.dataTypes.shift(),files.length?(form=$("<form enctype='multipart/form-data' method='post'></form>").hide().attr({action:options.url,target:name}),"string"==typeof origOptions.data&&origOptions.data.length>0&&alert("Invalid data format"),$.each(origOptions.data||{},function(name,value){$.isPlainObject(value)&&(name=value.name,value=value.value),$("<input type='hidden'>").attr({name:name,value:value}).appendTo(form)}),$("<input type='hidden' value='XMLHttpRequest' name='X-Requested-With'>").appendTo(form),markers=files.after(function(idx){return $(this).clone().prop("disabled",!0)}).next(),files.appendTo(form),{send:function(headers,completeCallback){iframe=$("<iframe src='javascript:false;' name='"+name+"' style='display:none'></iframe>"),iframe.bind("load",function(){iframe.unbind("load").bind("load",function(){var doc=this.contentWindow?this.contentWindow.document:this.contentDocument?this.contentDocument:this.document,root=doc.documentElement?doc.documentElement:doc.body,textarea=root.getElementsByTagName("textarea")[0],type=textarea?textarea.getAttribute("data-type"):null,content={text:type?textarea.value:root?root.textContent||root.innerText:null};cleanUp(),completeCallback(200,"OK",content,type?"Content-Type: "+type:null)}),form[0].submit()}),$("body").append(form,iframe)},abort:function(){null!==iframe&&(iframe.unbind("load").attr("src","javascript:false;"),cleanUp())}}):void 0}}),$.fn.ajaxJson=function(json){if(!json||!json.status)return $.status("Invalid Request"),!1;var redirect=function(){return!!json.redirect&&void("reload"==json.redirect?window.location=window.location.href:"referer"==json.redirect?window.referrer?window.location=window.referrer:history.go(-1):"back"==json.redirect?history.go(-1):window.location=json.redirect)};if(json.tipContext&&json.msg){var tip=eval(json.tipContext);tip.after("<span class='tip-error' id='field-tip-"+tip.attr("name")+"'><i class='fa fa-times'></i>"+json.msg+"</span>"),tip.focus()}else"ok"!=json.status&&"error"!=json.status||json.msg&&(json.redirect?$.status(json.msg):"ok"==json.status?$.status(json.msg):$.warning(json.msg));json.script&&eval(json.script),json.callback&&eval(json.callback).call(json.context||this,json.data),json.redirect&&(void 0===json.delay&&(json.delay=json.msg?2:0),setTimeout(redirect,1e3*json.delay))},$.fn.ajaxError=function(){},$.fn.ajaxComplete=function(){},$.fn.ajaxAuto=function(settings){"function"==typeof settings&&(settings={success:settings});var tagName=$(this).get(0).tagName;"FORM"!==tagName?$(this).ajaxLink(settings):$(this).attr("enctype")?$(this).ajaxUpload(settings):$(this).ajaxForm(settings)},$.fn.ajaxLink=function(settings){"function"==typeof settings&&(settings={success:settings}),settings=$.extend({},$.ajaxSettings,settings),this.each(function(){var url=$(this).attr("href");void 0===url&&(url=$(this).data("href"));var context=$(this),disableContext=function(){context.attr("disabled","disabled").addClass("processing")},enableContext=function(){context.removeAttr("disabled","disabled").removeClass("processing")};void 0!==url&&(settings.url=url),settings.dataType="json",settings.beforeSend=function(){disableContext(),settings.before&&settings.before()};var $$=$(this),success=settings.success;settings.success=function(json){$$.ajaxJson(json),success&&success(json),void 0!==json.redirect&&json.redirect||enableContext()},$.ajax(settings).always(function(json){settings.complete&&settings.complete(),void 0!==json.redirect&&json.redirect||enableContext()})})},$.fn.ajaxForm=function(settings){"function"==typeof settings&&(settings={success:settings}),settings=$.extend({},$.ajaxSettings,settings);var context=$(this),formBtn=context.find("button[type=submit]").eq(0),disableBtn=function(){formBtn.attr("disabled","disabled").addClass("processing")},enableBtn=function(){formBtn.removeAttr("disabled").removeClass("processing")};settings.context&&(context=settings.context),$.ajax({type:$(this).attr("method"),url:$(this).attr("action"),data:$(this).serialize(),dataType:settings.dataType?settings.dataType:"json",beforeSend:function(){disableBtn(),settings.before&&settings.before()}}).done(function(json){context.ajaxJson(json),settings.success&&settings.success(json),void 0!==json.redirect&&json.redirect||enableBtn()}).fail(function(){context.ajaxError(),settings.error&&settings.error()}).always(function(json){context.ajaxComplete(),settings.complete&&settings.complete(),void 0!==json.redirect&&json.redirect||enableBtn()})},$.fn.ajaxUpload=function(settings){"function"==typeof settings&&(settings={success:settings}),settings=$.extend({},$.ajaxSettings,settings);var context=this,formBtn=$(context).find("button[type=submit]").eq(0),disableBtn=function(){formBtn.attr("disabled","disabled")},enableBtn=function(){formBtn.removeAttr("disabled")};settings.context&&(context=settings.context),$.ajax({url:this.attr("action"),type:"POST",data:this.serializeArray(),files:$(":file",this),dataType:"json",beforeSend:function(){disableBtn(),settings.before&&settings.before()}}).done(function(json){"string"==typeof json&&(json=eval("("+json+")")),context.ajaxJson(json),settings.success&&settings.success(json),void 0!==json.redirect&&json.redirect||enableBtn()}).fail(function(){context.ajaxError(),settings.error&&settings.error()}).always(function(){context.ajaxComplete(),settings.complete&&settings.complete()})};
//# sourceMappingURL=../maps/js/core.ajaxauto.js.map
