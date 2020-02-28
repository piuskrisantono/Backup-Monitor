<?php
include 'koneksi.php';
?>
<html>
  <head>
    <meta charset='utf-8' />
    <meta http-equiv="X-UA-Compatible" content="chrome=1" />

    <link href="src/style_bootstrap.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="test/libs/bootstrap-editable.css" rel="stylesheet">
    <link href="src/bootstrap-filterable.css" rel="stylesheet">
    <link href="http://lightswitch05.github.io/filterable/stylesheets/main.css" rel="stylesheet">

    <title>Filterable</title>
  </head>
  <body style="background-color:#FFFFBB;">


    <!-- MAIN CONTENT -->
    <div style="margin-top:40px;" class="container">
      <div style="margin-left:-100px;" class="row">
	          <h1>List Inventory Database PostgreSQL GCP </h1>
	<ul>
		<li><a href="home.php">Home</a></li>
		<li><a href="">List</a>
			<ul>
				<li><a href="listdb.php">List Database</a></li>
				<li><a href="dupindex.php">List Duplicate Index</a></li>
				<li><a href="unusedidx.php">List Unused Index</a></li>
				<li><a href="bloat.php">List Bloat Table</a></li>
			</ul>
		</li>
	</ul>
	</div>
  </div>
    <div style="margin-top:10px;" class="container">
      <div style="margin-left:-100px;" class="row">
        <h3>List Inventory Database<!--<small>Click column name for shorting</small>--></h3>
        <table id="list_db"  class="table table-responsive table-bordered table-striped table-hover table-condensed">
          <tr>
      <th>Hostname&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
	  <th>Database_Name</th>
      <th>OS_Version&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
      <th>Memory_Size_MB</th>
      <th>Used_Memory</th>
      <th>bit_OS</th>
      <th>Total_CPU_Core</th>
      <th>DB_Role</th>
      <th>DB_Version</th>
      <th>DB_Size</th>
	  <th>DB_MaxConnection</th>
      <th>DB_Uptime&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
      <th>Data_Dir_Size</th>
      <th>Data_Dir_Available</th>
	  <th>Data_Dir_Used</th>
	  <th>Archive_Log_Size</th>
      <th>Archive_Log_Available</th>
	  <th>Archive_Log_Used</th>
      <th>Insert_Date</th>
          </tr>
          <tbody >
     <?php
			$sql="select a.hostname,a.osversion,a.memory,a.usedmemory,a.bit_os,a.cpucore,a.dbdatadirsize,a.dbdatadiravail,a.dbdatadirused,a.archlogsize,a.archlogavail,a.archlogused,b.dbname,b.dbrole,b.dbversion,b.dbsize,b.maxconn,b.dbuptime,to_char(b.insertdate,'DD/MM/YYYY') as insertdate from os_info a join db_info b using (hostname) order by a.hostname limit 5";

			$listdb = pg_query($conn,$sql);
			while($row = pg_fetch_assoc($listdb)):
		   ?>
      <tr>
      <td><?php echo $row['hostname']; ?></td>
	  <td><?php echo $row['dbname']; ?></td>
      <td><?php echo $row['osversion']; ?></td>
      <td><?php echo $row['memory']; ?></td>
      <td><?php echo $row['usedmemory']; ?></td>
      <td><?php echo $row['bit_os']; ?></td>
      <td><?php echo $row['cpucore']; ?></td>
      <td><?php echo $row['dbrole']; ?></td>
      <td><?php echo $row['dbversion']; ?></td>
      <td><?php echo $row['dbsize']; ?></td>
      <td><?php echo $row['maxconn']; ?></td>
      <td><?php echo $row['dbuptime']; ?></td>
      <td><?php echo $row['dbdatadirsize']; ?></td>
      <td><?php echo $row['dbdatadiravail']; ?></td>
      <td><?php echo $row['dbdatadirused']; ?></td>
	  <td><?php echo $row['archlogsize']; ?></td>
      <td><?php echo $row['archlogavail']; ?></td>
      <td><?php echo $row['archlogused']; ?></td>
      <td><?php echo $row['insertdate']; ?></td>
      </tr>
	<?php 
	endwhile;
	?>
          </tbody>
        </table>
		<h3>List Duplicate Index<!--<small>Click column name for shorting</small>--></h3>
		<table id="dup_index"  class="table table-responsive table-bordered table-striped table-hover table-condensed">
          <tr> 
	  <th>Database_Name</th>
      <th>Size</th>
      <th>Index1</th>
      <th>Index2</th>
      <th>Index3</th>
      <th>Index4</th>
      <th>Insert_Date</th>				
		  </tr>
          <tbody >
    <?php	
		$sql="select dbname,size,idx1,idx2,idx3,idx4,to_char(insertdate, 'DD/MM/YYYY')as insertdate from duplicate_index limit 5";
		$listindex = pg_query($conn,$sql);
		while($row = pg_fetch_assoc($listindex)):

	?>
      <tr>
      <!--<td><?php echo $row['hostname']; ?></td> -->
      <td><?php echo $row['dbname']; ?></td>
      <td><?php echo $row['size']; ?></td>
      <td><?php echo $row['idx1']; ?></td>
      <td><?php echo $row['idx2']; ?></td>
      <td><?php echo $row['idx3']; ?></td>
      <td><?php echo $row['idx4']; ?></td>
      <td><?php echo $row['insertdate']; ?></td>
      </tr>
	<?php 
	endwhile;
	?>
	     </tbody>
        </table>
		
	<h3>List Unused Index<!--<small>Click column name for shorting</small>--></h3>
		<table id="unused_index"  class="table table-responsive table-bordered table-striped table-hover table-condensed">
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
	$sql="SELECT a.dbname,a.tablename,a.indexname,a.num_rows,a.table_size,a.index_size,a.uniqueindex,a.number_of_scans,a.tuples_read,a.tuples_fetched,to_char(a.insert_date,'DD/MM/YYYY') as insert_date FROM list_unused_index_m a join list_unused_index_s b using (indexname) limit 5";

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
	<h3>List Bloated Table<!--<small>Click column name for shorting</small>--></h3>
		<table id="bloat_table"  class="table table-responsive table-bordered table-striped table-hover table-condensed">
          <tr>		  
      <th>Database_Name</th>
      <th>Schema_Name</th>
      <th>Table_Name</th>
      <th>Can_Estimate</th>
      <th>Est_Rows</th>
      <th>Percentage_Bloat</th>
      <th>MB_Bloat</th>
      <th>Table_Size_MB</th>
	  <th>Insert_Date</th>
          </tr>
          <tbody >
    <?php
	$sql="SELECT databasename,schemaname,tablename,can_estimate,est_rows,pct_bloat,mb_bloat,table_mb,to_char(insert_date,'DD/MM/YYYY') as insert_date from bloat_table limit 5";

	$listindex = pg_query($conn,$sql);
	while($row = pg_fetch_assoc($listindex)):
	  
	 
	?> 
      <tr>
	  <td><?php echo $row['databasename']; ?></td>
      <td><?php echo $row['schemaname']; ?></td>
      <td><?php echo $row['tablename']; ?></td>
      <td><?php echo $row['can_estimate']; ?></td>
      <td><?php echo $row['est_rows']; ?></td>
      <td><?php echo $row['pct_bloat']; ?></td>
      <td><?php echo $row['mb_bloat']; ?></td>
      <td><?php echo $row['table_mb']; ?></td>
	  <td><?php echo $row['insert_date']; ?></td>
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
	<!--	<a href="welcome.php">Main Menu</a>
		<a href="admin/logout.php">LOGOUT</a>-->
        <p class="copyright">
          Database List &copy; <a href="#">DB Inventory Blibli</a> 2019.
          Released under the <a href="#">synleolicense</a>.
        </p>
      </div>
    </footer>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
  <script src="test/libs/bootstrap-editable.min.js"></script>
  <script src="src/filterable-utils.js"></script>
  <script src="src/filterable-cell.js"></script>
  <script src="src/filterable-row.js"></script>
  <script src="src/filterable.js"></script>
  <!--<script type="text/javascript">
    $('table').filterable();
  </script>-->

  </body>
</html>
