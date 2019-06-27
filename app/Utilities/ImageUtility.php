<?php

namespace App\Utilities;

//use App\Http\Controllers\Controller;


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
    private $imageDestination = 'uploads';

    /**
     * Image Path.
     *
     * @var
     */
    private $imagePath = '';

    /**
     * ImageUtility class constructor.
     *
     * @param $imageData
     */
    public function __construct($imageData)
    {
        $this->data = $imageData;
        $this->imagePath;
    }

    /**
     * Uploads Image
     *
     * @return object
     * @return boolean
     */
    public function uploadPhoto(){


        if (!$this->data->isValid()){return false;}


        $extension = $this->data->getClientOriginalExtension();
        $fileName = str_random(16).'.'.$extension;

        $this->data->move($this->imageDestination, $fileName);

//        $filePath = `{$this->imageDestination}/{$fileName}`;

        $this->imagePath = `{$this->imageDestination}/{$fileName}`;

        return $this;
//        return $filePath;
    }
}