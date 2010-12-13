<?php

	define('DIRECTORY_ICON','<img src="/images/folder-open.png" alt="" />');
	define('INDENTATION','<img src="/images/indentation-blank.png" alt="" />');
	define('FILE_ACROBAT_ICON','<img src="/images/page_white_acrobat.png" alt="" />');
	define('FILE_PHP_ICON','<img src="/images/page_white_php.png" alt="" />');
	define('FILE_IMAGE_ICON','<img src="/images/page_white_picture.png" alt="" />');
	define('FILE_HTML_ICON','<img src="/images/page_white_world.png" alt="" />');
	define('FILE_ZIP_ICON','<img src="/images/page_white_zip.png" alt="" />');
	define('FILE_ICON','<img src="/images/folder-open.png" alt="" />');
	define('DEFAULT_ICON','<img src="/images/page_white.png" alt="" />');
	
	
	class IconCollection {
		
		function getImgStrMime ($mime) {
			$icon = DEFAULT_ICON;
			
			switch ($mime) {
				case FILENODE_DIR_EXT:
				$icon = DIRECTORY_ICON;
				break;
				
				case "png" :
				$icon = FILE_IMAGE_ICON;
				break;
				
				case "php" :
				$icon = FILE_PHP_ICON;
				break;
				
				case "html" :
				$icon = FILE_HTML_ICON;
				break;
				
			}
			
			return $icon;
			
		}
		
		function getImgStrIdent () {
			return INDENTATION;
		}
	}
?>