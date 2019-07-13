<?php 

$match_types = array("Tests", "ODIs", "T20Is", "First-class", "List A", "T20s");
$bat_stat_category  = array("Matches", "Innings", "Not Outs", "Runs", "Highest Score", "Batting Average", "Balls Faced", "Strike Rate", "100s", "50s", "4s", "6s", "Catches Taken", "Stumpings Made");
$bowl_stat_category = array("Matches", "Innings", "Balls Bowled", "Runs Conceded", "Wickets Taken", "Best Bowling Innings", "Best Bowling Match", "Bowling Average", "Economy Rate", "Bowling Strike Rate", "4 Wicket Haul", "5 Wicket Haul", "10 Wicket Haul");

function read_player_list($search_str)
{	
	$search_str 	= trim(htmlspecialchars($search_str));
	$scraper_api 	= "http://api.scraperapi.com?api_key=e77ad5342cca94d32c633c4c836e7813&url=";
	$data 			= file_get_contents($scraper_api . "http://search.espncricinfo.com/ci/content/player/search.html?search=" . urlencode($search_str) . "&x=38&y=11");		
	$summaries  	= explode('<p class="ColumnistSmry">', $data);
	$count 			= 0;
	$player_list 	= array();		
	
	foreach ($summaries as $summary)
	{
		if ($count == 0) 
		{
			$count++;
			continue;
		}
		else if ($count == sizeof($summaries) - 1)
		{
			$summary =  explode("</p>", $summary)[0];
		}

		$link 	= explode('" class="ColumnistSmry"', $summary);
		$url 	= explode('href="', $link[0])[1];
		
		$name 	= str_replace(">", "", explode('</a>', $link[1])[0]);
		$name 	= trim(preg_replace('/\s+/', ' ', $name));

		$id = explode(".html", $url)[0];
		$id = explode("player/", $id)[1];

		array_push($player_list, (object) array("name" => $name, "url" => $url, "id" => $id));					
		$count++;
	}

	return $player_list;
}

function render_player_list($player_1, $player_2)
{
	$player_1_list = read_player_list(str_replace(" ", "+", $player_1));
	$player_2_list = read_player_list(str_replace(" ", "+", $player_2));	
	
	$html = "

	<div class='container select-compare-options'>
					<legend>Select Comparison Options</legend>
					<div class='row'>						
	";	

	if (!empty($player_1_list) && !empty($player_2_list))
	{
		//Player 1
		if (!empty($player_1_list))
		{	
			$html .= "<div class='col-md-3'>";	
			$html .=  "<label for='player-1-selected'>Select Player 1</label>";
			$html .=  "<select class='form-control' id='player-1-selected'>";

			foreach ($player_1_list as $player) 
			{
				$html .=  "<option data-index='" . $player->url . "' value='" . $player->id . "'>" . $player->name . "</option>";
			}

			$html .=  "</select>";
			$html .=  "</div>";
		}	

		//Player 2
		if (!empty($player_2_list))
		{	
			$html .= "<div class='col-md-3'>";		
			$html .=  "<label for='player-2-selected'>Select Player 2</label>";
			$html .=  "<select class='form-control' id='player-2-selected'>";
			
			foreach ($player_2_list as $player) 
			{
				$html .=  "<option data-index='" . $player->url . "' value='" . $player->id . "'>" . $player->name . "</option>";
			}

			$html .=  "</select>";
			$html .=  "</div>";
		}	

		//Match Type
		$html .=  "<div class='col-md-3'>";	
		$html .=  "<label for='match-type-selected'>Select Match Type</label>";
		$html .=  "<select class='form-control' id='match-type-selected'>";
		
		foreach ($GLOBALS['match_types'] as $match_type) 
		{
			$html .=  "<option value='" . $match_type . "'>" . $match_type . "</option>";
		}

		$html .=  "</select>";
		$html .=  "</div>";

		//Batting vs Bowling
		$html .=  "<div class='col-md-3'>";	
		$html .=  "<label for='stat-type-selected'>Select Stat Type</label>";
		$html .=  "<select class='form-control' id='stat-type-selected'>";	
		$html .=  "<option value='bat'>Batting & Fielding</option>";
		$html .=  "<option value='bowl'>Bowling</option>";
		$html .=  "</select>";
		$html .=  "</div>";

		$html .=  "</div><div class='row pt-2'><div class='col-md-4 offset-md-4 '>";
		$html .=  "<button id='compare-btn' class='btn btn-success' onclick=comparePlayers(event)>Compare</button>";
		$html .=  "</div></div>";

		$html .= "</div>";
	}
	else
	{
		$html .= "<div class='col-md-12'>";	
		$html .=  "<label>Oops!.</label>";
		$html .=  "<p>Could not find any matching players for for your search. If unsure, try entering Last Name or First Name only</p>";		
		$html .=  "</div>";
	}

	return $html;
}

