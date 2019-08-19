<?php 


    if (isset ($_POST['round'])) {
        // $_POST['attack'] === 0 - means Orderus is attacking otherwise the beast
        require_once '../class/player.php';
        $players = json_decode($_POST['players']);
        $playerOrderus = new Player($players[0]->stats->name, $players[0]->stats, $players[0]->skills);
        $playerBeast = new Player($players[1]->stats->name, $players[1]->stats, $players[1]->skills);
        $roundInfo = [];
        // Transform JSON into PHP Class Objects
        $players[0] = $playerOrderus;
        $players[1] = $playerBeast;
        $attackingPlayer = 1;
        if (intval($_POST['attack']) === 0) {
            $attackingPlayer = 0;
        }
        
        $battleInfo = $players[!$attackingPlayer]->getsAttacked($players[$attackingPlayer]);
        $players[$attackingPlayer] = $players[$attackingPlayer]->getPlayerInfo();
        $players[!$attackingPlayer] = $battleInfo['player'];
        $roundInfo['players'] = $players;
        $roundInfo['logs'] = $battleInfo['logs'];
        $roundInfo['logs'][] = 'Round ' . intval($_POST['round']) . ' finished.';
        echo json_encode($roundInfo);
    }



?>