/*
 * 添加当前页面浮动图标
 */
function (this) {
	var $$ = $(this);
	var lr = tb = true;
	window.setInterval(function () {
		var browserInfo = {width: window.innerWidth, height: window.innerHeight},
			inputInfo = {width: $$.width(), height: $$.height()},
			left = parseInt($$.css('left')),
			top = parseInt($$.css('top'));

		if (lr) {
			if (left < browserInfo.width - inputInfo.width) {
				left = left + 1 + 'px';
			} else {
				lr = false;
			}
		} else {
			if (left > 0) {
				left = left - 1 + 'px';
			} else {
				lr = true;
			}
		}

		if (tb) {
			if (top < browserInfo.height - inputInfo.height) {
			    top = top + 1 + 'px';
			} else {
			    tb = false;
			}
		} else {
			if (top > 0) {
			    top = top - 1 + 'px';
			} else {
			    tb = true;
			}
		}

		$$.css({
			left: left,
			top: top,
		});
	}, 50);
}

/*
 * 解析 URL 信息
 */
function getUrlInfo(url) {
    var params = {};
    url = url.split("?");
    if (url[1] != undefined) {
        $(url[1].split("&")).each(function (key, value) {
            value = value.split("=");
            if (value[1] != undefined) {
                params[value[0]] = value[1];
            } else {
                params[value[0]] = "";
            }
        });
    }

    return {
        'host': url[0],
        'params': params,
    };
}

/*
 * 获取 URL 链接
 */
function getUrl(urlInfo) {
    var url = "";

    if (urlInfo.host != undefined) {
        url += urlInfo.host;
    }

    if (urlInfo.params != undefined) {
        url += "?";
        for(key in urlInfo.params) {
            if (!/\?$/.test(url)) {
                url += "&";
            }
            url += key + "=" + urlInfo.params[key];
        }
    }

    return url;
}

/*
 * 跳过当前页面，不加入缓存
 */
function fnUrlReplace(eleLink) {
	var link = eleLink;
	var linkInfo = getUrlInfo(link);
	link = getUrl(linkInfo);

	if (history.replaceState) {
	    history.replaceState(null, document.title, link.split('#')[0] + '#');
	    location.replace('');
	} else {
	    location.replace(link);
	}
};

/*
 * 加载 JQuery
 */
function loadScript(callback) {
	var script = document.createElement("script");
	script.type = "text/javascript";
	if(typeof(callback) != "undefined"){
		if (script.readyState) {
			script.onreadystatechange = function () {
				if (script.readyState == "loaded" || script.readyState == "complete") {
					script.onreadystatechange = null;
					callback();
				}
			};
		} else {
			script.onload = function () {
				callback();
			};
		}
	}
	script.src = "https://code.jquery.com/jquery-3.2.0.min.js";
	document.body.appendChild(script);
}
