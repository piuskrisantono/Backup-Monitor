<?php

$currentPage ='backupmon';

$conn = pg_connect("host=localhost port=5432 dbname=backup_monitoring user=postgres password=postgres");

$dataMongo = pg_query($conn, "SELECT dbname, to_char(created_at, 'dd/mm/yyyy') as created_at, description FROM backup_result br WHERE db_type LIKE 'mongo' AND  cast(created_at as date) > current_date - interval '5' day ORDER BY dbname");

$dataMongo2 = pg_query($conn, "SELECT dbname, to_char(created_at, 'dd/mm/yyyy') as created_at, description FROM backup_result br WHERE db_type LIKE 'mongo' AND  cast(created_at as date) > current_date - interval '5' day ORDER BY  dbname");

$dataPostgres = pg_query($conn, "SELECT dbname, to_char(created_at, 'dd/mm/yyyy') as created_at, description FROM backup_result br WHERE db_type LIKE 'pg' AND  cast(created_at as date) > current_date - interval '5' day ORDER BY dbname");

$dataPostgres2 = pg_query($conn, "SELECT dbname, to_char(created_at, 'dd/mm/yyyy') as created_at, description FROM backup_result br WHERE db_type LIKE 'pg' AND  cast(created_at as date) > current_date - interval '5' day ORDER BY  dbname");





$totalPostgres = 0;
$failedPostgres =0;
$successPostgres =0;


$totalMongo = 0;
$failedMongo = 0;
$successMongo = 0;

$dayTwo =0;
$dayThree =0;
$dayFour = 0;
$dayFive =0;


while($row = pg_fetch_assoc($dataPostgres)){
    if($row['created_at'] == date("d/m/Y")){
        $totalPostgres++;
        if($row['description'] == 'Failed'){
            $failedPostgres++;
        }

        else{
            $successPostgres++;
        }
    }

    if($row['created_at'] == date("d/m/Y", strtotime("-1 days")) && $row['description'] == 'Failed'){$dayTwo++;}
        else if($row['created_at'] == date("d/m/Y", strtotime("-2 days")) && $row['description'] == 'Failed'){$dayThree++;}
            else if($row['created_at'] == date("d/m/Y", strtotime("-3 days")) && $row['description'] == 'Failed'){$dayFour++;}
                else if($row['created_at'] == date("d/m/Y", strtotime("-4 days")) && $row['description'] == 'Failed'){$dayFive++;}
}

while($row = pg_fetch_assoc($dataMongo)){
    if($row['created_at'] == date("d/m/Y")){
        $totalMongo++;
        if($row['description'] == 'Failed'){
            $failedMongo++;
        }

        else{
            $successMongo++;
        }
    }


    if($row['created_at'] == date("d/m/Y", strtotime("-1 days")) && $row['description'] == 'Failed'){$dayTwo++;}
        else if($row['created_at'] == date("d/m/Y", strtotime("-2 days")) && $row['description'] == 'Failed'){$dayThree++;}
            else if($row['created_at'] == date("d/m/Y", strtotime("-3 days")) && $row['description'] == 'Failed'){$dayFour++;}
                else if($row['created_at'] == date("d/m/Y", strtotime("-4 days")) && $row['description'] == 'Failed'){$dayFive++;}

}

pg_result_seek($dataPostgres, 0);
pg_result_seek($dataMongo, 0);

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link type="text/css" rel="stylesheet" href="scripts/css/own.css">
	<link rel="stylesheet" href="scripts/css/devicon.css">
	<script defer src="scripts/js/fontawesome5/svg-with-js/js/fontawesome-all.min.js"></script>
	<script src="scripts/css/package/dist/Chart.js"></script>
    <script src="scripts/js/jquery.min.js"></script>

	<style type="text/css">


	</style>

