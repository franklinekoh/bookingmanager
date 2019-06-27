<?php

namespace App\Utilities;

use File;


class ImageUtility
{

    /**
     * Image data
     *
     * @var
     */
    private $data;

    /**
     * Image destination.
     *
     * @var
     */
    private $imageDestination;

    /**
     * ImageUtility class constructor.
     *
     * @param $imageData
     * @param $imageDestination
     */
    public function __construct($imageData, $imageDestination = 'uploads')
    {
        $this->data = $imageData;
        $this->imageDestination = $imageDestination;
    }

    /**
     * Uploads Image
     *
     * @return string
     * @return boolean
     */
    public function uploadPhoto(){


        if (!$this->data->isValid()){return false;}

        if (!File::exists(public_path($this->imageDestination))){return false;}


        $extension = $this->data->getClientOriginalExtension();
        $fileName = str_random(16).'.'.$extension;

        $this->data->move($this->imageDestination, $fileName);

        $filePath = "{$this->imageDestination}/{$fileName}";

        return $filePath;
    }
}