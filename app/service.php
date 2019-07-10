<?php 

function read_player_list($search_str)
{	
	$scraper_api 	= "http://api.scraperapi.com?api_key=e77ad5342cca94d32c633c4c836e7813&url=";
	$data 			= file_get_contents($scraper_api . "http://search.espncricinfo.com/ci/content/player/search.html?search=" . $search_str . "&x=38&y=11");		
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
	$player_1_list = read_player_list($player_1);
	$player_2_list = read_player_list($player_2);
	$html = "";

	if (!empty($player_1_list))
	{		
		$html .=  "<h3>Select Player 1</h3>";
		$html .=  "<select>";

		foreach ($player_1_list as $player) 
		{
			$html .=  "<option value='" . $player->id . "'>" . $player->name . "</option>";
		}

		$html .=  "</select>";
	}

	if (!empty($player_2_list))
	{		
		$html .=  "<h3>Select Player 2</h3>";
		$html .=  "<select>";
		
		foreach ($player_2_list as $player) 
		{
			$html .=  "<option value='" . $player->id . "'>" . $player->name . "</option>";
		}

		$html .=  "</select>";
	}

	return $html;
}


?>