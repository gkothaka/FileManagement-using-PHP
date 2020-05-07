<?php
//fetch.php
if(isset($_POST["action"]))
{
 $connect = mysqli_connect("localhost", "root", "", "phplessons");
 $output = '';
 if($_POST["action"] == "Subject")
 {
  $query = "SELECT LabName FROM labdetails WHERE Subject = '".$_POST["query"]."' GROUP BY LabName";
  $result = mysqli_query($connect, $query);
  $output .= '<option value="">Select LabName</option>';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '<option value="'.$row["LabName"].'">'.$row["LabName"].'</option>';
  }
 }
 echo $output;
}
?>
