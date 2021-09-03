<?php


namespace Dx\Helpers;


use Dx\Models\Consignment;

/**
 * Class TrackingParserHelper
 * @package Dx\Helpers
 *
 * Parse HTML code from DX-courier website.
 */
class TrackingParserHelper
{
    private \Dx\Models\Logs $_logs;

    /**
     * TrackingParserHelper constructor.
     * @param string $html the html to parse
     */
    public function __construct(string $html)
    {
        $logs = new \Dx\Models\Logs();
        $this->_logs = $logs;
        $dom = new \DOMDocument();

        @$dom->loadHTML($html);
        $dom->preserveWhiteSpace = false;
        $tables = $dom->getElementsByTagName('table');
        if($tables->count() < 3) {
            return $logs;
        }

        $tables = $tables->item(2); // 3rd table

        //get all rows from the table
        $rows = $tables->getElementsByTagName('tr');

        // loop over the table rows
        foreach ($rows as $i => $row) {

            if ($i === 0) {
                continue;
            }

            // get each column by tag name
            $columns = $row->getElementsByTagName('td');

            $log = new Consignment\Log();
            $log->setDateTime(\DateTime::createFromFormat('d/m/y h:i A', $columns->item(0)->textContent));
            $log->setStage($columns->item(1)->textContent);
            $log->setLocation($columns->item(2)->textContent);
            $logs->add($log);
        }

        $this->_logs = $logs;
    }

    /**
     * @return \Dx\Models\Logs returns the parsed log file
     */
    public function getLogs(): \Dx\Models\Logs
    {
        return $this->_logs;
    }

    /**
     * Gets the status code from the stage string
     * @param string $stage text representing the status
     * @return int the status code
     */
    public function getParsedStatus(string $stage): int
    {
        $stages = array(
            Consignment::STATUS_AWAITING_PICKUP => ['Scan at collection','Order'],
            Consignment::STATUS_IN_TRANSIT => ['Scan at delivery'],
            Consignment::STATUS_OUT_FOR_DELIVERY => ['Scanned'],
            Consignment::STATUS_DELIVERED => ['delivered']
        );

        foreach ($stages as $statusType => $keywords) //loop through stages and check position
        {
            foreach($keywords as $keyword)
            {
                if(strpos($stage, $keyword) !== false)
                    return $statusType;
            }
        }

        return 0;
    }
}