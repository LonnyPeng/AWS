var page=require("webpage").create(),system=require("system"),fs=require("fs"),ajaxUrl="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js";page.viewportSize={width:window.screen.width,height:window.screen.height},page.zoomFactor=1,page.open(system.args[1],function(status){if("success"===status){var body=page.evaluate(function(){return document.getElementsByTagName("html")[0].getBoundingClientRect()}),isJQ=page.evaluate(function(){return"function"==typeof jQuery}),action=function(){page.evaluate(function(){$(document).ready(function(){$("body").trigger("mouseenter")})})};isJQ?action():page.includeJs(ajaxUrl,function(){action()}),page.clipRect={top:body.top,left:body.left,width:body.width,height:body.height},page.render(system.args[2]),fs.write(system.args[3],page.content,"w"),page.close(),phantom.exit()}});
//# sourceMappingURL=../maps/js/save_img.js.map
