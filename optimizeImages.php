<?php
ini_set('memory_limit', '512M');
ini_set('max_execution_time', '0');
	
/*optimizeimage("00000123590.jpg");
optimizeimage("test.jpg");
optimizeimage("no_photo.png");
optimizeimage("1.png");
*/

$dir    = './';
$files1 = scandir($dir);
//print_r($files1);
foreach($files1 as $filename){
 if(($filename!=".")AND($filename!="..")){
	echo "found new file=".$filename."\n";
	optimizeimage($filename);
 }
}














function optimizeimage($filename){
	$size = getimagesize($filename);
	$fp = fopen($filename, "rb");
	if ($size && $fp) {
		print_r($size);
		if(stristr($size['mime'],"jpeg")!==FALSE){
			echo "jpg detected\n";
			$x=(int)$size[0];
			$y=(int)$size[1];
			$ratio = 1920/$x;
			$height = round($y*$ratio);
			echo "x=".$x."\n y=".$y."\n";
			if(($x>1920)AND($y>0)){
				echo "\n!!!!!!!!!!!!!\n".$filename." oversized detected, new size=1920x".$height."\n===================\n";
				fclose($fp);
				$image_src1 = imagecreatefromjpeg($filename);
				$iOut = imagecreatetruecolor(1920, $height);
				//imagescale($image_src1,1920,$height,IMG_BICUBIC);
				imagecopyresized($iOut, $image_src1, 0, 0, 0, 0, 1920, $height, $x, $y);
				imagejpeg($iOut,$filename,3);
			}
		}elseif(stristr($size['mime'],"png")!==FALSE){
			echo "png detected\n";
			$x=(int)$size[0];
			$y=(int)$size[1];
			$ratio = 1920/$x;
			$height = round($y*$ratio);
			echo "x=".$x.", y=".$y."\n";
			if(($x>1920)AND($y>0)){
				echo "\n!!!!!!!!!!!!!\n".$filename." oversized detected, new size=1920x".$height."\n===================\n";
				fclose($fp);
				$image_src1 = imagecreatefrompng($filename);
				$iOut = imagecreatetruecolor(1920, $height);
				//imagescale($image_src1,1920,$height,IMG_BICUBIC);
				imagecopyresized($iOut, $image_src1, 0, 0, 0, 0, 1920, $height, $x, $y);
				imagepng($iOut,$filename,3);
			}
		}
		//fpassthru($fp);
	} else {
		// error
	}
}
?>
