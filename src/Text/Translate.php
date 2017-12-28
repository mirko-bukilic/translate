<?php

namespace G4\Translate\Text;

use G4\Translate\File;
use G4\Translate\Text\GetText\MsgCat;
use G4\ValueObject\RelativePath;

class Translate
{

    /**
     * @var string
     */
    private $localePath;

    /**
     * @var bool
     */
    private $useFirst = false;

    /**
     * @param string $localePath
     */
    public function __construct($localePath, $useFirst = null)
    {
        $this->localePath = realpath($localePath);
        if($useFirst){
            $this->useFirst = true;
        }
        $this->concatenatePoFiles();
        $this->iterateTroughLocale();
    }

    /**
     * @param array $poFiles
     */
    private function concatenate(array $poFiles)
    {
        $filesToConcatenate = [];
        foreach($poFiles as $poFile){
            $path = $poFile->getPath();
            $filesToConcatenate[] = realpath($poFile->getPath()) . DIRECTORY_SEPARATOR . $poFile->getBasename();
        }

        $msgCat = new MsgCat($filesToConcatenate, new RelativePath(realpath($path), 'translation.po'));

        if ($this->useFirst) {
            $msgCat->useFirst();
        }

        (new Cmd($msgCat->format()))->execute();
    }

    /**
     * @param File $file
     */
    private function convert(File $file)
    {
        fputs(STDOUT, $file->getLocale() . "\n");
        (new Cmd([
            'msgfmt',
            '-v',
            $file->getInputFilePath(),
            '-o',
            $file->getOutputFilePath(),
        ]))->execute();
    }

    private function concatenatePoFiles()
    {
        $previousPoFiles = [];
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->localePath), \RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            if($file->isFile() && $file->getExtension() == 'po'){
                isset($previousPoFiles[$file->getPath()])
                    ? $previousPoFiles[$file->getPath()][] = $file
                    : $previousPoFiles[$file->getPath()] = [$file];
            }
        }
        foreach ($previousPoFiles as $poFiles){
            $this->concatenate($poFiles);
        }
    }

    private function iterateTroughLocale()
    {
        $allFiles = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->localePath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($allFiles as $fileInfo) {
            if ($fileInfo->isFile() && $fileInfo->getBasename() == 'translation.po') {
                $this->convert(new File($fileInfo));
            }
        }
    }
}