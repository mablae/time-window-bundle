<?php
namespace Mablae\TimeWindowBundle;



class TimeWindowService implements TimeWindowServiceInterface
{

    /**
     * @var array
     */
    private $timeWindowRegistry;


    public function registerNamedTimeWindowCollection(NamedTimeWindowCollection $namedTimeWindowCollection) {
        $this->timeWindowRegistry[$namedTimeWindowCollection->getName()] = $namedTimeWindowCollection;
    }

    public function isTimeWindowActive($name) {


        if (!isset($this->timeWindowRegistry[$name])) {
            throw new \InvalidArgumentException("'$name' is not a registered NamedTimeWindowCollection");
        }

        /** @var NamedTimeWindowCollection $collection */
        $collection = $this->timeWindowRegistry[$name];
        return $collection->isTimeWindowActive(new \DateTime());

    }
}
