<?php

use G4\Translate\Text\GetText\MsgCat;
use G4\ValueObject\RelativePath;
use PHPUnit\Framework\TestCase;

class MsgCatTest extends TestCase
{
    private $filesFromMock;

    /**
     * @var MsgCat
     */
    private $msgCat;

    private $outputFileMock;

    public function testFormat()
    {
        $data = $this->msgCat->format();
        $this->assertTrue(in_array('msgcat', $data));
        $this->assertTrue(in_array('-o', $data));
        $this->assertTrue(in_array('translation.po', $data));
        $this->assertTrue(in_array('file1.po file2.po', $data));
    }

    public function testFormatWithUseFirst()
    {
        $this->msgCat->useFirst();
        $data = $this->msgCat->format();
        $this->assertTrue(in_array('msgcat', $data));
        $this->assertTrue(in_array('--use-first', $data));
        $this->assertTrue(in_array('-o', $data));
        $this->assertTrue(in_array('translation.po', $data));
        $this->assertTrue(in_array('file1.po file2.po', $data));
    }

    protected function setUp(): void
    {
        $this->filesFromMock = [
            'file1.po',
            'file2.po',
        ];
        $this->outputFileMock = $this->getMockBuilder(RelativePath::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->outputFileMock->expects($this->once())->method('__toString')->willReturn('translation.po');
        $this->msgCat = new MsgCat($this->filesFromMock, $this->outputFileMock);
    }

    protected function tearDown(): void
    {
        $this->filesFromMock    = null;
        $this->outputFileMock   = null;
        $this->msgCat           = null;
    }
}
