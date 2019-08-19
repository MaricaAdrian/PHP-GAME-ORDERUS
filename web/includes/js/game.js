var players = [];
var round = 1;
function eventHandlers() {
    var $startGame = $('#startGame');
    var $game = $('#container');
    var $nextRound = $('#nextRound');
    $startGame.click(function () {
        round = 1;
        players = [];
        $('#result').hide();
        $.ajax({
            url: window.location.origin + '/orderus/api/game/initializeGame.php',
            method: 'GET',
            data: {initialize: 'YES'}
        }).done(function (response) {
            var responseObj = JSON.parse(response);
            var currentDiv;
            var maxPlayerSpeed = responseObj[0].stats.speed;
            var maxPlayerLuck = responseObj[0].stats.luck;
            var startingPlayer = 0;
            $startGame.hide();
            $game.show();
            $('.player').show();
            $('#round').html('Round ' + round);
            $('#copyLogs').hide();
            $('#logs').html('');
            responseObj.map(function (player) {
                players.push(player);
                currentDiv = $('div[data-for="' + player.stats.name + '"]');
                currentDiv.find('li[data-for="health"]').html('Health:' + player.stats.health);
                currentDiv.find('li[data-for="strength"]').html('Strength:' + player.stats.strength);
                currentDiv.find('li[data-for="defence"]').html('Defence:' + player.stats.defence);
                currentDiv.find('li[data-for="speed"]').html('Speed:' + player.stats.speed);
                currentDiv.find('li[data-for="luck"]').html('Luck:' + player.stats.luck);
                if(maxPlayerSpeed < player.stats.speed) {
                    startingPlayer = 1;
                } else if (maxPlayerSpeed == player.stats.speed && player.stats.name !== 'Orderus' && player.stats.luck > maxPlayerLuck) {
                   startingPlayer = 1;
                }
            });

            $('#attack').val(startingPlayer);
            updateAttackingPlayer(startingPlayer);
            $('#logs').append('<p>As Orderus walks the ever-green forests of Emagia, he encounters a wild beasts... and a battle begins.</p>');
        });
    });

    $nextRound.click(function () {
        var attack = parseInt($('#attack').val());
        if(attack === 0) {
            $('#attack').val('1');
        } else {
            $('#attack').val('0');
        }
        updateAttackingPlayer(+!attack);
        $.ajax({
            url: window.location.origin + '/orderus/api/game/round.php',
            method: 'POST',
            data: {round: round++, players: JSON.stringify(players), attack: attack}
        }).done(function (response) {
            var responseObj = JSON.parse(response);
            var currentPlayersStats = responseObj.players;
            var battleInfo = responseObj.logs;
            var currentDiv;
            $('#round').html('Round ' + round);
            battleInfo.map(function (element) {
                $('#logs').append('<p>' + element +'</p>');
            });
            players = [];
            currentPlayersStats.map(function (player) {
                players.push(player);
                currentDiv = $('div[data-for="' + player.stats.name + '"]');
                currentDiv.find('li[data-for="health"]').html('Health:' + player.stats.health);
                currentDiv.find('li[data-for="strength"]').html('Strength:' + player.stats.strength);
                currentDiv.find('li[data-for="defence"]').html('Defence:' + player.stats.defence);
                currentDiv.find('li[data-for="speed"]').html('Speed:' + player.stats.speed);
                currentDiv.find('li[data-for="luck"]').html('Luck:' + player.stats.luck);
                if(parseInt(player.stats.health) <= 0) {
                    var winner = player.stats.name === 'Orderus' ? 'Beast' : 'Orderus';
                    $('#copyLogs').show();
                    $('.player').hide();
                    $('#result').html(winner + ' has won the fight!');
                    $('#result').show();
                    $startGame.show();
                    $game.hide();
                    $('#logs').append('<p>' + player.stats.name +' has been defeted.</p>');
                    return;
                }
            });
        });
    });

    $('#copyLogs').click(function() {
        selectText('logs');
        document.execCommand("copy");
    });


    function selectText(containerid) {
        if (document.selection) { // IE
            var range = document.body.createTextRange();
            range.moveToElementText(document.getElementById(containerid));
            range.select();
        } else if (window.getSelection) {
            var range = document.createRange();
            range.selectNode(document.getElementById(containerid));
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
        }
    }

    function updateAttackingPlayer(attackingPlayer) {
        if(attackingPlayer) {
            $('.info[data-for="'+ players[attackingPlayer].stats.name +'"]').html('Attacks');
            $('.info[data-for="'+ players[attackingPlayer - 1].stats.name +'"]').html('Defends');
        } else {
            $('.info[data-for="'+ players[attackingPlayer].stats.name +'"]').html('Attacks');
            $('.info[data-for="'+ players[attackingPlayer + 1].stats.name +'"]').html('Defends');
        }
    }
}

$(document).ready(function () {
    eventHandlers();
})