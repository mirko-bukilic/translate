<?php

namespace G4\Translate\Json;

use G4\Translate\Json\TransName;

class TransPath
{
    const LC_MESSAGES =  '/LC_MESSAGES/';
    /**
     * @var string
     */
    private $src;

    /**
     * @var string
     */
    private $desctination;

    /**
     * @var TransName
     */
    private $name;

    public function __construct(TransName $name, $src, $destination = null)
    {
        if(empty($src)){
            throw new \Exception('source path is required');
        }

        if(!is_dir(realpath($src))){
            throw new \Exception('wrong path');
        }

        $this->src = realpath($src);
        $this->desctination = empty($destination) ? null : realpath($destination);
        $this->name = $name;
    }

    public function getDirs()
    {
        return glob($this->src . '/*' , GLOB_ONLYDIR);
    }

    public function getPoFile($langPath)
    {
        return file_get_contents($langPath . self::LC_MESSAGES . (string) $this->name . '.po');
    }

    public function getJsonPath($lang)
    {
        return empty($this->desctination)
            ? $this->src . '/' . $lang  . self::LC_MESSAGES . $this->name . '.json'
            : $this->getDestPath($lang);
    }

    private function getDestPath($lang)
    {
        $langPath = $this->desctination . '/' . $lang . self::LC_MESSAGES;
        if(!is_dir($langPath) && !mkdir($langPath, 0777, true)){
            throw new \Exception($langPath . ' folder is missing');
        }
        return $langPath . $this->name . '.json';
    }
}