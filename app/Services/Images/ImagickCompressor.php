<?php

namespace Services\Images;

use Imagick;

class ImagickCompressor extends ImageCompressor
{
    /**
     * @param string $imagePath
     */
    public function compress($imagePath)
    {
        $imagick = new Imagick($imagePath);
        $width = $imagick->getImageWidth();
        $height = $imagick->getImageHeight();

        list($newWidth, $newHeight) = $this->calculateDimensions(
            $width, $height, $this->maxWidth, $this->maxHeight
        );

        $imagick->resizeImage($newWidth, $newHeight, Imagick::FILTER_SINCFAST, 1);
        $imagick->writeImage($imagePath);
    }
}