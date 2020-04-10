<?PHP
session_start();

include "Database.php";


if (!$_COOKIE['user_id']) {
  header('Location: index.html');
}

$db = new Database();

$sql = "SELECT * from user where user_id = '$_COOKIE[user_id]'";
$db->query($sql);
$user = $db->single();

//search for member:
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $svar = $_POST['svar'];
  $sql = "
	SELECT member.member_id, member.member_fname, member.member_lname, member.member_fsize, u.user_fname, u.user_lname, member.member_start
	FROM member
	LEFT JOIN user as u ON u.user_id = member.user_id
     WHERE member.member_fname LIKE '%$svar%'
     OR member.member_id LIKE '%$svar%'
	 OR member.member_lname LIKE '%$svar%'
	 OR u.user_fname LIKE '%$svar%' 
     OR u.user_lname LIKE '%$svar%' 
     ORDER BY member_fname";


  $db->query($sql);
  $result = $db->resultSet();
  $rowNum = $db->rowCount();
  // echo "<pre>";
  // echo print_r($result);die;

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reports</title>
  <link rel="stylesheet" href="product.css">
  <link rel="stylesheet" href="sidebar.css">
</head>

<body>

  <div id="sidebar">
    <div class="toggle-btn" onclick="toggleSidebar()">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
    <ul class="side-ul">
      <li class="side-li"><a class="side" href="member_menu.php">Dashboard</a></li>
      <li class="side-li"><a class="side" href="memberInput.php">Add New Member</a></li>
      <li class="side-li"><a class="side" href="memberList.php">List All Members</a></li>
      <li class="side-li"><a class="side" href="logoutScript.php">Log out</a></li>
    </ul>
  </div>

  <header id="imgcontainer"></header>
  <script src="sidebar.js"></script>

</body>
<form method="post">

  <div id="container" style='margin-bottom:6em;text-align:center;'>
    <h1> Search for a member</h1>

    <input type="text" placeholder="Enter a word" name="svar" required><br>

    <button class="button" type="submit">Submit</button>
  </div>
</form>

<?PHP if ($_SERVER['REQUEST_METHOD'] == "POST") { ?>

  <div id="container" style='margin-bottom:6em;text-align:center;'>
    <table class="table-info" style="width:80%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
      <thead style="color:white;background:rgb(90, 156, 90);">
        <tr>
          <th>#</th>
          <th>Member Last Name</th>
          <th>Member First Name</th>
          <th>Family Size</th>
          <th>Who Added</th>
          <th>When Added</th>
          <th></th>
          <th></th </tr> </thead> <tbody>
          <?PHP
          $num = 1;
          foreach ($result as $item) {
            $shade = ($num % 2) ? 'style="background:#deffdc;"' : '';
            echo "<tr $shade>
                            <td>$num</td>
                            <td>$item->member_lname</td>
                            <td>$item->member_fname</td>
                            <td>$item->member_fsize</td>
                            <td>$item->user_fname $item->user_lname</td>
                            <td>$item->member_start</td>
							<td><a href='memberDelete.php?id=$item->member_id' >Delete</a></td>
							<td><a href='memberUpdtForm.php?id=$item->member_id'>Update</a></td>
						</tr>";
            $num++;
          }
          ?>
          </tbody>
    </table>
  </div>

<?PHP } ?>


</html>