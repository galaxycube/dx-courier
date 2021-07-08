<?php

namespace Dx\Models\Consignment;

class Log {
    private \DateTime $_dateTime;
    private string $_stage;
    private string $_location;

    /**
     * @return \DateTime
     */
    public function getDateTime(): \DateTime
    {
        return $this->_dateTime;
    }

    /**
     * @param \DateTime $dateTime
     * @return Log
     */
    public function setDateTime(\DateTime $dateTime): Log
    {
        $this->_dateTime = $dateTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getStage(): string
    {
        return $this->_stage;
    }

    /**
     * @param string $stage
     * @return Log
     */
    public function setStage(string $stage): Log
    {
        $this->_stage = $stage;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->_location;
    }

    /**
     * @param string $location
     * @return Log
     */
    public function setLocation(string $location): Log
    {
        $this->_location = $location;
        return $this;
    }

}