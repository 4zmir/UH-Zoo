<?PHP
session_start();

include "Database.php";


$db = new Database();

$sql = "SELECT * from user where user_id = '$_COOKIE[user_id]' ";
$db->query($sql);
$user = $db->single();

if (!$_COOKIE['user_id']) {
    header('Location: index.html');
}
if ($_COOKIE['user_id']) {

    $sql = "SELECT member.member_fname, member.member_expire, member.member_start, member.member_lname, member.member_fsize, u.user_fname, u.user_lname 
	FROM member 
	LEFT JOIN `user`as u ON u.user_id = member.user_id
	order by member_lname";

    $db->query($sql);
    $result = $db->resultSet();
    //$rowNum = $db->rowCount();
    // echo "<pre>";
    // echo print_r($result);die;



}
function formatDate($dayTime){
	 $arr = explode(' ', $dayTime);
	 $d = new DateTime($arr[0]);
	 return $d->format('M d, Y');
 }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="product.css">
    <title>Member List</title>
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
            <li class="side-li"><a class="side" href="memberReport.php">Member Reports</a></li>
            <li class="side-li"><a class="side" href="logoutScript.php">Log Out</a></li>
        </ul>
    </div>

    <!--- <header id="imgcontainer"></header> -->

    <div id="container" style='margin-bottom:6em;text-align:center;'>
        <h1>List of All Members</h1>
        <table class="table-info" style="width:80%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
            <thead style="color:white;background:rgb(90, 156, 90);">
                <tr>
                    <th> #</th>
                    <th>Last Name</th>
                    <th>First Name </th>
                    <th>Family size </th>
                    <th>Who Added </th>
					<th>Start Day </th>
					<th>End Day </th>
                </tr>
            </thead>

            <tbody>
                <?PHP
                $num = 1;
                foreach ($result as $item) {
					$ftdateSt = formatDate($item->member_start);
					$ftdateEnd = formatDate($item->member_expire);
                    $shade = ($num % 2) ? 'style="background:#deffdc;"' : '';
                    echo "<tr $shade>
                                <td>$num</td>
                                <td>$item->member_lname</td>
								<td>$item->member_fname</td>
                                <td>$item->member_fsize</td>
								<td>$item->user_fname $item->user_lname</td>
								<td>$ftdateSt</td>
								<td>$ftdateEnd</td>
							</tr>";
                    $num++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="sidebar.js"></script>

</body>

</html>