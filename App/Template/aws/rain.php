<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
		<meta http-equiv="content-language" content="zh-CN" />
		<title>Rain</title>
		<script type="text/javascript" src="<?= JS . "rainyday.min.js"?>"></script>
		<style type="text/css">
			* {
				margin: 0; 
				padding: 0;
			}
			body {
				background: #FFF;
			}
		</style>
		<script>
			window.onload = function () {
				var image = document.createElement('img');
				image.style.width = "100%";
				image.style.height = "100%";
				image.crossOrigin = 'anonymous';
				image.src = 'http://i.imgur.com/U1Tqqdw.jpg';

				document.body.appendChild(image);
                image.onload = function() {
                    var engine = new RainyDay({
                        image: this
                    });
					engine.rain([[3, 2, 2]], 100);

					image.parentNode.removeChild(image);
				};

				automaticFullScreen();

				function automaticFullScreen() {
					var isScree = false;

					function fullScreen() {
					  var el = document.documentElement;
					  var rfs = el.requestFullScreen || el.webkitRequestFullScreen ||
					      el.mozRequestFullScreen || el.msRequestFullScreen;
					  if(typeof rfs != "undefined" && rfs) {
					    rfs.call(el);
					  } else if(typeof window.ActiveXObject != "undefined") {
					    var wscript = new ActiveXObject("WScript.Shell");
					    if(wscript != null) {
					        wscript.SendKeys("{F11}");
					    }
					  }
					}

					function exitFullScreen() {
					  var el = document;
					  var cfs = el.cancelFullScreen || el.webkitCancelFullScreen ||
					      el.mozCancelFullScreen || el.exitFullScreen;
					  if(typeof cfs != "undefined" && cfs) {
					    cfs.call(el);
					  } else if(typeof window.ActiveXObject != "undefined") {
					    var wscript = new ActiveXObject("WScript.Shell");
					    if(wscript != null) {
					        wscript.SendKeys("{F11}");
					    }
					  }
					}

					document.addEventListener('click', function () {
						if (isScree) {
							exitFullScreen();
							isScree = false;
						} else {
							fullScreen();
							isScree = true;
						}
					}, false);

					document.addEventListener('keydown', function (e) {
						if (e.keyCode == 122) { //F11
							if (isScree) {
								isScree = false;
							} else {
								isScree = true;
							}
						} else if (e.keyCode == 27) { //Esc
							isScree = false;
						}
					}, false);
				}

				setTimeout(function () {
					var W = parseInt(window.screen.width), H = parseInt(window.screen.height);
					var content = document.getElementsByTagName('canvas')[0];
					content.width = W;
					content.height = H;
				}, 3000);


				setTimeout(function () {
					window.location.href = "aigitalrain";
				}, 10000);
			};
		</script>
	</head>
	<body></body>
</html>