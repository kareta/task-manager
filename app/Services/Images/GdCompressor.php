<?php

namespace Services\Images;


class GdCompressor extends ImageCompressor
{
    /**
     * @param string $imagePath
     */
    public function compress($imagePath)
    {
        list($width, $height) = getimagesize($imagePath);
        list($newWidth, $newHeight) = $this->calculateDimensions(
             $width, $height, $this->maxWidth, $this->maxHeight
        );

        $image = $this->createImage($imagePath);

        $compressedImage = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled(
            $compressedImage, $image, 0, 0, 0, 0,
            $newWidth, $newHeight, $width, $height
        );

        unlink($imagePath);
        $this->saveImage($imagePath, $compressedImage);
    }

    /**
     * @param string $path
     * @param $imageResource
     * @return bool
     * @throws \Exception
     */
    public function saveImage($path, $imageResource)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $extension = strtolower($extension);

        switch ($extension) {
            case 'png':
                return imagepng($imageResource, $path);
            case 'gif':
                return imagegif($imageResource, $path);
            case 'jpeg':
                return imagejpeg($imageResource, $path);
            case 'jpg':
                return imagejpeg($imageResource, $path);
        }

        throw new \Exception('1Image has unsupported format ' . $path);
    }

    /**
     * @param string $path
     * @return resource
     * @throws \Exception
     */
    public function createImage($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $extension = strtolower($extension);

        switch ($extension) {
            case 'png':
                return imagecreatefrompng($path);
            case 'gif':
                return imagecreatefromgif($path);
            case 'jpeg':
                return imagecreatefromjpeg($path);
            case 'jpg':
                return imagecreatefromjpeg($path);
        }

        throw new \Exception('1Image has unsupported format ' . $path);
    }
}