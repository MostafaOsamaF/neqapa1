<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    include '../asset/includes/dbconect.php';
    include '../asset/includes/header.php';

    if(isset($_GET['info'])){
        $request =$database->prepare("SELECT * FROM Emp WHERE IDNUM=:id");
        $request->bindParam("id",$_GET['info']);
        $request->execute();
        $user= $request->fetchObject();

        $req=$database->prepare("SELECT * FROM orders WHERE id_number =:idn");
        $req->bindParam("idn",$_GET['info']);
        $req->execute();
        echo '<main style="width: 80%; margin: auto; padding: 50px;">
        <form method="POST"> 
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">ID Number</label>
            <div class="col-sm-10">
            <input type="number" name="id-number" value="'.$user->IDNUM.'" class="form-control" id="inputPassword" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
            <input type="text" name="name" value="'.$user->Name.'" class="form-control" id="inputPassword" required>
            </div>
        </div>';

        echo'
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
            <label for="inputPassword" class="col-sm-2 col-form-label">Cost</label>
            <div class="col-sm-10">
            <input type="number" name="cost" class="form-control" id="inputPassword" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label" required>Ticket Number</label>
            <div class="col-sm-10">
            <input type="number" name="tnumber" class="form-control" id="inputPassword" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Date Ticket</label>
            <div class="col-sm-10">
            <input type="date" name="tdate" class="form-control" id="inputPassword" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Note</label>
            <div class="col-sm-10">
            <input type="text" name="note" class="form-control" id="inputPassword" required>
            </div>
        </div>
          <button style="float:right;" name="add-se" type="submit" class="btn btn-success">Add</button>
    </form>
    </main>';

    if(isset($_POST['add-se'])){

        $idname= $_POST['id-number'];
        $name= $_POST['name'];
        $tyser= $_POST['service'];
        $cost= $_POST['cost'];
        $tknum= $_POST['tnumber'];
        $tkdate= $_POST['tdate'];
        $note= $_POST['note'];
        $crdate= date("Y-m-d");
        $insert=$database->prepare("INSERT INTO orders(id_number,id_service,ticket_number,ticket_date,create_date,note,cost)
         VALUES(:idname,:service,:tknum,:tkdate,:crdate,:note,:cost)");

        $insert->bindParam("idname",$idname);
        $insert->bindParam("service",$tyser);
        $insert->bindParam("tknum",$tknum);
        $insert->bindParam("tkdate",$tkdate);
        $insert->bindParam("crdate",$crdate);
        $insert->bindParam("note",$note);
        $insert->bindParam("cost",$cost);
        $insert->execute();
        echo "<script>location.replace('result.php?Search=".$idname."')</script>";
    }
    }else{
        echo'
        <main style="width: 80%; margin: auto; padding: 50px;">
        <form method="POST"> 
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">ID Number</label>
            <div class="col-sm-10">
            <input type="number" name="id-number" class="form-control" id="inputPassword">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
            <input type="text" name="name"class="form-control" id="inputPassword">
            </div>
        </div>';
        echo'   
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Cost</label>
            <div class="col-sm-10">
            <input type="number" name="cost" class="form-control" id="inputPassword">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Ticket Number</label>
            <div class="col-sm-10">
            <input type="number" name="tnumber" class="form-control" id="inputPassword">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Date Ticket</label>
            <div class="col-sm-10">
            <input type="date" name="tdate" class="form-control" id="inputPassword">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Note</label>
            <div class="col-sm-10">
            <input type="text" name="note" class="form-control" id="inputPassword">
            </div>
        </div>
          <button style="float:right;" name="add-se" type="submit" class="btn btn-success">Add</button>
    </form>
    </main>';

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