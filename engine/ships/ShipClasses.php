<?php
    class BaseShip{

        public $shipSizeClass = 3; //0:Light, 1:Medium, 2:Heavy, 3:Capital, 4:Enormous
        public $imagePath, $shipClass;
        public $systems = array();
        public $EW = array();
        public $elint = false;
        public $structureArmour = array();
        public $maxStructureHealth = array();
        public $agile = false;
        public $turncost, $turndelaycost, $accelcost, $rollcost, $pivotcost;
        public $currentturndelay = 0;
        public $iniative = "N/A";
        public $iniativebonus = 0;
        public $gravitic = false;
        public $phpclass;
        public $forwardDefense, $sideDefense;
        public $destroyed = false;
        public $pointCost = 0;
        public $faction = null;
        
        public $canvasSize = 200;

        //following values from DB
        public $id, $userid, $name, $campaignX, $campaignY;
        public $rolled = false;
        public $rolling = false;
        public $team;
        
        public $slotid;

        public $movement = array();
        
        function __construct($id, $userid, $name, $movement){
            $this->id = (int)$id;
            $this->userid = (int)$userid;
            $this->name = $name;

        }
        
        public function setMovement($movement)
        {
            $this->movement = $movement;
        }
        
        public function onConstructed($turn, $phase)
        {
            foreach ($this->systems as $system){
                $system->onConstructed($this, $turn, $phase);
                
                if ($system instanceof ElintArray)
                    $this->elint = true;
            }
        }
        
        protected function addSystem($system, $loc){
            
            $i = sizeof($this->systems);
            $system->setId($i);
            $system->location = $loc;
            $this->systems[$i] = $system;
            
        
        }
        
        protected function addFrontSystem($system){
            $this->addSystem($system, 1);
        }
        protected function addAftSystem($system){
            $this->addSystem($system, 2);
        }
        protected function addPrimarySystem($system){
            $this->addSystem($system, 0);
        }
        protected function addLeftSystem($system){
            $this->addSystem($system, 3);
        }
        protected function addRightSystem($system){
            $this->addSystem($system, 4);
        }
        
        public function addDamageEntry($damage){
        
            $system = $this->getSystemById($damage->systemid);
            $system->damage[] = $damage;
        
        }
        
        public function getLastTurnMoved(){
            $turn = 0;
            foreach($this->movement as $elementKey => $move) {
                if (!$move->preturn)
                    $turn = $move->turn;
            } 
            
            return $turn;
        }
        
        public function getMovementById($id){
			foreach ($this->movement as $move){
				if ($move->id === $id)
					return $move;
			}
			
			return null;
		}
        
        public function getLastMovement(){
            $m = 0;
            
            if (!is_array($this->movement))
                return null;
            
            foreach($this->movement as $elementKey => $move) {
                $m = $move;
            } 
            
            return $m;
        }
        
        public function getSpeed(){
            $m = $this->getLastMovement();
            if ($m == null)
                return 0;
                
            return $m->speed;
        }
        
        public function unanimatePreturnMovements($turn){
            foreach($this->movement as $elementKey => $move) {
                if ($move->turn == $turn && $move->type != "start" && $move->preturn){
                    if ($move->type == "pivotright" || $move->type == "pivotleft"){
                        $move->animated = false;
                    }
                }
            } 
        }
        
        public function unanimateMovements($turn){
        
            if (!is_array($this->movement))
                return;
            
            foreach($this->movement as $elementKey => $move) {
                if ($move->turn == $turn && $move->type != "start" && !$move->preturn){
                    if ($move->type == "move" || $move->type == "turnleft" || $move->type == "turnright" || $move->type == "slipright" || $move->type == "slipleft" || $move->type == "pivotright" || $move->type == "pivotleft"){
                        $move->animated = false;
                    }
                }
            } 
        }
        
        public function getSystemById($id){
            foreach ($this->systems as $system){
                if ($system->id == $id){
                    return $system;
                }
            }
            
            return null;
        }
        
        public function getSystemByName($name){
            foreach ($this->systems as $system){
                if ($system instanceof $name){
                    return $system;
                }
            }
            
            return null;
        }
        
        public function getHitChangeMod($shooter, $pos, $turn){
			$affectingSystems = array();
            foreach($this->systems as $system){
                
                if (!$this->checkIsValidAffectingSystem($system, $shooter, $pos, $turn))
                    continue;
                
                $mod = $systems->getHitChangeMod($shooter, $pos, $turn);
                
                if ( !$affectingSystems[$system->$defensiveType]
                    || $affectingSystems[$system->$defensiveType] < mod){
                    $affectingSystems[$system->$defensiveType] = mod;
                }
                
            }
            return array_sum($affectingSystems);
		}
        
        public function getDamageMod($shooter, $pos, $turn){
			$affectingSystems = array();
            foreach($this->systems as $system){
                
                if (!$this->checkIsValidAffectingSystem($system, $shooter, $pos, $turn))
                    continue;
                
                $mod = $systems->getDamageMod($shooter, $pos, $turn);
                
                if ( !$affectingSystems[$system->$defensiveType]
                    || $affectingSystems[$system->$defensiveType] < mod){
                    $affectingSystems[$system->$defensiveType] = mod;
                }
                
            }
            return array_sum($affectingSystems);
		}
        
        private function checkIsValidAffectingSystem($system, $shooter, $pos, $turn){
            if (!($system instanceof DefensiveSystem))
                return false;
                
            //If the system was destroyed last turn continue 
            //(If it has been destroyed during this turn, it is still usable)
            if ($system->isDestroyed($turn-1))
               return false;

            //If the system is offline either because of a critical or power management, continue
            if (isOfflineOnTurn($turn))
                return false;

            //if the system has arcs, check that the position is on arc
            if($system->startArc && $system->endArc){

                $tf = $this->getFacingAngle();

                //get the heading of position, not ship (in case ballistic)
                $shooterCompassHeading = mathlib::getCompassHeadingOfPos($this, $pos);

                //if not on arc, continue!
                if (!mathlib::isInArc($shooterCompassHeading, Mathlib::addToDirection($system->startArc,$tf), Mathlib::addToDirection($system->endArc,$tf) )){
                    return false;
                }
            }
            
            return true;
        }

        
        public function getLastTurnMovement($turn){
        
            $movement = null;
            if (!is_array($this->movement)){
                return array("x"=>0, "y"=>0);
            }
            foreach ($this->movement as $move){
                if ($move->turn == $turn){
                    if (!$movement)
                        $movement = $move;
                    
                    break;
                }
                $movement = $move;
            }
        
            return $movement;
        
        }
        
        public function getCoPos(){
        
            $movement = null;
            if (!is_array($this->movement)){
                return array("x"=>0, "y"=>0);
            }
            foreach ($this->movement as $move){
                $movement = $move;
            }
            return $movement->getCoPos();
        
        }
        
        public function getPreviousCoPos(){
            $pos = $this->getCoPos();
            
            for ($i = sizeof($this->movement)-1; $i>=0; $i--){
                $move = $this->movement[$i];
                $pPos = $move->getCoPos();
                
                if ( $pPos["x"] != $pos["x"] || $pPos["y"] != $pos["y"])
                    return $pPos;
            }
            
            return $pos;
        }
        
        public function getEWbyType($type, $turn, $target = null){
            
            foreach ($this->EW as $EW)
            {
                if ($EW->turn != $turn)
                    continue;

                if ($target && $EW->targetid != $target->id)
                    continue;

                if ($EW->type == $type){
                    return $EW->amount;
                }
            }

            return 0;
        
        }
        
        public function getDEW($turn){
            
            foreach ($this->EW as $EW){
                if ($EW->type == "DEW" && $EW->turn == $turn)
                    return $EW->amount;
            }
            
            return 0;
        
        }
        
        public function getBlanketDEW($turn){
            foreach ($this->EW as $EW){
                if ($EW->type == "BDEW" && $EW->turn == $turn)
                    return $EW->amount;
            }
            
            return 0;
        }

        public function getOEW($target, $turn){
        
			if ($target instanceof FighterFlight){
				foreach ($this->EW as $EW){
					if ($EW->type == "CCEW" && $EW->turn == $turn)
						return $EW->amount;
				}
			}else{
				foreach ($this->EW as $EW){
					if ($EW->type == "OEW" && $EW->targetid == $target->id && $EW->turn == $turn)
						return $EW->amount;
				}
			}
        
            
            
            return 0;
        }
        
        public function getOEWTargetNum($turn){
        
			$amount = 0;
            foreach ($this->EW as $EW){
                if ($EW->type == "OEW" && $EW->turn == $turn)
                    $amount++;
            }
            
            return $amount;
        }
        
        public function getFacingAngle(){
            $movement = null;
            
            foreach ($this->movement as $move){
                $movement = $move;
            }
        
            return $movement->getFacingAngle();
        }
        
        public function getDefenceValuePos($pos){
            $tf = $this->getFacingAngle();
            $shooterCompassHeading = mathlib::getCompassHeadingOfPos($this, $pos);
          
            return $this->doGetDefenceValue($tf,  $shooterCompassHeading);
        }
        
        public function getDefenceValue($shooter){
            $tf = $this->getFacingAngle();
            $shooterCompassHeading = mathlib::getCompassHeadingOfShip($this, $shooter);
          
            return $this->doGetDefenceValue($tf,  $shooterCompassHeading);
            
        }
        
        
        public function doGetDefenceValue($tf, $shooterCompassHeading){
            if (mathlib::isInArc($shooterCompassHeading, Mathlib::addToDirection(330,$tf), Mathlib::addToDirection(30,$tf) )){
               return $this->forwardDefense;
            }else if (mathlib::isInArc($shooterCompassHeading, Mathlib::addToDirection(150,$tf), Mathlib::addToDirection(210,$tf) )){
                return $this->forwardDefense;
            }else if (mathlib::isInArc($shooterCompassHeading, Mathlib::addToDirection(210,$tf), Mathlib::addToDirection(330,$tf) )){
                return $this->sideDefense;
            }  else if (mathlib::isInArc($shooterCompassHeading, Mathlib::addToDirection(30,$tf), Mathlib::addToDirection(150,$tf) )){
                return $this->sideDefense;
            } 
                
            return $this->sideDefense;
        }
        
        public function doGetHitSection($tf, $shooterCompassHeading, $turn, $weapon){
            $location = 0;
            
            if (mathlib::isInArc($shooterCompassHeading, Mathlib::addToDirection(330,$tf), Mathlib::addToDirection(30,$tf) )){
                $location = 1;
            }else if (mathlib::isInArc($shooterCompassHeading, Mathlib::addToDirection(150,$tf), Mathlib::addToDirection(210,$tf) )){
                $location = 2;
            }else if (mathlib::isInArc($shooterCompassHeading, Mathlib::addToDirection(210,$tf), Mathlib::addToDirection(330,$tf) )){
                $location = 3;
            }else if (mathlib::isInArc($shooterCompassHeading, Mathlib::addToDirection(30,$tf), Mathlib::addToDirection(150,$tf) )){
                $location = 4;
            } 
           
            //print ($this->name ." shootercompas: $shooterCompassHeading, targetfacing: $tf, location: $location \n");
            
                
            return $location;
        }
           
        
        
        public function getHitSection($shooter, $turn, $weapon){
            
            $tf = $this->getFacingAngle();
            $shooterCompassHeading = null;
            
            if ($weapon->ballistic){
                $movement = $shooter->getLastTurnMovement($turn);
                $pos = mathlib::hexCoToPixel($movement->x, $movement->y);
                
                $shooterCompassHeading = mathlib::getCompassHeadingOfPos($this, $pos);
            }else{
                $shooterCompassHeading = mathlib::getCompassHeadingOfShip($this, $shooter);
            }
                       
            
            $location =  $this->doGetHitSection($tf, $shooterCompassHeading, $turn, $weapon);
            
            $rolled = Movement::isRolled($this);
            
            if ($rolled && $location == 3){
                $location = 4;
            }else if ($rolled && $location == 4){
                $location = 3;
            }   
            
            if ($location != 0){
                if ((($this instanceof MediumShip && Dice::d(20)>17 ) || Dice::d(10)>9) 
					&& !$weapon->flashDamage)
                    return 0;
                    
                $structure = $this->getStructureSystem($location);
                if ($structure != null && $structure->isDestroyed($turn-1))
                    return 0;
            }
            
            return $location;
            
        }
        
        public function getStructureSystem($location){
            foreach ($this->systems as $system){
                if ($system instanceof Structure  && $system->location == $location){
                    return $system;
                }
            }
            
            return null;
        }
        
        public function getFireControlIndex(){
              return 2;
               
        }
        
        public function isDestroyed($turn = false){
        
            foreach($this->systems as $system){
                /*
                if ($system instanceof Reactor && $system->isDestroyed()){
                    return true;
                }
                */
                if ($system instanceof Structure && $system->location == 0 && $system->isDestroyed($turn)){
                    return true;
                }
                
            }
            
            return false;
        }
        
        public function isPowerless(){
        
            $output = 0;
            
            foreach($this->systems as $system){
            
                if ($system->isDestroyed())
                    continue;
            
                if ($system instanceof Reactor){
                    $output += $system->outputMod;
                }else if ($system->powerReq > 0){
                    $output += $system->powerReq;
                }
            
            }
            
            if ($output >= 0)
                return false;
        
            return true;
        }
        
        
        public function getHitSystem($pos, $shooter, $fire, $weapon, $location = null){
        
			$system = null;
			if ($fire->calledid != -1){
				$system = $this->getSystemById($fire->calledid);
			}
			if ($system != null && !$system->isDestroyed())
				return $system;
        
            if ($location === null)
                $location = $this->getHitSection($shooter, $fire->turn, $weapon);
            
            //print("getHitSystem, location: $location ");
            $systems = array();
            $totalStructure = 0;

            foreach ($this->systems as $system){
                
                if ($system->location == $location){
                    //if ($system->isDestroyed())
                    //  continue;
                        
                     $systems[] = $system;
                        
                    if ($system->name == "structure"){
                        $multiply = 0.5;
                        if ($location == 0)
                            $multiply = 2;
                            
                        $totalStructure += round($system->maxhealth * $multiply);
                    }else{
                        $totalStructure += $system->maxhealth;
                    }
                    
                }
            
                
            }   
            
            $roll = Dice::d($totalStructure);
            $goneTrough = 0;

            
            foreach ($systems as $system){
                
                $health = 0;
            
                if ($system->name == "structure"){
                    $multiply = 0.5;
                    if ($location == 0)
                        $multiply = 2;
                        
                    $health = round($system->maxhealth * $multiply);
                }else{
                    $health = $system->maxhealth;
                }
                
                if ($roll > $goneTrough && $roll <= ($goneTrough + $health)){
                    //print("hitting: " . $system->displayName . " location: " . $system->location ."\n\n");
                    if ($system->isDestroyed()){
                        if ($system instanceof Structure){
                            if ($system->location == 0)
                                return null;
                                
                            return $this->getHitSystem($pos, $shooter, $fire, $weapon, 0);
                        }
                        $structure = $this->getStructureSystem($location);
                        if ($structure == null || $structure->isDestroyed()){
                            if ($structure->location == 0)
                                return null;
                                
                            return $this->getHitSystem($pos, $shooter, $fire, $weapon, 0);
                        }else{
                            return $structure;
                        }
                            
                        
                    }
                    return $system;
                }
                $goneTrough += $health;
                
            }
            
            return null;
        
        }
        
        public function getPiercingDamagePerLoc($damage){
            return ceil($damage/3);
        }
        
        public function getPiercingLocations($shooter, $pos, $turn, $weapon){
						
            $tf = $this->getFacingAngle();
            $shooterCompassHeading = mathlib::getCompassHeadingOfPos($this, $pos);
            $location =  $this->doGetHitSection($tf, $shooterCompassHeading, $turn, $weapon);
            
            $locs = array();
            $finallocs = array();

            if ($location == 1 || $location == 2){
                $locs[] = 1;
                $locs[] = 0;
                $locs[] = 2;
            }else if ($location == 3 || $location == 4){
                $locs[] = 3;
                $locs[] = 0;
                $locs[] = 4;
            }
            
            foreach ($locs as $loc){
                $structure = $this->getStructureSystem($loc);
                if ($structure != null && !$structure->isDestroyed()){
                    $finallocs[] = $loc;
                }
            }
            
            return $finallocs;
            
        }
        
        
        public static function hasBetterIniative($a, $b){
            if ($a->iniative > $b->iniative)
                return true;
            
            if ($a->iniative < $b->iniative)
                return false;
                
            if ($a->iniative == $b->iniative){
                if ($a->iniativebonus > $b->iniativebonus)
                    return true;
                
                if ($b->iniativebonus > $a->iniativebonus)
                    return false;
                
                if ($a->id > $b->id)
                    return true;
            }
            
            return false;
        }
        
        public function getAllFireOrders()
        {
            $orders = array();
            
            foreach ($this->systems as $system)
            {
                $orders = array_merge($orders, $system->fireOrders);
            }
            
            return $orders;
        }
        
    }
    
    class HeavyCombatVessel extends BaseShip{
    
        public $shipSizeClass = 2;
        
        
        
        function __construct($id, $userid, $name, $movement){
            parent::__construct($id, $userid, $name,$movement);
        }
     
            
         public function doGetHitSection($tf, $shooterCompassHeading, $turn, $weapon){
            
            $location = 0;
            
            if (mathlib::isInArc($shooterCompassHeading, Mathlib::addToDirection(270,$tf), Mathlib::addToDirection(90,$tf) )){
                $location = 1;
            }else if (mathlib::isInArc($shooterCompassHeading, Mathlib::addToDirection(90,$tf), Mathlib::addToDirection(270,$tf) )){
                $location = 2;
            }
           
                
            return $location;
        }

    
    }
    
    class MediumShip extends BaseShip{
    
        public $shipSizeClass = 1;
        
        function __construct($id, $userid, $name, $movement){
            parent::__construct($id, $userid, $name, $movement);
        }
        
        public function getFireControlIndex(){
              return 1;
               
        }
        
        public function doGetHitSection($tf, $shooterCompassHeading, $turn, $weapon){
            
            $location = 0;
            
            if (mathlib::isInArc($shooterCompassHeading, Mathlib::addToDirection(270,$tf), Mathlib::addToDirection(90,$tf) )){
                $location = 1;
            }else if (mathlib::isInArc($shooterCompassHeading, Mathlib::addToDirection(90,$tf), Mathlib::addToDirection(270,$tf) )){
                $location = 2;
            }
           
          
                
            return $location;
        }
        
        public function getHitSystem($pos, $shooter, $fire, $weapon, $location = null){
        
			$system = null;
			if ($fire->calledid != -1){
				$system = $this->getSystemById($fire->calledid);
			}
			if ($system != null && !$system->isDestroyed())
				return $system;
        
            if ($location == null)
                $location = $this->getHitSection($shooter, $fire->turn, $weapon);
            

            //print("getHitSystem, location: $location ");
            $systems = array();
            $totalStructure = 0;

            foreach ($this->systems as $system){
                
                if ($system->location == $location || $system instanceof Structure){
                    //if ($system->isDestroyed())
                    //  continue;
                        
                     $systems[] = $system;
                        
                    if ($system instanceof Structure){
                        $multiply = 1;
                            
                        $totalStructure += round($system->maxhealth * $multiply);
                    }else{
                        $totalStructure += $system->maxhealth;
                    }
                    
                }
            
                
            }   
            
            $roll = Dice::d($totalStructure);
            $goneTrough = 0;

            
            foreach ($systems as $system){
                
                $health = 0;
            
                if ($system->name == "structure"){
                    $multiply = 1;
                        
                    $health = round($system->maxhealth * $multiply);
                }else{
                    $health = $system->maxhealth;
                }
                
                if ($roll > $goneTrough && $roll <= ($goneTrough + $health)){
                    //print("hitting: " . $system->displayName . " location: " . $system->location ."\n\n");
                    if ($system->isDestroyed()){
                        if ($system instanceof Structure){
                            return null;
                                
                            return $this->getHitSystem($pos, $shooter, $fire, $weapon, 0);
                        }
                        $structure = $this->getStructureSystem(0);
                        if ($structure == null || $structure->isDestroyed()){
                            return null;
                          
                        }else{
                            return $structure;
                        }
                            
                        
                    }
                    return $system;
                }
                $goneTrough += $health;
                
            }
            
            return null;
        
        }
        
        public function getHitSystem2($pos, $shooter, $fire, $weapon, $location = null){
        
			$system = null;
			if ($fire->calledid != -1){
				$system = $this->getSystemById($fire->calledid);
			}
			if ($system != null && !$system->isDestroyed())
				return $system;
        
            if ($location == null)
                $location = $this->getHitSection($shooter, $fire->turn, $weapon);
            

            //print("getHitSystem, location: $location ");
            $systems = array();
            $totalStructure = 0;

            foreach ($this->systems as $system){
                
                if ($system->location == $location || $system instanceof Structure
                        || $system->location == 0){
                    //if ($system->isDestroyed())
                    //  continue;
                        
                     $systems[] = $system;
                     
                    $multiply = 1;
                    
                    if ($system->location == $location){
                        $multiply = 2;
                    }       
                    $totalStructure += round($system->maxhealth * $multiply);
                    
                    
                }
            
                
            }   
            
            $roll = Dice::d($totalStructure);
            $goneTrough = 0;

            
            foreach ($systems as $system){
                
                $health = 0;
            
                if ($system->location == $location){
                    $multiply = 2;
                        
                    $health = round($system->maxhealth * $multiply);
                }else{
                    $health = $system->maxhealth;
                }
                
                if ($roll > $goneTrough && $roll <= ($goneTrough + $health)){
                    //print("hitting: " . $system->displayName . " location: " . $system->location ."\n\n");
                    if ($system->isDestroyed()){
                        if ($system instanceof Structure){
                            return null;
                        }
                        
                        if ($location !== 0){
                            return $this->getHitSystem($pos, $shooter, $fire, $weapon, 0);
                        }
                        
                        $structure = $this->getStructureSystem(0);
                        if ($structure == null || $structure->isDestroyed()){
                            return null;
                          
                        }else{
                            return $structure;
                        }
                                
                        
                    }
                    return $system;
                }
                $goneTrough += $health;
                
            }
            
            return null;
        
        }   

    
    }

?>
