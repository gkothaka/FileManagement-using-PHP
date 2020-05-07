<?php
//fetch.php
if(isset($_POST["action"]))
{
 $connect = mysqli_connect("localhost", "root", "", "phplessons");
 $output = '';
 if($_POST["action"] == "DSubject")
 {
   $query = "SELECT LabName FROM docdetails WHERE Subject = '".$_POST["query"]."' GROUP BY LabName";
  $result = mysqli_query($connect, $query);
    $output .= '<option value="">Select LabName</option>';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '<option value="'.$row["LabName"].'">'.$row["LabName"].'</option>';
  }
 }
 if($_POST["action"] == "DLabName")
 {

  $query = "SELECT FileName FROM docdetails WHERE LabName = '".$_POST["query"]."'";
  $result = mysqli_query($connect, $query);
  $output .= '<option value="">Select FileName</option>';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '<option value="'.$row["FileName"].'">'.$row["FileName"].'</option>';
  }
 }
 echo $output;
}
?>
