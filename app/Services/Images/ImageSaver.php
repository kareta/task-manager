<?php

namespace Services;


use Core\Application;
use Services\Images\ImageCompressor;

class ImageSaver
{
    /**
     * @param $imageFile
     * @param ImageCompressor $compressor
     * @return string
     */
    public function save($imageFile, ImageCompressor $compressor)
    {
            $path = $imageFile['name'];
            $extension = pathinfo($path, PATHINFO_EXTENSION);

            $uniquePath = tempnam(Application::$config['images_path'], 'task');
            unlink($uniquePath);

            $uniquePath .= ".$extension";

            move_uploaded_file($imageFile['tmp_name'], $uniquePath);

            $compressor->compress($uniquePath);
            Application::$log->debug($uniquePath);

            return $uniquePath;
    }
}