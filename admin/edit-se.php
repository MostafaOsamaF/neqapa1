<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    include '../asset/includes/dbconect.php';
    include '../asset/includes/header.php';
    if(isset($_GET['info'])){
        $id=$_GET['info'];
        $request=$database->prepare("SELECT * FROM orders WHERE id=:id");
        $request->bindParam("id",$id);
        $request->execute();
        foreach($request AS $sh){
            $id_num = $sh['id_number'];
            $req=$database->prepare("SELECT * FROM Emp WHERE IDNUM=:idnum");
            $req->bindParam("idnum", $sh['id_number']);
            $req->execute();
            $Emp = $req->fetchObject();
            echo '<main style="width: 80%; margin: auto; padding: 50px;">
        <form  method="POST"> 
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">ID Number</label>
            <div class="col-sm-10">
            <input type="number" name="id-number" value="'.$sh['id_number'].'" class="form-control" id="inputPassword">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
            <input type="text" name="name" value="'.$Emp->Name.'" class="form-control" id="inputPassword">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Service Type</label>
            <div class="width" style="width:83%">
                <select name="service" class="form-select form-select-md mb-3" aria-label=".form-select-lg example" required>
                <option  selected>Open this select menu</option>';
        $sevice= $database->prepare("SELECT * FROM service");
        $sevice->execute();
        foreach($sevice AS $se){echo'<option  value="'.$se['id'].'">'.$se['servicesName'].'</option>';}
        echo'
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">cost</label>
            <div class="col-sm-10">
            <input type="number" name="cost" class="form-control" id="inputPassword" value="'.$sh['cost'].'" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label" required>Ticket Number</label>
            <div class="col-sm-10">
            <input type="number" name="tnumber" class="form-control" value="'.$sh['ticket_number'].'" id="inputPassword" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Date Ticket</label>
            <div class="col-sm-10">
            <input type="date" name="tdate" class="form-control" id="inputPassword" value="'.$sh['ticket_date'].'" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Note</label>
            <div class="col-sm-10">
            <input type="text" name="note" class="form-control" id="inputPassword" value="'.$sh['note'].'" required>
            </div>
        </div>
        <button style="float:right;" name="remove" value="'.$sh['id'].'" type="submit" class="btn btn-danger">Del</button>
          <button style="float:right;" name="update" value="'.$sh['id'].'" type="submit" class="btn btn-primary">update</button>
          
    </form>
    </main>';
        }
    
    }
    if(isset($_POST['update'])){
        $idname= $_POST['id-number'];
        $tyser= $_POST['service'];
        $cost= $_POST['cost'];
        $tknum= $_POST['tnumber'];
        $tkdate= $_POST['tdate'];
        $note= $_POST['note'];
        $update= $database->prepare("UPDATE orders SET id_number=:id_number ,
         id_service=:id_service ,
         ticket_number=:ticket_number ,
         ticket_date=:ticket_date , 
         note=:note , 
         cost=:cost
        WHERE id=:id");
        $update->bindParam("id_number",$idname);
        $update->bindParam("id_service",$tyser);
        $update->bindParam("ticket_number",$tknum);
        $update->bindParam("ticket_date",$tkdate);
        $update->bindParam("note",$note);
        $update->bindParam("cost",$cost);
        $update->bindParam("id",$_POST['update']);
        if($update->execute()){
            echo "<script>location.replace('result.php?Search=".$id_num."')</script>";
         }

    }


    if(isset($_POST['remove'])){
        $removeProduct = $database->prepare("DELETE FROM orders WHERE id = :Id ");
        $getId = $_POST['remove'];
        $removeProduct->bindParam("Id",$getId);
        if($removeProduct->execute()){
           echo "<script>location.replace('result.php?Search=".$id_num."')</script>";
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