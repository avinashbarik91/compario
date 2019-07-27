<?php 

$request = $_SERVER['REQUEST_URI'];
$query_param = trim($_SERVER['QUERY_STRING']);

if (($query_param != "") && (strpos($query_param, "head-to-head=true") !== false))
{	
	include $_SERVER['DOCUMENT_ROOT'] . "/../app/service.php";

	$player_1_link 	= $_GET['player_1_link'];
	$player_2_link 	= $_GET['player_2_link'];
	$match_type 	= $_GET['match_type'];	
	$stat_type 		= $_GET['stat_type'];
	$p1_search 		= $_GET['player_1_search'];
	$p2_search 		= $_GET['player_2_search'];
}
else
{
	if (file_exists(__DIR__ . $_SERVER["REQUEST_URI"] . ".php"))
	{
    	require(__DIR__ . $_SERVER["REQUEST_URI"] . ".php");
    	exit();
	}
	else if ($request != "/" && $request != "")
	{    
	    include "page_not_found.php";
	    exit();
	}
}

   
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-144172971-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-144172971-1');
		</script>					
		<title>Compario | Simple head-to-head comparison for cricket players</title>
		<meta charset="UTF-8">
		<meta http-equip="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Simple head-to-head comparison for cricket players. Compare cricket players.">
		<meta http-equiv="x-ua-compatible" content="ie-edge">
		<meta property='og:title' content='Compario'/>		
		<meta property='og:description' content='Compario - Simple head-to-head comparison for cricket players. Compare cricket players.'/>
		<meta property='og:url' content='https://compario.dev/'/>
		<meta property='og:image' content='https://www.compario.dev/static/feat-img-share.png'/>
		<link rel="icon" type="image/png" sizes="96x96" href="/static/favicon-3-96x96.png">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Righteous&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<link rel="stylesheet" href="stylesheet/bootstrap.min.css">
		<link rel="stylesheet" href="stylesheet/common.css">
		<script src="js/jquery.slim.min.js"></script>
		<script src="js/jquery.min.js"></script>
		<script src="js/common.js"></script>
		<script src="js/popper.js"></script>		
		<script src="js/bootstrap.min.js"></script>			
	</head>
	<body>

		<div id="body-content-wrapper">

			<?php include('header.inc'); ?>

			<div id="header-wrapper">
				<h1 class='display-3 px-4'>Compario<span class='beta'> v1.31</span></h1>
				<p>Compare cricket player stats head-to-head</p>

				<div class="container px-4  mb-4 search-form">
					<div class='row'>
							<div class='col-md-5'><i class="fas fa-user-circle"></i><input type='text' class="form-control text-center text-md-right" name='player_1' value='<?php echo($p1_search); ?>' placeholder='Search Player 1 Name (Ex: Dhoni)'/></div>
							<div class='col-md-2'><span class='vs-text'>vs</span></div>
							<div class='col-md-5'><i class="fas fa-user-circle"></i><input type='text' class="form-control text-center text-md-left" name='player_2' value='<?php echo($p2_search); ?>' placeholder='Search Player 2 Name (Ex: Gilchrist)'/></div>
							<div class='offset-md-4 col-md-4'><button class="btn btn-success" onclick="getPlayers(event)">Search</button></div>		
							<div class='err-msg offset-md-4 col-md-4'>Both player names are required!</div>													
					</div>					
				</div>
			</div>

			<p class='loader-first-text'>Loading Player List and Options...</p>
			<div id='content'>
				<!-- Player Selection -->

				<?php 
					if (($p1_search != "") && ($p2_search != "") && ($player_1_link != "") && ($player_2_link != "") && ($match_type != "") && ($stat_type != ""))
					{
						echo render_player_list($p1_search, $p2_search, $player_1_link, $player_2_link, $match_type, $stat_type); 						
					}
				?>
				
			</div>

			<div class='loader'></div>

		</div>

		<div class='container player-comp-intro'>

			<div class='row'>				
				<div class='col-md-12 px-5'>
					<h2 class='display-4'>Compare Cricket Players</h2>	

					<h5>Simple and Easy to use Cricket Player Comparison</h5>
					<h5 class='mb-5'>Compare cricket players head to head on multiple metrics across Batting, Fielding and Bowling</h5>

					<p class='mb-5'><em>Quick Compare below or start Search above</em></p>
				</div>
			</div>

			<div class='row mb-2'>				
				<div class='offset-md-2 col-md-8 px-5'>
					<h2>Quick Compare</h2>
				</div>				
			</div>

			<div class='row mb-5 quick-searches-row'>				
				<div class='mb-5 col-md-4'>
					<a href='?head-to-head=true&player_1_search=Virat%20Kohli&player_2_search=Kane%20Williamson&player_1_link=/india/content/player/253802.html&player_2_link=/newzealand/content/player/277906.html&match_type=Tests&stat_type=bat'>
						<div class='quick-searches-wrapper first'>
							<div class='quick-search-content'>
								<div class='quick-search-text'>
									<h4>Virat Kohli <br/>Vs<br/> Kane Williamson</h4>
								</div>
							</div>
						</div>
					</a>					
				</div>	

				<div class='mb-5 col-md-4'>
					<a href='?head-to-head=true&player_1_search=Steven%20Smith&player_2_search=Joe%20Root&player_1_link=/australia/content/player/267192.html&player_2_link=/england/content/player/303669.html&match_type=ODIs&stat_type=bat'>
						<div class='quick-searches-wrapper second'>
							<div class='quick-search-content'>
								<div class='quick-search-text'>
									<h4>Steve Smith <br/>Vs<br/> Joe Root</h4>
								</div>
							</div>
						</div>
					</a>					
				</div>	

				<div class='mb-5 col-md-4'>
					<a href='?head-to-head=true&player_1_search=Jasprit%20Bumrah&player_2_search=Lockie%20Ferguson&player_1_link=/india/content/player/625383.html&player_2_link=/newzealand/content/player/493773.html&match_type=ODIs&stat_type=bowl'>
						<div class='quick-searches-wrapper third'>
							<div class='quick-search-content'>
								<div class='quick-search-text'>
									<h4>Jasprit Bumrah <br/>Vs<br/> Lockie Ferguson</h4>
								</div>
							</div>
						</div>
					</a>					
				</div>		

			</div>	

			<div class='row mb-5'>				
				<div class='offset-md-2 col-md-8 px-5'>
					<h2>Or</h2>					
				</div>				
			</div>

			<div id='home-page-new-compare-btn'>
				<div class='col-md-12'><button id='compare-new-btn' class='btn btn-success'>Start New Comparison</button></div>
			</div>	

		</div>
		
		<div id='player-comparison-wrapper'>
			<!-- Player Comparison -->
			
		</div>				
        
        <?php 
			if (($p1_search != "") && ($p2_search != "") && ($player_1_link != "") && ($player_2_link != ""))
			{
				echo "<script>
					comparePlayers();
				</script>";
			}
		?>

		<div id='coming-soon' class='px-2'>
            <p>Compario is best viewed on larger screens such as laptops. More in-depth comparisons, date based filters and player profiles is coming soon.</p>
        </div>        

		<?php include('footer.inc'); ?>	
	</body>
</html>
