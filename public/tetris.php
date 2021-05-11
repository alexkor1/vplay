<?php
	if (isset($_POST["token"]))
		if ($_POST["pswd"] == 'technoart')
			file_put_contents('../tkey.txt', $_POST["token"]);

	if (isset($_POST["get"]))
	{
		$key = file_get_contents('../tdata.txt');
		file_put_contents('../tdata.txt', '');
		printt($key);
	}

	$key = file_get_contents('../tkey.txt');
	if (!isset($_GET["scr"]) || $_GET['scr'] != $key)
		exit;

	if (isset($_POST["key"]))
		switch ($_POST['key'])
		{
			case 'UP'   : file_put_contents('../tdata.txt', "1", FILE_APPEND); exit;
			case 'DOWN' : file_put_contents('../tdata.txt', "2", FILE_APPEND); exit;
			case 'LEFT' : file_put_contents('../tdata.txt', "3", FILE_APPEND); exit;
			case 'RIGHT': file_put_contents('../tdata.txt', "4", FILE_APPEND); exit;
			case 'START': file_put_contents('../tdata.txt', "S", FILE_APPEND); exit;
		}
?>
 <html lang="en" style="height: 100%;">
 <head>
 	<meta charset="utf-8" />
 	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
 	<title>Untitled</title>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://coliff.github.io/dark-mode-switch/dark-mode.css">

 </head>
 <body style="height: 100%;">
 	<div class="container user-select-none" style="height: 100%;">
 		<div class="row" style="height: 20%;">
 			<div class="col text-center" style="height: 100%;">
 				<p class="lead d-xl-flex justify-content-xl-center align-items-xl-center" style="height: 100%;font-size: 46px;">TechnoArt</p>
 			</div>
 		</div>
 		<div class="row" style="height: 20%;">
 			<div class="col" style="height: 100%;padding-bottom: 4px;">
 				<button class="btn btn-dark btn-block" type="button" style="height: 100%;" onclick="sendkey('UP');">▴Up</button>
 			</div>
 		</div>
 		<div class="row" style="height: 20%;">
 			<div class="col" style="padding-right: 2px;height: 100%;">
 				<button class="btn btn-dark btn-block" type="button" style="height: 100%;" onclick="sendkey('LEFT');">◂Left</button>
 			</div>
 			<div class="col" style="padding-left: 2px;height: 100%;">
 				<button class="btn btn-dark btn-block" type="button" style="height: 100%;" onclick="sendkey('RIGHT');">Right▸</button>
 			</div>
 		</div>
 		<div class="row" style="height: 20%;">
 			<div class="col" style="height: 100%;padding-top: 4px;">
 				<button class="btn btn-dark btn-block" type="button" style="height: 100%;" onclick="sendkey('DOWN');">Down▾</button>
 			</div>
 		</div>
 		<div class="row" style="height: 20%;">
 			<div class="col text-center" style="height: 100%; padding-top: 15px;">
 				<button class="btn btn-dark" type="button" onclick="sendkey('START');">     START     </button>
 			</div>
 		</div>
 	</div>
 </body>
 </html>
<script>

function mgetAllUrlParams() {
  var queryString = window.location.search.slice(1);
  var obj = {};
  if (queryString) {
    queryString = queryString.split('#')[0];
    var arr = queryString.split('&');
    for (var i = 0; i < arr.length; i++) {
      var a = arr[i].split('=');
      var paramName = a[0];
      var paramValue = typeof (a[1]) === 'undefined' ? true : a[1];
      paramName = paramName.toLowerCase();
      if (typeof paramValue === 'string') paramValue = paramValue.toLowerCase();
      if (paramName.match(/\[(\d+)?\]$/)) {
        var key = paramName.replace(/\[(\d+)?\]/, '');
        if (!obj[key]) obj[key] = [];
        if (paramName.match(/\[\d+\]$/)) {
          var index = /\[(\d+)\]/.exec(paramName)[1];
          obj[key][index] = paramValue;
        } else {
          obj[key].push(paramValue);
        }
      } else {
        if (!obj[paramName]) {
          obj[paramName] = paramValue;
        } else if (obj[paramName] && typeof obj[paramName] === 'string'){
          obj[paramName] = [obj[paramName]];
          obj[paramName].push(paramValue);
        } else {
          obj[paramName].push(paramValue);
        }
      }
    }
  }
  return obj;
}    

function sendkey(a)
{
    var data = new FormData();
    data.append('key', a);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/tetris.php?scr='+mgetAllUrlParams(window.location.search.slice(1)).scr, true);
    xhr.onload = function () {};
    xhr.send(data);
}
</script>>