</head>
<body>

	<div id="nav" style="font-weight: bold;font-size:16px; letter-spacing: 1px;">
		<div id="logo">
			<span>DBS<span style="font-size: 25px;">tat&trade;</span></span>
		</div>
		<div id="nav-menu">
			<a href="#" class="active"><div class="icon-nav"><i class="fa fa-undo" aria-hidden="true"></i></div><span >Backup Monitor</span></a>
		<!--	<a href="webinv/dupindex.php"><div class="icon-nav"><i class="fa fa-clone" aria-hidden="true"></i></div><span>Duplicate Index</span></a>
			<a href="webinv/listdb.php"><div class="icon-nav"><i class="fa fa-database" aria-hidden="true"></i></div><span>Databases</span></a>
			<a href="webinv/unusedidx.php"><div class="icon-nav"><i class="fa fa-trash" aria-hidden="true"></i></div><span>Unused Index</span></a> 
			<a href="webinv/bloat.php"><div class="icon-nav"><i class="fa fa-expand" aria-hidden="true"></i></div><span>Bloat Table</span></a>-->
		</div>

	</div>
	<div id="content-container">
	<div id="content">
			<div class="highlight">
				<div id="icon-total" class="icon">
					<i class="fa fa-database" aria-hidden="true" style="color: white; font-size: 2vw;"></i>
				</div>
				<div class="info">
					<h1><?php echo $totalPostgres + $totalMongo ?></h1>Total
				</div>
			</div>
			<div class="highlight">
				<div id="icon-failed"  class="icon">
					<i class="fa fa-times" aria-hidden="true" style="color: white; font-size: 2vw;"></i>
				</div>
				<div class="info">
					<h1><?php echo $failedPostgres + $failedMongo;?></h1>Failed
				</div>
			</div>
			<div class="highlight">
				<div  class="icon icon-postgres">
					<i class="devicon-postgresql-plain" style="font-size: 2.5vw; color: white;"></i>
				</div>
				<div class="info">
					<h1><?php echo $totalPostgres ?></h1>PostgreSQL
				</div>
			</div>
			<div class="highlight">
				<div  class="icon icon-mongo">
					<i class="devicon-mongodb-plain" style="font-size: 2.5vw; color: white;"></i>
				</div>
				<div class="info">
					<h1><?php echo $totalMongo ?></h1>MongoDB
				</div>
			</div>
			<div class="doughnut-container" >
				<div class="doughnut-header" style=" height: 2vw">
					<h2 style="margin: 0 15px;font-size: 1.2vw;"><i class="devicon-postgresql-plain" style="position:relative;top:2px;color:  #7f8c8d;"></i> PostgreSQL</h2>
				</div>

				<div class="doughnut-chart">
					<div style="position: relative; padding: 0;">
						<h1 style="position: absolute; width: 100%; text-align: center; top: 2.5vw; font-size: 3vw;"><?php echo $failedPostgres ?><span style="font-size: 16px; display: block;">Failed</span></h1>
						<canvas id="postgresChart" style="width: 10vw; height: 10vw;"></canvas>
					</div>

				</div>
				
			</div>
			<div class="doughnut-container" >
				<div class="doughnut-header" style=" height: 2vw">
					<h2 style="margin: 0 15px;font-size: 1.2vw;"><i class="devicon-mongodb-plain" style="position:relative;top:3px;font-size:1.4vw;color:  #7f8c8d;"></i>  MongoDB</h2>
				</div>


				<div class="doughnut-chart">
					<div style="position: relative; padding: 0;">
						<h1 style="position: absolute; width: 100%; text-align: center; top: 2.5vw; font-size: 3vw;"><?php echo $failedMongo ?><span style="font-size: 16px; display: block;">Failed</span></h1>
						<canvas id="mongoChart" style="width: 10vw; height: 10vw;"></canvas>
					</div>

				</div>
				
			</div>
			<div id="chart-container">
				<div class="doughnut-header" style=" height: 2vw">
					<h2 style="margin: 0 15px;font-size: 1.2vw;"><i class="fa fa-calendar" aria-hidden="true" ></i> Last 5 Days</h2>
				</div>
				<canvas id="myChart" height="100"></canvas>
			</div>

			<div id="table-container-postgres">
					<div class="header-table-container" style="display: grid; align-items: center;justify-content: center;">
						<h2 style="font-size: 1.2vw;">PostgreSQL Services</h2>

						
					</div>
			        <table style="width: 100%; text-align: left;">
                            <thead>
                                    <tr>
                                            <th  width="55%" onclick="sortTable(0, 'pg-table')" >
	                                            		DB Name
                                                    <span class="sort-icon">
                                                            <div class="sort-by-asc"></div>
                                                            <div class="sort-by-desc"></div>
                                                    </span>
                                            </th>


                                            <th class="today"  width="20%" onclick="sortTable(2, 'pg-table')" >
                                                    Today
                                                    <span class="sort-icon">
                                                            <div class="sort-by-asc"></div>
                                                            <div class="sort-by-desc"></div>
                                                    </span>
                                            </th>
                                            <th class="fiveDays" width="25%"><span style="position: relative;top: 3px;">5 Days <i class="fa fa-question-circle" aria-hidden="true"></i>
