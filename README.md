# TimeWindowBundle

This bundle implements implements basically daytime based feature flags. 

**NOTICE** This bundle is the result of quickly decoupling some logic we already had duplicated in serveral places
of an legacy codebase. If you are looking for a *full featured* Feature Toggle Bundle for Symfony you are probably better using
https://github.com/qandidate-labs/qandidate-toggle-bundle

Feel free to contribute or leave feedback in the issues. <3

##Installation

### Step 1: Install DatetimepickerBundle

```bash
php composer.phar require mablae/datetimepicker-bundle
```

### Step 2: Enable the bundle

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Mablae\TimeWindowBundle\MablaeTimeWindowBundle(),
    );
}
```


### Step 3: Configure your named time windows:
``` yml
# app/config/config.yml
mablae_time_window_:
    enabled: ~
    time_windows:
      in_the_morning:
        - { startTime : '06:00' , endTime: '08:00' }
```

At the moment there is no proper overlapping checks or sorting. The timewindow must be defined in correct order. 
The first timewindow that returns active wins.

### Step 4: Use the voter service to ask, if a time-window is active
``` php

<?php 
/* ... */ 

$timeWindowService = $this->get('mablae_time_window.service');

$itsInTheMorning = $timeWindowService->isTimeWindowActive('in_the_morning')


```
