<?php


namespace Dx\Models;

use Dx\Models\Consignment\Label;

use PHPUnit\Framework\TestCase;

/**
 * Class LabelTest
 * @package Dx\Models
 * @covers \Dx\Models\Consignment\Label
 */
class LabelTest extends TestCase
{

    private $_label;

    public function setUp(): void
    {
        $this->_label = new Label();
    }

    /**
     * @testCase Set lab content
     */
    public function testLabelContent(): void {
        $this->_label->setContents('CONTENT');
        self::assertEquals('CONTENT', $this->_label->getContents());
    }

    /**
     * @testCase Set file format
     */
    public function testLabelFileFormat(): void {
        $this->_label->setContents(Label::FORMAT_PDF);
        self::assertEquals(Label::FORMAT_PDF, $this->_label->getFileFormat());
    }

    /**
     * @testCase Set file format
     */
    public function testLabelsPerPagr(): void {
        $this->_label->setLabelsPerPage(Label::LABELS_PER_PAGE_1);
        self::assertEquals(Label::LABELS_PER_PAGE_1, $this->_label->getLabelsPerPage());
    }

}