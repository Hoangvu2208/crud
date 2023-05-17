<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include 'database.php';
(isset($_GET["limit"])) ? $limit = $_GET["limit"] : $limit = 3;
if (isset($_GET["page"])) {$page = $_GET["page"];} else { $page = 1;}
;
$start_from = ($page - 1) * $limit;

$query = "SELECT * FROM member ORDER BY id DESC LIMIT $start_from, $limit";
$stmt = $conn->prepare($query);
$stmt->execute();
$memberList = $stmt->fetchAll();
?>
<?php

$html = '<table class="table table-bordered table-striped">
<thead>
    <tr>
      <th >No</th>
      <th >User Name</th>
      <th>Email</th>
      <th>Action</th>

    </tr>
  </thead>
<tbody>  ';

foreach ($memberList as $member) {

    # code...
    $html .= '
    <tr>
    <td>' . $member['id'] . '</td>
    <td>' . $member['username'] . '</td>
    <td>' . $member['email'] . '</td>
    <td id="userAction">

            <button class="btn btn-primary" onClick="edit(' . $member['id'] . ')" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
            <button class="btn btn-danger" onClick="del(' . $member['id'] . ')">delete</button></td>
    </tr>

    ';
}

$html .= '</tbody>
</table>';

echo $html;

