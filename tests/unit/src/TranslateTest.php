<?php

namespace unit\src;

use G4\Translate\Text\Translate;
use G4\ValueObject\RealPath;
use PHPUnit\Framework\TestCase;

class TranslateTest extends TestCase
{

    /**
     * @var RealPath
     */
    private $pathToLocale;

    private $translate;

    public function testTranslate()
    {
        new Translate($this->pathToLocale, false);

        $translationPoFilePath = $this->pathToLocale->append('it_IT')->append('LC_MESSAGES')->append('translation.po');
        $translationMoFilePath = $this->pathToLocale->append('it_IT')->append('LC_MESSAGES')->append('translation.mo');

        $this->assertFileExists((string) $translationPoFilePath);
        $this->assertFileExists((string) $translationMoFilePath);

        $translationPoFixturePath = new RealPath('tests', 'unit', 'fixtures', 'it_IT-translation.po');
        $translationPoFixture = file_get_contents((string) $translationPoFixturePath);

        $this->assertStringEqualsFile((string) $translationPoFilePath, $translationPoFixture);
    }

    public function testTranslateWithUseFirst()
    {
        new Translate($this->pathToLocale, true);

        $translationPoFilePath = $this->pathToLocale->append('it_IT')->append('LC_MESSAGES')->append('translation.po');
        $translationMoFilePath = $this->pathToLocale->append('it_IT')->append('LC_MESSAGES')->append('translation.mo');

        $this->assertFileExists((string) $translationPoFilePath);
        $this->assertFileExists((string) $translationMoFilePath);

        $translationPoFixturePath = new RealPath('tests', 'unit', 'fixtures', 'it_IT-translation.po');
        $translationPoFixture = file_get_contents((string) $translationPoFixturePath);

        $this->assertStringEqualsFile((string) $translationPoFilePath, $translationPoFixture);
    }

    protected function setUp(): void
    {
        $this->pathToLocale = new RealPath('tests', 'unit', 'fixtures', 'locale');
    }

    protected function tearDown(): void
    {
        unlink((string) $this->pathToLocale->append('it_IT')->append('LC_MESSAGES')->append('translation.po'));
        unlink((string) $this->pathToLocale->append('it_IT')->append('LC_MESSAGES')->append('translation.mo'));

        $this->pathToLocale = null;
    }
}
