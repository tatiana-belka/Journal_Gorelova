<?php
    $r=rand(1000000,9999999);
    
    for($i=0;$i < 7;$i++)
    	$arr[$i]=substr($r,$i,1);
    
    $im=imagecreate(130,40);
    imagecolorallocate($im,255,255,255);
    $a=0;
    for($i=0;$i < 7;$i++)
    {
      $color=imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
      imagestring($im,rand(2,9),$a+=15,rand(0,20),$arr[$i],$color);
    }
    header("Content-type: image/jpeg");
	setcookie('captchaid', $r, 0, '/');
    imagejpeg($im,'',100);
?>
