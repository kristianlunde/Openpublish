<?php
defined('_OP') or die('Access denied');
/**
 *  Copyright (C) 2009 Lars Boldt
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
class opGraphics {
    protected $file, $tempDir, $name;

    public function __construct(opFileType $file, $tempDir) {
        $this->file     = $file;
        $this->tempDir  = $tempDir;
    }
    
    /**
     * Set a defined caching name of the file being created
     * 
     * @param string $name
     * @return opGraphics
     */
    public function setName($name) {
    	$this->name = $name;
    	return $this;
    }

    public function crop($x1, $x2, $y1, $y2, $q = 75) {
        $src    = $this->getResource();
        $dest   = imagecreatetruecolor($x2-$x1, $y2-$y1);
        imagecopyresampled($dest, $src, 0, 0, $x1, $y1, $x2-$x1, $y2-$y1, $x2-$x1, $y2-$y1);
                
        $tmpName = $this->save($dest, $q);

        imagedestroy($src);
        imagedestroy($dest);
        return $tmpName;
    }

    /**
     * Resize an image resource, if no height is provided it auto calculate the height
     * @param int $nW
     * @param int $nH
     * @param int $q
     * @param bool $upScale - Determine if the image can be resized to a larger version than the original
     */
    public function resize($nW, $nH = NULL, $q, $upScale = true) {
        $src  = $this->getResource();

        $height = imagesy($src);
        $width = imagesx($src);
        
     	if(empty($nH)) {
     		$nH = $this->getHeightByFixedWidth($width, $height, $nW);
        }
        
        if(!$upScale && ($nW > $width || $nH > $height)) { //do not scale the image into a larger version than it is
        	$nW = $width;
        	$nH = $height;
        }
  
        $dest = imagecreatetruecolor($nW, $nH);

        imagecopyresampled($dest, $src, 0, 0, 0, 0, $nW, $nH, $width, $height);

        $tmpName = $this->save($dest, $q);

        imagedestroy($src);
        imagedestroy($dest);
        return $tmpName;
    }
    
    /**
     * Calculate the height based of a fixed width 
     * @param float $width
     * @param float $height
     * @param int $newWidth
     * 
     * @return float
     */
    private function getHeightByFixedWidth($width, $height, $newWidth)  
	{   
	    return $newWidth * ($height / $width);   
	} 

	/**
	 * Return the current image sizes of the image
	 * 
	 * @return array
	 */
	public function getImageSize() {
		$src  = $this->getResource();

		return array(
			'height' => imagesy($src),
			'width' => imagesx($src),
		);
	}

    protected function save(&$resource, $q) {
        if (is_writable($this->tempDir)) {
           
        	$tmpName = $this->name;
        	if(empty($this->name)) {
        		$tmpName = md5(rand(0,5000).$this->file->getBasePath().$this->file->getFilename().microtime()).'.'.$this->file->getExtension();	
        	}

        	switch ($this->file->getExtension()) {
                case 'jpg':
                    imagejpeg($resource, $this->tempDir.$tmpName, $q);
                    break;
                case 'gif':
                    imagegif($resource, $this->tempDir.$tmpName);
                    break;
                case 'png':
                    imagepng($resource, $this->tempDir.$tmpName);
                    break;

            }
            return $tmpName;
        }
        return false;
    }

    protected function getResource() {
        switch ($this->file->getExtension()) {
            case 'jpg':
                $src = imagecreatefromjpeg($this->file->getBasePath().$this->file->getFilename());
                break;
            case 'gif':
                $src = imagecreatefromgif($this->file->getBasePath().$this->file->getFilename());
                break;
            case 'png':
                $src = imagecreatefrompng($this->file->getBasePath().$this->file->getFilename());
                break;
            default:
                $src = false;
        }
        return $src;
    }
}
?>