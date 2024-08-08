 <?php

//fetch_data.php

include('database_connection.php');

if(isset($_POST["action"]))
{
	$query = "
		SELECT * FROM add_movie WHERE status = '1'
	";
	
	if(isset($_POST["categroy"]))
	{
		$categroy_filter = implode("','", $_POST["categroy"]);
		$query .= "
		 AND categroy IN('".$categroy_filter."')
		";
	}
	if(isset($_POST["language"]))
	{
		$language_filter = implode("','", $_POST["language"]);
		$query .= "
		 AND language IN('".$language_filter."')
		";
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			if($row['action']== "running"){
			$output .= '
			<div class="col-lg-4 col-md-5 col-sm-6">
				<div  style="margin-bottom:1px; height:500px; border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25); ">
					<img src="admin/image/'. $row['image'] .'" alt="" class="resize" style="height:250px; width:150px; margin:20px; object-fit:cover;border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);" >
					<p align="center"><strong><h4>'. $row['movie_name'] .'</h4></strong></p>
					
					Directer : '. $row['directer'] .' <br />
					Categroy : '. $row['categroy'] .'<br />
					Language : '. $row['language'] .'</p>
					
				</div>
					<a href="movie_details.php?pass='.$row['id'].'" class="btn btn-primary" style="margin-left: -15px;margin-top: -90px;border-radius:15px; background-color:orange; border:none; box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);">Book Now</a>
			</div>
			';

		}

		if($row['action']== "upcoming"){
			$output .= '
			<div class="col-lg-4 col-md-5 col-sm-6">
				<div style="margin-bottom:1px; height:500px; border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);">
					<img src="admin/image/'. $row['image'] .'" alt="" class="resize" style="height:250px; width:150px; margin:20px; object-fit:cover;border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);" >
					<p align="center"><strong><h4>'. $row['movie_name'] .'</h4></strong></p>
					
					Directer : '. $row['directer'] .' <br />
					Categroy : '. $row['categroy'] .'<br />
					Language : '. $row['language'] .'</p>
					
				</div>
					<a href="movie_details.php?pass='.$row['id'].'" class="btn btn-primary" style="margin-left: -15px;border-radius:15px;  margin-top: -90px; box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25); background-color:orange; border:none;">Upcoming</a>
			</div>
			';
		}
	}
	}
	else
	{
		$output = '<h3>No Data Found</h3>';
	}
	echo $output;
}

?>