
function getPlayers(e)
{
    e.preventDefault();
    var player1 = $("input[name=player_1]").val();
    var player2 = $("input[name=player_2]").val();    
    $(".loader-first-text").css('visibility', 'visible');
    $("#player-comparison-wrapper").hide();
    $("#player-comp-intro").show();
    $.ajax({
        url: "compare.php",
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
                $(".loader-first-text").css('visibility', 'hidden');
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
    
    var contentWidth = $("#content").width();

    $(".loader").show();
    $("#player-comp-intro").hide();
    $("#player-comparison-wrapper").show();
    $("#player-comparison-wrapper").html("<p class='loader-text'>Crunching Data...</p>");

    $.ajax({
        url: "compare.php",
        dataType: "json",
        type: "POST",
        data: {
                function: "comparePlayers", 
                player_1_link: player1Link,
                player_2_link: player2Link,
                player_1_name: player1Name,
                player_2_name: player2Name,
                match_type: matchType,
                stat_type: statType,
                content_width: contentWidth
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
                    $(".player-profiles img").slideDown(300);
                    setTimeout(function(){
                        $(".bars").each(function(){
                            var width = $(this).attr('final-width');
                            $(this).css('width', width + "px");    
                        });
                    }, 400); 
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
