		<?php
			include("connects.php");
			
			$sql = "SELECT * FROM State";
			if($stmt = $db->query($sql))
			{
				while($result = mysqli_fetch_object($stmt))
				{
					echo '<p>No： '.$result->No.'，Time：'.$result->Timestamp.'</p>';
				}
			}
		?>
