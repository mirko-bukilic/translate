<?php

namespace G4\Translate;

class Locale
{

    const ENCODING = 'UTF-8';

    private $locale;

    private $domain;

    private $path;

    /**
     * @param string $locale
     * @param string $domain
     * @param string $path
     */
    public function __construct($locale, $domain, $path)
    {
        $this->locale = $locale;
        $this->domain = $domain;
        $this->path   = $path;
    }

    public function set()
    {
        putenv("LC_ALL={$this->locale}");
        setlocale(LC_ALL, $this->locale);
        bindtextdomain($this->domain, $this->path);
        bind_textdomain_codeset($this->domain, self::ENCODING);
        textdomain($this->domain);
    }
}