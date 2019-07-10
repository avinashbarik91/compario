
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
