<?php

namespace Mablae\TimeWindowBundle;

interface TimeWindowServiceInterface
{
    public function registerNamedTimeWindowCollection(NamedTimeWindowCollection $namedTimeWindowCollection);
    public function isTimeWindowActive($name);
}
