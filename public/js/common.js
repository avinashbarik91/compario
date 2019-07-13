
function getPlayers(e)
{
    e.preventDefault();
    var player1 = $("input[name=player_1]").val();
    var player2 = $("input[name=player_2]").val();    
    $("#content").html("<p>Loading Player List and Options...</p>");
    $("#player-comparison-wrapper").hide();
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
                $("#content").hide();
                $("#content").html(data.output).fadeIn(500);
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

    var player1Name = $("#player-1-selected option:selected").text();
    var player2Name = $("#player-2-selected option:selected").text();

    var matchType = $("#match-type-selected option:selected").val();
    var statType  = $("#stat-type-selected option:selected").val();
    
    $(".loader").show();
    $("#player-comparison-wrapper").show();
    $("#player-comparison-wrapper").html("<p><br/><br/>Crunching Data...</p>");

    $.ajax({
        url: "ajax_handler.php",
        dataType: "json",
        type: "POST",
        data: {
                function: "comparePlayers", 
                player_1_link: player1Link,
                player_2_link: player2Link,
                player_1_name: player1Name,
                player_2_name: player2Name,
                match_type: matchType,
                stat_type: statType
            },
        success: function(data){
            if (data.output != null)
            { 
                $(".loader").hide();               
                $("#player-comparison-wrapper").html(data.output);
                $('html, body').animate({
                    scrollTop: $("#player-comparison-wrapper").offset().top
                }, 500);
                    
                setTimeout(function(){
                    $(".player-profiles img").slideDown(500);
                }, 500);                
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
