
function getPlayers(e)
{
    e.preventDefault();
    var player1 = $("input[name=player_1]").val();
    var player2 = $("input[name=player_2]").val();    
    $("#content").html("Loading...");

    $.ajax({
        url: "ajax_handler.php",
        dataType: "json",
        type: "POST",
        data: {
                function: "readPlayerList", 
                player_1: player1,
                player_2: player2
            },
        success: function(data){
            if (data.output != null)
            {
                $("#content").html(data.output);
            }
            else
            {
                alert(data.error);
            }
        },
        error: function(data){

        }
    });
}

function comparePlayers(e)
{
    e.preventDefault();
    var player1Link = $("#player-1-selected option:selected").attr('data-index');
    var player2Link = $("#player-2-selected option:selected").attr('data-index'); 

    $.ajax({
        url: "ajax_handler.php",
        dataType: "json",
        type: "POST",
        data: {
                function: "comparePlayers", 
                player_1_link: player1Link,
                player_2_link: player2Link
            },
        success: function(data){
            if (data.output != null)
            {
                $("#player-comparison-wrapper").html(data.output);
            }
            else
            {
                alert(data.error);
            }
        },
        error: function(data){

        }
    });
}
