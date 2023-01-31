<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    include '../asset/includes/header.php';
    include '../asset/includes/dbconect.php';

    echo'
    <main style="width: 80%; margin: auto; padding: 50px;">
        <form  method="POST"> 
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">ID Number</label>
            <div class="col-sm-10">
            <input type="number" name="id-number" class="form-control" id="inputPassword">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
            <input type="text" name="name" class="form-control" id="inputPassword">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Birth Day</label>
            <div class="col-sm-10">
            <input type="date" name="bdate" class="form-control" id="inputPassword" required>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Start Work</label>
            <div class="col-sm-10">
            <input type="date" name="sdate" class="form-control" id="inputPassword" required>
            </div>
        </div>
        <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-2 col-form-label">End Work</label>
        <div class="col-sm-10">
        <input type="date" name="edate" class="form-control" id="inputPassword" required>
        </div>
    </div>

        <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
        <div class="width" style="width:83%">
            <select name="status" class="form-select form-select-md mb-3" aria-label=".form-select-lg example" required>
            <option  selected>Open this select menu</option>
            <option  value="اجازة بدون مرتب" >اجازة بدون مرتب</option>
            <option  value="اجازة رعاية طفل">اجازة رعاية اطفال</option>
            <option  value="ايقاف صرف للحبس">ايقاف صرف للحبس</option>
            <option  value="ايقاف صرف للنقل">ايقاف صرف للنقل</option>
            <option  value="محكمة تأديبيه">محكمة تأديبيه</option>
            <option  value="منتدب للخارج">منتدب للخارج</option>
            <option  value="يصرف">يصرف</option>
            
            </select>
            </div>
        </div>
        <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Location</label>
        <div class="col-sm-10">
        <input type="text" name="location" class="form-control" id="inputPassword" required>
        </div>
        </div>
        <button style="float:right;" name="Add" type="submit" class="btn btn-primary">Add</button>
        
  </form>
  </main>
    ';

    if(isset($_POST['Add'])){
        $name= $_POST['name'];
        $idnum= $_POST['id-number'];
        $bdate = $_POST['bdate'];
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        $status = $_POST['status'];
        $location = $_POST['location'];

        $insert=$database->prepare("INSERT INTO Emp(Name,IDNUM,BirthDate,StartJob,EndJob,AllStatus,Location)
         VALUES(:name,:idnum,:bdate,:sdate,:edate,:statues,:location)");

         $insert->bindParam("name",$name);
         $insert->bindParam("idnum",$idnum);
         $insert->bindParam("bdate",$bdate);
         $insert->bindParam("sdate",$sdate);
         $insert->bindParam("edate",$edate);
         $insert->bindParam("statues",$status);
         $insert->bindParam("location",$location);
         if($insert->execute()){
            echo "<script>location.replace('result.php?Search=".$idnum."')</script>";
         }



    }
include '../asset/includes/footer.php';
}
else{
    header("location:login.php");
}
if(isset($_POST['logout'])){
    session_destroy();
    header("location:login.php");
}
?>