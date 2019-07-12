<html>
	<head>
		<link href="https://fonts.googleapis.com/css?family=Anton|Lato&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<link rel="stylesheet" href="stylesheet/bootstrap.min.css">
		<script src="js/jquery.slim.min.js"></script>
		<script src="js/jquery.min.js"></script>
		<script src="js/common.js"></script>
		<script src="js/popper.js"></script>		
		<script src="js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>

		<style>
			
			body {
				background-image: linear-gradient(to right, #1a3d8e , #0c2561);
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
				min-height: 530px;
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

			.form-control {
				margin: 5px 0px;
			}

			.select-compare-options {
				background: rgba(35, 40, 130, 0.3);
    			padding: 30px;
    			border-radius: 100px;
			}
			
		</style>		
	</head>
	<body>
		<div id="body-content-wrapper">
			<div id="header-wrapper">
				<h1>Compario</h1>
				<p>Compare cricket player stats head-to-head</p>

				<div class="container">
					<div class='row'>
						<div class='col-md-4'></div>
						<div class='col-md-4'>
							<form id="compare-form" method="post" action="/">
								<div class="form-group"> 
									<input type='text' class="form-control" name='player_1' value='' placeholder='Search Player 1 Name'/>
									<input type='text' class="form-control" name='player_2' value='' placeholder='Search Player 2 Name'/>
									<button class="form-control btn btn-primary" onclick="getPlayers(event)">Search</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>


			<div id='content'>
				<!-- Player Selection -->
			</div>

		</div>

		<div id='player-comparison-wrapper'>
			<!-- Player Comparison -->
		</div>
	</body>
</html>
