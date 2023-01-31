<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    include '../asset/includes/dbconect.php';
    include '../asset/includes/header.php';

    echo '
    <main style="width:100%;min-height: 495px; margin-top: 50px;" >
    <table class="table table-striped table-hover">
    <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Id Number</th>
      <th scope="col">Birth Day</th>
      <th scope="col">Start Work</th>
      <th scope="col">end Work</th>
      <th scope="col">Status</th>
      <th scope="col">Location</th>
    </tr>
  </thead>
  <tbody>
        
        ';
        if(isset($_GET['Search'])){
            $word = $_GET['Search'];
            $search = $database->prepare("SELECT * FROM Emp WHERE IDNUM LIKE :value");
            $res = "%".$word."%";
            $search->bindParam("value",$res);
            $search->execute();
            foreach($search AS $sh){
                echo '
                    <tr>
                    <th scope="row"><a href="edit-em.php?info='.$sh['ID'].'">'.$sh['Name'].'</a></th>
                    <td>'.$sh['IDNUM'].'</td>
                    <td>'.$sh['BirthDate'].'</td>
                    <td>'.$sh['StartJob'].'</td>
                    <td>'.$sh['EndJob'].'</td>
                    <td>'.$sh['AllStatus'].'</td>
                    <td>'.$sh['Location'].'</td>
                    </tr>
                ';
                $name= $sh['Name'];
                $id_number =$sh['IDNUM'];
            }
            echo '
            <tbody>
            </table>
            ';
            $services=$database->prepare("SELECT * FROM orders WHERE id_number=:id_number");
            $services->bindParam("id_number", $id_number);
            $services->execute();
                echo '
                <h2 style="display: flex;justify-content: center;padding: 25px 0;">Services</h2>
                <a href="add-se.php?info='.$id_number.'" style="float: right;margin: 10px 20px;" class="btn btn-primary">Add</a>
                <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Id Number</th>
                    <th scope="col">Service</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Ticket Number</th>
                    <th scope="col">Ticket Date</th>
                    <th scope="col">Note</th>
                    <th scope="col">Cost</th>
                </tr>
              </thead>
              <tbody>
                
                ';

            foreach($services AS $sh){
                $numS =$database->prepare("SELECT * FROM service WHERE id=:id");
                $numS->bindParam("id",$sh['id_service']);
                $numS->execute();
                $s= $numS->fetchObject();
                echo '
                <tr>
                    <th scope="row"><a href="edit-se.php?info='.$sh['id'].'">'.$name.'</a></th>
                    <td>'.$sh['id_number'].'</td>
                    <td>'.$s->	servicesName.'</td>
                    <td>'.$sh['create_date'].'</td>
                    <td>'.$sh['ticket_number'].'</td>
                    <td>'.$sh['create_date'].'</td>
                    <td>'.$sh['note'].'</td>
                    <td>'.$sh['cost'].'</td>
                </tr>
            ';
            }
            echo '
            <tbody>
            </table>
            ';
            echo '</main>';
        }



}
else{
    header("location:login.php");
}
if(isset($_POST['logout'])){
    session_destroy();
    header("location:login.php");
}
include '../asset/includes/footer.php';
?>