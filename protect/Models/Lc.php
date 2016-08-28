<?php

namespace protect\Models;


use Elision\Orm\Model;
use Elision\Web\Images;

class Lc
    extends Model
{

    public $title;
    public $description;

    public function setConfig($client_id)
    {

        if (!empty($_FILES['image']['name'])) {
            
            $image = Images::uploadImage('./files/' . $client_id . '_', false);

            Images::resizeImg($image, $image, 700, 700);

            Images::joinImg($image, './files/001.jpg', $image, 400, 0, 0, 0, 300, 700);

            $image = \Elision\Core\Config::getConfig()->url . substr($image, 2);

        }

        $config = new Config();
        $config->title = $this->title;
        $config->description = $this->description;
        $config->image = $image;
        $config->update(['client_id' => $client_id]);
    }
}