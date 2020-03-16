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
    <title>Document</title>
</head>
<body>
    <div>
    <?php
    if(isset($_POST['AddLab']))
    {
    $subject =$_POST["subject"];
    $LabName = $_POST["LabName"];
    $Description = $_POST["Description"];
    $LabInstructor = $_POST["LabInstructor"];
    # Inserting a new record into LabDetails table
    $sql = "Insert into LabDetails (subject, LabName, Description, LabInstructor) values ('$subject','$LabName','$Description','$LabInstructor')";
    if(mysqli_query($conn,$sql))
    {
    echo "Lab Added successfully! you may upload a document";
    }else{
    echo "There was an error creating a new lab";
    }
    }
    ?>
    <h1>Add NEW LAB </h1>
    <form  method="post" enctype="multipart/form-data">
    <label>Subject</label>
    <input type="text" name="subject" placeholder="Java/PHP"><br><br>
    <label>LAB_NAME</label>
    <input type="text" name="LabName" placeholder="DataTypes/Operations"><br><br>
    <label>Description</label>
    <textarea name="Description" placeholder="define lab" cols="30" rows="5"></textarea><br><br>
    <label>LABInstructor</label>
    <input type="text" name="LabInstructor"><br><br>
    <input type="submit" name="AddLab">
    </form>
    </div>


    <div>
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
                $Usubject =$_POST["subject"];
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
<?php
$sql = "select distinct(subject) from LabDetails order by subject";
$sql1 = "select distinct(LabName) from LabDetails order by LabName";
    $result = mysqli_query($conn,$sql);
    $result1 = mysqli_query($conn,$sql1);
?>
    
    <h1>Upload a Document</h1>

    <form method="post" enctype="multipart/form-data">
    <label>Subject</label>
    <select name="subject">
    <?php while($rows = $result->fetch_assoc())
    {
        $subject = $rows['subject'];
        echo "<option>$subject</option>";
    }
    ?>
    </select><br><br>
    <label>LabName</label>
    <select name="LabName">
    <?php while($rows = $result1->fetch_assoc())
    {
        $LabName = $rows['LabName'];
        echo "<option>$LabName</option>";
    }
    ?></select><br><br>
    <label>Type</label>
    <select name="Type">
    <option>QuestionSheet</option>
    <option>AnswerSheet</option>
    </select><br><br>
    <input type="File" name="file"><br><br>
    <input type="submit" name="UploadLab">
    </form>
    </div>


<div>
    <?php
    if(isset($_POST['RetrieveLab2']))
    {
        $Rsubject=$_POST["subject"];
        $RLabName=$_POST["LabName"];
        $file ='uploads/'.$_POST["file"];
        $filename = $_POST["file"];
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="'.$filename.'"');
        header('Content-Transfer-Encoding:binary');
        header('Accept-Ranges: bytes');
        @readfile($file);
    }
?>
<?php
$sql = "select distinct(subject) from DocDetails order by subject";
$sql1 = "select distinct(LabName) from DocDetails order by LabName";
$sql2 = "select distinct(FileName) from DocDetails order by subject;";
    $result = mysqli_query($conn,$sql);
    $result1 = mysqli_query($conn,$sql1);
    $result2 = mysqli_query($conn,$sql2);
?>
    
    <h1>Upload a Document</h1>

    <form method="post" enctype="multipart/form-data">
    <label>Subject</label>
    <select name="subject">
    <?php while($rows = $result->fetch_assoc())
    {
        $subject = $rows['subject'];
        echo "<option>$subject</option>";
    }
    ?>
    </select><br><br>
    <label>LabName</label>
    <select name="LabName">
    <?php while($rows = $result1->fetch_assoc())
    {
        $LabName = $rows['LabName'];
        echo "<option>$LabName</option>";
    }
    ?></select><br><br>
    <label>FileName</label>
    <select name="file">
    <?php while($rows = $result2->fetch_assoc())
    {
        $FileName = $rows['FileName'];
        echo "<option>$FileName</option>";
    }
    ?>   </select><br><br>
    <input type="submit" name="RetrieveLab2">
    </form>
    </div>
</body>
</html>