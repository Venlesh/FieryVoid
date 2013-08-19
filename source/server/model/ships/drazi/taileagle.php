<?php
class Taileagle extends MediumShipLeftRight{
    
    function __construct($id, $userid, $name,  $slot){
        parent::__construct($id, $userid, $name,  $slot);
        
	$this->pointCost = 325;
	$this->faction = "Drazi";
        $this->phpclass = "Taileagle";
        $this->imagePath = "img/ships/stareagle.png";
        $this->shipClass = "Taileagle Escort Frigate";
        $this->agile = true;
        $this->canvasSize = 100;
        $this->occurence = "uncommon";
        
        $this->forwardDefense = 12;
        $this->sideDefense = 11;
        
        $this->turncost = 0.33;
        $this->turndelaycost = 0.25;
        $this->accelcost = 2;
        $this->rollcost = 2;
        $this->pivotcost = 1;
	$this->iniativebonus = 60;

        $this->addPrimarySystem(new StdParticleBeam(4, 4, 1, 240, 120));
        $this->addPrimarySystem(new Reactor(5, 10, 0, 2));
        $this->addPrimarySystem(new CnC(5, 8, 0, 0));
        $this->addPrimarySystem(new Scanner(4, 10, 3, 6));
        $this->addPrimarySystem(new Engine(5, 10, 0, 7, 2));
	$this->addPrimarySystem(new Hangar(4, 1));
	$this->addPrimarySystem(new Thruster(4, 10, 0, 4, 1));
	$this->addPrimarySystem(new Thruster(4, 8, 0, 3, 1));
	$this->addPrimarySystem(new Thruster(5, 14, 0, 7, 2));
		
        $this->addLeftSystem(new Thruster(4, 11, 0, 4, 3));
        $this->addLeftSystem(new StdParticleBeam(4, 4, 1, 240, 60));
        $this->addLeftSystem(new StdParticleBeam(4, 4, 1, 240, 60));
		
        $this->addRightSystem(new Thruster(4, 11, 0, 4, 4));
        $this->addRightSystem(new StdParticleBeam(4, 4, 1, 300, 120));
        $this->addRightSystem(new StdParticleBeam(4, 4, 1, 300, 120));
		
        $this->addPrimarySystem(new Structure( 5, 36));
    }
}
?>
