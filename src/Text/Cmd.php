<?php

namespace G4\Translate\Text;

class Cmd
{

    /**
     * @var array
     */
    private $parts;

    /**
     * @param array $parts
     */
    public function __construct(array $parts)
    {
        $this->parts = $parts;
    }

    public function execute()
    {
        echo shell_exec(join(' ', $this->parts));
    }
}