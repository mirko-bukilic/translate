<?php

namespace G4\Translate;

use G4\Constants\Time;
class Repository
{

    const NAME = 'locale';

    /**
     * @var Options
     */
    private $options;

    /**
     * @param Options $options
     */
    public function __construct(Options $options)
    {
        $this->options = $options;
    }


    public function create($locale)
    {
        setcookie(self::NAME, $locale, $this->options->cookieExpiresAt(), '/');
    }

    public function delete()
    {
        setcookie(self::NAME, '', time() - Time::HOUR_01);
    }

    public function has()
    {
        return isset($_COOKIE[self::NAME]);
    }

    public function read()
    {
        return $this->has()
            ? $_COOKIE[self::NAME]
            : null;
    }
}