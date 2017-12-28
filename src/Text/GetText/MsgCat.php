<?php


namespace G4\Translate\Text\GetText;

use G4\ValueObject\RelativePath;

class MsgCat
{

    const COMMAND_NAME          = 'msgcat';

    const OPTION_USE_FIRST      = '--use-first';
    const OPTION_FILES_FROM     = '-f';
    const OPTION_OUTPUT_FILE    = '-o';

    /**
     * @var RelativePath
     */
    private $filesFrom;

    /**
     * @var RelativePath
     */
    private $outputFile;

    /**
     * @var bool
     */
    private $shouldUseFirst;

    /**
     * MsgCat constructor.
     * @param array $filesFrom
     * @param RelativePath $outputFile
     */
    public function __construct(array $filesFrom, RelativePath $outputFile)
    {
        $this->filesFrom        = $filesFrom;
        $this->outputFile       = $outputFile;
        $this->shouldUseFirst   = false;
    }

    public function useFirst()
    {
        $this->shouldUseFirst = true;
    }

    /**
     * @return array
     */
    public function format()
    {
        return array_filter([
            self::COMMAND_NAME,
            $this->shouldUseFirst ? self::OPTION_USE_FIRST : false,
            self::OPTION_OUTPUT_FILE,
            (string) $this->outputFile,
            join(' ', $this->filesFrom),
        ]);
    }
}