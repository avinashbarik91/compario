<html>
	<head>
		<link href="https://fonts.googleapis.com/css?family=Anton|Lato&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<style>
			
			body {
				background-color: #232882;
				color: white;
				text-align: center;
				margin: 0px;
				font-family: 'Lato', sans-serif;
			}

			#player-comparison-wrapper {
				width: auto !important;
			    max-width: 1200px;
			    margin: 0 auto;
			    text-align: center;
			    display: table;
			    margin-top: 30px;
			}

			.xyz {
			    width: 350px;	   
			    border: 1px solid white;
			    margin: 10px;
			    padding: 10px;
			    display: inline-block;
			    text-align: left;
			}

			.player-bat-stats {
				display: inline-block;
			}

			#body-content-wrapper {
				background: url("static/intro-bg.png");
				min-height: 450px;
			    background-size: cover;
			    border-bottom-left-radius: 800px;
			    border-bottom-right-radius: 800px;
			}

			#header-wrapper {
				padding-top: 30px;				
			}

			h1 {
				font-family: 'Anton', sans-serif;
				font-weight: 500;
    			font-size: 3em;
    			text-transform: uppercase;
			}

			.chart-heading {
				text-align: center;
			}

			.fas {
				font-size: 2em;
			}
			
		</style>		
	</head>
	<body>
		<div id="body-content-wrapper">
			<div id="header-wrapper">
				<h1>Compario</h1>
				<p>Compare cricket player stats head-to-head</p>

				<form id="compare-form" method="post" action="/">
					<input type='text' name='player_1' value='' placeholder='Search Player 1 Name'/>
					<input type='text' name='player_2' value='' placeholder='Search Player 2 Name'/>
					<button onclick="getPlayers(event)">Search</button>
					<!-- <input type="submit" name="submit-btn" value="submit"> -->
				</form>
			</div>


			<div id='content'>
				<!-- Player Selection -->
			</div>

		</div>

		<div id='player-comparison-wrapper'>
			<!-- Player Comparison -->
		</div>
		

		<script src="js/jquery.slim.min.js"></script>
		<script src="js/jquery.min.js"></script>
		<script src="js/common.js"></script>
		<script src="js/popper.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
