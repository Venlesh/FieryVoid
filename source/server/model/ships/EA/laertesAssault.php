<?php
class LaertesAssault extends MediumShip{
    
    function __construct($id, $userid, $name,  $slot){
        parent::__construct($id, $userid, $name,  $slot);
        
		$this->pointCost = 250;
		$this->faction = 'EA';//"EA defenses";
        $this->phpclass = "LaertesAssault";
        $this->imagePath = "img/ships/laertes.png";
        $this->shipClass = "Laertes Assault Corvette";
        $this->canvasSize = 100;
        $this->variantOf = "Laertes Police Corvette";
        $this->isd = 2200;
        $this->unofficial = true;
        
        $this->forwardDefense = 12;
        $this->sideDefense = 12;
        
        $this->turncost = 0.5;
        $this->turndelaycost = 0.5;
        $this->accelcost = 1;
        $this->rollcost = 1;
        $this->pivotcost = 2;
		$this->iniativebonus = 60;
         
        $this->addPrimarySystem(new Reactor(3, 10, 0, 0));
        $this->addPrimarySystem(new CnC(4, 8, 0, 0));
        $this->addPrimarySystem(new Scanner(3, 12, 4, 5));
		$this->addPrimarySystem(new Hangar(3, 2, 1));
		$this->addPrimarySystem(new CargoBay(4, 12));
		$this->addPrimarySystem(new Thruster(3, 10, 0, 3, 3));
		$this->addPrimarySystem(new Thruster(3, 10, 0, 3, 4));
		$this->addPrimarySystem(new StdParticleBeam(2, 4, 1, 180, 360));
		$this->addPrimarySystem(new StdParticleBeam(2, 4, 1, 0, 180));
		
        $this->addFrontSystem(new Thruster(3, 8, 0, 2, 1));
        $this->addFrontSystem(new Thruster(3, 8, 0, 2, 1));
        $this->addFrontSystem(new InterceptorMkI(2, 4, 1, 270, 90));
        $this->addFrontSystem(new InterceptorMkI(2, 4, 1, 240, 60));
        $this->addFrontSystem(new InterceptorMkI(2, 4, 1, 300, 120));
		
        $this->addAftSystem(new Thruster(3, 8, 0, 3, 2));
        $this->addAftSystem(new Thruster(3, 8, 0, 3, 2));
        $this->addAftSystem(new Engine(3, 11, 0, 6, 2));
        $this->addAftSystem(new InterceptorMkI(2, 4, 1, 90, 270));
	
        $this->addPrimarySystem(new Structure( 4, 40));
	    
		$this->hitChart = array(
                0=> array(
                        11 => "Thruster",
                		14 => "Cargo Bay",
                        16 => "Scanner",
                        17 => "Hangar",
                        19 => "Reactor",
                        20 => "C&C",
                ),
                1=> array(
                        5 => "Thruster",
						8 => "Interceptor I",
                        10 => "0:Standard Particle Beam",
                        17 => "Structure",
                        20 => "Primary",
                ),
                2=> array(
                        6 => "Thruster",
						8 => "0:Standard Particle Beam",
						9 => "Interceptor I",
                        10 => "Engine",
                        17 => "Structure",
                        20 => "Primary",
                ),
        );
    }

}



?>
