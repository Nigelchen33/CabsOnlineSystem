<?php

require_once ("settings.php");
$conn = @mysqli_connect($host, $user, $pswd, $dbnm);
if (!$conn) {
    echo "<p> Database connection failure</p>";
} else {
    $sql_tble = "CREATE TABLE IF NOT EXISTS cabsonlineSystem(
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
    $queryResult = @mysqli_query($conn, $sql_tble)
            or die("<p> Unable to excute the query.</p>"
                    . "<p>Error code " . mysqli_errno($conn)
                    . ":" . mysqli_error($conn)) . "</p>";
    $customerName = $_POST['customerName'];
    $contactNum = $_POST['contactNum'];
    $uniNum = $_POST['uniNum'];
    $streetNum = $_POST['streetNum'];
    $streetName = $_POST['streetName'];
    $suburb = $_POST['suburb'];
    $deAddress = $_POST['deAddress'];
    $deSuburb = $_POST['deSuburb'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $pass = $_POST['pass'];
    $referenceNum = $_POST['referenceNum'];
    $timeLimit = $date." ".$time;
    $coName = false;
    $coContact = false;
    $coStNum = false;
    $costName = false;
    $coSuburb = false;
    $coAddress = false;
    $coDeSuburb = false;
    $coDate = false;
    $coTime = false;
    if (!empty($customerName) && !empty($contactNum) && !empty($streetNum) &&
            !empty($streetName) && !empty($suburb) && !empty($deAddress) &&
            !empty($deSuburb) && !empty($date) && !empty($time)) {
        $namecheck = "/^[a-zA-Z]*/";
        $streenNumCheck = "/^[0-9]+$/";
        $addressCheck = "/^[a-zA-Z0-9_ ]*$/";
        $dateFormat = "/^(([0-9]|[1-2][0-9]|[3][0-1])-([0-9]|[1][0-2])-([1-2][0-9][0-9][0-9]))/";
        $timeCheck = "/^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])/";
//        check every input
        if (preg_match($namecheck, $customerName)) {
            $coName = true;
        } else {
            echo "<p style='color:#FF0000'>Customer name only include a-z and A-Z</p>";
        }
        if (preg_match($streenNumCheck, $contactNum)) {
            $coContact = true;
        } else {
            echo "<p style='color:#FF0000'>please enter correct phone number with numbers only!</p>";
        }
        if (preg_match($streenNumCheck, $streetNum)) {
            $coStNum = true;
        } else {
            echo "<p style='color:#FF0000'>please enter correct street number with numbers only!</p>";
        }
        if (preg_match($namecheck, $streetName)) {
            $costName = true;
        } else {
            echo "<p style='color:#FF0000'>please enter corect street name!</p>";
        }
        if (preg_match($namecheck, $suburb)) {
            $coSuburb = true;
        } else {
            echo "<p style='color:#FF0000'>please enter corect street Suburb name!</p>";
        }
        if (preg_match($addressCheck, $deAddress)) {
            $coAddress = true;
        } else {
            echo "<p style='color:#FF0000'>please enter corect Address!</p>";
        }
        if (preg_match($namecheck, $deSuburb)) {
            $coDeSuburb = true;
        } else {
            echo "<p style='color:#FF0000'>please enter corect Suburb!</p>";
        }
        if (preg_match($dateFormat, $date)) {
            $coDate = true;
        } else {
            echo "<p style='color:#FF0000'>The date you enter is wrong. The format is 2000-1-1</p>";
        }
        if(preg_match($timeCheck, $time)&& (strtotime($timeLimit)>= strtotime(date('Y-m-d H:i')))){
                 $coTime = true;                      
        }else{
             echo "<p style='color:#FF0000'>The time you enter is wrong. The format is 12:12 and the time must after current time</p>";
        }
    } else {
        echo "<p style = 'color:#FF0000'>please fill in the blank except the unit number";
    }

    if ($coAddress && $coDate && $coName && $coDeSuburb && $coStNum && $coContact && $coSuburb && $coTime && $costName) {
        $query_check = "select * from cabsonlineSystem where customerName='$customerName'";
        $result = mysqli_query($conn, $query_check);
        if (!$result) {
            echo "<p class='wrong'>Sorry,connection fail</p>";
            echo "<a href='index.php'>return to the Home page</a>";
        } else {
            $row = mysqli_fetch_assoc($result);
            if ($row != null) {
                echo "<p style='color:#FF0000'>Failure,status code exists</p>";
            } else {

                $query = "insert into cabsonlineSystem(referenceNum,customerName,contactNum,uniNum,streetNum, streetName,suburb,deAddress, deSuburb,date,time,passengersNum) 
                            values('$referenceNum','$customerName','$contactNum','$uniNum','$streetNum','$streetName','$suburb','$deAddress','$deSuburb','$date','$time','$pass')";
                echo "Thank you! Your booking reference number is < " . $referenceNum . " >.";
                echo "<br/>";
                echo "You will be picked up in front of your provided address at " . $time . " on " . $date;
                mysqli_query($conn, $query);
            }
        }
    } else {
        echo "<p>you enter wrong format, please write again</p>";
    }
}
?>