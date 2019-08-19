<?php

require_once '../configs/connection.php';
class Player extends Database{

    private $stats = [];
    private $skills = [];
    private $playerInfo = [];
    function __construct($playerName, $stats = null, $skills = null) {
        parent::__construct();
        try{
            if ($stats === null) {
                $getPlayers = $this->dbc->prepare('SELECT * FROM `players` WHERE name=:name');
                $getPlayers->bindValue(':name' , $playerName);
                $getPlayers->execute();
                $result = $getPlayers->fetch();
                // Initialize player stats
                $this->stats['health'] = rand($result['minHealth'], $result['maxHealth']);
                $this->stats['strength'] = rand($result['minStrength'], $result['maxStrength']);
                $this->stats['defence'] = rand($result['minDefence'], $result['maxDefence']);
                $this->stats['speed'] = rand($result['minSpeed'], $result['maxSpeed']);
                $this->stats['luck'] = rand($result['minLuck'], $result['maxLuck']);
                $this->stats['name'] = $playerName;

                $getSkills = $this->dbc->prepare('SELECT * FROM `playerSkills` WHERE forPlayer=:forPlayer');
                $getSkills->bindValue(':forPlayer' , $result['id']);
                $getSkills->execute();
                $skills = $getSkills->fetchAll();
                // Get all player skills
                foreach($skills as $skill) {
                    $this->skills[] = $skill;
                }
            } else {
                $this->stats = $stats;
                $this->skills = $skills;
            }
            $this->playerInfo['stats'] = $this->stats;
            $this->playerInfo['skills'] = $this->skills; 
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function getStats() {
        return $this->stats;
    }

    function getSkills() {
        return $this->skills;
    }

    function getPlayerInfo() {
        return $this->playerInfo;
    }

    function getsAttacked($attackingPlayer) {
        $attackingPlayerStats = $attackingPlayer->getStats();
        $attackingPlayerSkills = $attackingPlayer->getSkills();
        $currentLuck = rand(0, 100);
        $currentSkillLuck = rand(0, 100);
        $battleInfo = [];
        $logs = [];
        $logs[] = $attackingPlayerStats->name . " is attacking...";
        // Defender got lucky - no damage done
        if ($this->stats->luck >= $currentLuck) {
            $logs[] = $this->stats->name . " got lucky and took no damage.";
            $battleInfo['logs'] = $logs;
            $battleInfo['player'] = $this->getPlayerInfo();
            return $battleInfo;
        }

        $damage = intval($attackingPlayerStats->strength) - intval($this->stats->defence);

        // Iterate through skills and apply the attacker skills
        foreach($attackingPlayerSkills as $skill) {
            if ($skill->skillLuck >= $currentSkillLuck && $skill->occurOnAttack && $skill->skillName === 'Rapid strike') {
                $logs[] = $attackingPlayerStats->name . " got lucky and used the skill " . $skill->skillName;
                $damage *= 2;
            }
        }

        // Iterate through skills and apply the defender skills
        foreach($this->skills as $skill) {
            if ($skill->skillLuck >= $currentSkillLuck && !$skill->occurOnAttack && $skill->skillName === 'Magic shield') {
                $logs[] = $this->stats->name . " got lucky and used the skill " . $skill->skillName;
                $damage /= 2;
            }
        }

        // Calculate damage
        $logs[] = $attackingPlayerStats->name . " attacked " . $this->stats->name . " and dealt " . $damage . ' damage.';
        $this->stats->health = intval($this->stats->health) - intval($damage);
        $battleInfo['logs'] = $logs;
        $battleInfo['player'] = $this->getPlayerInfo();
        return $battleInfo;
    }
}


?>