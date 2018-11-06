<?php

namespace G4\Translate\Locale;

class Locale
{

    /**
     * @var string
     */
    private $locale;

    /**
     * @var Options
     */
    private $options;

    /**
     * @var Repository
     */
    private $repository;

    /**
     * @param Options $options
     */
    public function __construct(Options $options)
    {
        $this->options    = $options;
        $this->repository = new Repository($this->options);
    }

    public function set()
    {
        $this
            ->clearCookie()
            ->setEnvironment()
            ->setInCookie();
    }

    private function clearCookie()
    {
        if ($this->options->shouldRememberInCookie()) {
            $this->repository->delete();
        }
        return $this;
    }

    private function getLocale()
    {
        if ($this->locale === null) {
            $this->locale = $this->shouldLoadFromOptions()
                ? $this->options->getLocale()
                : $this->repository->read();
        }
        return $this->locale;
    }

    private function setEnvironment()
    {
        putenv("LC_ALL={$this->getLocale()}");
        putenv("LANGUAGE={$this->getLocale()}");
        putenv("LANG={$this->getLocale()}");
        setlocale(LC_ALL, $this->getLocale());
        bindtextdomain($this->options->getDomain(), $this->options->getPath());
        bind_textdomain_codeset($this->options->getDomain(), $this->options->getEncoding());
        textdomain($this->options->getDomain());
        return $this;
    }

    private function setInCookie()
    {
        if ($this->options->shouldRememberInCookie()) {
            $this->repository->create($this->getLocale());
        }
    }

    private function shouldLoadFromOptions()
    {
        return $this->options->isLocaleSet()
            || !$this->options->shouldRememberInCookie()
            || ($this->options->shouldRememberInCookie() && !$this->repository->has());
    }
}