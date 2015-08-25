<?php

namespace G4\Translate\Locale;

use G4\Constants\Time;

class Options
{

    const DEFAULT_LOCALE = 'en_US';

    const ENCODING = 'UTF-8';

    const DEFAULT_COOKIE_LIFETIME = Time::DAY_30;


    /**
     * @var int
     */
    private $cookieLifetime;

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
     * @var true
     */
    private $rememberInCookie;

    public function cookieExpiresAt()
    {
        return time()
            + ($this->cookieLifetime === null
                ? self::DEFAULT_COOKIE_LIFETIME
                : $this->cookieLifetime);
    }

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
        return $this->isLocaleSet()
            ? $this->locale
            : self::DEFAULT_LOCALE;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    public function isLocaleSet()
    {
        return $this->locale !== null;
    }

    /**
     * @return \G4\Translate\Locale\Options
     */
    public function rememberInCookie()
    {
        $this->rememberInCookie = true;
        return $this;
    }

    /**
     * @param int $cookieLifetime
     * @return \G4\Translate\Locale\Options
     */
    public function setCookieLifetime($cookieLifetime)
    {
        $this->cookieLifetime = $cookieLifetime;
        return $this;
    }

    /**
     * @param string $domain
     * @return \G4\Translate\Locale\Options
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @param string $locale
     * @return \G4\Translate\Locale\Options
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @param string $path
     * @return \G4\Translate\Locale\Options
     */
    public function setPath($path)
    {
        $this->path = realpath($path);
        return $this;
    }

    /**
     * @return boolean
     */
    public function shouldRememberInCookie()
    {
        return (bool) $this->rememberInCookie;
    }
}