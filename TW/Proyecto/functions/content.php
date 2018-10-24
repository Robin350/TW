<?php

	require_once 'db_operations.php';
	require_once 'admin_functions.php';
	require_once 'shop_functions.php';

	function printIntro($action, $id){
		$table_name = 'Introduction';

		$con = dbConnection();
		$result = getTableContent($con, $table_name);

		echo "<div>";
		while($row = $result->fetch_assoc()) {
			if(isset($action) && isset($id) && $action=='Modify Paragraph' && $id==$row['Id']){
				
				if(isset($row['Title'])){
					echo "<h3 style='color:rgb(255, 81, 0);'>".$row['Title']."</h3>";
				}
				echo "<p style='color:rgb(255, 81, 0);'>".$row['Content']."</p>";
			}
			else{
				if(isset($_SESSION['login']) && $_SESSION['type']=='admin'){
					printModDelForm($row['Id'], 'ILLENIUMmain.php', 'Paragraph');
				}
			
				if(isset($row['Title'])){
					echo "<h3>".$row['Title']."</h3>";
				}
				echo "<p>".$row['Content']."</p>";
				
			}
		}
		if(isset($_SESSION['login']) && $_SESSION['type']=='admin'){
			printAddForm('ILLENIUMmain.php', 'Paragraph');
		}
		echo "</div>";

		echo "<div> <img src='pics/illenium-portrait'></div>";
	}

	function printMedia(){
		$tbl_name = 'Media';

		$con = dbConnection();
		$result = getTableContent($con, $tbl_name);

		$media_per_column=($con->affected_rows)/3;

		for($i=0; $i<3; $i++)
		{
			echo "<div class='media-thumb'>";
			
			for($j=0; $j<$media_per_column; $j++){
				$row = $result->fetch_assoc();
				if($row !== null){
				echo "
					<a href='".$row['Url']."'>
						<div class='center'><i class='fa fa-external-link'></i></div>
						<img src='media/".$row['Content']."' class='media-".$row['Type']."'>

					</a>";
				}
			}

			echo	"</div>";
		}

	}

	function printMerch(){
	}

	function printFooter($links=['Top']){

		echo    "
		<div class='Footer'>
			<div>
				<ul class='nav-footer'>";
		foreach($links as $link){
			echo "<li><a href='#$link'>$link</a></li>";
		}
		echo    " 	<li><a href='ILLENIUMmain.php'>Home</a></li>
					<li><a href='ILLENIUMmusic.php'>Music</a></li>
					<li><a href='ILLENIUMshop.php'>Shop</a></li>
					<li><a href='ILLENIUMconcerts.php'>Concerts</a></li>
				</ul>
			</div>";

		echo "
			<div>
			<ul class='footer-social'>
				<li>
					<a href='https://www.facebook.com/Illenium' target='_blank'>
						<i class='fa fa-facebook'></i></a>
				</li>
				<li>
					<a href='https://twitter.com/ILLENIUMMUSIC' target='_blank'>
					<i class='fa fa-twitter'></i></a>
				</li>
				<li>
					<a href='http://instagram.com/illeniummusic' target='_blank'>
					<i class='fa fa-instagram'></i></a>
				</li>
				<li>
					<a href='https://soundcloud.com/illeniumofficial' target='_blank'>
					<i class='fa fa-soundcloud'></i></a>
				</li>
				<li>
					<a href='https://www.youtube.com/channel/UCv0tIDoaBZCTXQvVO4zosng' target='_blank'>
					<i class='fa fa-youtube'></i></a>
				</li>
			</ul>
			</div>";

		echo "<div class='newsletter'>
				<form action='javascript.void(0)'>
					<input placeholder='Enter Your Email Address' name='EMAIL' class='required email' id='mce-EMAIL' type='email'>
					<div style='position: absolute; left: -5000px;' aria-hidden='true'><input name='b_0e24f6708a290a46f4f5fce78_26edf08333' tabindex='-1' value='' type='text'></div>
					<input value='Subscribe' name='subscribe' id='mc-embedded-subscribe' type='submit'>
				</form>
			</div>
		</div>
		
		<div class='author'>
			<div><h5>Made by Robin Costas del Moral for TW. Contact me at robinloja97@correo.ugr.es</h5></div>
		</div>";


	}


	function printAlbums(){
		$con = dbConnection();
		$result = getTableContent($con, 'Albums');

		if(isset($_POST['picked']))
			processPurchase($_POST['picked']);

		echo "<div class='albums-container'>";
		while($row = $result->fetch_assoc()) {
			echo "<div class='album'>";
			echo "<h5 class='album-title'>". $row['Name'] ."</h5>";
			echo "<div class='album-content'>";
				echo "<div class='album-left'>";
					if(isset($_SESSION['type'])&&($_SESSION['type']=='admin')){
						printModDelForm($row['Name'],'ILLENIUMmusic.php','Album');
					}

					echo "<img class='album-img' src='albums/". $row['Image'] ."'>";
				echo "</div>";

				$price = $row['Price'];
				echo "<div class='album-right'>";
					echo "<p class='album-desc'>". $row['Description'] ."</p>";
					echo "<table class='songs'>
								<tr><th>Name</th><th>Duration</th></tr>";
					
					$sql = "SELECT * FROM Songs WHERE Name='". $row['Name'] ."'";
					$query = $con->query($sql);
					$number = 1;
					while($song = $query->fetch_assoc()){
						echo "<tr><td>$number. ". $song['Song'] ."</td><td>". $song['Duration'] ."</td></tr>";
						$number++;
						if(isset($_SESSION['type'])&&($_SESSION['type']=='admin')){
							printDelForm($song['Song'],'ILLENIUMmusic.php','Song');
						}
					}
					if(isset($_SESSION['type'])&&($_SESSION['type']=='admin')){
						printAddForm('ILLENIUMmusic.php','Song', $row['Name']);
					}
					echo "</table>";

					echo "<form action='ILLENIUMmusic.php' method='POST'>
									<input type='hidden' name='picked' id='".$row['Name']."'/>
									Price: $price $<input class='btn' type='submit' name='purchase' value='Purchase'/>
								</form>";

				echo "</div>";

			echo "</div>";
			echo "</div>";

		}
		echo "</div>";
		if(isset($_SESSION['type'])&&($_SESSION['type']=='admin')){
			printAddForm('ILLENIUMmusic.php','Album');
		}

	}

	function printConcerts(){
		$con=dbConnection();
		$result=getTableContent($con, 'Concerts');

		echo "<div class='concerts-container'>";
		echo "<table>
		<tr><th>Date</th><th>Festival</th><th>Place</th>";
		if(isset($_SESSION['type'])&&($_SESSION['type']=='admin')){
			echo "<th>Action</th>";
		}
		while($row = $result->fetch_assoc()) {

						
			echo "</tr>";

			echo "<tr><td>". $row['Date'] ."</td><td>". $row['Festival'] ."</td><td> ".$row['Place']."</td>";
			if(isset($_SESSION['type'])&&($_SESSION['type']=='admin')){
				printModDelForm($row['Date'],'ILLENIUMconcerts.php','Concert');
			}
			echo "</tr>";
		}
		echo "</table>";
		echo "</div>";
		if(isset($_SESSION['type'])&&($_SESSION['type']=='admin')){
			printAddForm('ILLENIUMconcerts.php','Concert');
		}

	}

?>