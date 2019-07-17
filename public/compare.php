<?php 

include "../app/service.php";

if (isset($_POST['function']) && $_POST['function'] == "readPlayerList")
{
	echo json_encode(array("output" => render_player_list(trim($_POST['player_1']), trim($_POST['player_2']))));
	exit();
}
else if (isset($_POST['function']) && $_POST['function'] == "comparePlayers")
{
	echo json_encode(array("output" => render_players_comparison($_POST['player_1_link'], $_POST['player_1_name'], $_POST['player_2_link'], $_POST['player_2_name'], $_POST['match_type'], $_POST['stat_type'], $_POST['content_width'])));
	exit();
}
else
{
	header('Location: https://' . $_SERVER["HTTP_HOST"]);
}


?>