<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    include '../asset/includes/dbconect.php';
    include '../asset/includes/header.php';
    if(isset($_GET['info'])){
        $id=$_GET['info'];
        $request=$database->prepare("SELECT * FROM Emp WHERE ID=:id");
        $request->bindValue("id" , $id);
        $request->execute();
        foreach($request AS $sh){
        echo'
        <main style="width: 80%; margin: auto; padding: 50px;">
        <form  method="POST"> 
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">ID Number</label>
            <div class="col-sm-10">
            <input type="number" name="id-number"  value="'.$sh['IDNUM'].'" class="form-control" id="inputPassword">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
            <input type="text" name="name"  value="'.$sh['Name'].'" class="form-control" id="inputPassword">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Birth Day</label>
            <div class="col-sm-10">
            <input type="txt" name="bdate"  value="'.$sh['BirthDate'].'" class="form-control" id="inputPassword" required>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Start Work</label>
            <div class="col-sm-10">
            <input type="txt" name="sdate" value="'.$sh['StartJob'].'" class="form-control" id="inputPassword" required>
            </div>
        </div>
        <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-2 col-form-label">End Work</label>
        <div class="col-sm-10">
        <input type="txt" name="edate" value="'.$sh['EndJob'].'" class="form-control" id="inputPassword" required>
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
        <input type="text" name="location" value="'.$sh['Location'].'" class="form-control" id="inputPassword" required>
        </div>
        </div>
        <button style="float:right;" name="remove" value="'.$sh['ID'].'" type="submit" class="btn btn-danger">Del</button>
        <button style="float:right;" value="'.$sh['ID'].'" name="Add" type="submit" class="btn btn-primary">Update</button>
        
  </form>
  </main>
        
        ';
        }
    }


    if(isset($_POST['Add'])){
        $name= $_POST['name'];
        $idnum= $_POST['id-number'];
        $bdate = $_POST['bdate'];
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        $status = $_POST['status'];
        $location = $_POST['location'];

        $insert=$database->prepare("UPDATE Emp SET Name=:name, IDNUM=:idnum,BirthDate=:bdate,StartJob=:sdate,EndJob=:edate,AllStatus=:statues,Location=:location WHERE ID=:id");

         $insert->bindParam("name",$name);
         $insert->bindParam("idnum",$idnum);
         $insert->bindParam("bdate",$bdate);
         $insert->bindParam("sdate",$sdate);
         $insert->bindParam("edate",$edate);
         $insert->bindParam("statues",$status);
         $insert->bindParam("location",$location);
         $insert->bindParam("id", $_POST['Add']);
         if($insert->execute()){
            echo "<script>location.replace('result.php?Search=".$idnum."')</script>";
         }



    }

    if(isset($_POST['remove'])){
        $removeProduct = $database->prepare("DELETE FROM Emp WHERE id = :Id ");
        $getId = $_POST['remove'];
        $removeProduct->bindParam("Id",$getId);
        if($removeProduct->execute()){
           echo "<script>location.replace('index.php')</script>";
        }}
        echo'
            <style>
                .footer{
                    margin-top: 13px;
                }
            </style>
        ';
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