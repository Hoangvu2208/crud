<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include 'database.php';
$limit = 4;
$query = "SELECT count(id) from member";
$stmt = $conn->prepare($query);
$stmt->execute();
$row = $stmt->fetchAll();

//var_dump($row[0][0]);
$total_records = $row[0][0];
$total_pages = ceil($total_records / $limit);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
    <h2>user List</h2>
    <p style="background-color:<?php if (isset($_SESSION['status'])) {echo ($_SESSION['status'] == 'success') ? 'green' : 'red';}?>  ;"><?php echo (isset($_SESSION['msg'])) ? $_SESSION['msg'] : ''; ?></p>



<button type="button" class="btn btn-primary" onclick="changeTitle('Add user')" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Add
</button>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
        <button type="button" class="btn-close btn btn-danger" data-bs-dismiss="modal" aria-label="Close"> x</button>
      </div>
      <div class="modal-body">
      <form id="form-container"  method="POST" >
        <input type="hidden" name="id" id="edit_id" value()>
    <div class="form-group">
    <label for="exampleInputEmail1">User name</label>
    <input type="text" name="username" id="username" value="<?php  echo (!empty($_SESSION['username'])) ? $_SESSION['username'] :''?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
    </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" name="email" id="email" value="" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">

  </div>
  <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
      
    </div>
  </div>
</div>

<div id="table-data">


</div>

<nav aria-label="Page navigation example">
  <ul class="pagination">

    <?php
for ($i = 1; $i <= $total_pages; $i++) {
    echo ' <li class="page-item"><button class="page-link" onclick="page('.$i.')">' . $i . '</button></li>';
    # code...
}

?>
  </ul>
</nav>
<form action="" id="changeLimit">
<select id="limit" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
  <option selected>chon so record</option>
  <?php 
  for ($i= 5; $i < 20 ; $i+=5) {
    echo '  <option value="'.$i.'">'.$i.'</option>';
    # code.....
  }
    
  
  
  ?>
</select>
<button type="submit" class="btn btn-primary">Choose</button>
</form>




<div id="msg">

</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
<script>

$(document).on('submit','#changeLimit',function(e){
      e.preventDefault();

      limit = $('#limit').val();

      $.ajax({
       url : "pagination.php",
       type:'get',
       data:{
        limit:limit
       },
       success: function (result){
        $('#table-data').html(result)
       }
      });
    });


  function changeTitle($title){
    $('#exampleModalLabel').html($title);
  }
//delete
    function del(id){
        if (confirm("ban co muon xoa?")){
          $.ajax({
            url:'delete.php',
            type:('get'),
            data:{
               deleteId:id
            },
            success: function(result){
                $('#data').html(result);
                location.reload();

            }
        });
        }
    }

//add
    $(document).on('submit','#form-container',function(e){
        e.preventDefault();

         if ($('#edit_id').val() == ''){
          $.ajax({
              type:"POST",
              url: "add.php",
              data:$(this).serialize(),
              success: function(data){
                $('#msg').html(data);
               //alert("them thanh cong!");
               $.ajax({
                url:'pagination.php',
                type:'get',
                data:{
                    page:1
                },
                success:function (result) {
                    $('#table-data').html(result);
                    $('#exampleModal').modal('hide');
                }
            })
              
              }});
         }else{

          $.ajax({
          type:"POST",
          url: "edit.php",
          data:$(this).serialize(),
          success: function(data){
          $('#msg').html(data);
           alert("sua thanh cong!");
          location.reload();
         }});
         }

});

// edit

function edit(id){
  $('#exampleModalLabel').html('Edit User');
  $.ajax({
            url:'edit.php',
            type:('get'),
            data:{
               editId:id
            },
            success: function(result){
                result = JSON.parse(result);
                //$('#msg').html(result);
                $('#edit_id').val(result.id);
               $('#username').val(result.username);
               $('#email').val(result.email);
                 //location.reload();

//                  $(document).on('submit','#form-container',function(e){
//         e.preventDefault();


// });
            }

});
}

//pagination

$(window).load( $.ajax({
                url:'pagination.php',
                type:'get',
                data:{
                    page:1
                },
                success:function (result) {
                    $('#table-data').html(result); 
                }
            }));

    function page (page) {
            $.ajax({
                url:'pagination.php',
                type:'get',
                data:{
                    page:page
                },
                success:function (result) {
                    $('#table-data').html(result); 
                }
    });
    }
    
    
    
    //change limit #




</script>
    </div>
</body>
</html>