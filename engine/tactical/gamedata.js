gamedata = {

    gamewidth: 1600,
    gameheight: 1000,
    zoom:1.5,
    zoomincrement: 0.1,
    scroll:  {x:0,y:0},
    scrollOffset: {x:0,y:0},
    animating: false,
    ships: Array(),
	ballistics: Array(),
    thisplayer: 1,
    waiting: false,
    selectedShips: Array(),
    targetedShips: Array(),
    selectedSystems: Array,
    effectsDrawing: false,
    finished: false,
	gamephase: 0,
    
    mouseOverShipId: -1,
    
        
    selectShip: function(ship, add){
        if (!add){
            for (var i in gamedata.selectedShips){
                var s2 = gamedata.selectedShips[i];
                gamedata.unSelectShip(s2);
            }
            gamedata.selectedShips = Array();
            
        }
            
        
        
        if (!gamedata.isSelected(ship)){   
            gamedata.selectedShips.push(ship);
            if (gamedata.gamephase == 1)
                ew.adEWindicators(ship);
            
            gamedata.shipStatusChanged(ship);
            shipWindowManager.checkIfAnyStatusOpen(ship);
            gamedata.selectedSystems = Array();
           
        } 
        
    },
    
    targetShip: function(ship, add){
        if (!add){
            for (var i in gamedata.targetedShips){
                var s2 = gamedata.targetedShips[i];
                gamedata.unTargetShip(s2);
            }
            gamedata.targetedShips = Array();
            
        }
            
        
        
        if (!gamedata.isTargeted(ship)){   
            gamedata.targetedShips.push(ship);
            
                
            shipWindowManager.checkShipWindow(ship);
        } 
        
    },
    
    unTargetShip: function(ship){
        
    },
    
    unSelectShip: function(ship){
        ew.RemoveEWEffectsFromShip(ship);
        gamedata.selectedSystems = Array();
    },
    
    isTargeted: function(ship){
        if ($.inArray(ship, gamedata.targetedShips) >= 0)
            return true;
            
        return false;
    },
    
    isSelected: function(ship){
        if ($.inArray(ship, gamedata.selectedShips) >= 0)
            return true;
            
        return false;
    },
    
    getSelectedShip: function(){
        for (var i in gamedata.selectedShips){
            return gamedata.selectedShips[i];
            
        }
    },
    
    getTargetedShip: function(){
        for (var i in gamedata.targetedShips){
            return gamedata.targetedShips[i];
            
        }
    },
    
    getActiveShip: function(){
        return gamedata.getShip(gamedata.activeship);
            
    },
    
    getShip: function(id){
        for (var i in gamedata.ships){
            if (gamedata.ships[i].id == id){
                return gamedata.ships[i];
            }
        }
        
        return null;
    
    },
    
    isMyShip: function(ship){
        return (ship.userid == gamedata.thisplayer);
    },
    
    shipStatusChanged: function(ship){
        botPanel.onShipStatusChanged(ship);
        shipWindowManager.setData(ship);
        gamedata.checkGameStatus();
    },
    
    onCommitClicked: function(e){
        
        if (gamedata.waiting == true)
            return;     
        
        if(gamedata.status == "FINISHED")
            return;
        
        if (gamedata.gamephase == 1){
        
            if (!shipManager.power.checkPowerPositive()){
                window.confirm.error("You have ships with insufficient power. You need to turn off systems before you can commit the turn.", function(){});
                return false;
            }
        
            for (var i in gamedata.ships){
                var ship = gamedata.ships[i];
                ew.convertUnusedToDEW(ship);
                
            }
            ajaxInterface.submitGamedata();
            
        }else if (gamedata.gamephase == 2){
            UI.shipMovement.hide();
            var ship = gamedata.getActiveShip();
            if (shipManager.movement.isMovementReady(ship)){
                gamedata.waiting = true;
                ajaxInterface.submitGamedata();
            }else{
                return false;
            }
        }else if (gamedata.gamephase == 3){
            ajaxInterface.submitGamedata();
        }else if (gamedata.gamephase == 4){
            ajaxInterface.submitGamedata();
        }
        
    
            
    },
    
    onCancelClicked: function(e){
        if (gamedata.gamephase == 2){
            var ship = gamedata.getActiveShip();
            shipManager.movement.deleteMove(ship);
            
            
        }
    },
    
    getActiveShipName: function(){
        var ship = gamedata.getActiveShip();
        if (ship)
            return ship.name;
            
        return "";
    },
    
    getPhasename: function(){
        if (gamedata.gamephase == 1)
            return "INITIAL ORDERS";
            
        if (gamedata.gamephase == 2)
            return "MOVEMENT ORDERS:";
        
        if (gamedata.gamephase == 3)
            return "FIRE ORDERS";
            
        if (gamedata.gamephase == 4)
            return "FINAL ORDERS";
            
        return "ERROR"
    },
    
    setPhaseClass: function(){
    
        var b = $("body");
        
        b.removeClass("phase1");
        b.removeClass("phase2");
        b.removeClass("phase3");
        b.removeClass("phase4");
    
        b.addClass("phase"+gamedata.gamephase);
    },
    
    initPhase: function(){
    
        shipManager.initShips();
        ballistics.initBallistics();
        
        gamedata.setPhaseClass();
        for (var i in gamedata.ships){
            gamedata.shipStatusChanged(gamedata.ships[i]);
        }
        
         if (gamedata.gamephase == 4){
            if (gamedata.waiting == false){
                effects.displayAllWeaponFire(function(){infowindow.informPhase(5000, null);});
            }
                           
        }
        
               
        if (gamedata.gamephase == 2){
            ew.RemoveEWEffects();
            animation.setAnimating(animation.animateShipMoves, function(){
                infowindow.informPhase(5000, null);
                scrolling.scrollToShip(gamedata.getActiveShip());
                shipWindowManager.checkIfAnyStatusOpen(gamedata.getActiveShip());
                
                var ship = gamedata.getActiveShip();
                
                if (ship.userid == gamedata.thisplayer){
                    shipManager.movement.doForcedPivot(ship);
                    gamedata.selectShip(ship, false);
                }
           
            });
        }
          
        if (gamedata.gamephase == 1 && gamedata.waiting == false){
            shipManager.power.repeatLastTurnPower();
            infowindow.informPhase(5000, null);
            if (gamedata.waiting == false){
                for (var i in gamedata.ships){
                    var ship = gamedata.ships[i];
                    if (ship.userid == gamedata.thisplayer && !ship.destroyed){
                        gamedata.selectShip(ship, false);
                        scrolling.scrollToShip(ship);
                        break;
                    }
                }
            }
        }
        
        if (gamedata.gamephase == 3 && gamedata.waiting == false){
            UI.shipMovement.hide();
            ew.RemoveEWEffects();
            animation.setAnimating(animation.animateShipMoves, function(){
                infowindow.informPhase(5000, null);
                                
                if (gamedata.waiting == false){
                    for (var i in gamedata.ships){
                        var ship = gamedata.ships[i];
                        if (ship.userid == gamedata.thisplayer){
                            gamedata.selectShip(ship, false);
                            scrolling.scrollToShip(ship);
                            break;
                        }
                    }
                }
                
        
            });

            
        }
        
       
        
        if (gamedata.waiting){
            ajaxInterface.startPollingGamedata();
        }
    },
            
    checkGameStatus: function(){
        $("#phaseheader .turn.value").html("TURN: " + gamedata.turn+ ",");
        $("#phaseheader .phase.value").html(gamedata.getPhasename());
        $("#phaseheader .activeship.value").html(gamedata.getActiveShipName());
        
        var commit = $(".committurn");
        var cancel = $(".cancelturn");
        
        if (gamedata.status == "FINISHED"){
            cancel.hide();
            commit.hide();
            $("#phaseheader .finished").show();
            return;
        }
		
		
        
        if (gamedata.gamephase == 4){
            
            commit.show();
            cancel.hide();
            
        }else if (gamedata.gamephase == 3){
            
            commit.show();
            cancel.hide();
            
        }else if (gamedata.gamephase == 2){
            var ship = gamedata.getActiveShip();
            if (shipManager.movement.isMovementReady(ship) && ship.userid == gamedata.thisplayer){
                commit.show();
            }else{
                commit.hide();
            }
            
            if (shipManager.movement.hasDeletableMovements(ship) && ship.userid == gamedata.thisplayer){
                cancel.show();
            }else{
                cancel.hide();
            }
            
        }else if (gamedata.gamephase == 1){
            
            commit.show();
            cancel.hide();
            
        }else{
            commit.hide();
            cancel.hide();
        }
		
		if (!playerManager.isInGame()){
			cancel.hide();
            commit.hide();
			return;
		}
        
        if (gamedata.waiting){
            $("#phaseheader .waiting.value").show();
            cancel.hide();
            commit.hide();
        }else{
            $("#phaseheader .waiting.value").hide();
        }
    },
    
    

    parseServerData: function(serverdata){
    
        if (serverdata == null)
            return;
            
        if (gamedata.waiting == false && serverdata.waiting == true && serverdata.changed == false){
             gamedata.waiting = true;
             ajaxInterface.startPollingGamedata();
        }
            
    
        if (serverdata.changed == true){
                
                
            //console.log(serverdata);
            gamedata.turn = serverdata.turn;
            gamedata.gamephase = serverdata.phase;
            gamedata.activeship = serverdata.activeship;
            gamedata.gameid = serverdata.id;
            gamedata.players = serverdata.players;
            gamedata.ships = serverdata.ships;
            gamedata.thisplayer = serverdata.forPlayer;
            gamedata.waiting = serverdata.waiting;
            gamedata.status = serverdata.status;
			gamedata.ballistics = serverdata.ballistics;
            //combatLog.constructLog();
            
            gamedata.initPhase();
            drawEntities();
        }
        gamedata.checkGameStatus();
    },
    
    listShipPositions: function(){
        
        scrolling.scrollTo(0,0);
        for (var i in gamedata.ships){
            console.log(shipManager.getShipPositionInWindowCo(gamedata.ships[i]));
        }
    }
    
}


