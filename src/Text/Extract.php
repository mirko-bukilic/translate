<?php

namespace G4\Translate\Text;

use jblond\TwigTrans\Translation;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Extract
{
    private $templatesPath;

    private $tmpPath;

    private $workPath;

    private $genPath;

    private $domain;

    private $messagesFile;

    private $twig;


    public function __construct($templatesPath, $workingPath, $genPath, $domain)
    {
        $this->templatesPath = realpath($templatesPath);
        $this->tmpPath       = $workingPath . '/twig_templates';
        $this->workPath      = $workingPath . '/moved_templates';
        $this->genPath       = realpath($genPath);
        $this->domain        = $domain;
        $this->messagesFile  = realpath($this->genPath . '/' . $this->domain . '.po');

        $this
            ->removeOldMessagesFile()
            ->createDir($this->tmpPath)
            ->createDir($this->workPath)
            ->initTwig()
            ->iterateTroughTemplates()
            ->moveAllToWork()
            ->generate();
    }

    private function createDir($path)
    {
        if(!is_dir($path) && !mkdir($path, 0777, true)) {
            throw new \Exception($path . ' folder is missing');
        }
        return $this;
    }

    private function generate()
    {
        (new Cmd([
            'xgettext',
            '--default-domain=' . $this->domain,
            '-p ' . $this->genPath,
            '--from-code=UTF-8',
            '--no-wrap',
            '-i',
            '-s',
            '-n',
            '--package-name=ND_PROMO_PAGES_I18N',
            '--package-version=' . time(), // use something better here
            '--msgid-bugs-address=bugs.translate@codeplicity.com',
            '--no-location',
            '--add-comments=notes',
            '--omit-header',
            '-L PHP',
            $this->workPath . '/*.php',
        ]))->execute();
    }

    private function initTwig()
    {
        $this->twig = new Environment(new FilesystemLoader($this->templatesPath), [
            'cache'       => $this->tmpPath,
            'auto_reload' => true
        ]);
        $this->twig->addExtension(new Translation());
        return $this;
    }

    private function iterateTroughTemplates()
    {
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->templatesPath), \RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            $file->isFile() && $this->twig->loadTemplate(str_replace($this->templatesPath.'/', '', $file));
        }
        return $this;
    }

    private function moveAllToWork()
    {
        array_map('unlink', glob($this->workPath . '/*'));

        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->tmpPath), \RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            $file->isFile() && $file->getExtension() == 'php' && copy($file, $this->workPath . '/' . basename($file));
        }
        return $this;
    }

    private function removeOldMessagesFile()
    {
        file_exists($this->messagesFile) && unlink($this->messagesFile);
        return $this;
    }
}