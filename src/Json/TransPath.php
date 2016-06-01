<?php

namespace G4\Translate\Json;

use G4\Translate\Json\TransName;

class TransPath
{
    const LC_MESSAGES =  '/LC_MESSAGES/';
    /**
     * @var string
     */
    private $path;

    /**
     * @var TransName
     */
    private $name;

    public function __construct($path, TransName $name)
    {
        if(empty($path)){
            throw new \Exception('source path is required');
        }

        if(!is_dir(realpath($path))){
            throw new \Exception('wrong path');
        }

        $this->path = realpath($path);
        $this->name = $name;
    }

    public function getDirs()
    {
        return glob($this->path . '/*' , GLOB_ONLYDIR);
    }

    public function getPoFile($langPath)
    {
        return file_get_contents($langPath . self::LC_MESSAGES . (string) $this->name . '.po');
    }

    public function getJsonPath($langPath)
    {
        return $langPath . self::LC_MESSAGES . $this->name . '.json';
    }
}