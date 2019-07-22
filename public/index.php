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
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		  (adsbygoogle = window.adsbygoogle || []).push({
		    google_ad_client: "ca-pub-8230657718992601",
		    enable_page_level_ads: true
		  });
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
				<h1 class='display-3 px-4'>Compario<span class='beta'> v1.3</span></h1>
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

		<div id='player-comp-intro' class='container'>

			<div class='row'>				
				<div class='col-md-12 px-5'>
					<h1>Welcome to Compario</h2>
					<h3 class='mb-4'>The only cricket player comparison site you will ever need</h3>
					<h5 class='mb-5'>Simple and Easy to use Cricket Player Comparison
					Compario specialises in head to head stats comparison for cricket players and compares players on multiple metrics across Batting, Fielding and Bowling</h5>
				</div>
			</div>

			<div class='row'>				
				<div class='col-md-12 px-5'>
					<h2><u>Features</u></h2>
				</div>
			</div>

			<div class='row'>
				
				<div class='features col-md-6'>
					<div class='feature-text p-5 m-5'>
						<i class="fas fa-balance-scale"></i></i><h3 class='px-4 mb-3'>Head to Head Player Comparison</h3>
						<p class='px-4'>Unique comparison for players based on more than 15 metrics such as Batting Average, Best Bowling Figures, Strike Rate etc.</p>
					</div>
				</div>

				<div class='features col-md-6'>
					<div class='feature-text p-5 m-5'>						
						<i class='fas fa-poll'></i><h3 class='px-4 mb-3'>Easy To Read Player Statistics</h3>
						<p class='px-4'>Player comparison is presented in easy to read side by side format with a central line indicator that helps you understand the better stat at a glance.</p>
					</div>
				</div>

			</div>

			<div class='row'>
				
				<div class='features col-md-6'>
					<div class='feature-text p-5 m-5'>
						<i class="fas fa-calendar-alt"></i><h3 class='px-4 mb-3'>Match & Statistic Categories</h3>
						<p class='px-4'>Select from ODIs, Test Matches, T20Is, ListA and more. See performace stats based on Batting & Fielding or Bowling stat type.</p>
					</div>
				</div>

				<div class='features col-md-6'>
					<div class='feature-text p-5 m-5'>
						<i class="fas fa-address-card"></i><h3 class='px-4 mb-3'>Player Profiles & Date Filters</h3>
						<p class='px-4'>Your feedback is very important to us and we value it immensely. Player Profiles and Date filters will be added soon to present more in-depth analysis.</p>
					</div>
				</div>

			</div>

			<div class='row mb-5'>				
				<div class='col-md-12 px-5'>
					<h2 class='mb-3'><u>Sneak Peek</u></h2>
					<img class='feature-img' alt='Compario sneak peek feature image' src='static/feat-img.png'/>
				</div>

			</div>

			<div class='row mb-3'>				
				<div class='col-md-12 px-5'>
					<h2><u>How to use</u></h2>
					<h5>Using Compario is super easy. Just follow the three steps given below</h5>
				</div>
			</div>

			<div class='row mb-5'>				
				<div class='offset-md-2 col-md-8 px-5'>
					<ul>
						<li>Enter first, last or full names of the players you wish to compare</li>
						<li>Select players, match type and stat type from the drop-down options & hit Compare</li>
						<li>View detailed comparison and share it with your cricket loving friends</li>
					</ul>
				</div>
			</div>

			<div id='home-page-new-compare-btn'>
				<div class='col-md-12'><button id='compare-new-btn' class='btn btn-success'>Start New Comparison</button></div>
			</div>


		</div>
		
		<div id='player-comparison-wrapper'>
			<!-- Player Comparison -->
			
		</div>	
		
		<script type="text/javascript">
	atOptions = {
		'key' : '30f2871c3697cdb99b29467a9c6f638f',
		'format' : 'iframe',
		'height' : 60,
		'width' : 468,
		'params' : {}
	};
	document.write('<scr' + 'ipt type="text/javascript" src="http' + (location.protocol === 'https:' ? 's' : '') + '://www.bcloudhost.com/30f2871c3697cdb99b29467a9c6f638f/invoke.js"></scr' + 'ipt>');
</script>	

		<div id='coming-soon' class='px-2'>
			<p>Compario is best viewed on larger screens such as laptops. More in-depth comparisons, date based filters and player profiles is coming soon.</p>
		</div>		
        
        <?php 
			if (($p1_search != "") && ($p2_search != "") && ($player_1_link != "") && ($player_2_link != ""))
			{
				echo "<script>
					comparePlayers();
				</script>";
			}
		?>

		<?php include('footer.inc'); ?>	
	</body>
</html>
