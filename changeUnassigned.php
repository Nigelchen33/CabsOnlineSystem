<?php

//connect to database
require_once('settings.php');

$conn = @mysqli_connect($host, $user, $pswd, $dbnm);

if ($conn) {
    $referenceNum = $_POST["referenceNum"];
    if (!empty($_POST["referenceNum"])) {

        $Query = "select * from cabsonlinesystem where referenceNum = '$referenceNum'";
        $uniqueQueryResult = @mysqli_query($conn, $Query) or die("<p>Unable to execute the query.</p>"
                        . "<p>Error code " . mysqli_errno($conn)
                        . ": " . mysqli_error($conn)) . "</p>";

        $mResult = mysqli_query($conn, $Query);
        if (!$mResult) {
            echo "<p><font color='red'>The SQL query got error!</font></p>";
        } else {

            if (mysqli_num_rows($mResult) < 1) {
                echo "<p><font color='red'>The number you have entered does not exists!</font></p>";
            } else {
                $query = "UPDATE cabsonlinesystem set status = 'assigned' where referenceNum = '$referenceNum' and status = 'unassigned'";
                //display error code
                $queryResult = @mysqli_query($conn, $query) or die("<p>Unable to execute the query.</p><p>Error code " . mysqli_errno($conn) . ":" . mysqli_error($conn)) . "</p>";

                $result = mysqli_query($conn, $query);

                if (!$result) {

                    echo "<p><font color='red'>The SQL query got error!</font></p>";
                } else {

                    echo "<p><font color='DarkGreen'>The booking request <font color='red'>$referenceNum</font> has been properly assigned.</font></p>";
                }
            }
        }
    } else {
        echo "<p><font color='Red'>The search text box cannot be null!</font></p>";
    }
    //close the connect
    mysqli_close($conn);
} else {

    echo "<p>Database connection failure</p>";
    mysqli_close($conn);
}
?>