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
      <a href="#" class="active"><div class="icon-nav"><i class="fa fa-clone" aria-hidden="true"></i></div><span>Duplicate Index</span></a>
      <a href="listdb.php"><div class="icon-nav"><i class="fa fa-database" aria-hidden="true"></i></div><span>Databases</span></a>
      <a href="unusedidx.php"><div class="icon-nav"><i class="fa fa-trash" aria-hidden="true"></i></div><span>Unused Index</span></a>
      <a href="bloat.php"><div class="icon-nav"><i class="fa fa-expand" aria-hidden="true"></i></div><span>Bloat Table</span></a>
    </div>

  </div>
  <div id="content-container">

    <!-- MAIN CONTENT -->
    <div style="margin-top:80px;" class="container">
      <div style="margin-left:15px;" class="row">
        <h1>List Duplicate Index</h1>
		<h3>Choose Database</h3>
			<form id="dname" action="#" method="POST">
				<select name="db_name" id="db_name">
					<option value="">------choose-----</option>
						<?php
						$sql1="SELECT distinct dbname FROM duplicate_index ORDER BY dbname";
						$listdb = pg_query($conn,$sql1);

						while($row = pg_fetch_assoc($listdb)){ // Ambil semua data dari hasil eksekusi $sql
							echo "<option value='".$row['dbname']."'>".$row['dbname']."</option>";
						}
						
						?>			
				</select>
				<br>
				<td colspan="2"><button type="submit" value="simpan">Submit</button>&nbsp&nbsp&nbsp&nbsp</td>
			</form>
        <table id="myTable"  class="table table-responsive table-bordered table-striped table-hover table-condensed">
	  <tr>
     <!-- <th>Hostname</th> -->
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
	if(isset($_POST['db_name']))
		{
			$dbname = $_POST['db_name'];
			$sql="select dbname,size,idx1,idx2,idx3,idx4,to_char(insertdate, 'DD/MM/YYYY')as insertdate from duplicate_index where dbname='$dbname'";
		}
	else
		{
			$sql="select dbname,size,idx1,idx2,idx3,idx4,to_char(insertdate, 'DD/MM/YYYY')as insertdate from duplicate_index limit 20";
		}

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
      </div>
    </div>

    <!-- FOOTER  -->
    <footer class="footer">
      <div class="container">
        <p class="copyright">
          Duplicate Index &copy; <a href="#">DB Inventory Blibli</a> 2019.
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
  <script type="text/javascript">
    $('table').filterable();
  </script>

  </body>
</html>
