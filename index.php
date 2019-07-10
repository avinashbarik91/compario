<?php 
	
	if (isset($_POST['player_1'])  && isset($_POST['player_2']))
	{
		$player_1_list = read_player_list($_POST['player_1']);
		$player_2_list = read_player_list($_POST['player_2']);
	}

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
?>

<html>
	<form method="post" action="/">
		<input type='text' name='player_1' value='' placeholder='Search Player 1 Name'/>
		<input type='text' name='player_2' value='' placeholder='Search Player 2 Name'/>
		<input type='submit' value='Submit'/>
	</form>
</html>

<?php

	if (!empty($player_1_list))
	{		
		echo "<h3>Select Player 1</h3>";
		echo "<select>";

		foreach ($player_1_list as $player) 
		{
			echo "<option value='" . $player->id . "'>" . $player->name . "</option>";
		}

		echo "</select>";
	}

	if (!empty($player_2_list))
	{		
		echo "<h3>Select Player 2</h3>";
		echo "<select>";

		foreach ($player_2_list as $player) 
		{
			echo "<option value='" . $player->id . "'>" . $player->name . "</option>";
		}

		echo "</select>";
	}
 ?>