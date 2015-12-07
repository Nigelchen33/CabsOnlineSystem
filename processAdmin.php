<link rel = "stylesheet" href="style.css">
<?php

include_once "settings.php";
$conn = @mysqli_connect($host, $user, $pswd, $dbnm);
if (!$conn) {
    /* check connection */
    echo "<p><font color='red'>Sorry connect failure</font></p>";
} else {
     /* create table */
    $create_sql = "CREATE TABLE IF NOT EXISTS cabsonlineSystem(
					 orderNum INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                         referenceNum VARCHAR(255) NOT NULL,
					 customerName VARCHAR(255) NOT NULL,
                                         contactNum INT NOT NULL,
                                         uniNum INT,
                                         streetNum INT NOT NULL,
                                         streetName VARCHAR(255) NOT NULL,
                                         suburb VARCHAR(255) NOT NULL,
                                         deAddress VARCHAR(255) NOT NULL,
                                         deSuburb VARCHAR(255) NOT NULL,
                                         date VARCHAR(255) NOT NULL,
                                         time VARCHAR(255) NOT NULL,
                                         passengersNum INT NOT NULL,
                                         status varchar(50) default 'unassigned')";

    mysqli_query($conn, $create_sql);
    $sql = "select * from cabsonlineSystem";
    $result = mysqli_query($conn, $sql);
    if ($result == null) {
        echo "<p><font color='red'>you do not have unassigned request</font></p>";
    } else {
        /* get the result */
        $r = "<table border='2'class = 'tableLayout'><tr><th>Reference Number</th>
		<th>Customer Name</th><th>Contact Number</th><th>Pick Up Suburb</th>
		<th>Destination Suburb</th><th>Pick Up Date</th>
		<th>Pick-Up Time</th><th>Number of Passengers</th><th>Status</th>";
        while ($row = mysqli_fetch_assoc($result)) {
            $status = $row["status"];
            if ($status == "assigned") {
                
            } else {
                $referenceNum = $row["referenceNum"];
                $customerName = $row["customerName"];
                $contactNum = $row["contactNum"];
                $pickSub = $row["suburb"];
                $deSub = $row["deSuburb"];
                $pickDate = $row["date"];
                $pickTime = $row["time"];
                $passen = $row["passengersNum"];
                $status = $row["status"];
                /* check two hours from now */
               $time_array=explode(':',$pickTime);
		$hour=intval(trim($time_array[0]), 10)-2;
		$h=strval($hour);
		$check_time=$pickDate." ".$h.":".$time_array[1];
		if(strtotime($check_time)>strtotime(date('d-m-Y H:i'))){
                    /* create table to show the result */
                    $r = $r . "<tr><td>" . $referenceNum . "</td>
		<td>" . $customerName . "</td>
		<td>" . $contactNum . "</td>
		<td>" . $pickSub . "</td>
		<td>" . $deSub . "</td>
		<td>" . $pickDate . "</td>
		<td>" . $pickTime . "</td>
		<td>" . $passen . "</td>
                <td>" . $status."    </tr>";
                }
            }
        }
        $r = $r . "</table>";
        echo $r;
    }
}
?>