<html>
<head>
<title>Soundcloud Gettin Reallink</title>
</head>
<body style="margin: 0;">
<form method="post">
  <input name="tracks" placeholder="Insert tracks here" style="
    margin-left: 25%;
    margin-top: 20px;
    margin-bottom: 30px;
    margin-right: 25%;
    width: 50%;
    height: 30px;
   ">
</form>
<?php
if(!empty($_POST['tracks'])){
  
  if(strpos($_POST['tracks'], "/sets/")){ echo "Sorry i cant handdle playlist,YET!"; }
  
  elseif(preg_match("/http(s)?:\/\/soundcloud\.com\/.*\/.*(\/)?/", $_POST['tracks'])){
    
    $object = explode("/", parse_url($_POST['tracks'], PHP_URL_PATH));
    
    $object[2] = str_replace("-", " ", $object[2]);
    
    $trackNames = ucwords($object[1]." - ".$object[2]);
    
    $object = json_decode(curl("http://soundcloud.com/oembed?format=json&url=".$_POST['tracks']));
    
    preg_match("/url=(.*)&show/", $object->{"html"}, $object);
    
    $object = json_decode(curl(urldecode($object[1])."/streams?client_id=6964960b77da97eb01b0c0e4f8b88547&format=json"));
    
    echo "<a href='".$object->{"http_mp3_128_url"}."' style='margin: 25%;'>".$trackNames."</a>";
    
  }else{ echo "Im sorry im just fuckedup"; }
}


function curl($url, $post = ""){
  $ch = @curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  //curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.28 (KHTML, like Gecko) Chrome/26.0.1397.2 Safari/537.28');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt ($ch, CURLOPT_HTTPHEADER, array('If-None-Match:"b733b19cdfb59a208b9b2dd6a06e865b"'));
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
  $page = curl_exec( $ch);
  curl_close($ch);
  return $page;
}
?>
</body>
</html>
