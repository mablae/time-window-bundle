<?php
namespace Mablae\TimeWindowBundle;

class TimeWindow
{
    /**
     * @var \DateTime
     */
    private $startDate;
    /**
     * @var \DateTime
     */
    private $endDate;


    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     */
    private function __construct(\DateTime  $startDate, \DateTime $endDate) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @param $startTime
     * @param $endTime
     * @return TimeWindow
     */
    public static function create($startTime, $endTime)
    {

        self::checkTimeFormat($startTime);
        self::checkTimeFormat($endTime);

        $startDate = self::parseTime($startTime);
        $endDate = self::parseTime($endTime);

        if($startDate > $endDate) {
            throw new \InvalidArgumentException("startTime must before endTime");
        }

        return new self($startDate, $endDate);
    }

    /**
     * @param $timeString
     */
    protected static function checkTimeFormat($timeString)
    {
        if (!preg_match('/\d{2}:\d{2}/', $timeString)) {
            throw new \InvalidArgumentException();
        }

    }

    /**
     * @param $timeString
     * @return \DateTime
     */
    private static function parseTime($timeString)
    {
        list($hours, $minutes) = explode(':', $timeString);

        if ($hours < 23 && $minutes < 59) {
            return \DateTime::createFromFormat('H:i', $timeString);
        }

    }


    /**
     * @return boolean
     */
    public function isTimeWindowActive(\DateTime $current) {

        if ($current->format('U') > $this->startDate->format('U')
            && $current->format('U') <= $this->endDate->format('U')) {
            return true;
        }

        return false;

    }

    /**
     * @return string
     */
    public function generateHash()
    {

        $hash = $this->startDate->format(\DateTime::ISO8601).$this->endDate->format(\DateTime::ISO8601);
        return md5($hash);
    }
}