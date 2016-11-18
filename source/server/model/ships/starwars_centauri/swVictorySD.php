<?php
class swVictorySD extends BaseShip{
    /*StarWars Victory class Star Destroyer*/
	
    function __construct($id, $userid, $name,  $slot){
        parent::__construct($id, $userid, $name,  $slot);
        
	$this->pointCost = 1100;
	$this->faction = "StarWars Galactic Empire";
        $this->phpclass = "swVictorySD";
        $this->imagePath = "img/starwars/victory1.png";
        $this->shipClass = "Victory Star Destroyer";
        $this->shipSizeClass = 3;
	    
	$this->fighters = array("fighter flights"=>8);

	    
	$this->unofficial = true;
	    
	    //$this->isd = 2246;
        
        $this->forwardDefense = 16;
        $this->sideDefense = 20;
        
        $this->turncost = 1.25;
        $this->turndelaycost = 1.25;
        $this->accelcost = 5;
        $this->rollcost = 4;
        $this->pivotcost = 6;
	$this->iniativebonus = 0 *5; 
		
	    
	    
	$this->addPrimarySystem(new CnC(6, 20, 0, 0));
        $this->addPrimarySystem(new Reactor(5, 26, 0, 10));
        $this->addPrimarySystem(new Scanner(4, 14, 4, 3)); //split to Aft, too
        $this->addPrimarySystem(new Engine(4, 20, 0, 6, 5)); //split to Aft, too
	$hyperdrive = new JumpEngine(4, 24, 8, 20);
	$hyperdrive->displayName = 'Hyperdrive';
	$this->addPrimarySystem($hyperdrive);
	$this->addPrimarySystem(new Hangar(3, 48, 12));
         

        
		
        $this->addFrontSystem(new Thruster(3, 18, 0, 4, 1));
        $this->addFrontSystem(new Thruster(3, 18, 0, 4, 1));
	$this->addFrontSystem(new SWRayShield(3,13,8,4,330,30)); //$armour, $maxhealth, $powerReq, $shieldFactor, $startArc, $endArc
	$this->addFrontSystem(new SWCapitalConcussion(3, 300, 60, 4)); //armor, arc and number of weapon in common housing: structure and power data are calculated!
	$this->addFrontSystem(new SWHeavyTLaser(3, 300, 60, 2)); //armor, arc and number of weapon in common housing: structure and power data are calculated!
	$this->addFrontSystem(new SWHeavyTLaser(3, 300, 60, 2)); //armor, arc and number of weapon in common housing: structure and power data are calculated!
	$this->addFrontSystem(new SWHeavyLaser(3, 300, 60, 4)); //armor, arc and number of weapon in common housing: structure and power data are calculated!
	    

	    
        $this->addAftSystem(new Thruster(2, 18, 0, 4, 2));
	$this->addAftSystem(new Thruster(2, 18, 0, 4, 2));
	$this->addAftSystem(new Thruster(2, 18, 0, 4, 2));
        $this->addAftSystem(new Scanner(3, 12, 4, 3)); //split to Primary, too
        $this->addAftSystem(new Engine(4, 15, 0, 4, 5)); //split to Primary, too
	$this->addAftSystem(new SWRayShield(2,10,5,3,210,330)); //$armour, $maxhealth, $powerReq, $shieldFactor, $startArc, $endArc
	$this->addAftSystem(new SWHeavyLaser(2, 120, 240, 4)); //armor, arc and number of weapon in common housing: structure and power data are calculated!
	$this->addAftSystem(new SWHeavyLaser(2, 120, 240, 4)); //armor, arc and number of weapon in common housing: structure and power data are calculated!
	    
        
	    
	$this->addLeftSystem(new Thruster(3, 20, 0, 4, 3));
	$this->addLeftSystem(new SWRayShield(3,13,8,3,210,330)); //$armour, $maxhealth, $powerReq, $shieldFactor, $startArc, $endArc
	$this->addLeftSystem(new SWHeavyTLaser(3, 270, 30, 2)); //armor, arc and number of weapon in common housing: structure and power data are calculated!
	$this->addLeftSystem(new SWHeavyTLaser(3, 240, 0, 2)); //armor, arc and number of weapon in common housing: structure and power data are calculated!
	$this->addLeftSystem(new SWHeavyTLaser(3, 240, 0, 2));
	$this->addLeftSystem(new SWHeavyTLaser(3, 240, 0, 2));
	$this->addLeftSystem(new SWHeavyLaser(3, 240, 0, 4)); //armor, arc and number of weapon in common housing: structure and power data are calculated!
	$this->addLeftSystem(new SWCapitalConcussion(3, 240, 0, 4));
	$this->addLeftSystem(new SWCapitalConcussion(3, 240, 0, 4));

		
	    
	$this->addRightSystem(new Thruster(3, 20, 0, 4, 4));
	$this->addRightSystem(new SWRayShield(3,13,8,3,30,150)); //$armour, $maxhealth, $powerReq, $shieldFactor, $startArc, $endArc
	$this->addRightSystem(new SWHeavyTLaser(3, 330, 90, 2)); //armor, arc and number of weapon in common housing: structure and power data are calculated!
	$this->addRightSystem(new SWHeavyTLaser(3, 0, 120, 2)); //armor, arc and number of weapon in common housing: structure and power data are calculated!
	$this->addRightSystem(new SWHeavyTLaser(3, 0, 120, 2));
	$this->addRightSystem(new SWHeavyTLaser(3, 0, 120, 2));
	$this->addRightSystem(new SWHeavyLaser(3, 0, 120, 4)); //armor, arc and number of weapon in common housing: structure and power data are calculated!
	$this->addRightSystem(new SWCapitalConcussion(3, 0, 120, 4));
	$this->addRightSystem(new SWCapitalConcussion(3, 0, 120, 4));
	    
	    
        
        //0:primary, 1:front, 2:rear, 3:left, 4:right;
        $this->addFrontSystem(new Structure( 5, 55));
        $this->addAftSystem(new Structure( 3, 85));
        $this->addLeftSystem(new Structure( 4, 65));
        $this->addRightSystem(new Structure( 4, 65));
        $this->addPrimarySystem(new Structure( 5, 70));
	    
	    
        $this->hitChart = array(
            0=> array(
                    8 => "Structure",
                    10 => "Hyperdrive",
                    12 => "Scanner",
                    13 => "Engine",
                    17 => "Hangar",
                    19 => "Reactor",
                    20 => "C&C",
            ),
            1=> array(
                    5 => "Thruster",
		    6 => "Ray Shield",
                    9 => "Heavy Turbolaser",
                    10 => "Heavy Laser",
                    12 => "Concussion Missile Battery",
                    18 => "Structure",
                    20 => "Primary",
            ),
            2=> array(
                    7 => "Thruster",
		    8 => "Ray Shield",
                    10 => "Heavy Laser",
                    12 => "Scanner",
                    13 => "Engine",
                    17 => "Structure",
                    20 => "Primary",
            ),
            3=> array(
                    4 => "Thruster",
		    5 => "Ray Shield",
                    9 => "Heavy Turbolaser",
                    10 => "Heavy Laser",
                    13 => "Concussion Missile Battery",
                    18 => "Structure",
                    20 => "Primary",
            ),
            4=> array(
                    4 => "Thruster",
		    5 => "Ray Shield",
                    9 => "Heavy Turbolaser",
                    10 => "Heavy Laser",
                    13 => "Concussion Missile Battery",
                    18 => "Structure",
                    20 => "Primary",
            ),
       );
	    
	    
    }
}
?>