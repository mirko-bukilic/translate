<?php

namespace G4\Translate;

class Locale
{

    /**
     * @var Options
     */
    private $data;

    /**
     * @param Options $data
     */
    public function __construct(Options $data)
    {
        $this->data = $data;
    }

    public function set()
    {
        putenv("LC_ALL={$this->data->getLocale()}");
        setlocale(LC_ALL, $this->data->getLocale());
        bindtextdomain($this->data->getDomain(), $this->data->getPath());
        bind_textdomain_codeset($this->data->getDomain(), $this->data->getEncoding());
        textdomain($this->data->getDomain());
    }
}