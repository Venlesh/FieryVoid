<?php
class technicalTargetDrone extends BaseShip{
/* WARNING: prone to change!*/
    
	function __construct($id, $userid, $name,  $slot){
		parent::__construct($id, $userid, $name,  $slot);
		$this->pointCost = 10;
		$this->faction = "Custom Ships";
		$this->phpclass = "technicalTargetDrone";
		$this->imagePath = "img/ships/optine.png";
		$this->shipClass = "Target Drone - DO NOT USE";
		$this->shipSizeClass = 3;
		$this->forwardDefense = 30;
		$this->sideDefense = 30;
		$this->fighters = array("light"=>12);        
		$this->turncost = 0.5;
		$this->turndelaycost = 0.5;
		$this->accelcost = 2;
		$this->rollcost = 3;
		$this->pivotcost = 4;
		$this->addPrimarySystem(new Reactor(6, 35, 0, 0));
		$this->addPrimarySystem(new CnC(6, 26, 0, 0));
		$this->addPrimarySystem(new Scanner(6, 23, 4, 6));
		$this->addPrimarySystem(new Engine(5, 20, 0, 20, 3));
		$this->addPrimarySystem(new Hangar(4, 2));
				$this->addPrimarySystem(new ImperialLaser(2, 12, 5, 0, 360));
				$this->addPrimarySystem(new ImperialLaser(2, 12, 5, 0, 360));
		
		$this->addFrontSystem(new Thruster(4, 10, 0, 4, 1));
		$this->addFrontSystem(new Thruster(4, 10, 0, 4, 1));
		$this->addFrontSystem(new Hangar(4, 6));
		$this->addFrontSystem(new AssaultLaser(3, 6, 4, 300, 60));
		$this->addFrontSystem(new ImperialLaser(3, 8, 5, 300, 60));
		$this->addFrontSystem(new ImperialLaser(3, 8, 5, 300, 60));
		$this->addFrontSystem(new TwinArray(3, 6, 2, 240, 60));
		$this->addFrontSystem(new TwinArray(3, 6, 2, 300, 120));
		
		$this->addAftSystem(new Thruster(4, 10, 0, 3, 2));
		$this->addAftSystem(new Thruster(4, 12, 0, 4, 2));
		$this->addAftSystem(new Thruster(4, 10, 0, 3, 2));
		$this->addAftSystem(new JumpEngine(5, 20, 3, 20));
		$this->addAftSystem(new AssaultLaser(3, 6, 4, 180, 300));
		$this->addAftSystem(new AssaultLaser(3, 6, 4, 60, 180));
		$this->addAftSystem(new TwinArray(2, 16, 2, 120, 0));
		$this->addAftSystem(new TwinArray(2, 16, 2, 0, 240));
		
		$this->addLeftSystem(new Thruster(4, 14, 0, 5, 3));
		$this->addLeftSystem(new ImperialLaser(3, 8, 5, 300, 0));
		$this->addLeftSystem(new TwinArray(3, 6, 2, 180, 0));
		
		$this->addRightSystem(new Thruster(4, 14, 0, 5, 4));
		$this->addRightSystem(new ImperialLaser(3, 8, 5, 0, 60));
		$this->addRightSystem(new TwinArray(3, 6, 2, 0, 180));
		
		//0:primary, 1:front, 2:rear, 3:left, 4:right;
		$this->addFrontSystem(new Structure( 5, 98));
		$this->addAftSystem(new Structure( 5, 95));
		$this->addLeftSystem(new Structure( 4, 98));
		$this->addRightSystem(new Structure( 4, 98));
		$this->addPrimarySystem(new Structure( 6, 95));
		   
		//d20 hit chart
		$this->hitChart = array(
			
			0=> array(
				10 => "Structure",
				13 => "Scanner",
				16 => "Engine",
				17 => "Hangar",
				19 => "Reactor",
				20 => "C&C",
			),
			1=> array(
				20 => "3:Thruster", //front targets Port Thruster - but once destroyed, Front Structure shall be next
			),
			2=> array(
				5 => "Thruster",
				8 => "Jump Engine",
				10 => "Assault Laser",
				12 => "Twin Array",
				18 => "Structure",
				20 => "Primary",
			),
			3=> array( //Stbd
				10 => "2:Thruster", //Aft Twin Arrays
				20 => "0:Imperial Laser", //PRIMARY Imperial Lasers
			),
			4=> array(
				4 => "Thruster",
				6 => "Imperial Laser",
				8 => "Twin Array",
				18 => "Structure",
				20 => "Primary",
			),
		);
    }
}