</span></th>
                                    </tr>
                            </thead>


                            <tbody >
                                    <?php
                                            while($row = pg_fetch_assoc($dataPostgres)):
                                            	 if($row['created_at'] == date("d/m/Y")):
                                            
                                    ?>
                                    <tr
                                    <?php  if($row['description'] == 'Failed'): ?>
                                            class="failed-backup-postgres"
                                    <?php
                                            endif;
                                            echo " status='";echo $row['description'];echo"' ";
                                            echo " created_at='";echo $row['created_at'];echo"' ";
                                    ?>
                                    >

                                            <td width="55%"><?php echo $row['dbname']; ?></td>
                                            <td class="today" width="20%"><?php echo $row['description']; ?></td>
                                            <td  width="25%">
                                            	<?php

                                            		


                                            		for($i = 4; $i >=0 ; $i--){
                                            				pg_result_seek($dataPostgres2, 0);
                                            				$result = null;
       			                                      		while($row2 = pg_fetch_assoc($dataPostgres2)):
		                                            			if($row2['dbname']==$row['dbname'] && $row2['created_at'] == date("d/m/Y", strtotime("-".$i." days"))){
			                                            			$result = $row2['description'];
		                                            			}
		                                            		endwhile;
		                                            		if($result == 'Success') echo '<div class="backup-result-icon backup-result-icon-success"></div>';
		                                            		elseif ($result == 'Failed') echo '<div class="backup-result-icon backup-result-icon-failed"></div>';
		                                            		else echo '<div class="backup-result-icon"></div>';
		                                            		

                                            		}
                                            	?>

                                            </td>
                                           
                                    </tr>

                                    <?php
                                            endif; endwhile;
                                    ?>
                            </tbody>

                    </table>
			</div>

			<div id="table-container-mongo">
				<div class="header-table-container" style="display: grid;align-items: center;justify-content: center;">
						<h2 style="font-size: 1.2vw;">MongoDB Services</h2>

					</div>
			        <table style="width: 100%; text-align: left;">
                            <thead>
                                    <tr>
                                            <th  width="55%" onclick="sortTable(0, 'pg-table')" >
                                                    DB Name
                                                    <span class="sort-icon">
                                                            <div class="sort-by-asc"></div>
                                                            <div class="sort-by-desc"></div>
                                                    </span>
                                            </th>


                                            <th class="today"  width="20%" onclick="sortTable(2, 'pg-table')" >
                                                    Today
                                                    <span class="sort-icon">
                                                            <div class="sort-by-asc"></div>
                                                            <div class="sort-by-desc"></div>
                                                    </span>
                                            </th>
                                            <th class="fiveDays" width="25%"><span style="position: relative;top: 3px;">5 Days <i class="fa fa-question-circle" aria-hidden="true"></i>
