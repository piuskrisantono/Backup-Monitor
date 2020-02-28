<?php
include 'koneksi.php';
?>
<html>
  <head>
    <meta charset='utf-8' />
    <meta http-equiv="X-UA-Compatible" content="chrome=1" />
  <link type="text/css" rel="stylesheet" href="../scripts/css/own.css">
  <script defer src="../scripts/js/fontawesome5/svg-with-js/js/fontawesome-all.min.js"></script>
    <link href="src/style_bootstrap.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="test/libs/bootstrap-editable.css" rel="stylesheet">
    <link href="src/bootstrap-filterable.css" rel="stylesheet">
    <link href="http://lightswitch05.github.io/filterable/stylesheets/main.css" rel="stylesheet">

    <title>Filterable</title>

  </head>

  <body >

    <div id="nav" style="font-weight: bold;font-size:16px; letter-spacing: 1px;">
    <div id="logo">
      <span>DBS<span style="font-size: 25px;">tat&trade;</span></span>
    </div>
    <div id="nav-menu">
      <a href="../index.php"><div class="icon-nav"><i class="fa fa-undo" aria-hidden="true"></i></div><span >Backup Monitor</span></a>
      <a href="dupindex.php"><div class="icon-nav"><i class="fa fa-clone" aria-hidden="true"></i></div><span>Duplicate Index</span></a>
      <a href="listdb.php"><div class="icon-nav"><i class="fa fa-database" aria-hidden="true"></i></div><span>Databases</span></a>
      <a href="#" class="active"><div class="icon-nav"><i class="fa fa-trash" aria-hidden="true"></i></div><span>Unused Index</span></a>
      <a href="bloat.php"><div class="icon-nav"><i class="fa fa-expand" aria-hidden="true"></i></div><span>Bloat Table</span></a>
    </div>

  </div>
  <div id="content-container">


    <!-- MAIN CONTENT -->
    <div style="margin-top:80px;" class="container">
      <div style="margin-left:15px;" class="row">
        <h1>List Unused Index </h1>
		<h3>Choose Database</h3>
			<form id="dname" action="#" method="POST">
				<select name="db_name" id="db_name">
					<option value="">------choose-----</option>
						<?php
						$sql1="SELECT distinct dbname FROM list_unused_index_m ORDER BY dbname";
						$listdb = pg_query($conn,$sql1);

						while($row = pg_fetch_assoc($listdb)){ // Ambil semua data dari hasil eksekusi $sql
							echo "<option value='".$row['dbname']."'>".$row['dbname']."</option>";
						}
						
						?>			
				</select>
		<br>
		<td colspan="2"><button type="submit" value="simpan">Submit</button>&nbsp&nbsp&nbsp&nbsp</td>
		</form>
		
        <table id="myTable" class="table table-responsive table-bordered table-striped table-hover table-condensed">


          <tr>		  
	  <!--<th>Hostname</th>-->
      <th>Database_Name</th>
      <th>Table_Name</th>
      <th>Index_Name</th>
      <th>Num_rows</th>
      <th>Table_Size</th>
      <th>Index_Size</th>
      <th>Unique</th>
      <th>Number_of_scans</th>
      <th>Tuples_read</th>
      <th>Tuples_fetched</th>
	  <th>Insert_Date</th>
	  <!--<th>Insert_Date</th>-->
          </tr>
          <tbody >
	<?php
	if(isset($_POST['db_name']))
		{
			$dbname = $_POST['db_name'];
			$sql="SELECT a.dbname,a.tablename,a.indexname,a.num_rows,a.table_size,a.index_size,a.uniqueindex,a.number_of_scans,a.tuples_read,a.tuples_fetched,to_char(a.insert_date,'DD/MM/YYYY') as insert_date FROM list_unused_index_m a join list_unused_index_s b using (indexname) where a.dbname='$dbname'";
		}
	else
		{
			$sql="SELECT a.dbname,a.tablename,a.indexname,a.num_rows,a.table_size,a.index_size,a.uniqueindex,a.number_of_scans,a.tuples_read,a.tuples_fetched,to_char(a.insert_date,'DD/MM/YYYY') as insert_date FROM list_unused_index_m a join list_unused_index_s b using (indexname) limit 20";
		}

	$listindex = pg_query($conn,$sql);
	while($row = pg_fetch_assoc($listindex)):
	  
	 
	?>
      <tr>
	  <!--<td><?php echo $row['hostname']; ?></td>-->
      <td><?php echo $row['dbname']; ?></td>
      <td><?php echo $row['tablename']; ?></td>
      <td><?php echo $row['indexname']; ?></td>
      <td><?php echo $row['num_rows']; ?></td>
      <td><?php echo $row['table_size']; ?></td>
      <td><?php echo $row['index_size']; ?></td>
      <td><?php echo $row['uniqueindex']; ?></td>
      <td><?php echo $row['number_of_scans']; ?></td>
      <td><?php echo $row['tuples_read']; ?></td>
      <td><?php echo $row['tuples_fetched']; ?></td>
	  <td><?php echo $row['insert_date']; ?></td>
	  <!--<td><?php echo $row['b.insert_date']; ?></td>-->
      </tr>
	<?php 
	endwhile;
	?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- FOOTER  -->
    <footer class="footer">
      <div class="container">
        <p class="copyright">
          Unused Index &copy; <a href="#">DB Inventory Blibli</a> 2019.
          Released under the <a href="#">synleolicense</a>.
        </p>
      </div>
    </footer>
  </div>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
  <script src="test/libs/bootstrap-editable.min.js"></script>
  <script src="src/filterable-utils.js"></script>
  <script src="src/filterable-cell.js"></script>
  <script src="src/filterable-row.js"></script>
  <script src="src/filterable.js"></script>
  <script type="text/javascript"> $('table').filterable(); </script>
  </body>
</html>
