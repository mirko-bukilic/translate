<?php

namespace G4\Translate\Text;

class Translate
{

    /**
     * @var string
     */
    private $localePath;

    /**
     * @param string $localePath
     */
    public function __construct($localePath)
    {
        $this->localePath = realpath($localePath);
        $this->concatenatePoFiles();
        $this->iterateTroughLocale();
    }

    /**
     * @param array $poFiles
     */
    private function concatenate(array $poFiles)
    {
        $filesToConcatenate = "";
        foreach($poFiles as $poFile){
            $path = $poFile->getPath();
            $filesToConcatenate .= realpath($poFile->getPath()) . DIRECTORY_SEPARATOR . $poFile->getBasename() . " ";
        }
        (new Cmd([
                'msgcat',
                '-o',
                realpath($path) . DIRECTORY_SEPARATOR . 'translation.po',
                $filesToConcatenate
            ]
        ))->execute();
    }

    /**
     * @param \SplFileInfo $file
     */
    private function convert(\SplFileInfo $file)
    {
        (new Cmd([
            'msgfmt',
            realpath($file->getPath()) . DIRECTORY_SEPARATOR . $file->getBasename(),
            '-o',
            realpath($file->getPath()) . DIRECTORY_SEPARATOR . $file->getBasename('.po') . '.mo',
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
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->localePath), \RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            $file->isFile() && $file->getBasename() == 'translation.po' && $this->convert($file);
        }
    }
}