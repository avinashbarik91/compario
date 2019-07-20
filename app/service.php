<?php 

$stat_types 		= array(array("name" => "bat", "value" => "Batting & Fielding"), array("name" => "bowl", "value" => "Bowling"));
$match_types 		= array("Tests", "ODIs", "T20Is", "First-class", "List A", "T20s");
$bat_stat_category  = array("Matches", "Innings", "Not Outs", "Runs", "Highest Score", "Batting Average", "Balls Faced", "Strike Rate", "100s", "50s", "4s", "6s", "Catches Taken", "Stumpings Made");
$bowl_stat_category = array("Matches", "Innings", "Balls Bowled", "Runs Conceded", "Wickets Taken", "Best Bowling Innings", "Best Bowling Match", "Bowling Average", "Economy Rate", "Bowling Strike Rate", "4 Wicket Haul", "5 Wicket Haul", "10 Wicket Haul");

function read_player_list($search_str)
{	
	$search_str 	= trim(htmlspecialchars($search_str));
	$scraper_api 	= "";	
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

function render_player_list($player_1, $player_2, $player_1_selected = null, $player_2_selected = null, $match = null, $stat = null)
{
	$player_1_list = read_player_list(str_replace(" ", "+", $player_1));
	$player_2_list = read_player_list(str_replace(" ", "+", $player_2));	
	
	$html = "

	<div class='container px-4 select-compare-options'>
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
				if ($player->url == $player_1_selected)
				{
					$html .=  "<option data-index='" . $player->url . "' selected='selected' value='" . $player->id . "'>" . $player->name . "</option>";
				}
				else
				{
					$html .=  "<option data-index='" . $player->url . "' value='" . $player->id . "'>" . $player->name . "</option>";	
				}
				
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
				if ($player->url == $player_2_selected)
				{
					$html .=  "<option data-index='" . $player->url . "' selected='selected' value='" . $player->id . "'>" . $player->name . "</option>";
				}
				else
				{
					$html .=  "<option data-index='" . $player->url . "' value='" . $player->id . "'>" . $player->name . "</option>";	
				}
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
			if ($match_type == $match)
			{
				$html .=  "<option selected='selected' value='" . $match_type . "'>" . $match_type . "</option>";
			}
			else
			{
				$html .=  "<option value='" . $match_type . "'>" . $match_type . "</option>";	
			}
			
		}

		$html .=  "</select>";
		$html .=  "</div>";

		//Batting vs Bowling
		$html .=  "<div class='col-md-3'>";	
		$html .=  "<label for='stat-type-selected'>Select Stat Type</label>";
		$html .=  "<select class='form-control' id='stat-type-selected'>";	

		foreach ($GLOBALS['stat_types'] as $stat_type) 
		{
			if ($stat_type['name'] == $stat)
			{
				$html .=  "<option selected='selected' value='" . $stat_type['name'] . "'>" . $stat_type['value'] . "</option>";
			}
			else
			{
				$html .=  "<option value='" . $stat_type['name'] . "'>" . $stat_type['value'] . "</option>";
			}
		}
		
		$html .=  "</select>";
		$html .=  "</div>";

		$html .=  "</div><div class='row pt-2'><div class='col-md-4 offset-md-4 '>";
		$html .=  "<button id='compare-btn' class='btn btn-success' onclick=comparePlayers(event)>Compare</button>";
		$html .=  "</div></div>";

		$html .= "</div>";
	}
	else if (empty($player_1_list))
	{
		$html .= "<div class='col-md-12'>";	
		$html .=  "<label>Oops!.</label>";
		$html .=  "<p class='px-4'>Could not find any matching players for <u>" . $player_1 . "</u>. Try searching <u>Last Name</u> or <u>First Name</u> only</p>";		
		$html .=  "</div>";
	}
	else if (empty($player_2_list))
	{
		$html .= "<div class='col-md-12'>";	
		$html .=  "<label>Oops!.</label>";
		$html .=  "<p class='px-4'>Could not find any matching players for <u>" . $player_2 . "</u>. Try searching <u>Last Name</u> or <u>First Name</u> only</p>";		
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

function render_players_comparison($player_1_link, $player_1_name, $player_2_link, $player_2_name, $match_type, $stat_type, $content_width, $share_link)
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

	if (sizeof($player_1_stats_val) != sizeof($player_2_stats_val))
	{
		$html .= "<div class='row'>";
		$html .= "<div class='col-md-12 mt-5'>
					<h5 class='chart-heading'><i class='comp-error fas fa-info-circle'></i>Oops! Some of the relevant data needed for head to head comparison could not be found. Retry with other players.</h5>";
		$htnl .= "</div>";
		$html .= "</div>";	

		$html .= "</div>";

		return $html;		
	}

	$html .= "<div class='divider'></div>";

	for ($i = 0; $i < sizeof($stats_keys); $i++)
	{
		$player_1_stats_val[$i] = $player_1_stats_val[$i] == "" ? "-" : $player_1_stats_val[$i];
		$player_2_stats_val[$i] = $player_2_stats_val[$i] == "" ? "-" : $player_2_stats_val[$i];

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
					<span class='bar-1 bars' final-width='".$player_1_bar_width."'; style='width: 5px; display:inline-block;'></span>
					<span class='bar-2 bars' final-width='".$player_2_bar_width."'; style='width: 5px; display:inline-block;'></span>
					<span class='stat-play-num'>" . $player_2_stats_val[$i] . "</span>

				  </div>";

		$html .= "</div>";		   
	}

	$html .= "</div>";	

	$html .= "<div>
				<div class='col-md-12'><button id='compare-new-btn-alt' class='btn btn-success'>Start New Comparison</button></div>
			  </div>";	


	$share_str 			= $player_1_clean_name . " vs " . $player_2_clean_name;		  

	$html .= '<div class="container mt-5">
        		<div class="row">
	        		<div class="col-md-12">	
	        		<h4>Enjoyed ' . $share_str . '? Drop a comment below and share with friends</h4>        			
	        			<div id="disqus_thread"></div>
							<script>		
								var disqus_config = function () {
								this.page.url = "https://compario.dev/' . $share_link .'";  
								this.page.identifier = "head-to-head"; 
								};
			
									(function() {
									var d = document, s = d.createElement("script");
									s.src = "https://compario-1.disqus.com/embed.js";
									s.setAttribute("data-timestamp", +new Date());
									(d.head || d.body).appendChild(s);
									})();
							</script>
							<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
	        		</div>
	        	</div>
	        </div>';

	
	
	return $html;
}

function render_share_buttons($share_link, $share_str)
{
	return '<div class="container mt-5 mb-5">
        		<div class="row">        		
        			<div class="col-md-12 post-share-btns pt-2">
						
						<!-- Twitter -->
						<a alt="Share on Twitter" title="Share on Twitter" href="https://twitter.com/intent/tweet?text=' . $share_str . '&url=' . rawurlencode($share_link) . '&via=avinashbarik91" target="_blank" class="twitter-share-btn"><i class="fab fa-twitter-square"></i></a>

						<!-- Facebook -->
						<a alt="Share on Facebook" title="Share on Facebook" href="https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode($share_link) .'" target="_blank" class="facebook-share-btn"><i class="fab fa-facebook-square"></i></a>

						<!-- LinkedIn -->
						<a alt="Share on LinkedIn" title="Share on LinkedIn" href="https://www.linkedin.com/shareArticle?mini=true&url=' . rawurlencode($share_link) . '&title=' . $share_str . '&source=https://www.compario.dev&summary=' . $share_str.'" target="_blank" class="linked-in-share-btn"><i class="fab fa-linkedin"></i></a>							
					</div>
				</div>
			</div>';
}

function read_batting_and_fielding_stats($player_link, &$player_image)
{
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