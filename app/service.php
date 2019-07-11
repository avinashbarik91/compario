<?php 

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
	$player_2_list = read_player_list($player_2);
	$html = "";

	if (!empty($player_1_list))
	{		
		$html .=  "<h3>Select Player 1</h3>";
		$html .=  "<select id='player-1-selected'>";

		foreach ($player_1_list as $player) 
		{
			$html .=  "<option data-index='" . $player->url . "' value='" . $player->id . "'>" . $player->name . "</option>";
		}

		$html .=  "</select>";
	}

	if (!empty($player_2_list))
	{		
		$html .=  "<h3>Select Player 2</h3>";
		$html .=  "<select id='player-2-selected'>";
		
		foreach ($player_2_list as $player) 
		{
			$html .=  "<option data-index='" . $player->url . "' value='" . $player->id . "'>" . $player->name . "</option>";
		}

		$html .=  "</select>";
	}

	$html .= "<br/><br/><button id='compare-btn' onclick=comparePlayers(event)>Compare</button>";

	return $html;
}

function read_player_comparison($player_1_link, $player_2_link)
{
	$player_1_bat_stats 	= read_batting_and_fielding_stats($player_1_link);
	$player_1_bowl_stats 	= read_bowling_stats($player_1_link);
	$player_2_bat_stats 	= read_batting_and_fielding_stats($player_2_link);
	$player_2_bowl_stats 	= read_bowling_stats($player_2_link);

	return array(	"player_1_stats" => array("bat" => $player_1_bat_stats, "bowl" => $player_1_bowl_stats), 
					"player_2_stats" => array("bat" => $player_2_bat_stats, "bowl" => $player_2_bowl_stats)
				);
}

function render_players_comparison($player_1_link, $player_1_name, $player_2_link, $player_2_name)
{
	$player_stats = read_player_comparison($player_1_link, $player_2_link);

	$player_1_bat_stats_keys = $GLOBALS['bat_stat_category'];
	$player_1_bat_stats_val  = array_values($player_stats['player_1_stats']['bat']['ODIs']);
	$player_2_bat_stats_val  = array_values($player_stats['player_2_stats']['bat']['ODIs']);
	
	for ($i = 0; $i < sizeof($player_1_bat_stats_keys); $i++)
	{
		$html .= "<div class='xyz'><canvas id='my-chart-".$i."'></canvas></div>                 
		            <div class='player-bat-stats'>          
		                <script>
					            var ctx = document.getElementById('my-chart-".$i."').getContext('2d');      
					            Chart.defaults.global.defaultFontColor = 'white';       
					            var chart = new Chart(ctx, {               
					                
					                type: 'horizontalBar',  
					                responsive: true,
	    							maintainAspectRatio: false,      
					                data: {
					                    labels: ['".$player_1_bat_stats_keys[$i]."'],    
					                    datasets: [
					                    {
					                        label: '".explode("(", $player_1_name)[0]."',
	                                        pointStyle: 'line',      
					                        backgroundColor: '#ff1e50',
					                        <!--borderColor: 'darkgreen',	-->		                      
		                					borderWidth: 1,
					                        data: [".$player_1_bat_stats_val[$i]."],                       
					                    },
					                    {
					                        label: '".explode("(", $player_2_name)[0]."',
	                                        pointStyle: 'line',      
					                        backgroundColor: '#009051',
					                        <!--borderColor: 'darkgreen',	-->		                      
		                					borderWidth: 1,
					                        data: [".$player_2_bat_stats_val[$i]."],                        
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

	return $html;
}

function read_batting_and_fielding_stats($player_link)
{
	//$scraper_api 		= "http://api.scraperapi.com?api_key=e77ad5342cca94d32c633c4c836e7813&url=";
	$scraper_api 		= "";
	$data 				= file_get_contents($scraper_api . "http://www.espncricinfo.com" . $player_link);	
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

function read_bowling_stats($player_link)
{
	//$scraper_api 		= "http://api.scraperapi.com?api_key=e77ad5342cca94d32c633c4c836e7813&url=";
	$scraper_api 		= "";
	$data 				= file_get_contents($scraper_api . "http://www.espncricinfo.com" . $player_link);	
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