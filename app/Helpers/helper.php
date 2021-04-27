<?php


function formatMoney($s,$dec=2){
	return str_replace('.00','',number_format((float)$s,$dec,'.',','));
}
function slug($s){
	$s = strtolower($s);
	return str_replace(' ', '-', $s);
}
function formatPhone($s){
    if(strlen($s)>1){
        $s = preg_replace('/[^0-9]+/', '', $s);
        if($s[0]=='0'){
            $s = '62'.substr($s, 1);
        }
        if($s[0]=='8'){
            $s = '62'.$s;
        }

    }
    return $s;
}
function compress_image($source_url, $destination_url, $quality=100)
{
    // $info = getimagesize($source_url);
    // if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
    // elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
    // elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
    // imagejpeg($image, $destination_url, $quality);
    // $type='jpg';
    // $info = getimagesize($source_url);
    // if ($info['mime'] == 'image/jpeg') $type = 'jpg';
    // elseif ($info['mime'] == 'image/gif') $type = 'gif';
    // elseif ($info['mime'] == 'image/png') $type = 'png';
    // // imagejpeg($image, $destination_url, $quality);

    $im = new Imagick();
    $im->readImage($source_url);
    $im->setImageCompressionQuality($quality);
    // $im->setImageFormat($type);
    $profiles = $im->getImageProfiles("icc", true);
    $im->stripImage();
    if(!empty($profiles)) $im->profileImage("icc", $profiles['icc']);
    $im->writeImage($destination_url);
    $im->destroy();
}
function compress_upload($source){
	$try=0;
	// while (filesize($source) > (2*1024*1024)) {
		// $try++;
		// if($try>10) break;
	compress_image($source,$source,90);

	// }
    generateWebP($source);
	return $source;
}
function generate_preview($source,$width){

	$ext = pathinfo($source, PATHINFO_EXTENSION);
	$preview_file = $source.'_preview.'.$ext;
	if($width>0){
		resizePicture($source,$preview_file,$width,true);
	}
	// compress_image($source,$preview_file,100);
	// $try=0;
	// while (filesize($preview_file) > (300*1024)) {
	// 	$try++;
	// 	if($try>15) break;
	// 	compress_image($preview_file,$preview_file,50);

	// }

	return $preview_file;
}
function formatDate($date){
	if(empty($date)){
		return '';
	}
	return date("d M, Y H:i",strtotime($date));
}
function deleteImage($path){
    @unlink($path);
    @unlink($path.'.webp');
}
function generateWebP($path){
    $size = getimagesize($path);
     switch($size['mime']) {
        case 'image/jpeg':
            $picture = imagecreatefromjpeg($path);
        break;
        case 'image/png':
            $picture = imagecreatefrompng($path);
        break;
        case 'image/gif':
            $picture = imagecreatefromgif($path);
        break;
        default:
            return false;
        break;
    }
    try{
        imagewebp($picture,$path.'.webp');
    }catch(ErrorException $e){
        echo "ERROR :".$path.PHP_EOL;
    }
}
function resizePicture($path, $new_path,$new_width, $proportion = false) {
    // $im = new Imagick();
    // $im->readImage($source_url);
    // $im->setImageCompressionQuality($quality);
    // // $im->setImageFormat($type);
    // $im->stripImage();
    // if(!empty($profiles)) $im->profileImage("icc", $profiles['icc']);
    // $im->writeImage($destination_url);
    // $im->destroy();


    $im = new Imagick($path);
    $im->setImageCompressionQuality(40);
    $profiles = $im->getImageProfiles("icc", true);
    $im->stripImage();
    if(isset($profiles['icc'])){
        $im->profileImage("icc", $profiles['icc']);
    } 
    $im->thumbnailImage($new_width,null);
    $im->writeImage($new_path);
    if(!isset($profiles['icc'])){
        $im->setImageFormat('webp');
        $im->writeImage($new_path.'.webp');
    }
    // $size = getimagesize($path);
    // $x = 0;
    // $y = 0;

    // switch($size['mime']) {
    //     case 'image/jpeg':
    //         $picture = imagecreatefromjpeg($path);
    //     break;
    //     case 'image/png':
    //         $picture = imagecreatefrompng($path);
    //     break;
    //     case 'image/gif':
    //         $picture = imagecreatefromgif($path);
    //     break;
    //     default:
    //         return false;
    //     break;
    // }

    // $width = $size[0];
    // $height = $size[1];

    
    // $new_height=$new_width*($height/$width);
    // $frame = imagecreatetruecolor($new_width, $new_height);
    // if($size['mime'] == 'image/jpeg') {
    //     $bg = imagecolorallocate($frame, 255, 255, 255);
    //     imagefill($frame, 0, 0, $bg);
    // } else if($size['mime'] == 'image/gif' or $size['mime'] == 'image/png') {
    //     imagealphablending($picture, false);
    //     imagesavealpha($picture, true);
    //     imagealphablending($frame, false);
    //     imagesavealpha($frame, true);
    // }
    // // imagecopyresampled(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h);
    // imagecopyresampled($frame, $picture, $x, $y, 0, 0, $new_width, $new_height, $width, $height);


    // switch($size['mime']) {
    //     case 'image/jpeg':
    //         imagejpeg($frame, $new_path, 85);
    //     break;
    //     case 'image/png':
    //         imagepng($frame, $new_path, 80);
    //     break;
    //     case 'image/gif':
    //         imagegif($frame, $new_path);
    //     break;
    //     default:
    //         return false;
    //     break;
    // }
    // imagewebp($frame,$new_path.'.webp');
    return $new_path;

}
function active_class($path, $active = 'active') {
  return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function is_active_route($path) {
  return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
}

function show_class($path) {
  return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
}