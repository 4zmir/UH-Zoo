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

$sql = "SELECT * from product where product_type_id = '3'";
$db->query($sql);
$items = $db->resultSet();

function formatDate($dayTime)
{
  $arr = explode(' ', $dayTime);
  $d = new DateTime($arr[0]);
  return $d->format('M d, Y');
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $startday = $_POST['startday'] . " 00:00:00";
  $endday = $_POST['endday'] . " 23:59:59";

  $sql = "SELECT 
          member.member_fname,
          member.member_lname,
          member.member_fsize,
          member.member_start,
          u.user_fname,
          u.user_lname
          FROM member
          LEFT JOIN user AS u ON u.user_id = member.user_id
          WHERE member.member_start >= '$startday' AND member.member_start <= '$endday'
          ORDER BY member.member_start";
  $db->query($sql);
  $result = $db->resultSet();

  $sql = "SELECT COUNT(member.member_id) AS 'units',
          member.member_id 
          FROM member 
          WHERE member.member_start >= '$startday' AND member.member_start <= '$endday'
          GROUP BY member.member_id";
  $db->query($sql);
  $countt = $db->resultSet();
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
      <li class="side-li"><a class="side" href="memberUpdate.php">Update Member</a></li>
      <li class="side-li"><a class="side" href="memberList.php">List All Members</a></li>
      <li class="side-li"><a class="side" href="logoutScript.php">Log out</a></li>
    </ul>
  </div>

  <!--<header id="imgcontainer"></header>-->
  <script src="sidebar.js"></script>

</body>
<form method="post">

  <div id="container" style='margin-bottom:6em;text-align:center;'>
    <h1>Search Members By Date Added</h1>
    <label>Start day</label><br>
    <input type="date" name="startday" style="width:300px;" value="<?= (isset($startday)) ? explode(' ', $startday)[0] : '' ?>" required><br>


    <label>End day</label><br>
    <input type="date" name="endday" style="width:300px;" value="<?= (isset($endday)) ? explode(' ', $endday)[0] : '' ?>" required><br>

    <button class="button" type="submit">Submit</button>
  </div>
</form>

<!---->
<?PHP if ($_SERVER['REQUEST_METHOD'] == "POST") { ?>
  <div id="container" style='margin-bottom:6em;text-align:center;'>
    <table class="table-info" style="width:65%;margin:auto;box-shadow: 2px 2px 12px #b6bab5;">
      <thead style="color:white;background:rgb(90, 156, 90);">
        <tr>
          <th></th>
          <th>#</th>
          <th>Member Last Name</th>
          <th>Member First Name</th>
          <th>Family Size</th>
          <th>Who Added</th>
          <th>When Added</th>
        </tr>
      </thead>

      <tbody>
        <?PHP
        $num = 1;
        foreach ($result as $cnt) {
          $ftdate = formatDate($cnt->member_start);
          $shade = ($num % 2) ? 'style="background:#deffdc;"' : '';
          echo "<tr $shade>
                    <td></td>
                    <td>$num</td>
                    <td>$cnt->member_lname</td>
                    <td>$cnt->member_fname</td>
                    <td>$cnt->member_fsize</td>
                    <td>$cnt->user_fname $cnt->user_lname</td>
                    <td>$ftdate</td>

                  </tr>";
          $num++;
        } ?>
      </tbody>

      <?PHP
      $ttt = 0;
      foreach ($countt as $cnt) {
        $ttt++;
      }
      ?>

      <tfoot style="background:#b4edc3">
        <tr>
          <td></td>
          <td><b>Total:<b></td>
          <td><b><?PHP echo "$ttt Member(s) added";  ?><b></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        </b>
      </tfoot>
    </table>
  </div>
<?PHP } ?>
<!---->
</html>