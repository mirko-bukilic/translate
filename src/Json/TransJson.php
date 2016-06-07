<?php

namespace G4\Translate\Json;

use G4\Translate\Json\TransPath;
use G4\Translate\Json\TransName;

class TransJson
{
    /**
     * @var TransPath
     */
    private $path;

    public function __construct(TransPath $path)
    {
        $this->path = $path;
    }

    public function execute()
    {
        $langDirectories =   $this->path->getDirs();
        foreach($langDirectories as $dir){
            $this->createJson($dir);
        }
    }

    private function createJson($langPath)
    {
        $poSrc =  $this->path->getPoFile($langPath);
        preg_match_all('/msgid\s+\"([^\"]*)\"/', $poSrc, $matches);
        preg_match_all('/msgstr\s+\"([^\"]*)\"/', $poSrc, $matchesTrans);
        $this->createJsonFile(array_combine($matches[1], $matchesTrans[1]), $langPath);

    }

    private function createJsonFile($trans, $langPath)
    {
        file_put_contents(
            $this->path->getJsonPath(basename($langPath)),
            json_encode($trans)
        );
    }
}