function read_player_comparison($player_1_link, $player_2_link, $stat_type)
{	
	if ($stat_type == "bat")
	{ 
		$player_1_bat_stats 	= read_batting_and_fielding_stats($player_1_link, $player_1_image);
		$player_2_bat_stats 	= read_batting_and_fielding_stats($player_2_link, $player_2_image);

		return array(	"player_1_stats" => array("bat" => $player_1_bat_stats, "image" => $player_1_image), 
						"player_2_stats" => array("bat" => $player_2_bat_stats, "image" => $player_2_image)
				);
	}
	else if ($stat_type == "bowl")
	{
		$player_1_bowl_stats 	= read_bowling_stats($player_1_link, $player_1_image);	
		$player_2_bowl_stats 	= read_bowling_stats($player_2_link, $player_2_image);

		return array(	"player_1_stats" => array("bowl" => $player_1_bowl_stats, "image" => $player_1_image), 
						"player_2_stats" => array("bowl" => $player_2_bowl_stats, "image" => $player_2_image)
				);
	}	
}

function render_players_comparison($player_1_link, $player_1_name, $player_2_link, $player_2_name, $match_type, $stat_type, $content_width)
{
	$player_stats = read_player_comparison($player_1_link, $player_2_link, $stat_type);
	
	if ($stat_type == "bat")
	{
		$stats_keys = $GLOBALS['bat_stat_category'];
		$stat_full_name = "Batting and Fielding";	
	}
	else if ($stat_type == "bowl")
	{
		$stats_keys = $GLOBALS['bowl_stat_category'];
		$stat_full_name = "Bowling";	
	}	

	$player_1_stats_val  = array_values($player_stats['player_1_stats'][$stat_type][$match_type]);
	$player_2_stats_val  = array_values($player_stats['player_2_stats'][$stat_type][$match_type]);

	$player_1_clean_name = explode("(", $player_1_name)[0];
	$player_2_clean_name = explode("(", $player_2_name)[0];

	$player_1_image = $player_stats['player_1_stats']['image'];
	$player_2_image = $player_stats['player_2_stats']['image'];

	$html = "<i class='fas fa-poll'></i><h3>Head-to-Head " . $match_type . " " . $stat_full_name . " Career Comparison</h3>";
	$html .= "<div class='container player-profiles'>";
	$html .= "<div class='row'>";

	$html .= "<div class='offset-md-2 col-md-3'>";
	$html .= "<img id='p1-img' src='".$player_1_image."'/><p class='player-name-post'>".$player_1_clean_name."</p>";
	$html .= "</div>";

	$html .= "<div class='col-md-2'>";
	$html .= "<p class='display-4'> vs </p>";
	$html .= "</div>";

	$html .= "<div class='col-md-3'>";
	$html .= "<img id='p2-img' src='".$player_2_image."'/><p class='player-name-post'>".$player_2_clean_name."</p>";
	$html .= "</div>";

	$html .= "</div></div>";	
	
	$html .= "<div class='container player-stat-chart-container'>";

	for ($i = 0; $i < sizeof($stats_keys); $i++)
	{
		$player_1_stats_val[$i] = $player_1_stats_val[$i] == "" ? 0 : $player_1_stats_val[$i];
		$player_2_stats_val[$i] = $player_2_stats_val[$i] == "" ? 0 : $player_2_stats_val[$i];

		$html .= "<div class='row'>";

		$max_width = (0.25)*$content_width; 

		if ($player_1_stats_val[$i] > $player_2_stats_val[$i])
		{
			$diff_percent = $player_1_stats_val[$i]/$player_2_stats_val[$i];
			$player_1_bar_width = $max_width;
			$player_2_bar_width = $player_1_bar_width/$diff_percent;
		}
		else if ($player_1_stats_val[$i] < $player_2_stats_val[$i])
		{
			$diff_percent = $player_2_stats_val[$i]/$player_1_stats_val[$i];
			$player_2_bar_width = $max_width;
			$player_1_bar_width = $player_2_bar_width/$diff_percent;
		}
		else
		{
			$player_1_bar_width = $max_width / 2;
			$player_2_bar_width = $max_width / 2;
		}

		$html .= "<div class='col-md-12'>
					<h5 class='chart-heading'>".$stats_keys[$i]."</h5>		

					<span class='stat-play-num'>" . $player_1_stats_val[$i] . "</span>
					<span class='bar-1' style='width: ".$player_1_bar_width."px; display:inline-block;'></span>
					<span class='bar-2' style='width: ".$player_2_bar_width."px; display:inline-block;'></span>
					<span class='stat-play-num'>" . $player_2_stats_val[$i] . "</span>

				  </div>";

		$html .= "</div>";		   
	}

	$html .= "</div>";

	
	return $html;
}

