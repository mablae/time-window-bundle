<?php
namespace Mablae\TimeWindowBundle;

class NamedTimeWindowCollection
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $timeWindows;

    public function __construct($name, $timeWindows)
    {
        $this->name = $name;
        foreach ($timeWindows as $timeWindow) {
            $this->addTimeWindow(TimeWindow::create($timeWindow['startTime'], $timeWindow['endTime']));
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getTimeWindows()
    {
        return $this->timeWindows;
    }

    public function addTimeWindow(TimeWindow $timeWindow) {

        $this->timeWindows[$timeWindow->generateHash()] = $timeWindow;

    }

    /**
     * @param \DateTime $current
     * @return boolean
     */
    public function isTimeWindowActive(\DateTime $current) {
        foreach ($this->timeWindows as $timeWindow) {
            /** @var $timeWindow TimeWindow */
            if ($timeWindow->isTimeWindowActive($current)) {
                return true;
            }
        }
        return false;
    }

}