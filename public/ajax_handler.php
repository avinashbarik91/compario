<?php 

include "../app/service.php";

if (isset($_POST['function']) && $_POST['function'] == "readPlayerList")
{
	echo json_encode(array("output" => render_player_list($_POST['player_1'], $_POST['player_2'])));
	exit();
}


?>