/*function render_players_comparison($player_1_link, $player_1_name, $player_2_link, $player_2_name, $match_type, $stat_type)
{
	$player_stats = read_player_comparison($player_1_link, $player_2_link, $stat_type);
	
	if ($stat_type == "bat")
	{
		$stats_keys = $GLOBALS['bat_stat_category'];
		$stat_full_name = "Batting and Fielding";	
	}
	else if ($stat_type == "bowl")
	{
		$stats_keys = $GLOBALS['bowl_stat_category'];
		$stat_full_name = "Bowling";	
	}	

	$player_1_stats_val  = array_values($player_stats['player_1_stats'][$stat_type][$match_type]);
	$player_2_stats_val  = array_values($player_stats['player_2_stats'][$stat_type][$match_type]);

	$player_1_clean_name = explode("(", $player_1_name)[0];
	$player_2_clean_name = explode("(", $player_2_name)[0];

	$player_1_image = $player_stats['player_1_stats']['image'];
	$player_2_image = $player_stats['player_2_stats']['image'];

	$html = "<i class='fas fa-poll'></i><h3>Head-to-Head " . $match_type . " " . $stat_full_name . " Career Comparison</h3>";
	$html .= "<div class='container player-profiles'>";
	$html .= "<div class='row'>";

	$html .= "<div class='offset-md-3 col-md-2'>";
	$html .= "<img id='p1-img' src='".$player_1_image."'/><p class='player-name-post'>".$player_1_clean_name."</p>";
	$html .= "</div>";

	$html .= "<div class='col-md-2'>";
	$html .= "<p class='display-4'> vs </p>";
	$html .= "</div>";

	$html .= "<div class='col-md-2'>";
	$html .= "<img id='p2-img' src='".$player_2_image."'/><p class='player-name-post'>".$player_2_clean_name."</p>";
	$html .= "</div>";

	$html .= "</div></div>";	
	
	for ($i = 0; $i < sizeof($stats_keys); $i++)
	{
		if ($stats_keys[$i] == "Best Bowling Innings" || 
			$stats_keys[$i] == "Best Bowling Match" || 
			$stats_keys[$i] == "Bowling Average" || 
			$stats_keys[$i] == "Bowling Strike Rate" || 
			($player_1_stats_val[$i] == "" && $player_2_stats_val[$i]))
		{
			$html_2 .= "<div class='charts'><h4 class='chart-heading'>".$stats_keys[$i]."</h4>
						
							<div class='player-bat-stats diff'>
							<span class='sp-first'></span><p>".$player_1_clean_name . "-" . $player_1_stats_val[$i]."</p>
							<span class='sp-second'></span><p>".$player_2_clean_name . "-" . $player_2_stats_val[$i]."</p>
							</div>
						
						</div>";             
			continue;
		}

		$html .= "<div class='charts'><h4 class='chart-heading'>".$stats_keys[$i]."</h4><canvas id='my-chart-".$i."'></canvas></div>                 
		            <div class='player-bat-stats'>          
		                <script>
					            var ctx = document.getElementById('my-chart-".$i."').getContext('2d');      
					            Chart.defaults.global.defaultFontColor = 'white';       
					            var chart = new Chart(ctx, {               
					                
					                type: 'horizontalBar',  
					                responsive: true,
	    							maintainAspectRatio: false,      
					                data: {
					                    labels: ['".$stats_keys[$i]."'],    
					                    datasets: [
					                    {
					                        label: '".$player_1_clean_name."',
	                                        pointStyle: 'line',      
					                        backgroundColor: '#5cdb95',
					                        <!--borderColor: 'darkgreen',	-->		                      
		                					borderWidth: 1,
					                        data: [".$player_1_stats_val[$i]."],                       
					                    },
					                    {
					                        label: '".$player_2_clean_name."',
	                                        pointStyle: 'line',      
					                        backgroundColor: '#05386b',
					                        <!--borderColor: 'darkgreen',	-->		                      
		                					borderWidth: 1,
					                        data: [".$player_2_stats_val[$i]."],                        
					                    }
					                    ]
					                },

					                //----Configuration options go here-----
					                
					                options: 
					                {
					                    legend: 
					                    {
					                        labels: 
					                        {				                            
					                            fontColor: 'white'
					                        }
					                    },

					                    scales:
					                    {
					                        xAxes: [{                           
					                            
					                            scaleLabel: 
					                            {
					                                display: true,
					                            } ,
					                            ticks: 
					                            {
											        beginAtZero:true
											    }  
					                        }],

					                        yAxes: [{                           
					                            
					                            scaleLabel: 
					                            {
					                                display: true,
					                            }, 
					                            ticks: 
					                            {
											        beginAtZero:true
											    } 
					                        }]

					                    }			                    
					                }
					            });
					    </script>        
		            </div>";
	}

	if ($html_2 != "")
	{
		return $html . $html_2;
	}

	return $html;
}*/

