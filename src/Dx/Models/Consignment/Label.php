<?php


namespace Dx\Models\Consignment;

use Dx\Models\Consignment;


class Label
{

    const FORMAT_PDF = 0;
    const FORMAT_ZPL = 1;
    const FORMAT_DATAMAX = 2;

    const LABELS_PER_PAGE_1 = 1;
    const LABELS_PER_PAGE_4 = 2;

    private int $_fileFormat = self::FORMAT_PDF;
    private string $_contents;
    private Consignment $_consignment;

    private int $_labelsPerPage;
    private int $_startingPosition;

    /**
     * @return int
     */
    public function getFileFormat(): int
    {
        return $this->_fileFormat;
    }

    /**
     * @param int $fileFormat
     * @return Label
     */
    public function setFileFormat(int $fileFormat): Label
    {
        $this->_fileFormat = $fileFormat;
        return $this;
    }

    /**
     * @return string
     */
    public function getContents(): string
    {
        return $this->_contents;
    }

    /**
     * @param string $contents
     * @return Label
     */
    public function setContents(string $contents): Label
    {
        $this->_contents = $contents;
        return $this;
    }

    /**
     * @return int
     */
    public function getLabelsPerPage(): int
    {
        return $this->_labelsPerPage;
    }

    /**
     * @param int $labelsPerPage
     * @return Label
     */
    public function setLabelsPerPage(int $labelsPerPage): Label
    {
        $this->_labelsPerPage = $labelsPerPage;
        return $this;
    }

    /**
     * @return int
     */
    public function getStartingPosition(): int
    {
        return $this->_startingPosition;
    }

    /**
     * @param int $startingPosition
     * @return Label
     */
    public function setStartingPosition(int $startingPosition): Label
    {
        $this->_startingPosition = $startingPosition;
        return $this;
    }


    /**
     * @return Consignment
     */
    public function getConsignment(): Consignment
    {
        return $this->_consignment;
    }

    /**
     * @param Consignment $consignment
     * @return Label
     */
    public function setConsignment(Consignment $consignment): Label
    {
        $this->_consignment = $consignment;
        return $this;
    }
}