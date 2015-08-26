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
        $this->iterateTroughLocale();
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

    private function iterateTroughLocale()
    {
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->localePath), \RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            $file->isFile() && $file->getExtension() == 'po' && $this->convert($file);
        }
    }
}