<?php
declare(strict_types=1);

class UploadImg{
	
	private static $filename;
	private static $filetype;
	private static $filesize;
	private static $filepath;
	private static $errorcode;
	private static $width;
	private static $height;
	private static $relation;
	private static $new_image;
	
	private static $user_id;
	private static $token;
	private static $mainFileUrl;
	

	public static function setfile(array $file, string $token, int $user_id): bool{
		if(($file['error'] === "0") or ($file['size'] > 5*1024*1024))
			return false;
		
		self::$user_id = $user_id;
		self::$token = $token; 
			
		self::$filename = $file['name'];
		self::$filesize = $file['size'];
		
		self::$filepath = $file['tmp_name'];
		
		return true;
	}
	
	public static function checkUpload():bool{
		if(self::$errorcode !== UPLOAD_ERR_OK || !is_uploaded_file(self::$filepath)){
			return true;
		}
		return false;
	}
	
	public static function checkFormat():bool{
		$fi = finfo_open(FILEINFO_MIME_TYPE);
        self::$filetype = (string) finfo_file($fi, self::$filepath);
        finfo_close($fi);
		if((strpos(self::$filetype, 'image/png') === false) and (strpos(self::$filetype, 'image/jpg') === false) and (strpos(self::$filetype, 'image/gif') === false) and (strpos(self::$filetype, 'image/jpeg') === false)) {
              return false;
        }
		return true;
	}
	
	public static function createTempImage():bool{
		if(self::$filetype == 'image/png') {
            self::$filepath = imagecreatefrompng(self::$filepath);
        }
        elseif(self::$filetype == 'image/jpg' or self::$filetype == 'image/jpeg') {
            self::$filepath = imagecreatefromjpeg(self::$filepath);
        }
        elseif(self::$filetype == 'image/gif') {
            self::$filepath = imagecreatefromgif(self::$filepath);
        }else {
          return false;
        }	
		return true;
	}

	public static function checkDimension():bool{
		self::$width = imageSX(self::$filepath);
		self::$height = imageSY(self::$filepath);
		self::$relation = self::$width / self::$height;
		if((self::$width < 400) or (self::$height < 400) or (self::$width > 4000) or (self::$height > 4000) or (self::$relation > 2) or (self::$relation < 0.5)){
			return false;
		}

		return true;

	}

	public static function resizeImage():bool{
		$new_width = 400;
		$new_height = intval(400 / self::$relation);

		self::$new_image = imageCreateTrueColor($new_width, $new_height);
		imageCopyResampled(self::$new_image, self::$filepath, 0, 0, 0, 0, $new_width, $new_height, self::$width, self::$height);
		return true;

		
	}
	private static function fixDirectories(string $r_dir, string $i_dir):bool{
		if(file_exists(__DIR__."./".$r_dir) and is_dir(__DIR__."./".$r_dir)){
			if(!file_exists(__DIR__."./".$r_dir."/".$i_dir) or !is_dir(__DIR__."./".$r_dir."/".$i_dir)){
				mkdir(__DIR__."./".$r_dir."/".$i_dir, 0777, true);
			}
		}else{
			mkdir(__DIR__."./".$r_dir, 0777, true);
			mkdir(__DIR__."./".$r_dir."/".$i_dir, 0777, true);
		};
		return true;
	}
	public static function saveImg(): string{
		self::$mainFileUrl = "";
		$pathstring = md5(self::$token."".self::$user_id.time())."a".self::$user_id.".jpg";
		$root_dir = substr($pathstring, 0, 2);
		$internal_dir = substr($pathstring, 2, 2);
		$filename = substr($pathstring, 4);
		 
		if(self::fixDirectories($root_dir,$internal_dir)){
			self::$mainFileUrl = $root_dir."/".$internal_dir."/".$filename;
			 
			if(imagejpeg(self::$new_image, self::$mainFileUrl, 100)){
				return self::$mainFileUrl;
			}
		}
		return "";
		
	}
}