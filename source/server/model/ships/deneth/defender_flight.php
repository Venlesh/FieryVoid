<?php
class Defender extends FighterFlight{
    
    function __construct($id, $userid, $name,  $slot){
        parent::__construct($id, $userid, $name,  $slot);
        
    	$this->pointCost = 180;
        $this->faction = "Deneth";
        $this->phpclass = "Defender";
        $this->shipClass = "Defender Medium Fighters";
    	$this->imagePath = "img/ships/dragon.png";
        
        $this->forwardDefense = 6;
        $this->sideDefense = 7;
        $this->freethrust = 10;
        $this->offensivebonus = 3;
        $this->jinkinglimit = 8;
        $this->turncost = 0.33;
        $this->iniativebonus = 90;
        $this->populate();
    }
    public function populate(){
        $current = count($this->systems);
        $new = $this->flightSize;
        $toAdd = $new - $current;
        for ($i = 0; $i < $toAdd; $i++){
            $armour = array(2, 1, 2, 2);
            $fighter = new Fighter("dragon", $armour, 9, $this->id);
            $fighter->displayName = "Defender Medium Fighter";
            $fighter->imagePath = "img/ships/dragon.png";
            $fighter->iconPath = "img/ships/dragon_large.png";
            $fighter->addFrontSystem(new PairedParticleGun(330, 30, 1));
            $this->addSystem($fighter);
        }
    }
}
?>
