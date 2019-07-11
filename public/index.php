<html>
	<head>
		<style>
			
			body {
				background-color: #232882;
				color: white;
				text-align: center;
			}

			#player-comparison-wrapper {
				width: auto !important;
			    max-width: 1200px;
			    margin: 0 auto;
			    text-align: center;
			    display: table;
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
		</style>		
	</head>
	<body>
		<h1>Compario</h1>
		<p>Compare cricket player stats head-to-head</p>

		<form id="compare-form" method="post" action="/">
			<input type='text' name='player_1' value='' placeholder='Search Player 1 Name'/>
			<input type='text' name='player_2' value='' placeholder='Search Player 2 Name'/>
			<button onclick="getPlayers(event)">Search</button>
			<!-- <input type="submit" name="submit-btn" value="submit"> -->
		</form>


		<div id='content'>
			
		</div>

		<div id='player-comparison-wrapper'>
			
		</div>

		<script src="js/jquery.slim.min.js"></script>
		<script src="js/jquery.min.js"></script>
		<script src="js/common.js"></script>
		<script src="js/popper.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
