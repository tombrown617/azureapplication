<html>
<head>
<Title>Registration Form</Title>
<style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; font-size: .85em; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; }
    th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
</style>
</head>
<body>
<h3 align="right"><a href="index.php">Registration page</a></h3>
<h1>Search the database</h1>
<form method="post" action="search.php" enctype="multipart/form-data" >
          <input type="text" name="searchterm" id="searchterm"/></br>
      Search by:  <select name="searchtype"><option value="name">Name</option><option value="email">Email</option><option value="companyname">Company Name</option></br>
      <input type="submit" name="submit" value="Search" />
</form>
<?php
    // DB connection info
    //TODO: Update the values for $host, $user, $pwd, and $db
    //using the values you retrieved earlier from the portal.
    $host = "eu-cdbr-azure-west-b.cloudapp.net";
    $user = "bbd53f14d03551";
    $pwd = "8eeaa2e9";
    $db = "tombrowANQS3Hz1m";
    // Connect to database.
    try {
        $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        die(var_dump($e));
    }
    if(!empty($_POST)) {
                try {
                        //Copy POST data to variables and perform relevant SQL SELECT
                        $searchtype = $_POST['searchtype'];
                                                if($searchtype != "name" && $searchtype != "email" && $searchtype != "companyname")        {
                                                        echo "Invalid search type, please try again";
                                                }
                                                else {
                                $searchterm = $_POST['searchterm'];
                                $sql_select = "SELECT * FROM registration_tbl WHERE ".$searchtype." LIKE '%".$searchterm."%'";
                                $stmt = $conn->prepare($sql_select);               
                                    $stmt->execute();
                                    $results = $stmt->fetchAll(); 
                                    if(count($results) > 0) {
                                        echo "<h2>Search Results:</h2>";
                                        echo "<table>";
                                        echo "<tr><th>Name</th>";
                                        echo "<th>Email</th>";
                                    echo "<th>Company Name</th>";
                                        echo "<th>Date</th></tr>";
                                        foreach($results as $result) {
                                            echo "<tr><td>".$result['name']."</td>";
                                            echo "<td>".$result['email']."</td>";
                                        echo "<td>".$result['companyname']."</td>";
                                            echo "<td>".$result['date']."</td></tr>";
                                        echo "</table>";
                                        }
                                }
                                     else {
                                         echo "<h3>No matching registrants found.</h3>";
                                     }
                                                }
                    }
                catch(Exception $e) {
                die(var_dump($e));
                    }
        }
         
?>
</body>
</html>
