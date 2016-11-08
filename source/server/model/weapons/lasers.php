<?php

    class Raking extends Weapon{
        public $raking = 10; //rake size
        public $priority = 8;
        public $damageType = "Raking"; //MANDATORY (first letter upcase) actual mode of dealing damage (Standard, Flash, Raking, Pulse...) - overrides $this->data["Damage type"] if set!
        public $weaponClass = "Laser"; //MANDATORY (first letter upcase) weapon class - overrides $this->data["Weapon type"] if set!
        
        
        function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
            parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
        }
        
        /*no longer needed, Raking mode recognized natively
        public function damage($target, $shooter, $fireOrder, $pos, $gamedata, $damage){
            
            $rake = $this->raking;
            
            $totalDamage = $damage;
            
            if ($this->piercing && $fireOrder->firingMode == 2)
                $rake = $totalDamage;
            
            $this->damages = array();
            
            if ($target instanceof FighterFlight)
            {
                $system = $target->getHitSystem($shooter, $fireOrder, $this);
                //$this->doDamage($target, $shooter, $system, $totalDamage, $fireOrder, $pos, $gamedata);
                $this->doDamage($target, $shooter, $system, $totalDamage, $fireOrder, null, $gamedata);
                return;
            }
            
            while(true){
                                
                if ($totalDamage <= 0)
                    break;
            
                if ($target->isDestroyed()) return;
                
                $trgtLoc = $target->getHitSectionChoice($shooter, $fireOrder, $this);
                $system = $target->getHitSystem($shooter, $fireOrder, $this, $trgtLoc);
                
                if ($system == null)
                    return;
                    
                if ($totalDamage - $this->raking >= 0){
                    //$this->doDamage($target, $shooter, $system, $rake, $fireOrder, $pos, $gamedata);
                    $this->doDamage($target, $shooter, $system, $rake, $fireOrder, null, $gamedata, $trgtLoc);
                    $totalDamage -= $this->raking;
                }else if ($totalDamage > 0){
                    //$this->doDamage($target, $shooter, $system, $totalDamage, $fireOrder, $pos, $gamedata);
                    $this->doDamage($target, $shooter, $system, $totalDamage, $fireOrder, null, $gamedata, $trgtLoc);
                    break;
                }else{
                    break;
                }
                    
            }
        }
        
        protected function doDamage($target, $shooter, $system, $damage, $fireOrder, $pos, $gamedata, $location = null){
            $damage = floor($damage);//make sure damage is a whole number, without fractions!
            $armour = $this->getSystemArmour($system, $gamedata, $fireOrder, $pos);
            
            foreach ($this->damages as $previous){
                if ($previous->systemid == $system->id)
                    $armour -= $previous->damage;
            }
            
            $systemHealth = $system->getRemainingHealth();
            $modifiedDamage = $damage;
            
            if ($armour < 0)
                $armour = 0;
            
            $destroyed = false;
            if ($damage-$armour >= $systemHealth){
                $destroyed = true;
                $modifiedDamage = $systemHealth + $armour;
            }

            
            $damageEntry = new DamageEntry(-1, $target->id, -1, $fireOrder->turn, $system->id, $modifiedDamage, $armour, 0, $fireOrder->id, $destroyed, "", $fireOrder->damageclass);
            $damageEntry->updated = true;
            $system->damage[] = $damageEntry;
            $this->damages[] = $damageEntry;
            $this->onDamagedSystem($target, $system, $modifiedDamage, $armour, $gamedata, $fireOrder);
            if ($damage-$armour > $systemHealth){            
                $damage = $damage-$modifiedDamage;                 
                $overkillSystem = $this->getOverkillSystem($target, $shooter, $system, $pos, $fireOrder, $gamedata, $location);
                if ($overkillSystem != null)
                    $this->doDamage($target, $shooter, $overkillSystem, $damage, $fireOrder, $pos, $gamedata, $location);
            }
        }*/
        
        
    } //endof class Raking
    

    class Laser extends Raking{
        public $uninterceptable = true;
    }


    class HeavyLaser extends Laser{
        public $name = "heavyLaser";
        public $displayName = "Heavy Laser";
        public $animation = "laser";
        public $animationColor = array(255, 11, 11);
        public $animationWidth = 4;
        public $animationWidth2 = 0.2;
        
        public $loadingtime = 4;
        public $overloadable = true;
        public $extraoverloadshots = 2;

        public $raking = 10;
        public $priority = 7;
        
        public $rangePenalty = 0.33;
        public $fireControl = array(-4, 2, 3); // fighters, <mediums, <capitals 
    
        function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
            parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
        }
        
        public function getDamage($fireOrder){        return Dice::d(10, 4)+20;   }
        public function setMinDamage(){     $this->minDamage = 24 ;      }
        public function setMaxDamage(){     $this->maxDamage = 60 ;      }
        
        
    }


    
    class MediumLaser extends Laser{
        
        public $name = "mediumLaser";
        public $displayName = "Medium Laser";
        public $animation = "laser";
        public $animationColor = array(255, 11, 11);
        public $animationExplosionScale = 0.18;
        public $animationWidth = 3;
        public $animationWidth2 = 0.3;
        public $priority = 8;
        
        public $loadingtime = 3;
        
        public $raking = 10;
        
        public $rangePenalty = 0.5;
        public $fireControl = array(-3, 2, 3); // fighters, <mediums, <capitals 
    
        function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
            parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
        }
        
        public function getDamage($fireOrder){        return Dice::d(10, 3)+12;   }
        public function setMinDamage(){     $this->minDamage = 15 ;      }
        public function setMaxDamage(){     $this->maxDamage = 42 ;      }
        
        
        
    }
    
    class LightLaser extends Laser{
        public $name = "lightLaser";
        public $displayName = "Light Laser";
        public $animation = "laser";
        public $animationColor = array(255, 11, 11);
        public $animationExplosionScale = 0.15;
        public $animationWidth = 2;
        public $animationWidth2 = 0.2;
        
        public $loadingtime = 2;
        public $priority = 8;
        
        public $raking = 10;

        public $rangePenalty = 1;
        public $fireControl = array(-2, 1, 2); // fighters, <mediums, <capitals 
    
        function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
            parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
        }
        
        public function getDamage($fireOrder){        return Dice::d(10, 2)+7;   }
        public function setMinDamage(){     $this->minDamage = 9 ;      }
        public function setMaxDamage(){     $this->maxDamage = 27 ;      }
    }
    

    class BattleLaser extends Laser{
        public $name = "battleLaser";
        public $displayName = "Battle Laser";
        public $animation = "laser";
        public $animationColor = array(255, 11, 115);
        public $animationWidth = 4;
        public $animationWidth2 = 0.2;
        
        public $loadingtime = 3;

        public $raking = 10;
        public $priority = 7;
        public $priorityArray = array(1=>7, 2=>2); //Piercing shots go early, to do damage while sections aren't detroyed yet!
        
        public $firingModes = array(
            1 => "Raking",
            2 => "Piercing"
        );
        
        public $damageTypeArray=array(1=>'Raking', 2=>'Piercing');
        //public $damageType = $this->damageTypeArray[1]; //MANDATORY (first letter upcase) actual mode of dealing damage (Standard, Flash, Raking, Pulse...) - overrides $this->data["Damage type"] if set!
        public $weaponClass = "Laser"; //MANDATORY (first letter upcase) weapon class - overrides $this->data["Weapon type"] if set!
        
        
        
                
        public $rangePenalty = 0.25;
        public $fireControlArray = array( 1=>array(-3, 3, 4), 2=>array(null,-1,0) ); //Raking and Piercing mode
        //public $fireControl = $this->fireControlArray[1]; // fighters, <mediums, <capitals 
    
        function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
            parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
        }
        
        public function getDamage($fireOrder){        return Dice::d(10, 4)+12;   }
        public function setMinDamage(){     $this->minDamage = 16 ;      }
        public function setMaxDamage(){     $this->maxDamage = 52 ;      }
        
    } //endof class BattleLaser


    
    class AssaultLaser extends Laser{
        public $name = "assaultLaser";
        public $displayName = "Assault Laser";
        public $animation = "laser";
        public $animationColor = array(255, 11, 115);
        public $animationWidth = 3;
        public $animationWidth2 = 0.3;
        public $priority = 8;
        
        public $loadingtime = 2;
                
        public $rangePenalty = 0.33;
        public $fireControl = array(-4, 3, 3); // fighters, <mediums, <capitals 
    
        function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
            parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
        }
        
        public function getDamage($fireOrder){        return Dice::d(10, 3)+4;   }
        public function setMinDamage(){     $this->minDamage = 7 ;      }
        public function setMaxDamage(){     $this->maxDamage = 34 ;      }
    }
    

    class AdvancedAssaultLaser extends Laser{
        
        public $name = "advancedAssaultLaser";
        public $displayName = "Adv. Assault Laser";
        public $animation = "laser";
        public $animationColor = array(255, 11, 115);
        public $animationWidth = 4;
        public $animationWidth2 = 0.4;
        
        public $loadingtime = 2;
        
        public $rangePenalty = 0.33;
        public $fireControl = array(-3, 4, 4); // fighters, <mediums, <capitals 
    
        function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
            parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
        }
        
        public function getDamage($fireOrder){        return Dice::d(10, 3)+10;   }
        public function setMinDamage(){     $this->minDamage = 13 ;      }
        public function setMaxDamage(){     $this->maxDamage = 40 ;      }
    }
    
    // Jasper
    class NeutronLaser extends Laser{
            public $name = "neutronLaser";
            public $displayName = "Neutron Laser";
            public $animation = "laser";
            public $animationColor = array(175, 225, 175);
            public $animationWidth = 4;
            public $animationWidth2 = 0.4;

            public $loadingtime = 3;
            public $overloadable = true;

            public $priority = 7;
            public $priorityArray = array(1=>7, 2=>2); //Piercing shots go early, to do damage while sections aren't detroyed yet!

            public $firingModes = array(
                1 => "Raking",
                2 => "Piercing"
            );
        
            public $damageTypeArray=array(1=>'Raking', 2=>'Piercing');
            public $fireControlArray = array( 1=>array(1, 4, 4), 2=>array(null,0,0) ); //Raking and Piercing mode
        
            public $extraoverloadshots = 2;        
            public $extraoverloadshotsArray = array(1=>2, 2=>0); //extra shots from overload are relevant only for Raking mode!

            public $rangePenalty = 0.25;

            function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
                parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
            }

            public function getDamage($fireOrder){ return Dice::d(10, 4)+15; }
            public function setMinDamage(){ $this->minDamage = 19 ; }
            public function setMaxDamage(){ $this->maxDamage = 55 ; }
    }



    class ImprovedNeutronLaser extends Laser{
        public $name = "improvedNeutronLaser";
        public $displayName = "Improved Neutron Laser";
        public $iconPath = "neutronLaser.png";
        public $animation = "laser";
        public $animationColor = array(175, 225, 175);
        public $animationWidth = 5;
        public $animationWidth2 = 0.5;

        public $loadingtime = 3;
        public $overloadable = true;
        public $priority = 7;
        public $priorityArray = array(1=>7, 2=>2); //Piercing shots go early, to do damage while sections aren't detroyed yet!

            public $firingModes = array(
                1 => "Raking",
                2 => "Piercing"
            );
        
            public $damageTypeArray=array(1=>'Raking', 2=>'Piercing');
            public $fireControlArray = array( 1=>array(1, 4, 5), 2=>array(null,0,1) ); //Raking and Piercing mode
        
            //public $extraoverloadshots = 3;        
            public $extraoverloadshotsArray = array(1=>3, 2=>0); //extra shots from overload are relevant only for Raking mode!

        public $rangePenalty = 0.25;

        function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
            parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
        }

        public function getDamage($fireOrder){ return Dice::d(10, 4)+18; }
        public function setMinDamage(){ $this->minDamage = 22 ; }
        public function setMaxDamage(){ $this->maxDamage = 58; }
    }



    class LaserLance extends HeavyLaser{

        public $name = "laserLance";
        public $displayName = "Laser Lance";
        public $animation = "laser";
        public $animationColor = array(220, 100, 11);
        public $animationWidth = 3;
        public $animationWidth2 = 0.3;
        public $priority = 8;
        public $priorityArray = array(1=>8, 2=>2); //Piercing shots go early, to do damage while sections aren't detroyed yet!

        public $loadingtime = 3;
        public $overloadable = false;

        public $raking = 10;

            public $firingModes = array(
                1 => "Raking",
                2 => "Piercing"
            );
        
            public $damageTypeArray=array(1=>'Raking', 2=>'Piercing');
            public $fireControlArray = array( 1=>array(-5, 3, 3), 2=>array(null,-1,-1) ); //Raking and Piercing mode

        public $rangePenalty = 0.5;
        //public $fireControl = array(-5, 3, 3); // fighters, <mediums, <capitals

        function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
            parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
        }

        public function getDamage($fireOrder){ return Dice::d(10, 3)+6; }
        public function setMinDamage(){ $this->minDamage = 9 ; }
        public function setMaxDamage(){ $this->maxDamage = 36 ; }
        }


    class HeavyLaserLance extends LaserLance{

        public $name = "heavyLaserLance";
        public $displayName = "Heavy Laser Lance";
        public $animationWidth = 4;
        public $animationWidth2 = 0.6;

        public $loadingtime = 4;

        public $priority = 7;
        public $priorityArray = array(1=>7, 2=>2); //Piercing shots go early, to do damage while sections aren't detroyed yet!

            public $firingModes = array(
                1 => "Raking",
                2 => "Piercing"
            );
        
            public $damageTypeArray=array(1=>'Raking', 2=>'Piercing');
            public $fireControlArray = array( 1=>array(-5, 3, 3), 2=>array(null,-1,-1) ); //Raking and Piercing mode

        public $rangePenalty = 0.5;
        //public $fireControl = array(-5, 3, 3); // fighters, <mediums, <capitals

        function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
            parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
        }

        public function getDamage($fireOrder){ return Dice::d(10, 4)+10; }
        public function setMinDamage(){ $this->minDamage = 14 - $this->dp; }
        public function setMaxDamage(){ $this->maxDamage = 50 - $this->dp; }
    }



    class TacLaser extends Laser{

        public $name = "tacLaser";
        public $displayName = "Tactical Laser";
        public $animation = "laser";
        public $animationColor = array(220, 60, 120);
        public $animationWidth = 3;
        public $animationWidth2 = 0.2;
        public $priority = 8;

        public $loadingtime = 2;

        public $raking = 10;

        public $rangePenalty = 0.5;
        public $fireControl = array(-5, 1, 2); // fighters, <mediums, <capitals

        function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
            parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
        }

        public function getDamage($fireOrder){ return Dice::d(10, 2)+8; }
        public function setMinDamage(){ $this->minDamage = 10 ; }
        public function setMaxDamage(){ $this->maxDamage = 28 ; }
    }



    class ImperialLaser extends Laser{

        public $name = "imperialLaser";
        public $displayName = "Imperial Laser";
        public $animation = "laser";
        public $animationColor = array(220, 60, 120);
        public $animationWidth = 5;
        public $animationWidth2 = 0.5;
        public $priority = 7;

        public $loadingtime = 4;

        public $raking = 10;

        public $rangePenalty = 0.33;
        public $fireControl = array(-5, 2, 3); // fighters, <mediums, <capitals

        function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
            parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
        }

        public function getDamage($fireOrder){ return Dice::d(10, 4)+8; }
        public function setMinDamage(){ $this->minDamage = 12 ; }
        public function setMaxDamage(){ $this->maxDamage = 48 ; }
    }



    class ImprovedBlastLaser extends Weapon{
        public $name = "improvedBlastLaser";
        public $displayName = "Improved Blast Laser";
        public $animation = "laser";
        public $animationColor = array(130, 25, 200);
        public $animationWidth = 5;
        public $animationWidth2 = 0.5;
        public $uninterceptable = true;
        public $priority = 6;

        public $loadingtime = 3;


        public $rangePenalty = 0.33;
        public $fireControl = array(-1, 3, 5); // fighters, <mediums, <capitals

        public $damageType = "Standard"; //MANDATORY (first letter upcase) actual mode of dealing damage (Standard, Flash, Raking, Pulse...) - overrides $this->data["Damage type"] if set!
        public $weaponClass = "Raking";
        
        
        function __construct($armour, $maxhealth, $powerReq, $startArc, $endArc){
            parent::__construct($armour, $maxhealth, $powerReq, $startArc, $endArc);
        }

        public function getDamage($fireOrder){ return Dice::d(10, 3)+14; }
        public function setMinDamage(){ $this->minDamage = 17 ; }
        public function setMaxDamage(){ $this->maxDamage = 44 ; }

    }


?>
