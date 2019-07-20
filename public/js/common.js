
function getPlayers(e)
{
    e.preventDefault();
    var player1 = $("input[name=player_1]").val().trim();
    var player2 = $("input[name=player_2]").val().trim();  

    $(".err-msg").slideUp(200);
    $("#content").slideUp(200);

    if (player1 == "" || player2 == "")
    {
        $(".err-msg").slideDown(200);
        $("#content").slideUp(200);
        $("#player-comparison-wrapper").fadeOut(500);
        $("#player-comp-intro").fadeIn(500);
        return false;
    }

    $(".loader-first-text").css('visibility', 'visible');
    $("#player-comparison-wrapper").fadeOut(500);
    $("#player-comp-intro").fadeIn(500);
    $("#compare-new-btn").slideDown(200);
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
                $("#content").html(data.output).slideDown(500);
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
    if (e !== undefined)
    {
        e.preventDefault();   
    }
    
    var player1 = $("input[name=player_1]").val().trim();
    var player2 = $("input[name=player_2]").val().trim();  

    var player1Link = $("#player-1-selected option:selected").attr('data-index');
    var player2Link = $("#player-2-selected option:selected").attr('data-index'); 

    var player1Name = $("#player-1-selected option:selected").text();
    var player2Name = $("#player-2-selected option:selected").text();

    var matchType = $("#match-type-selected option:selected").val();
    var statType  = $("#stat-type-selected option:selected").val();
    
    var contentWidth = $("#content").width();    

    window.history.pushState("","Compario", "?head-to-head=true&player_1_search="+player1+"&player_2_search="+player2+"&player_1_link="+player1Link+"&player_2_link="+player2Link+"&match_type="+matchType+"&stat_type="+statType);
    
    $(".loader").fadeIn(200);

     $('html, body').animate({
        scrollTop: $(".loader").offset().top
    }, 500);

    $("#player-comparison-wrapper").show();
    $("#player-comparison-wrapper").html("<p class='loader-text'>Crunching Data...</p>");    
    $("#player-comp-intro").hide();

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
                $("#player-comp-intro").hide();           
                $("#player-comparison-wrapper").html(data.output);
                $('html, body').animate({
                    scrollTop: $("#player-comparison-wrapper").offset().top
                }, 500);
                    
                setTimeout(function(){
                    $(".player-profiles img").slideDown(100);
                    setTimeout(function(){
                        $(".bars").each(function(){
                            var width = $(this).attr('final-width');
                            $(this).css('width', width + "px");    
                        });
                    }, 400); 
                }, 500); 

                $("#compare-new-btn-alt").on('click', function(){
                    $('html, body').animate({
                        scrollTop: $("#body-content-wrapper").offset().top
                    }, 500);

                $("#player-comparison-wrapper").fadeOut(500);
                $("#player-comp-intro").fadeIn(500);
                $("#compare-new-btn").slideDown(200);
                $("#content").slideUp(200);
                $(".err-msg").slideUp(200);
                $("input[name=player_1]").val("");
                $("input[name=player_2]").val("");  
                window.history.pushState("","Compario","/");

                });
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

window.addEventListener('popstate', function(event) {
  window.location.href = window.location.href;
});

$(document).ready(function(){    
    $("#compare-new-btn").on('click', function(){
        $('html, body').animate({
            scrollTop: $("#body-content-wrapper").offset().top
        }, 500);

    $("#player-comparison-wrapper").fadeOut(500);
    $("#player-comp-intro").fadeIn(500);
    $("#compare-new-btn").slideDown(200);
    $("#content").slideUp(200);
    $(".err-msg").slideUp(200);
    $("input[name=player_1]").val("");
    $("input[name=player_2]").val("");
    window.history.pushState("","Compario","/");  

    });
});



