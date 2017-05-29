<?php

namespace Services\Images;


abstract class ImageCompressor
{
    /**
     * @var int
     */
    protected $maxWidth;

    /**
     * @var int
     */
    protected $maxHeight;

    /**
     * ImageCompressor constructor.
     * @param int $maxWidth
     * @param int $maxHeight
     */
    public function __construct($maxWidth, $maxHeight)
    {
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
    }

    /**
     * @param string $imagePath
     * @return void
     */
    public abstract function compress($imagePath);

    /**
     * @param int $width
     * @param int $height
     * @param int $maxWidth
     * @param int $maxHeight
     * @return array
     */
    public function calculateDimensions($width, $height, $maxWidth, $maxHeight)
    {
        $newHeight = $height;
        $newWidth = $width;

        if ($height > $maxHeight) {
            $howManyTimesIsHeightGreater = $height / $maxHeight;
            $newHeight = $height / $howManyTimesIsHeightGreater;
            $newWidth = $width / $howManyTimesIsHeightGreater;
        }

        if ($newWidth > $maxWidth) {
            $howManyTimesIsWidthGreater = $width / $maxWidth;
            $newHeight = $height / $howManyTimesIsWidthGreater;
            $newWidth = $width / $howManyTimesIsWidthGreater;
        }

        return [$newWidth, $newHeight];
    }
}