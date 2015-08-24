<?php

namespace G4\Translate;

class Options
{

    const DEFAULT_LOCALE = 'en_US';

    const ENCODING = 'UTF-8';

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $path;

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getEncoding()
    {
        return self::ENCODING;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale === null
            ? self::DEFAULT_LOCALE
            : $this->locale;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $domain
     * @return \G4\Translate\Options
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @param string $locale
     * @return \G4\Translate\Options
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @param string $path
     * @return \G4\Translate\Options
     */
    public function setPath($path)
    {
        $this->path = realpath($path);
        return $this;
    }
}