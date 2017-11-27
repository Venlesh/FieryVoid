<?php
class Babylon5 extends StarBaseSixSections{

	function __construct($id, $userid, $name,  $slot){
		parent::__construct($id, $userid, $name,  $slot);

		$this->pointCost = 1000;
		$this->faction = 'EA';//"EA defenses";
		$this->phpclass = "Babylon5";
		$this->shipClass = "Babylon 5 Diplomatic Station";
		$this->fighters = array("heavy"=>24); 
		$this->isd = 2259;

		$this->shipSizeClass = 3; //Enormous is not implemented
		$this->iniativebonus = -200; //no voluntary movement anyway
		$this->turncost = 0;
		$this->turndelaycost = 0;

		$this->forwardDefense = 20;
		$this->sideDefense = 24;

		$this->imagePath = "img/ships/orion.png";
		$this->canvasSize = 280; //Enormous Starbase

		$this->locations = array(41, 42, 2, 32, 31, 1);
		$this->hitChart = array(			
			0=> array(
				13=> "Structure",
				15 => "Scanner",
				17 => "Hangar",
				18 => "Cargo Bay",
				19 => "Reactor",
				20 => "C&C",
			),
		);


		$this->addPrimarySystem(new Reactor(4, 20, 0, 0));
		$this->addPrimarySystem(new CnC(4, 27, 0, 0)); 
		$this->addPrimarySystem(new Scanner(4, 20, 4, 7));
		$this->addPrimarySystem(new Scanner(4, 20, 4, 7));
		$this->addPrimarySystem(new Hangar(4, 32, 12));
		$this->addPrimarySystem(new CargoBay(4, 25));

		$this->addPrimarySystem(new Structure(4, 180));
		
//		for ($i = 0; $i < sizeof($this->sides); $i++){
		
		//fwd
		$min = 300;
		$max = 60;
		$systemsTemp = array(
			new StdParticleBeam(3, 4, 1, $min, $max),
			new InterceptorMKI(3, 4, 1, $min, $max),
			new SubReactor(3, 18, 0, 0),
			new CargoBay(3, 25),
			new Hangar(3, 8, 1),
			new Structure(3, 150)
		);
		$loc = 1;
		$this->hitChart[$loc] = array(
			1 => "Standard Particle Beam",
			2 => "Interceptor I",
			4 => "Cargo Bay",
			5 => "Hangar",
			6 => "Reactor",
			18 => "Structure",
			20 => "Primary",
		);
		foreach ($systemsTemp as $system){
			$this->addSystem($system, $loc);
		}
	
		//aft
		$min = 120;
		$max = 240;
		$systemsTemp = array(
				new StdParticleBeam(3, 4, 1, $min, $max),
				new InterceptorMKI(3, 4, 1, $min, $max),
				new SubReactor(3, 18, 0, 0),
				new CargoBay(3, 25),
				new Structure(3, 150)
		);
		$loc = 2;
		$this->hitChart[$loc] = array(
				1 => "Standard Particle Beam",
				2 => "Interceptor I",
				5 => "Cargo Bay",
				6 => "Reactor",
				18 => "Structure",
				20 => "Primary",
		);
		foreach ($systemsTemp as $system){
			$this->addSystem($system, $loc);
		}
		
		//side42
		$min = 180;
		$max = 300;
		$systemsTemp = array(
				new QuadParticleBeam(3, 8, 4, $min, $max),
				new InterceptorMKI(3, 4, 1, $min, $max),
				new SubReactor(3, 18, 0, 0),
				new CargoBay(3, 25),
				new Structure(3, 150)
		);
		$loc = 42;
		$this->hitChart[$loc] = array(
				1 => "Quad Particle Beam",
				2 => "Interceptor I",
				5 => "Cargo Bay",
				6 => "Reactor",
				18 => "Structure",
				20 => "Primary",
		);
		foreach ($systemsTemp as $system){
			$this->addSystem($system, $loc);
		}

		//side41
		$min = 240;
		$max = 360;
		$systemsTemp = array(
				new QuadParticleBeam(3, 8, 4, $min, $max),
				new InterceptorMKI(3, 4, 1, $min, $max),
				new SubReactor(3, 18, 0, 0),
				new CargoBay(3, 25),
				new Structure(3, 150)
		);
		$loc = 41;
		$this->hitChart[$loc] = array(
				1 => "Quad Particle Beam",
				2 => "Interceptor I",
				5 => "Cargo Bay",
				6 => "Reactor",
				18 => "Structure",
				20 => "Primary",
		);
		foreach ($systemsTemp as $system){
			$this->addSystem($system, $loc);
		}
		
		//side32
		$min = 60;
		$max = 180;
		$systemsTemp = array(
				new QuadParticleBeam(3, 8, 4, $min, $max),
				new InterceptorMKI(3, 4, 1, $min, $max),
				new SubReactor(3, 18, 0, 0),
				new CargoBay(3, 25),
				new Structure(3, 150)
		);
		$loc = 32;
		$this->hitChart[$loc] = array(
				1 => "Quad Particle Beam",
				2 => "Interceptor I",
				5 => "Cargo Bay",
				6 => "Reactor",
				18 => "Structure",
				20 => "Primary",
		);
		foreach ($systemsTemp as $system){
			$this->addSystem($system, $loc);
		}
		
		//side31
		$min = 0;
		$max = 120;
		$systemsTemp = array(
				new QuadParticleBeam(3, 8, 4, $min, $max),
				new InterceptorMKI(3, 4, 1, $min, $max),
				new SubReactor(3, 18, 0, 0),
				new CargoBay(3, 25),
				new Structure(3, 150)
		);
		$loc = 31;
		$this->hitChart[$loc] = array(
				1 => "Quad Particle Beam",
				2 => "Interceptor I",
				5 => "Cargo Bay",
				6 => "Reactor",
				18 => "Structure",
				20 => "Primary",
		);
		foreach ($systemsTemp as $system){
			$this->addSystem($system, $loc);
		}
		
	}
}
//}
