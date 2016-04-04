<?php
class Prophet extends BaseShip{
    /*Orieni Prophet Command Ship, variant ISD 2007 (WoCR)*/
    function __construct($id, $userid, $name,  $slot){
        parent::__construct($id, $userid, $name,  $slot);
        
		$this->pointCost = 880;
		$this->faction = "Orieni";
        $this->phpclass = "Prophet";
        $this->imagePath = "img/ships/prophet.png";
        $this->shipClass = "Prophet Command Ship (2007)";
        $this->shipSizeClass = 3;
        $this->fighters = array("normal"=>30);
        $this->canvasSize = 280;
		
        $this->forwardDefense = 19;
        $this->sideDefense = 19;
        
        $this->turncost = 1.33;
        $this->turndelaycost = 1.33;
        $this->accelcost = 6;
        $this->rollcost = 4;
        $this->pivotcost = 3;

        $this->limited = 33;
        
        $this->addPrimarySystem(new Reactor(5, 34, 0, 0));
        $this->addPrimarySystem(new CnC(6, 30, 0, 0));
        $this->addPrimarySystem(new Scanner(5, 30, 4, 7));
        $this->addPrimarySystem(new Engine(5, 30, 0, 8, 4));
        $this->addPrimarySystem(new Hangar(5, 38, 30));
        $this->addPrimarySystem(new JumpEngine(5, 40, 6, 25));
        $this->addPrimarySystem(new HKControlNode(5, 24, 3, 3));
        
        $this->addFrontSystem(new Thruster(3, 15, 0, 2, 1));
        $this->addFrontSystem(new Thruster(3, 15, 0, 2, 1));
        $this->addFrontSystem(new Thruster(3, 15, 0, 2, 1));
        $this->addFrontSystem(new CargoBay(2, 25));
        $this->addFrontSystem(new SMissileRack(5, 6, 0, 270, 90));
        $this->addFrontSystem(new HeavyGausscannon(4, 10, 4, 270, 90));
        $this->addFrontSystem(new SMissileRack(5, 6, 0, 270, 90));
        $this->addFrontSystem(new RapidGatling(2, 4, 1, 240, 120));
        $this->addFrontSystem(new RapidGatling(2, 4, 1, 240, 120));
        $this->addFrontSystem(new RapidGatling(2, 4, 1, 240, 120));

        $this->addAftSystem(new SMissileRack(5, 6, 0, 90, 270));
        $this->addAftSystem(new HeavyGausscannon(2, 10, 4, 90, 270));
        $this->addAftSystem(new RapidGatling(1, 4, 1, 60, 300));
        $this->addAftSystem(new RapidGatling(1, 4, 1, 60, 300));
        $this->addAftSystem(new RapidGatling(1, 4, 1, 60, 300));
        $this->addAftSystem(new Thruster(3, 15, 0, 2, 2));
        $this->addAftSystem(new Thruster(3, 15, 0, 2, 2));
        $this->addAftSystem(new Thruster(3, 15, 0, 2, 2));
        $this->addAftSystem(new Thruster(3, 15, 0, 2, 2));
        $this->addAftSystem(new CargoBay(2, 25));
		
        $this->addLeftSystem(new Thruster(4, 25, 0, 6, 3));
        $this->addLeftSystem(new CargoBay(2, 25));
        $this->addLeftSystem(new SMissileRack(5, 6, 0, 240, 60));
        $this->addLeftSystem(new HeavyLaserLance(3, 6, 4, 180, 360));
        $this->addLeftSystem(new HeavyLaserLance(3, 6, 4, 180, 360));
        $this->addLeftSystem(new RapidGatling(2, 4, 1, 180, 360));
        $this->addLeftSystem(new RapidGatling(2, 4, 1, 180, 360));
        $this->addLeftSystem(new RapidGatling(2, 4, 1, 180, 360));
        $this->addLeftSystem(new HeavyGausscannon(3, 10, 4, 180, 360));


        $this->addRightSystem(new Thruster(4, 25, 0, 6, 4));
        $this->addRightSystem(new CargoBay(2, 25));
        $this->addRightSystem(new SMissileRack(5, 6, 0, 300, 120));
        $this->addRightSystem(new HeavyLaserLance(3, 6, 4, 0, 180));
        $this->addRightSystem(new HeavyLaserLance(3, 6, 4, 0, 180));
        $this->addRightSystem(new RapidGatling(2, 4, 1, 0, 180));
        $this->addRightSystem(new RapidGatling(2, 4, 1, 0, 180));
        $this->addRightSystem(new RapidGatling(2, 4, 1, 0, 180));
        $this->addRightSystem(new HeavyGausscannon(3, 10, 4, 0, 180));


		//structures
        $this->addFrontSystem(new Structure(4, 60));
        $this->addAftSystem(new Structure(4, 60));
        $this->addLeftSystem(new Structure(4, 68));
        $this->addRightSystem(new Structure(4, 68));
        $this->addPrimarySystem(new Structure(5, 60));
        
        
        
	//d20 hit chart
	$this->hitChart = array(
		
		//PRIMARY
		0=> array( 
			7 => "Structure",
			9 => "Jump Engine",
			11 => "Scanner",
			13 => "Engine",
			16 => "Hangar",
			18 => "HK-Control Node",
			19 => "Reactor",
			20 => "C&C",
		),
		//Forward
		1=> array(
			3 => "Thruster",
			5 => "Class-S Missile Rack",
			7 => "Heavy Gauss Cannon",
			9 => "Rapid Gatling Railgun",
			12 => "Cargo Bay",
			18 => "Structure",
			20 => "Primary",
		),
		//Aft
		2=> array(
			5 => "Thruster",
			6 => "Class-S Missile Rack",
			8 => "Heavy Gauss Cannon",
			10 => "Rapid Gatling Railgun",
			12 => "Cargo Bay",
			18 => "Structure",
			20 => "Primary",
		),
		//Port
		3=> array(
			3 => "Thruster",
			5 => "Heavy Laser Lance",
			7 => "Heavy Gauss Cannon",
			8 => "Class-S Missile Rack",
			10 => "Rapid Gatling Railgun",
			12 => "Cargo Bay",
			18 => "Structure",
			20 => "Primary",
		),
		//Starboard
		4=> array(
			3 => "Thruster",
			5 => "Heavy Laser Lance",
			7 => "Heavy Gauss Cannon",
			8 => "Class-S Missile Rack",
			10 => "Rapid Gatling Railgun",
			12 => "Cargo Bay",
			18 => "Structure",
			20 => "Primary",
		),
	);
        
        
    }

}



?>
