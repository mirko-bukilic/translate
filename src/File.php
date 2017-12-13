<?php


namespace G4\Translate;


class File
{

    const EXTENSION_PO = '.po';
    const EXTENSION_MO = '.mo';

    /**
     * @var \SplFileInfo
     */
    private $fileInfo;

    public function __construct(\SplFileInfo $fileInfo)
    {
        $this->fileInfo = $fileInfo;
    }

    /**
     * @return string
     */
    public function getInputFilePath()
    {
        return realpath($this->fileInfo->getPathname());
    }

    /**
     * @return string
     */
    public function getOutputFilePath()
    {
        return realpath($this->fileInfo->getPath()) .
            DIRECTORY_SEPARATOR .
            $this->fileInfo->getBasename(self::EXTENSION_PO) .
            self::EXTENSION_MO;
    }


    public function getLocale()
    {
        $countryCode = \preg_replace(
            '~.*\/locale\/(.*)\/LC_MESSAGES\/translation\.po~',
            '$1',
            (string) $this->fileInfo->getPathname()
        );
        return $countryCode;
    }
}