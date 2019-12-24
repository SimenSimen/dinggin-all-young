<?php
class Upload_model extends MY_Model {

	public function __construct()
	{
		$this->load->database();
	}

	//上傳一般圖檔 以plupload取代了
	public function uploadImage($imgFile, $r_width=330, $r_height=440)//$_FILES['image']
	{
		$imagePathDir = $imgFile['path'];

		/*上傳圖片文件類型列表 */
		$uptypes = array (
			'image/jpg',
			'image/jpeg',
			'image/pjpeg',
			'image/gif',
			'image/png'
		);
		
		/*產生唯一的檔案名稱*/
		$imgName = md5(uniqid(rand())) . '.jpg';
		
		/*檢查檔案大小 5Mb*/
		// if ($imgFile['size'] > 5242880)
		// {
		// 	$data=array(
		// 		"error" => '檔案過大, 檔案限制 : 5Mb'
		// 	);
		// 	return $data;
		// }
		/*檢查文件類型 */
		if(in_array($imgFile['type'], $uptypes))
		{
			/*上傳圖片類型為jpg,pjpeg,jpeg */
			if (strstr($imgFile['type'], "jp"))
			{
				if(!($source = @ imageCreatefromjpeg($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
			  /*上傳圖片類型為png */
			}
			elseif(strstr($imgFile['type'], "png"))
			{
				if(!($source = @ imagecreatefrompng($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
				/*上傳圖片類型為gif */
			}
			elseif(strstr($imgFile['type'], "gif"))
			{
				if(!($source = @ imagecreatefromgif($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
			  /*其他例外圖片排除 */
			}
			else
			{
			  	$data=array(
					"error" => '檔案類型錯誤'
				);
			 	return $data;
			}
			$w = imagesx($source); /*取得圖片的寬 */
			$h = imagesy($source); /*取得圖片的高 */
			
			/* 儲存到檔案目錄(JPG) */
			imagejpeg($source, $imagePathDir . $imgName);
			/* 檔案resize */
			$newImage=$this->resizeImage($imagePathDir . $imgName, $r_width, $r_height);
			/* 檔案resize存檔 */
			imagejpeg($newImage, $imagePathDir.'c'.$imgName);

			imagejpeg($source, $imagePathDir.$imgName);
			/* 檔案resize */
			$newImage=$this->setImage($imagePathDir.$imgName, 150, 150);
			/* 檔案resize存檔 */
			imagejpeg($newImage, $imagePathDir.'s'.$imgName);
			
			//刪除原始圖檔
			unlink($imagePathDir . $imgName);

			//圖檔資訊回傳
			$data=array(
				"path"	=>  $imagePathDir.'c'.$imgName,
				"size" 	=>	filesize($imagePathDir.'c'.$imgName),
				"error" => 	''
			);

			return $data;
		}
		else
		{
			$data=array(
				"error" => '檔案類型錯誤'
			);
			return $data;
		}
	}

	//上傳icon 單檔
	public function uploadIcon($imgFile, $path, $r_width=120, $r_height=120)
	{
		$imagePathDir = $path.'icon/';

		if(!is_dir($imagePathDir))
			mkdir($imagePathDir, 0755);

		/*上傳圖片文件類型列表 */
		$uptypes = array (
			'image/jpg',
			'image/jpeg',
			'image/pjpeg',
			'image/gif',
			'image/png'
		);
		
		/*產生唯一的檔案名稱*/
		$pos=strpos($imgFile['type'], '/');
		$ext=substr($imgFile['type'], $pos+1);
		$imgName = 'icon.'.$ext;

		//刪除原始檔
		$icon = glob($imagePathDir."{*.gif,*.jpg,*.jpeg,*.png,*.GIF,*.JPG,*.PNG}", GLOB_BRACE);
		if(is_file($icon[0]))
			unlink($icon[0]);
		
		/*檢查文件類型 */
		if(in_array($imgFile['type'], $uptypes))
		{
			/*上傳圖片類型為jpg,pjpeg,jpeg */
			if (strstr($imgFile['type'], "jp"))
			{
				if(!($source = @ imageCreatefromjpeg($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
			  /*上傳圖片類型為png */
			}
			elseif(strstr($imgFile['type'], "png"))
			{
				if(!($source = @ imagecreatefrompng($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
				/*上傳圖片類型為gif */
			}
			elseif(strstr($imgFile['type'], "gif"))
			{
				if(!($source = @ imagecreatefromgif($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
			  /*其他例外圖片排除 */
			}
			else
			{
			  	$data=array(
					"error" => '檔案類型錯誤'
				);
			 	return $data;
			}
			$w = imagesx($source); /*取得圖片的寬 */
			$h = imagesy($source); /*取得圖片的高 */

			$icon = glob($imagePathDir."{*.gif,*.jpg,*.png,*.GIF,*.JPG,*.PNG}", GLOB_BRACE);
			if(is_file($imagePathDir.$icon[0]))
				unlink($imagePathDir.$icon[0]);
		
			/* 儲存到檔案目錄(JPG) */
			imagejpeg($source, $imagePathDir.$imgName);
			/* 檔案resize */
			$newImage=$this->resizeImage($imagePathDir.$imgName, $r_width, $r_height);
			/* 檔案resize存檔 */
			imagejpeg($newImage, $imagePathDir.$imgName);
		}
		else
		{
			$data=array(
				"error" => '檔案類型錯誤'
			);
			return $data;
		}
	}

	//上傳背景圖
	public function uploadBgimg($imgFile, $path, $r_width=1080, $r_height=1920)
	{
		$imagePathDir = $path.'bgimg/';

		if(!is_dir($imagePathDir))
			mkdir($imagePathDir, 0755);

		/*上傳圖片文件類型列表 */
		$uptypes = array (
			'image/jpg',
			'image/jpeg',
			'image/pjpeg',
			'image/gif',
			'image/png'
		);
		
		/*產生唯一的檔案名稱*/
		$pos=strpos($imgFile['type'], '/');
		$ext=substr($imgFile['type'], $pos+1);
		$imgName = 'bgimg.'.$ext;

		if(is_file($imagePathDir . $imgName))
			unlink($imagePathDir . $imgName);
		
		/*檢查文件類型 */
		if(in_array($imgFile['type'], $uptypes))
		{
			/*上傳圖片類型為jpg,pjpeg,jpeg */
			if (strstr($imgFile['type'], "jp"))
			{
				if(!($source = @ imageCreatefromjpeg($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
			  /*上傳圖片類型為png */
			}
			elseif(strstr($imgFile['type'], "png"))
			{
				if(!($source = @ imagecreatefrompng($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
				/*上傳圖片類型為gif */
			}
			elseif(strstr($imgFile['type'], "gif"))
			{
				if(!($source = @ imagecreatefromgif($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
			  /*其他例外圖片排除 */
			}
			else
			{
			  	$data=array(
					"error" => '檔案類型錯誤'
				);
			 	return $data;
			}
			$w = imagesx($source); /*取得圖片的寬 */
			$h = imagesy($source); /*取得圖片的高 */
			
			/* 儲存到檔案目錄(JPG) */
			imagejpeg($source, $imagePathDir.$imgName);
			/* 檔案resize */
			$newImage=$this->resizeImage($imagePathDir.$imgName, $r_width, $r_height);
			/* 檔案resize存檔 */
			imagejpeg($newImage, $imagePathDir.$imgName);
		}
		else
		{
			$data=array(
				"error" => '檔案類型錯誤'
			);
			return $data;
		}
	}

	//上傳功能圖
	public function upload_htm_tumb($imgFile, $path, $r_width, $r_height)
	{
		$imagePathDir = '.'.$path;

		/*上傳圖片文件類型列表 */
		$uptypes = array (
			'image/jpg',
			'image/jpeg',
			'image/pjpeg',
			'image/gif',
			'image/png'
		);
		
		/*產生唯一的檔案名稱*/
		$imgName = md5(uniqid(rand())) . '.jpg';

		/*檢查文件類型 */
		if(in_array($imgFile['type'], $uptypes))
		{
			/*上傳圖片類型為jpg,pjpeg,jpeg */
			if (strstr($imgFile['type'], "jp"))
			{
				if(!($source = @ imageCreatefromjpeg($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
			  /*上傳圖片類型為png */
			}
			elseif(strstr($imgFile['type'], "png"))
			{
				if(!($source = @ imagecreatefrompng($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
				/*上傳圖片類型為gif */
			}
			elseif(strstr($imgFile['type'], "gif"))
			{
				if(!($source = @ imagecreatefromgif($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
			  /*其他例外圖片排除 */
			}
			else
			{
			  	$data=array(
					"error" => '檔案類型錯誤'
				);
			 	return $data;
			}
			$w = imagesx($source); /*取得圖片的寬 */
			$h = imagesy($source); /*取得圖片的高 */
			
			/* 儲存到檔案目錄(JPG) */
			imagejpeg($source, $imagePathDir.$imgName);
			$result_name=$imgName;
			/* 檔案resize */
			if($r_width != '' && $r_height != '')
			{
				$newImage=$this->resizeImage($imagePathDir.$imgName, $r_width, $r_height);
				/* 檔案resize存檔 */
				imagejpeg($newImage, $imagePathDir.'f'.$imgName);
				/* 刪除原始圖檔 */
				unlink($imagePathDir . $imgName);
				/* 最後儲存檔名 */
				$result_name='f'.$imgName;
			}
			//圖檔資訊回傳
			$data=array(
				"path"	=>  $result_name,
				"width" =>	$r_width,
				"height"=>	$r_height,
				"error" => 	''
			);

			return $data;
		}
		else
		{
			$data=array(
				"error" => '檔案類型錯誤'
			);
			return $data;
		}
	}

	//上傳商品圖
	public function upload_product($imgFile, $path, $r_width=600, $r_height=600)
	{
		$imagePathDir = '.'.$path;

		/*上傳圖片文件類型列表 */
		$uptypes = array (
			'image/jpg',
			'image/jpeg',
			'image/pjpeg',
			'image/gif',
			'image/png'
		);
		
		/*產生唯一的檔案名稱*/
		$imgName = md5(uniqid(rand()));
		/*檢查文件類型 */
		if(in_array($imgFile['type'], $uptypes))
		{
			/*上傳圖片類型為jpg,pjpeg,jpeg */
			if (strstr($imgFile['type'], "jp"))
			{		
				if(!($source = @ imageCreatefromjpeg($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
			    /*上傳圖片類型為jp */

				$w = imagesx($source); /*取得圖片的寬 */
				$h = imagesy($source); /*取得圖片的高 */

				$imgName .= '.jpg';
				
				/* 儲存到檔案目錄(JPG) */
				imagejpeg($source, $imagePathDir.$imgName);
				/* 檔案resize */
				$newImage=$this->resizeImage($imagePathDir.$imgName, $r_width, $r_height, 'jpg');
				/* 檔案resize存檔 */
				imagejpeg($newImage, $imagePathDir.'p'.$imgName);

				/* 儲存到檔案目錄(JPG) */
				imagejpeg($source, $imagePathDir.$imgName);
				/* 檔案resize */
				$newImage=$this->setImage_w($imagePathDir.$imgName, 300, 'jpg');
				/* 檔案resize存檔 */
				imagejpeg($newImage, $imagePathDir.'set_'.$imgName);
			}
			elseif(strstr($imgFile['type'], "png"))
			{
				if(!($source = @ imagecreatefrompng($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
				/*上傳圖片類型為png */
				imagealphablending( $source, false );
				imagesavealpha( $source, true );

				$w = imagesx($source); /*取得圖片的寬 */
				$h = imagesy($source); /*取得圖片的高 */

				$imgName .= '.png';
				
				/* 儲存到檔案目錄(JPG) */
				imagepng($source, $imagePathDir.$imgName);
				/* 檔案resize */
				$newImage=$this->resizeImage($imagePathDir.$imgName, $r_width, $r_height, 'png');
				/* 檔案resize存檔 */
				imagepng($newImage, $imagePathDir.'p'.$imgName);

				/* 儲存到檔案目錄(JPG) */
				imagepng($source, $imagePathDir.$imgName);
				/* 檔案resize */
				$newImage=$this->setImage_w($imagePathDir.$imgName, 300, 'png');
				/* 檔案resize存檔 */
				imagepng($newImage, $imagePathDir.'set_'.$imgName);
			}
			elseif(strstr($imgFile['type'], "gif"))
			{
				if(!($source = @ imagecreatefromgif($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
				/*上傳圖片類型為gif */
				imagealphablending( $source, false );
				imagesavealpha( $source, true );

				$w = imagesx($source); /*取得圖片的寬 */
				$h = imagesy($source); /*取得圖片的高 */

				$imgName .= '.gif';
				
				/* 儲存到檔案目錄(JPG) */
				imagegif($source, $imagePathDir.$imgName);
				/* 檔案resize */
				$newImage=$this->resizeImage($imagePathDir.$imgName, $r_width, $r_height, 'gif');
				/* 檔案resize存檔 */
				imagegif($newImage, $imagePathDir.'p'.$imgName);

				/* 儲存到檔案目錄(JPG) */
				imagegif($source, $imagePathDir.$imgName);
				/* 檔案resize */
				$newImage=$this->setImage_w($imagePathDir.$imgName, 300, 'gif');
				/* 檔案resize存檔 */
				imagegif($newImage, $imagePathDir.'set_'.$imgName);
			}
			else
			{
			  	$data=array(
					"error" => '檔案類型錯誤'
				);
			 	return $data;
			}
			/* 刪除原始圖檔 */
			unlink($imagePathDir . $imgName);
			/* 最後儲存檔名 */
			$result_name='p'.$imgName;
			$result_name2 = 'set_'.$imgName;

			//圖檔資訊回傳
			$data=array(
				"path"	=>  $result_name,
				"path2" =>	$result_name2,
				"width" =>	$r_width,
				"height"=>	$r_height,
				"error" => 	''
			);

			return $data;
		}
		else
		{
			$data=array(
				"error" => '檔案類型錯誤'
			);
			return $data;
		}
	}

	//上傳多個商品圖
	public function upload_product_arr($imgFile, $path, $count, $r_width=600, $r_height=600)
	{
		$imagePathDir = '.'.$path;

		/*上傳圖片文件類型列表 */
		$uptypes = array (
			'image/jpg',
			'image/jpeg',
			'image/pjpeg',
			'image/gif',
			'image/png'
		);
		
		/*檢查文件類型 */
		if(in_array($imgFile['type']['0'], $uptypes))
		{
			$i=0;
			while ($i<$count) {
				/*產生唯一的檔案名稱*/
				$imgName = md5(uniqid(rand()));
				/*上傳圖片類型為jpg,pjpeg,jpeg */
				if (strstr($imgFile['type']["$i"], "jp"))
				{		
					if(!($source = @ imageCreatefromjpeg($imgFile['tmp_name']["$i"])))
					{
						$data=array(
							"error" => '檔案類型錯誤'
						);
						return $data;
					}
				    /*上傳圖片類型為jp */

					$w = imagesx($source); /*取得圖片的寬 */
					$h = imagesy($source); /*取得圖片的高 */

					$imgName .= '.jpg';
					
					/* 儲存到檔案目錄(JPG) */
					imagejpeg($source, $imagePathDir.$imgName);
					/* 檔案resize */
					//$newImage=$this->resizeImage($imagePathDir.$imgName, $r_width, $r_height, 'jpg');
					$x1=$_POST['x1d_Files'.$i];
					$y1=$_POST['y1d_Files'.$i];
					$widthd_Files=$_POST['widthd_Files'.$i];
					$heightd_Files=$_POST['heightd_Files'.$i];
					$newImage = $this->cutimg($imagePathDir.$imgName, $x1, $y1, $widthd_Files, $heightd_Files, 'jpg');

					/* 檔案resize存檔 */
					imagejpeg($newImage, $imagePathDir.'p'.$imgName);

					/* 儲存到檔案目錄(JPG) */
					imagejpeg($source, $imagePathDir.$imgName);
					/* 檔案resize */
					//$newImage=$this->setImage_w($imagePathDir.$imgName, 300, 'jpg');
					//$newImage = $this->cutimg($imagePathDir.$imgName, $x1, $y1, 300, 225, 'jpg');
					/* 檔案resize存檔 */
					//imagejpeg($newImage, $imagePathDir.'set_'.$imgName);
				}
				elseif(strstr($imgFile['type']["$i"], "png"))
				{
					if(!($source = @ imagecreatefrompng($imgFile['tmp_name']["$i"])))
					{
						$data=array(
							"error" => '檔案類型錯誤'
						);
						return $data;
					}
					/*上傳圖片類型為png */
					imagealphablending( $source, false );
					imagesavealpha( $source, true );

					$w = imagesx($source); /*取得圖片的寬 */
					$h = imagesy($source); /*取得圖片的高 */

					$imgName .= '.png';
					
					/* 儲存到檔案目錄(JPG) */
					imagepng($source, $imagePathDir.$imgName);
					/* 檔案resize */
					// $newImage=$this->resizeImage($imagePathDir.$imgName, $r_width, $r_height, 'png');
					$x1=$_POST['x1d_Files'.$i];
					$y1=$_POST['y1d_Files'.$i];
					$widthd_Files=$_POST['widthd_Files'.$i];
					$heightd_Files=$_POST['heightd_Files'.$i];
					$newImage = $this->cutimg($imagePathDir.$imgName, $x1, $y1, $widthd_Files, $heightd_Files, 'png');
					/* 檔案resize存檔 */
					imagepng($newImage, $imagePathDir.'p'.$imgName);

					/* 儲存到檔案目錄(JPG) */
					imagepng($source, $imagePathDir.$imgName);
					/* 檔案resize */
					// $newImage=$this->setImage_w($imagePathDir.$imgName, 300, 'png');
					//$newImage = $this->cutimg($imagePathDir.$imgName, $x1, $y1, 300, 225, 'png');
					/* 檔案resize存檔 */
					//imagepng($newImage, $imagePathDir.'set_'.$imgName);
				}
				elseif(strstr($imgFile['type']["$i"], "gif"))
				{
					if(!($source = @ imagecreatefromgif($imgFile['tmp_name']["$i"])))
					{
						$data=array(
							"error" => '檔案類型錯誤'
						);
						return $data;
					}
					/*上傳圖片類型為gif */
					imagealphablending( $source, false );
					imagesavealpha( $source, true );

					$w = imagesx($source); /*取得圖片的寬 */
					$h = imagesy($source); /*取得圖片的高 */

					$imgName .= '.gif';
					
					/* 儲存到檔案目錄(JPG) */
					imagegif($source, $imagePathDir.$imgName);
					/* 檔案resize */
					// $newImage=$this->resizeImage($imagePathDir.$imgName, $r_width, $r_height, 'gif');
					$x1=$_POST['x1d_Files'.$i];
					$y1=$_POST['y1d_Files'.$i];
					$widthd_Files=$_POST['widthd_Files'.$i];
					$heightd_Files=$_POST['heightd_Files'.$i];
					$newImage = $this->cutimg($imagePathDir.$imgName, $x1, $y1, $widthd_Files, $heightd_Files, 'gif');
					/* 檔案resize存檔 */
					imagegif($newImage, $imagePathDir.'p'.$imgName);

					/* 儲存到檔案目錄(JPG) */
					imagegif($source, $imagePathDir.$imgName);
					/* 檔案resize */
					// $newImage=$this->setImage_w($imagePathDir.$imgName, 300, 'gif');					
					//$newImage = $this->cutimg($imagePathDir.$imgName, $x1, $y1, 300, 225, 'gif');
					/* 檔案resize存檔 */
					//imagegif($newImage, $imagePathDir.'set_'.$imgName);
				}
				else
				{
				  	$data=array(
						"error" => '檔案類型錯誤'
					);
				 	return $data;
				}
				/* 刪除原始圖檔 */
				unlink($imagePathDir . $imgName);
				/* 最後儲存檔名 */
				$result_name='p'.$imgName;
				$result_name2 = 'set_'.$imgName;

				//圖檔資訊回傳
				$data=array(
					"path"	=>  $result_name,
					"width" =>	$r_width,
					"height"=>	$r_height,
					"error" => 	''
				);
				//return $data;
				$i++;
				$test[]=$data;
			}
				return $test;
		}
		else
		{
			$data=array(
				"error" => '檔案類型錯誤'
			);
			return $data;
		}
	}


	public function cutimg($fromimgname, $fromimg_startx, $fromimg_starty, $newimg_width, $newimg_height, $type='')
	{

		//取得目標檔案的長寬
		$run = true;
		if ($type == "gif") {
			$src = imagecreatefromgif ( $fromimgname);
		} elseif ($type == "jpg") {
			$src = imagecreatefromjpeg ( $fromimgname );
		} elseif ($type == "png") {
			$src = imagecreatefrompng ( $fromimgname);
		} else {
			$run = false;
		}

		if ($run){
			//新檔案的寬高
			$newimg = imagecreatetruecolor($newimg_width, $newimg_height); // 超過256色改用這個
			//進行裁切
			imagecopy($newimg, $src, 0,0,$fromimg_startx,$fromimg_starty,$newimg_width,$newimg_height);
			return $newimg;
		}
	}

	public function resizeImage($filename, $max_width, $max_height, $type='')
	{
	    list($orig_width, $orig_height) = getimagesize($filename);

	    $width = $orig_width;
	    $height = $orig_height;

	    # taller
	    if ($height > $max_height) {
	        $width = ($max_height / $height) * $width;
	        $height = $max_height;
	    }

	    # wider
	    if ($width > $max_width) {
	        $height = ($max_width / $width) * $height;
	        $width = $max_width;
	    }

    	switch ($type) {
    		case 'jpg':
    			$image_p = imagecreatetruecolor($width, $height);
	    		$image = @imagecreatefromjpeg($filename);
	    		imagecopyresampled($image_p, $image, 0, 0, 0, 0, 
                                     $width, $height, $orig_width, $orig_height);
    			break;
    		
    		case 'png':
    			$image_p = imagecreatetruecolor($width, $height);
				imagealphablending( $image_p, false );
				imagesavealpha( $image_p, true );
	    		$image = imagecreatefrompng($filename);
	    		imagecopyresampled($image_p, $image, 0, 0, 0, 0, 
                                     $width, $height, $orig_width, $orig_height);
    			break;
    		
    		case 'gif':
    			$image_p = imagecreatetruecolor($width, $height);
				imagealphablending( $image_p, false );
				imagesavealpha( $image_p, true );
	    		$image = imagecreatefromgif($filename);
	    		imagecopyresampled($image_p, $image, 0, 0, 0, 0, 
                                     $width, $height, $orig_width, $orig_height);
    			break;
    		
    		default:
    			$image_p = imagecreatetruecolor($width, $height);
	    		$image = imagecreatefromjpeg($filename);
	    		imagecopyresampled($image_p, $image, 0, 0, 0, 0, 
                                     $width, $height, $orig_width, $orig_height);
    			break;
    	}

	    return $image_p;
	}

	public function setImage_w($filename, $max_width, $type='')
	{
	    list($orig_width, $orig_height) = getimagesize($filename);

	    $width = $orig_width;
	    $height = $orig_height;

	    if($width > $max_width)
	    {
	    	$height = ($max_width / $width) * $height;
	        $width = $max_width;
	    }

    	switch ($type) {
    		case 'jpg':
    			$image_p = imagecreatetruecolor($width, $height);
	    		$image = imagecreatefromjpeg($filename);
	    		imagecopyresampled($image_p, $image, 0, 0, 0, 0, 
                                     $width, $height, $orig_width, $orig_height);
    			break;
    		
    		case 'png':
    			$image_p = imagecreatetruecolor($width, $height);
				imagealphablending( $image_p, false );
				imagesavealpha( $image_p, true );
	    		$image = imagecreatefrompng($filename);
	    		imagecopyresampled($image_p, $image, 0, 0, 0, 0, 
                                     $width, $height, $orig_width, $orig_height);
    			break;
    		
    		case 'gif':
    			$image_p = imagecreatetruecolor($width, $height);
				imagealphablending( $image_p, false );
				imagesavealpha( $image_p, true );
	    		$image = imagecreatefromgif($filename);
	    		imagecopyresampled($image_p, $image, 0, 0, 0, 0, 
                                     $width, $height, $orig_width, $orig_height);
    			break;
    		
    		default:
    			$image_p = imagecreatetruecolor($width, $height);
	    		$image = imagecreatefromjpeg($filename);
	    		imagecopyresampled($image_p, $image, 0, 0, 0, 0, 
                                     $width, $height, $orig_width, $orig_height);
    			break;
    	}

	    return $image_p;
	}

	public function uploadDoc($docFile)
	{
		//允許的副檔名
		$allowedExts = array("pdf", "doc", "docx", "ppt", "pptx", "xls", "xlsx");

		//檢查檔名合法
		$chk_file_ext= $this->CheckExtendName($docFile['name'], $allowedExts);

		if($chk_file_ext == 1)
		{
			$lastdot = strrpos($docFile['name'], "."); //取出.最後出現的位置 
			$extended = substr($docFile['name'], $lastdot); //取出副檔名 

			/*產生唯一的檔案名稱*/
			$docName = md5(uniqid(rand())) . $extended;
			
			move_uploaded_file($docFile["tmp_name"], $docFile["path"].'c'.$docName);

			$data=array(
				"path"	=>  $docFile["path"].'c'.$docName,
				"size" 	=>	filesize($docFile["path"].'c'.$docName),
				"error" => 	''
			);

			return $data;
		}
		else
		{
			$data=array(
				"error" => '檔案類型錯誤'
			);
			return $data;
		}
	}

	//----------------------------------------------------------------------------------- 
	// 函數名：CheckExtendName($C_filename,$A_extend) 
	// 作 用：上傳文件的副檔名判斷 
	// 參 數：$C_filename 上傳的檔案名 
	// $A_extend 要求的副檔名 
	// 返回值：布林值 
	// 備 注：無 
	//----------------------------------------------------------------------------------- 
	function CheckExtendName($C_filename, $A_extend) 
	{ 
		if(strlen(trim($C_filename)) < 5) 
		{ 
			return 0; //返回0表示沒上傳圖片 
		} 
		
		$lastdot = strrpos($C_filename, "."); //取出.最後出現的位置 
		$extended = substr($C_filename, $lastdot+1); //取出副檔名 

		for($i=0;$i<count($A_extend);$i++) //進行檢測 
		{ 
			if (trim(strtolower($extended)) == trim(strtolower($A_extend[$i]))) //轉換大小寫並檢測 
			{ 
				$flag=1; //加成功標誌 
				$i=count($A_extend); //檢測到了便停止檢測 
			} 
		} 

		if($flag<>1) 
		{ 
			for($j=0;$j<count($A_extend);$j++) //列出允許上傳的副檔名種類 
			{ 
				$alarm .= $A_extend[$j]." "; 
			}
			return -1; //返回-1表示上傳圖片的類型不符 
		} 

		return 1; //返回1表示圖片的類型符合要求 
	} 



	//上傳 png icon 單檔
	public function upload_png($imgFile, $path, $file_name, $r_width, $r_height)
	{
		$imagePathDir = $path.'icon/';

		if(!is_dir($imagePathDir))
			mkdir($imagePathDir, 0755);

		/*上傳圖片文件類型列表 */
		$uptypes = array (
			'image/png'
		);
		
		/*產生唯一的檔案名稱*/
		$imgName = $file_name.'.png';

		//刪除原始檔
		$icon = glob($imagePathDir."{*.png,*.PNG}", GLOB_BRACE);
		if(is_file($imagePathDir.$icon[0]))
			unlink($imagePathDir.$icon[0]);
		
		/*檢查文件類型 */
		if(in_array($imgFile['type'], $uptypes))
		{
			if(strstr($imgFile['type'], "png"))
			{
				if(!($source = @ imagecreatefrompng($imgFile['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
				/*上傳圖片類型為gif */
				imagealphablending( $source, false );
				imagesavealpha( $source, true );
			}
			else
			{
			  	$data=array(
					"error" => '檔案類型錯誤'
				);
			 	return $data;
			}
			$w = imagesx($source); /*取得圖片的寬 */
			$h = imagesy($source); /*取得圖片的高 */

			/* 儲存到檔案目錄(JPG) */
			imagepng($source, $imagePathDir.$imgName);
			/* 檔案resize */
			$newImage=$this->resize_png($imagePathDir.$imgName, $r_width, $r_height);
			/* 檔案resize存檔 */
			imagepng($newImage, $imagePathDir.$imgName);
			if($r_width == 512 && $r_height == 512)
			{
				$newImage=$this->resize_png($imagePathDir.$imgName, 100, 100);
				imagepng($newImage, $imagePathDir.$file_name.'100x100.png');
			}
		}
		else
		{
			$data=array(
				"error" => '檔案類型錯誤'
			);
			return $data;
		}
	}
	public function resize_png($filename, $max_width, $max_height)
	{
	    list($orig_width, $orig_height) = getimagesize($filename);

	    $width = $orig_width;
	    $height = $orig_height;

	    # taller
	    if ($height > $max_height) {
	        $width = ($max_height / $height) * $width;
	        $height = $max_height;
	    }

	    # wider
	    if ($width > $max_width) {
	        $height = ($max_width / $width) * $height;
	        $width = $max_width;
	    }

	    $image_p = imagecreatetruecolor($width, $height);
		imagealphablending( $image_p, false );
		imagesavealpha( $image_p, true );

	    $image = imagecreatefrompng($filename);

	    imagecopyresampled($image_p, $image, 0, 0, 0, 0, 
	                                     $width, $height, $orig_width, $orig_height);

	    return $image_p;
	}
	
	//上傳一般圖檔
	public function upload_single_image($image_dir, $image_file)
	{
		/*上傳圖片文件類型列表 */
		$uptypes = array (
			'image/jpg',
			'image/jpeg',
			'image/pjpeg',
			'image/gif',
			'image/png'
		);

		$file_extname = substr($image_file['name'], strpos($image_file['name'], '.'));

		/*產生唯一的檔案名稱*/
		$image_name = md5(uniqid(rand())) . $file_extname;
		
		/*檢查文件類型 */
		if(in_array($image_file['type'], $uptypes))
		{
			/*上傳圖片類型為jpg,pjpeg,jpeg */
			if (strstr($image_file['type'], "jp"))
			{
				if(!($source = @ imageCreatefromjpeg($image_file['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
			}
			elseif(strstr($image_file['type'], "png"))
			{
				if(!($source = @ imagecreatefrompng($image_file['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
				/*上傳圖片類型為gif */
			}
			elseif(strstr($image_file['type'], "gif"))
			{
				if(!($source = @ imagecreatefromgif($image_file['tmp_name'])))
				{
					$data=array(
						"error" => '檔案類型錯誤'
					);
					return $data;
				}
			  /*其他例外圖片排除 */
			}
			else
			{
			  	$data=array(
					"error" => '檔案類型錯誤'
				);
			 	return $data;
			}
			$w = imagesx($source); /*取得圖片的寬 */
			$h = imagesy($source); /*取得圖片的高 */
			
			/* 儲存到檔案目錄 */
			switch ($image_file['type']) {
				case 'image/jpg':
				case 'image/jpeg':
				case 'image/pjpeg':
					imagejpeg($source, $image_dir . $image_name);
					break;
				case 'image/gif':
					imagegif($source, $image_dir . $image_name);
					break;
				case 'image/png':
					imagepng($source, $image_dir . $image_name);
					break;
			}

			//圖檔資訊回傳
			$data=array("path" => $image_name, 'error' => '');

			return $data;
		}
		else
		{
			$data=array("error" => '檔案類型錯誤');

			return $data;
		}
	}

	// ------------------------------------------------
	// upload_ios_element
	// ------------------------------------------------
	// $file      : 上傳檔案
	// $file_dir  : 上傳路徑
	// $file_type : 上傳類型
	// $file_name : 檔案名稱
	// ------------------------------------------------
	public function upload_ios_element($file, $file_dir, $file_type, $file_name)
	{
		//允許的副檔名
		$allowedExts = array($file_type);

		//檢查檔名合法
		$chk_file_ext= $this->CheckExtendName($file['name'], $allowedExts);

		if($chk_file_ext == 1)
		{
			$lastdot = strrpos($file['name'], "."); //取出.最後出現的位置 
			$extended = substr($file['name'], $lastdot); //取出副檔名 

			// 產生唯一的檔案名稱
			if($file_name == '')
			{
				$fileName = md5(uniqid(rand())) . $extended;
			}
			else
				$fileName = $file_name . $extended;
			move_uploaded_file($file["tmp_name"], $file_dir.$fileName);

			$data=array(
				"path"	=>  $file_dir.$fileName,
				"size" 	=>	filesize($file_dir.$fileName),
				"error" => 	''
			);

			return $data;
		}
		else
		{
			$data=array(
				"error" => '檔案類型錯誤'
			);
			return $data;
		}
	}

}