</span></th>
                                    </tr>
                            </thead>


                            <tbody >
                                    <?php
                                            while($row = pg_fetch_assoc($dataMongo)):
                                            	 if($row['created_at'] == date("d/m/Y")):
                                            
                                    ?>
                                    <tr
                                    <?php  if($row['description'] == 'Failed'): ?>
                                            class="failed-backup-postgres"
                                    <?php
                                            endif;
                                            echo " status='";echo $row['description'];echo"' ";
                                            echo " created_at='";echo $row['created_at'];echo"' ";
                                    ?>
                                    >

                                            <td width="55%"><?php echo $row['dbname']; ?></td>
                                            <td class="today" width="20%"><?php echo $row['description']; ?></td>
                                            <td  width="25%">
                                            	<?php

                                            		


                                            		for($i = 4; $i >=0 ; $i--){
                                            				pg_result_seek($dataMongo2, 0);
                                            				$result = null;
       			                                      		while($row2 = pg_fetch_assoc($dataMongo2)):
		                                            			if($row2['dbname']==$row['dbname'] && $row2['created_at'] == date("d/m/Y", strtotime("-".$i." days"))){
			                                            			$result = $row2['description'];
		                                            			}
		                                            		endwhile;
		                                            		if($result == 'Success') echo '<div class="backup-result-icon backup-result-icon-success"></div>';
		                                            		elseif ($result == 'Failed') echo '<div class="backup-result-icon backup-result-icon-failed"></div>';
		                                            		else echo '<div class="backup-result-icon"></div>';
		                                            		

                                            		}
                                            	?>

                                            </td>
                                           
                                    </tr>

                                    <?php
                                            endif; endwhile;
                                    ?>
                            </tbody>

                    </table>
			</div>


		</div>
		
	</div>

</body>

<script type="text/javascript">


	
	Chart.defaults.global.defaultFontFamily= 'sans-serif';
	Chart.defaults.global.defaultFontColor= '#7f8c8d';


	let lineChart = document.getElementById('myChart').getContext('2d');
	let backupFailedChart = new Chart(lineChart, {
		type: 'line',
		data: {
			labels: ['5d', '4d', '3d', '2d', 'Today'],
			datasets: [{
				label: 'Failed',
				data: [
				<?php echo $dayFive; ?>,<?php echo $dayFour; ?>,<?php echo $dayThree; ?>,<?php echo $dayTwo; ?>,<?php echo $failedPostgres + $failedMongo; ?>],
				fill: false,
				borderColor:'#e74c3c',
				pointBackgroundColor:'#e74c3c',
				pointBorderColor: '#e74c3c'
		
			}]
		},
		options: {
			legend: {
				display:false
			},
			scales: {
		        yAxes: [{
		            ticks: {
		                stepSize: 1,
		                beginAtZero: true
		            }
		        }]
		    },
			 layout: {
	            padding: {
	                left: 15,
	                right: 15,
	                top: 25,
	                bottom: 0
	            }
	        }

		}
	});

	let postgresChart = document.getElementById('postgresChart').getContext('2d');
	let postgresFailedChart = new Chart(postgresChart, {
		type: 'doughnut',
		data: {
			labels: ['Failed','Success'],
			datasets: [{
				data: [<?php echo $failedPostgres; ?>,<?php echo $successPostgres; ?>],
				
				backgroundColor: ['#e74c3c', '#bdc3c7']
				
			}],
			
		},
		options: {
			cutoutPercentage: 85,
			legend: {
				display:false
			},

		}
	});

	let mongoChart = document.getElementById('mongoChart').getContext('2d');
	let mongoFailedChart = new Chart(mongoChart, {
		type: 'doughnut',
		data: {
			labels: ['Failed','Success'],
			datasets: [{
				data: [<?php echo $failedMongo; ?>,<?php echo $successMongo; ?>],
				
				backgroundColor: ['#e74c3c', '#bdc3c7']
				
			}],
			
		},
		options: {
			cutoutPercentage: 85,
			legend: {
				display:false
			},

		}
	});


</script>
</html>
