<?php 


    if (isset ($_GET['initialize']) && $_GET['initialize'] === 'YES') {
        require_once '../class/player.php';
        $players = [];
        $playerOrderus = new Player('Orderus');
        $playerBeast = new Player('Beast');
        $players[] = $playerOrderus->getPlayerInfo();
        $players[] = $playerBeast->getPlayerInfo();
        echo json_encode($players);
    }



?>