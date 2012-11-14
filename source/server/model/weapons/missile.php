<?php

class MissileLauncher extends Weapon
{
    public $useOEW = false;
    public $ballistic = true;
    
    public static $fireModeToMissile = array(
        1 => 'BasicMissile'
    );
        

    function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc)
    {
        parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
    }

    public function setSystemDataWindow($turn)
    {
        $this->data["Weapon type"] = "Missile";
        $this->data["Damage type"] = "Standard";
        $this->data["Ammo"] = "Basic missile";

        parent::setSystemDataWindow($turn);
    }
}

class SMissileRack extends MissileLauncher
{
    public $name = "sMissileRack";
    public $displayName = "Class-S Missile Rack";
    public $range = 15;
    public $loadingtime = 2;
    public $iconPath = "missile1.png";

    public $fireControl = array(3, 3, 3); // fighters, <mediums, <capitals 

    public $trailColor = array(141, 240, 255);
    public $animation = "trail";
    public $animationColor = array(100, 100, 100);
    public $animationExplosionScale = 0.25;
    public $projectilespeed = 12;
    public $animationWidth = 4;
    public $trailLength = 40;

    function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
        parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);

    }
    protected function getAmmo()
    {
        return new BasicMissile();
    }
    
    public function getDamage($fireOrder)
    {
        return self::$fireModeToMissile[$fireOrder->firingMode]->getDamage();
    }
    public function setMinDamage(){     $this->minDamage = 20 - $this->dp;}
    public function setMaxDamage(){     $this->maxDamage = 20 - $this->dp;}     
}