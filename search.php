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
<body><h1>Search the database</h1>
<!--<p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>-->
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
    /** Insert registration info
    if(!empty($_POST)) {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $date = date("Y-m-d");
                $companyname = $_POST['companyname'];
        // Insert data
        $sql_search = "INSERT INTO registration_tbl (name, email, date, companyname) 
                   VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql_search);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $date);
                $stmt->bindValue(4, $companyname);
        $stmt->execute(); 
    }
    catch(Exception $e) {
        die(var_dump($e));
    }
    echo "<h3>You're registered!</h3>";
    }**/
    // Retrieve data
    if(!empty($_POST)) {
                try {
                        //Copy POST data to variables and perform relevant SQL SELECT
                        $searchtype = $_POST['searchtype'];
                	$searchterm = $_POST['searchterm'];
                	echo "<p>".$searchtype.":".$searchterm"</p>";
                        $sql_select = "SELECT * FROM registration_tbl WHERE ? LIKE '%?%'";
                        $stmt = $conn->prepare($sql_select);
                        $stmt->bindValue(1, $searchtype);
                        $stmt->bindValue(2, $searchterm);                
                    $stmt = $conn->query($sql_select);
                    $results = $stmt->fetchAll(); 
                    if(count($registrants) > 0) {
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
                catch(Exception $e) {
                die(var_dump($e));
            }
        }
         
?>
</body>
</html>
