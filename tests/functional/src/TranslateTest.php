<?php


use G4\Translate\Text\Translate;
use G4\ValueObject\RealPath;


class TranslateTest extends PHPUnit_Framework_TestCase
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

        $translationPoFixturePath = new RealPath('tests', 'functional', 'fixtures', 'it_IT-translation.po');
        $translationPoFixture = file_get_contents((string) $translationPoFixturePath);

        $this->assertStringEqualsFile((string) $translationPoFilePath, $translationPoFixture);
    }

    protected function setUp()
    {
        $this->pathToLocale = new RealPath('tests', 'functional', 'fixtures', 'locale');
    }

    protected function tearDown()
    {
        unlink((string) $this->pathToLocale->append('it_IT')->append('LC_MESSAGES')->append('translation.po'));
        unlink((string) $this->pathToLocale->append('it_IT')->append('LC_MESSAGES')->append('translation.mo'));

        $this->pathToLocale = null;
    }
}
