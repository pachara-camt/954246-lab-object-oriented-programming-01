<?php
class Car
{
    private $owner;
    private $cc;
    private $isEngineOn;
    private $distance;

    function __construct($owner, $cc)
    {
        $this->owner = $owner;
        $this->cc = $cc;
        $this->isEngineOn = false;
        $this->distance = 0;
    }

    function engineStart()
    {
        $this->isEngineOn = true;
    }

    function engineStop()
    {
        $this->isEngineOn = false;
    }

    function runFor($km)
    {
        if(!$this->isEngineOn) {
            fprintf(STDERR, "Cannot run, engine is off\n");
            return false;
        }
        
        $this->distance += $km;
        return true;
    }

    function fuelUsed()
    {
        return ($this->distance / 20) * ($this->cc / 1000);
    }

    function showInfo()
    {
        if($this->isEngineOn) {
            fprintf(STDERR, "Cannot show, engine is on\n");
            return false;
        }
        printf("Owner: %s\n", $this->owner);
        printf("Running distance: %6d km\n",
            $this->distance);
        printf("Fuel used:        %6.2f L\n",
            $this->fuelUsed());
        
        return true;
    }
}

printf("Input (owner cc): ");
fscanf(STDIN, "%s %d", $owner, $cc);
$car = new Car($owner, $cc);

while(true) {
    printf("command (h for help): ");
    $command = null;
    $value = null;
    fscanf(STDIN, "%s %d", $command, $value);
    if(strtolower($command) === 'e') break;
    switch(strtolower($command)) {
        case '0':
            $car->engineStop();
            break;
        case '1':
            $car->engineStart();
            break;
        case 'r':
            $car->runFor($value);
            break;
        case 'i':
            $car->showInfo();
            break;
        case 'h':
            printf(
<<<EOT
 0 stop engine
 1 start engine
 r run for the given km
 i show information (engine is off only)
 e exit
 h print this help

EOT
            );
            break;
        default:
            fprintf(STDERR, "Unkown command '%s' !!!\n", $command);
    }
}
