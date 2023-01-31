<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    include '../asset/includes/header.php';
    include '../asset/includes/dbconect.php';
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
        $resultsPerPage = 100;
        $request=$database->prepare("SELECT * FROM Emp");
        $request->execute();
        $numberOfResults = $request->rowCount();
        if(!isset($_GET['page'])){
            $page = 1;
            }
        else if(isset($_GET['page'])){
        $page = $_GET['page'];
        }
        $totalPages = ceil($numberOfResults / $resultsPerPage) ;

        $results = $database->prepare("SELECT * FROM Emp LIMIT " . $resultsPerPage . " OFFSET " . ($page-1)*$resultsPerPage);
        $results->execute();
        foreach($results AS $sh){
        
            echo '
                <tr>
                    <th scope="row"><a href="result.php?Search='.$sh['IDNUM'].'">'.$sh['Name'].'</a></th>
                    <td>'.$sh['IDNUM'].'</td>
                    <td>'.$sh['BirthDate'].'</td>
                    <td>'.$sh['StartJob'].'</td>
                    <td>'.$sh['EndJob'].'</td>
                    <td>'.$sh['AllStatus'].'</td>
                    <td>'.$sh['Location'].'</td>

                </tr>
            ';
        }
        echo '    
        <tbody>
        </table>
        ';

        for($count = 1; $count<= $totalPages; ++$count){
            if($page == $count){
                echo '<a style="color:black;" href="index.php?page='.$count.'">'.$count.'</a> ';
            }else{
                echo '<a  href="index.php?page='.$count.'">'.$count.'</a> ';
            }
        
        }   
        echo '</main>';






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