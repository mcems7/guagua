<?php
/*
 * Written By: ShivalWolf
 * Date: 2011/06/03
 * Contact: Shivalwolf@domwolf.net
 *
 * UPDATE 2011/04/05
 * The code now returns a real error message on a bad query with the mysql error number and its error message
 * checks for magic_quotes being enabled and strips slashes if it is. Its best to disable magic quotes still.
 * Checks to make sure the submitted form is a x-www-form-urlencode just so people dont screw with a browser access or atleast try to
 * Forces the output filename to be JSON to conform with standards
 *
 * UPDATE 2011/06/03
 * Code updated to use the Web Module instead of tinywebdb
 *
 * UPDATE 2013/12/.
 * minor modifications by Taifun
 */

/************************************CONFIG****************************************/
//DATABSE DETAILS//
require("conexion.php");
//SETTINGS//
//This code is something you set in the APP so random people cant use it.
$SQLKEY=sha1("12343");

/************************************CONFIG****************************************/

//these are just in case setting headers forcing it to always expire and the content type to CSV
header('Cache-Control: no-cache, must-revalidate');
header('Content-type: text/csv');

error_log(print_r($_POST,TRUE));

if( isset($_POST['query']) && isset($_POST['key']) ){         //checks if the tag post is there and if its been a proper form post
  if($_POST['key']==$SQLKEY){          ///validate the SQL key
    $query=urldecode($_POST['query']);
    if(get_magic_quotes_gpc()){     //check if the worthless pile of crap magic quotes is enabled and if it is strip the slashes from the query
      $query=stripslashes($query);
    }
    if($mysqli){
     $mysqli->query("SET time_zone =  '-05:00'");
      $result=$mysqli->query($query);                            //runs the posted query (NO PROTECTION FROM INJECTION HERE)
      if($result){
        if (strlen(stristr($query,"SELECT"))>0) {             //tests if its a select statemnet
          $num_fields = $result->mysqli_num_fields;            //collects the rows and writes out a header row
          $headers = array();
          
          for ($i = 0; $i < $num_fields; $i++) {
            $headers[] = mysqli_field_name($result , $i);
          }
          
          $datosrow = array();
          $datosrow2 = array();
          while ($row = $result->fetch_assoc()){
            $datosrow[] = $row;
          }
          foreach ($datosrow as $id => $valor){
              foreach ($valor as $id2 => $valor2){
                $datosrow2[$id2][$id]=$valor2;
              }
          }
          foreach ($datosrow2 as $id => $valor){
              $headers[] = $id;
          }
          $outstream = fopen("php://temp", 'r+');             //opens up a temporary stream to hold the data
          fputcsv($outstream, $headers, ',', '"');
          foreach ($datosrow as $idv => $rowv){
            fputcsv($outstream, $rowv, ',', '"');
          }
          rewind($outstream);
          fpassthru($outstream);
          fclose($outstream);
          // echo $csv; //writes out csv data back to the client
        }else if (strlen(stristr($query,"SHOW"))>0) {
             $num_fields = $result->mysqli_num_fields;            //collects the rows and writes out a header row
          $headers = array();
          for ($i = 0; $i < $num_fields; $i++) {
            $headers[] = mysqli_field_name($result, $i);
          }
          $outstream = fopen("php://temp", 'r+');             //opens up a temporary stream to hold the data
            fputcsv($outstream, $headers, ',', '"');
          while ($row = $result->fetch_assoc()){
            fputcsv($outstream, $row, ',', '"');
          }
          rewind($outstream);
          fpassthru($outstream);
          fclose($outstream);
          // echo $csv; //writes out csv data back to the client
        }else {
          header("HTTP/1.0 201 Rows");
          echo "AFFECTED ROWS: ".$mysqli->affected_rows; //if the query is anything but a SELECT it will return the number of affected rows
        }
      } else {
        header("HTTP/1.0 400 Bad Request");  //send back a bad request error
        echo $mysqli->errno.": ".$mysqli->error;     // errors if the query is bad and spits the error back to the client
      }
      $mysqli->close();                                //close the DB
    } else {
      header("HTTP/1.0 400 Bad Request");
      echo "ERROR Database Connection Failed";               //reports a DB connection failure
    }
  } else {
     header("HTTP/1.0 400 Bad Request");
     echo "Bad Request";                                     //reports if the code is bad
  }
} else {
        header("HTTP/1.0 400 Bad Request");
        echo "Bad Request";
}
echo "<hr>";
?>