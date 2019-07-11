<html>
	<head>
		<style>
			.xyz {
				width: 400px;
				float: left;
			}
		</style>		
	</head>
	<body>
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
