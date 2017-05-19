<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
		<meta http-equiv="content-language" content="zh-CN" />
		<title>Digital Rain</title>
		<style type="text/css">
			* {
				margin: 0; 
				padding: 0;
			}
			body {
				background: #000;
			}
		</style>
		<script type="text/javascript">
			window.onload = function () {
				var canvas = document.querySelector('canvas'),
			    ctx = canvas.getContext('2d'),
			    letters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
			    height = canvas.height = window.innerHeight,
			    width = canvas.width = window.innerWidth,
			    font_size = 24,
			    columns = width / font_size,
			    drops = [],
			    frame = 1;

				letters = letters.split("");

				for(var i = 0; i < columns; i++){
				  drops[i] = 1;
				}

				clear();

				function draw(){
				  if(frame == 1){
				    clear();
				    showLetters();
				  }else if(frame == 2){
				    frame = 0;
				  }

				  frame++;
				  window.requestAnimationFrame(draw);
				}

				function showLetters(){
				  ctx.fillStyle = "#0F0";
				  ctx.font = font_size + "px arial";
				  
				  for(var i = 0; i < drops.length; i++){
				      var text = letters[Math.floor(Math.random()*letters.length)];
				      var textPosY = drops[i] * font_size;

				      ctx.fillText(text,i*font_size,textPosY);

				      if(textPosY > height && Math.random() > 0.956){
				        drops[i] = 0;
				      }

				      drops[i]++;
				    }
				}

				function clear(){
				  ctx.fillStyle = 'rgba(0,0,0,0.05)';
				  ctx.fillRect(0,0,width,height);
				}

				window.requestAnimationFrame(draw);
				window.addEventListener('resize', function(){
				  height = canvas.height = window.innerHeight;
				  width = canvas.width = window.innerWidth;
				});
			};
		</script>
	</head>
	<body>
		<canvas></canvas>
	</body>
</html>