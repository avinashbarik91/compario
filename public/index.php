<html>
	<head>
		<title>Compario | Simple head-to-head comparison for cricket players</title>
		<meta charset="UTF-8">
		<meta http-equip="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Simple head-to-head comparison for cricket players">
		<meta http-equiv="x-ua-compatible" content="ie-edge">
		<meta property='og:title' content='Compario'/>		
		<meta property='og:description' content='Compario - Simple head-to-head comparison for cricket players'/>
		<meta property='og:url' content='https://compario.dev'/>
		<meta property='og:type' content='Open Source'/>
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Righteous&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<link rel="stylesheet" href="stylesheet/bootstrap.min.css">
		<script src="js/jquery.slim.min.js"></script>
		<script src="js/jquery.min.js"></script>
		<script src="js/common.js"></script>
		<script src="js/popper.js"></script>		
		<script src="js/bootstrap.min.js"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script> -->

		<style>
			
			body {
				/*background-image: linear-gradient(to right, #233d7b , #071842);*/
				background-image: radial-gradient(circle, #1d215a, #171b4e, #040b27);
				color: #EDF5E1 !important;
				text-align: center;
				margin: 0px;
				font-family: 'Josefin Sans', sans-serif;
				min-height: 100%;
				position: relative;
			}

			input[type="text"], select option, .form-control {
			 	background-color : #EDF5E1 !important; 
			 	color: #05386b !important;
			}

			#player-comparison-wrapper {
				width: auto !important;
			    max-width: 1200px;
			    margin: 0 auto;
			    text-align: center;
			    display: table;
			    margin-top: 30px;			    		    
			}

			.charts {
			    width: 350px;	
			    height: 220px;   
			    border: 1px solid white;
			    margin: 10px;
			    padding: 10px;
			    display: inline-block;
			    text-align: left;
			    box-shadow: 4px 5px 5px 1px #00000040;
			}

			.player-bat-stats {
				display: inline-block;
			}

			#body-content-wrapper {
				/*background: url("static/intro-bg.png");*/
				/*background-image: linear-gradient(to right, #f11f53 , #071842);*/
				background-image: linear-gradient(to right, #5cdb95 , #05386b);
				min-height: 650px;
			    background-size: cover;
			    border-bottom-left-radius: 500px;
			    border-bottom-right-radius: 500px;
			   /* border-bottom: 4px solid #ff1e50;*/
			    box-shadow: 5px 6px 10px 2px #050b28;
			}

			#header-wrapper {
				padding-top: 30px;				
			}

			h1 {
				font-family: 'Righteous', sans-serif;				
    			font-size: 3em;    			
			}

			.chart-heading {
				text-align: center;
			}

			.fas {
				font-size: 2em;
				margin-bottom: 5px;
			}

			.form-control {
				margin: 5px 0px;
			}

			.select-compare-options {
				background: rgba(5, 57, 107, 0.4);
    			padding: 30px;
    			border-radius: 20px;
			}

			.loader {
				background-image: url(static/flat-bouncing-circle-loading-icon.svg);
			    width: 50px;
			    height: 50px;
			    background-size: cover;
			    position: absolute;
			    top: 71%;
			    right: 49%;
			    display: none;
			}

			.player-profiles {
				font-size: 1.4em;
			}			

			.player-profiles img{
				border: 1px solid white;
			}

			.player-profiles img{
				margin: 10px 0px;
				box-shadow: 4px 5px 5px 1px #00000040;
				display: none;
			}

			.footer {
				position: absolute;
				bottom:0;
				width: 100%;
				background-color: #05386b;
				bottom: -70px;
			}

			#coming-soon {
				position: absolute;
				bottom:0;
				width: 100%;
				bottom: -28px;
			}

			.footer a {
				padding-top: 10px;
				color: #EDF5E1 !important;
			}

			.footer p {
				margin-top: 15px;
			}

			#compare-form button {
				background-color: #e41c4e;
				border: #f11f53;
			}

			label {
				font-size: 1.2em;
			}

			/*.player-bat-stats.diff {
				width: 100%;
			    height: auto;
			    text-align: center;
			    margin-top: 10%;
			}*/

			.stat-play-num {
				font-size: 1rem;
			}

			.player-stat-chart-container .row {
				margin-bottom: 15px;
			}

			.bar-1 {
				border-top-left-radius: 25px;
				border-bottom-left-radius: 25px;
				height: 30px;
				background-color:#5cdb95; 				
			}

			.bar-2 {
				border-top-right-radius: 25px;
				border-bottom-right-radius: 25px;
				height: 30px;
				background-color:#05386b; 
			}

			.player-bat-stats.diff span {
				width: 45px;
			    height: 12px;
			    display: inline-block;			    
			    margin: 4px;
			    background-color: #5cdb95;
			}

			.player-bat-stats.diff .sp-second {
				background-color: #05386b !important;
			}

			.vs-text {
				font-size: 5.5rem;
				font-family: 'Righteous', sans-serif;
			}

			.btn {
				width: 150px;
			}

			.fas {
				font-size: 3em;
			} 

			legend {
				font-family: 'Righteous', sans-serif;
			}

			.player-name-post {
				font-family: 'Righteous', sans-serif;
				font-size: 2rem;
			}

			.player-profiles .display-4 {
				font-family: 'Righteous', sans-serif;
				margin-top: 38%;
				font-size: 5rem;
			}

			.beta {
				font-size: 1rem !important;
				font-family: 'Josefin Sans', sans-serif;;
			}
			
		</style>		
	</head>
	<body>
		
		<div id="body-content-wrapper">
			<div id="header-wrapper">
				<h1 class='display-3'>Compario<span class='beta'> v1 Beta</span></h1>
				<p>Compare cricket player stats head-to-head</p>

				<div class="container mb-4 search-form">
					<div class='row'>
							<div class='col-md-5'><i class="fas fa-user-circle"></i><input type='text' class="form-control text-right" name='player_1' value='' placeholder='Search Player 1 Name (Ex: Dhoni)'/></div>
							<div class='col-md-2'><span class='vs-text'>vs</span></div>
							<div class='col-md-5'><i class="fas fa-user-circle"></i><input type='text' class="form-control" name='player_2' value='' placeholder='Search Player 2 Name (Ex: Gilchrist)'/></div>
							<div class='offset-md-4 col-md-4'><button class="btn btn-success" onclick="getPlayers(event)">Search</button></div>													
					</div>					
				</div>
			</div>


			<div id='content'>
				<!-- Player Selection -->
			</div>

		</div>
		<div class='loader'></div>
		<div id='player-comparison-wrapper'>
			<!-- Player Comparison -->
			<i class='fas fa-poll'></i><h3>Head-to-Head Batting, Bowling and Fielding Career Comparison</h3>
			<p>Simple to read statistics with the latest results and scores for cricket players. Search and select players, stat type and match type to get started.</p>
		</div>
		<div id='coming-soon'>
			<p>Compario is in beta. More in-depth comparisons, date based filters and player profiles is coming soon.</p>
		</div>
		<h5 class="mb-2">Share your thoughts</h5>
					<hr/>
					<div id="disqus_thread"></div>
					<script>
					var disqus_config = function () {
					this.page.url = 'compario.dev';  // Replace PAGE_URL with your page's canonical URL variable
					this.page.identifier = 'compario.dev'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
					};
					
					(function() { // DON'T EDIT BELOW THIS LINE
					var d = document, s = d.createElement('script');
					s.src = 'https://compario.disqus.com/embed.js';
					s.setAttribute('data-timestamp', +new Date());
					(d.head || d.body).appendChild(s);
					})();
					</script>
					<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                            
		<div class="footer" style="height: 50px;">
			<p class="footer-text text-center mb-0 text-light"><a target="_blank" href="https://github.com/avinashbarik91/compario">&#9400; Compario <?php echo date('Y');?> By Avinash Barik  </a></p>
		</div>
		<script id="dsq-count-scr" src="//compario.disqus.com/count.js" async></script>
	</body>
</html>
