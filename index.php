<?php
$servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "phplessons";
    $conn = new mysqli($servername, $username, $password, $dbName);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
$(document).ready(function(){
 $('.action').change(function(){
  if($(this).val() != '')
  {
   var action = $(this).attr("id");
   var query = $(this).val();
   var result = '';
   if(action == "Subject")
   {
    result = 'LabName';
   }
      $.ajax({
    url:"fetcher.php",
    method:"POST",
    data:{action:action, query:query},
    success:function(data){
     $('#'+result).html(data);
    }
   })
  }
 });
});
</script>
<script>
$(document).ready(function(){
 $('.action').change(function(){
  if($(this).val() != '')
  {
   var action = $(this).attr("id");
   var query = $(this).val();
   var result = '';
   if(action == "DSubject")
   {
    result = 'DLabName';
   }
   else
   {
    result = 'DFileName';
   }
   $.ajax({
    url:"fetch.php",
    method:"POST",
    data:{action:action, query:query},
    success:function(data){
     $('#'+result).html(data);
    }
   })
  }
 });
});
</script>

    <title>Document</title>
</head>
<body>
    
    <div class="container" style="width:600px;">
    <?php
    if(isset($_POST['AddLab']))
    {
    $subject =$_POST["Subject"];
    $LabName = $_POST["LabName"];
    $Description = $_POST["Description"];
    $LabInstructor = $_POST["LabInstructor"];
    # Inserting a new record into LabDetails table
    $sql = "Insert into labdetails (Subject, LabName, Description, LabInstructor) values ('$subject','$LabName','$Description','$LabInstructor')";
    if(mysqli_query($conn,$sql))
    {
    echo "Lab Added successfully! you may upload a document";
    }else{
    echo "There was an error creating a new lab (or) the lab you are trying to create is already present!";
    }
    }
    ?>
    <h1 align="center">Add NEW LAB </h1>
    <form  method="post"  enctype="multipart/form-data">
    <label>Subject</label>
    <input type="text" name="Subject" placeholder="Java/PHP"><br><br>
    <label>LAB_NAME</label>
    <input type="text" name="LabName" placeholder="DataTypes/Operations"><br><br>
    <label>Description</label>
    <textarea name="Description" placeholder="define lab" cols="30" rows="5"></textarea><br><br>
    <label>LABInstructor</label>
    <input type="text" name="LabInstructor"><br><br>
    <input type="submit" name="AddLab">
    </form>
    </div>

<!-- uploading browsing document -->

    <div class="container" style="width:600px;">
    <?php
    if(isset($_POST['UploadLab']))
    {
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('docx', 'pdf', 'jpg');
    if(in_array($fileActualExt, $allowed))
    {
        if($fileError === 0)
        {
            if ($fileSize <1000000){
                $Usubject =$_POST["Subject"];
                $ULabName = $_POST["LabName"];
                $UType = $_POST['Type'];
                $UfileNameNew = $Usubject.$ULabName.$fileName.uniqid('',true).".".$fileActualExt;
                $fileDestination = 'uploads/'.$UfileNameNew;
    
                # Inserting a new record into DocDetails table
                $sql2 = "Insert into DocDetails (subject, LabName, Type, FileName) values ('$Usubject','$ULabName','$UType','$UfileNameNew')";
                if(mysqli_query($conn,$sql2))
                {
                echo "Doc details added successfully";
                move_uploaded_file($fileTmpName, $fileDestination);
                echo "File uploaded successfully";
                }else{
                echo "Doc details couldn't added! Try adding again.";
                }
                
            }else{
                echo "your file is too big!";
                }
        }else{
            echo "There was an error uploading your file";
            }
    }else{
        echo "you can upload only docx pdf and jpg";
        }
}
?>
<h2 align="center">Upload documents</h2><br /><br />
  <?php
//index.php
$Subject = '';
$query = "SELECT Subject FROM labdetails GROUP BY Subject ORDER BY Subject ASC";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result))
{
 $Subject .= '<option value="'.$row["Subject"].'">'.$row["Subject"].'</option>';
}
?>
    <form method="post" enctype="multipart/form-data">
    <label>Subject</label>
     <select name="Subject" id="Subject" class="form-control action">
    <option value="">Select Subject</option>
    <?php echo $Subject; ?>
   </select>
   <br />
    <label>LabName</label>
   <select name="LabName" id="LabName" class="form-control action">
    <option value="">Select LabName</option>
   </select>
   <br />
    <label>Type</label>
    <select name="Type">
    <option>QuestionSheet</option>
    <option>AnswerSheet</option>
    </select><br><br>
    <input type="File" name="file"><br><br>
    <input type="submit" name="UploadLab">
    </form>
    </div>


<!-- Retrieving  document -->


<div class="container" style="width:600px;">
    <?php
    if(isset($_POST['RetrieveLab2']))
    {
        $Rsubject=$_POST["DSubject"];
        $RLabName=$_POST["DLabName"];
        $file ='uploads/'.$_POST["DFileName"];
        $filename = $_POST["DFileName"];
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="'.$filename.'"');
        header('Content-Transfer-Encoding:binary');
        header('Accept-Ranges: bytes');
        @readfile($file);
    }
?>
<?php
//index.php
$Subject = '';
$query = "SELECT Subject FROM docdetails GROUP BY Subject ORDER BY Subject ASC";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result))
{
 $Subject .= '<option value="'.$row["Subject"].'">'.$row["Subject"].'</option>';
}
?>

 <h2 align="center">Retrieve a Document</h2><br /><br />
    <form method="post" enctype="multipart/form-data">
    <label>Subject</label>
    <select name="DSubject" id="DSubject" class="form-control action">
    <option value="">Select Subject</option>
    <?php echo $Subject; ?>
   </select>
   <br />
    <label>LabName</label>
    <select name="DLabName" id="DLabName" class="form-control action">
    <option value="">Select LabName</option>
   </select>
   <br />
    <label>FileName</label>
    <select name="DFileName" id="DFileName" class="form-control">
    <option value="">Select FileName</option>
   </select><br><br>
    <input type="submit" name="RetrieveLab2">
    </form>
    </div>
</body>
</html>