function read_batting_and_fielding_stats($player_link, &$player_image)
{
	//$scraper_api 		= "http://api.scraperapi.com?api_key=e77ad5342cca94d32c633c4c836e7813&url=";
	$scraper_api 		= "";
	$data 				= file_get_contents($scraper_api . "http://www.espncricinfo.com" . $player_link);
	$player_image 		= read_player_profile($data)['image'];	
	$bat_field_table 	= explode('<table class="engineTable"', $data)[1];
	$bat_field_body  	= explode('<tbody>', $bat_field_table)[1];
	$bat_field_td   	= explode('</td>', $bat_field_body);

	$count = 0;
	$stat_array = array();
	$stat_group_array = array();
	$current_stat_group_name = "";
	$stat_category = $GLOBALS['bat_stat_category'];
	$loop_count = 0;
	
	foreach ($bat_field_td as $td) 
	{
		if ($loop_count < sizeof($bat_field_td) - 1)
		{
			if (strpos($td, 'title="record rank') !== false)
			{
				$current_stat_group_name = str_replace("</b>", "", explode("<b>", $td)[1]);			
				$stat_array = array();
				$count = 0;
			}
			else
			{
				$stat_array[$stat_category[$count]] = str_replace("*", "", explode(">", $td)[1]);
				$stat_group_array[$current_stat_group_name] = $stat_array;
				$count++;
			}
		}

		$loop_count++;		
	}
	
	return $stat_group_array;
}

function read_player_profile($data)
{
	$link = explode('/inline/', $data)[1];
	$link = trim(explode('" title="', $link)[0]);
	$player_image = "http://www.espncricinfo.com/inline/" . $link; 
	$player_image = "https://anaixnggen.cloudimg.io/crop/160x200/x/".$player_image;
	$profile = null;
	
	return array("image" => $player_image, "profile" => $profile);
}

function read_bowling_stats($player_link, &$player_image)
{
	//$scraper_api 		= "http://api.scraperapi.com?api_key=e77ad5342cca94d32c633c4c836e7813&url=";
	$scraper_api 		= "";
	$data 				= file_get_contents($scraper_api . "http://www.espncricinfo.com" . $player_link);
	$player_image 		= read_player_profile($data)['image'];	
	$bowl_table 		= explode('<table class="engineTable"', $data)[2];
	$bowl_table_body  	= explode('<tbody>', $bowl_table)[1];
	$bowl_td   			= explode('</td>', $bowl_table_body);

	$count = 0;
	$stat_array = array();
	$stat_group_array = array();
	$current_stat_group_name = "";
	$stat_category = $GLOBALS['bowl_stat_category'];
	$loop_count = 0;
	
	foreach ($bowl_td as $td) 
	{
		if ($loop_count < sizeof($bowl_td) - 1)
		{
			if (strpos($td, 'title="record rank') !== false)
			{
				$current_stat_group_name = str_replace("</b>", "", explode("<b>", $td)[1]);			
				$stat_array = array();
				$count = 0;
			}
			else
			{
				$stat_array[$stat_category[$count]] = explode(">", $td)[1];
				$stat_group_array[$current_stat_group_name] = $stat_array;
				$count++;
			}
		}

		$loop_count++;		
	}
	
	return $stat_group_array;
}


?>