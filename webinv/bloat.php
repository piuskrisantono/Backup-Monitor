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

  <body>
<div id="nav" style="font-weight: bold;font-size:16px; letter-spacing: 1px;">
    <div id="logo">
      <span>DBS<span style="font-size: 25px;">tat&trade;</span></span>
    </div>
    <div id="nav-menu">
      <a href="../index.php"><div class="icon-nav"><i class="fa fa-undo" aria-hidden="true"></i></div><span >Backup Monitor</span></a>
      <a href="dupindex.php"><div class="icon-nav"><i class="fa fa-clone" aria-hidden="true"></i></div><span>Duplicate Index</span></a>
      <a href="listdb.php"><div class="icon-nav"><i class="fa fa-database" aria-hidden="true"></i></div><span>Databases</span></a>
      <a href="unusedidx.php"><div class="icon-nav"><i class="fa fa-trash" aria-hidden="true"></i></div><span>Unused Index</span></a>
      <a href="#" class="active"><div class="icon-nav"><i class="fa fa-expand" aria-hidden="true"></i></div><span>Bloat Table</span></a>
    </div>

  </div>
  <div id="content-container">

    <!-- MAIN CONTENT -->
    <div style="margin-top:80px;" class="container">
      <div style="margin-left:15px;" class="row">
        <h1>List Bloated Table</h1>
		<h3>Choose Database</h3>
			<form id="dname" action="#" method="POST">
				<select name="db_name" id="db_name">
					<option value="">------choose-----</option>
 <?php
                                                $sql1="SELECT distinct databasename FROM bloat_table where DATE(insert_date) >= CURRENT_DATE AND DATE(insert_date) < CURRENT_DATE + INTERVAL '1 DAY' ORDER BY databasename";
                                                $listdb = pg_query($conn,$sql1);

                                                while($row = pg_fetch_assoc($listdb)){ // Ambil semua data dari hasil eksekusi $sql
                                                        echo "<option value='".$row['databasename']."'>".$row['databasename']."</option>";
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
      <th>Schema_Name</th>
      <th>Table_Name</th>
      <th>Can_Estimate</th>
      <th>Est_Rows</th>
      <th>Percentage_Bloat</th>
      <th>MB_Bloat</th>
      <th>Table_Size_MB</th>
	  <th>Insert_Date</th>
	  <!--<th>Insert_Date</th>-->
          </tr>
          <tbody >
	 <?php
        if(isset($_POST['db_name']))
                {
                        $dbname = $_POST['db_name'];
                        $sql="SELECT databasename,schemaname,tablename,can_estimate,est_rows,pct_bloat,mb_bloat,table_mb,to_char(insert_date,'DD/MM/YYYY') as insert_date from bloat_table where databasename='$dbname'";
                         $sql2="select distinct on (databasename,schemaname,tablename,insert_date)
                         databasename,schemaname,tablename,can_estimate,est_rows,pct_bloat,mb_bloat,table_mb,to_char(insert_date,'DD/MM/YYYY') as insert_date
                         from bloat_table
                         where DATE(insert_date) >= CURRENT_DATE AND DATE(insert_date) < CURRENT_DATE + INTERVAL '1 DAY'
                        and databasename='$dbname'
                         order by databasename,schemaname,tablename,insert_date DESC";
                }
        else
                {
                        $sql="SELECT databasename,schemaname,tablename,can_estimate,est_rows,pct_bloat,mb_bloat,table_mb,to_char(insert_date,'DD/MM/YYYY') as insert_date from bloat_table limit 20";
                         $sql2="select distinct on (databasename,schemaname,tablename,insert_date)
                databasename,schemaname,tablename,can_estimate,est_rows,pct_bloat,mb_bloat,table_mb,to_char(insert_date,'DD/MM/YYYY') as insert_date
                from bloat_table
                where DATE(insert_date) >= CURRENT_DATE AND DATE(insert_date) < CURRENT_DATE + INTERVAL '1 DAY'
                order by databasename,schemaname,tablename,insert_date DESC limit 20";
}

        $listindex = pg_query($conn,$sql2);
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
