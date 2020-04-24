<?PHP
session_start();

include "Database.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	
	$obj = json_decode($_POST['cart']);
	echo "<PRE>";
	print_r($obj);die;
	
	echo $obj[1]->description;
	die;
	

	foreach($obj as $o){
		echo "<div style='margin-bottom:.2em;background:lightblue;font-size:1.4em;'>" . $o->qty . " " . $o->description . "@" . $o->price . "</div>";
	}
}

if(!$_COOKIE['user_id']){
	header('Location: index.html');
}

$db = new Database();

$sql="SELECT * from user where user_id = '$_COOKIE[user_id]'";
$db->query($sql);
$user = $db->single();

$sql="SELECT * from product ORDER BY product_name";
$db->query($sql);
$items = $db->resultSet();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Sale</title>
    <link rel="stylesheet" href="product.css">
    <link rel="stylesheet" href="sidebar.css">
</head>

<body>
<style>
#forSaleProductsTbl{
	width:70%;
	margin:auto;
}

#forSaleProductsTbl  th td tr{
	padding:1em !important;
}
.clickable{
    cursor: pointer;
    padding: 5px;
    color: blue;	
}
</style>
    <div id="sidebar">
        <div class="toggle-btn" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="side-ul">
            <li class="side-li"><a class="side" href="sale_menu.php">Dashboard</a></li>
            <li class="side-li"><a class="side" href="saleList.php">List All Sales</a></li>
			<li class="side-li"><a class="side" href="saleUpdate.php">Update Sale</a></li>
			<li class="side-li"><a class="side" href="saleReport.php">Report Sale</a></li>
            <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
            
        </ul>
    </div>

  <!-- <header id="imgcontainer"></header>-->

    <div id="container" style='margin-bottom:6em;text-align:center;'>
		<h1> INPUT NEW SALE</h1>
			<table id="forSaleProductsTbl">
				<thead>
					<th>Select Product</th>
					<th>Quantity</th>
					<th>Price</th>
					<th></th>
				</thead>
				<tbody>
					<tr>
						<td>
							<select id="productList" style="width:300px;">
								<option selected>--Select Item--</option>
								<?PHP 
									foreach($items as $item){
										echo "<option value='$item->product_id|$item->product_price'>$item->product_name</option>";
									}							
								?>
							</select>
						</td>
						<td><input type="text" size=10 id="qty"><input type="hidden" id="pid"></td>
						<td><span id="priceField"></span></td>
						<td><button onclick="addToCart()" style="background:yellowgreen;color:green;">Add to cart</button></td>
					</tr>
				</tbody>
			</table>
			<div id="tblContainer" style="margin-top:3em;margin-bottom:3em;">
				
				<table id="cartTbl" style="width: 80%;margin: auto;">
				</table>
				<form method="POST" action="saleScript.php">
					<input type="hidden" name="cart">
					<button style="background:greenyellow;" onclick="checkout(event);">Checkout</button>
				</form>
			</div>
    </div>

        

    <script src="sidebar.js"></script>
	<script>
		var cart = [];
		
		document.getElementById('productList').addEventListener('change',function(event){
			var i = event.target.options.selectedIndex;
			var pid = event.target.options[i].value.split('|')[0];
			var price = event.target.options[i].value.split('|')[1];
			document.getElementById('pid').innerText =  pid;
			document.getElementById('priceField').innerText =  price;
		});
		
		function addToCart(){
			var pid = document.getElementById('pid');
			var price = document.getElementById('priceField');
			var qty = document.getElementById('qty');
			var description = document.getElementById('productList');
			
			if(qty.value == '' || isNaN(qty.value) || qty.value <= 0){
				alert('Please enter a valid quantity before adding to cart!!');
				return;
			}
			
			description = description.options[description.options.selectedIndex].innerText;
					
			var obj = {"pid":pid.innerText*1,"description":description,"qty":qty.value*1,"price":price.innerText*1};
			cart.push(obj);
			renderCart();
		}
		
		function renderCart(){
			var pid = document.getElementById('pid');
			var price = document.getElementById('priceField');
			var qty = document.getElementById('qty');
			var description = document.getElementById('productList');
			
			var cartTotal = 0;
			var t = document.getElementById('cartTbl');
			t.innerHTML='';

			if(cart.length == 0){
				t.innerHTML = '';
				return;
			}
			
			for(var x=0; x < cart.length; x++){
				cartTotal+= cart[x].qty * cart[x].price;
				
				var row = t.insertRow(x);
				
				row.insertCell(0).innerText = cart[x].description;
				row.insertCell(1).innerText = cart[x].qty;
				row.insertCell(2).innerText = formatNum(cart[x].price * cart[x].qty,2);
				row.insertCell(3).innerHTML = '<span class="clickable" onclick="removeItem(' + x + ')" >Remove</span>';

			}
			t.innerHTML+="<tr><td></td><td><b>Total:</b></td><td style='text-align:right;'>$"+formatNum(cartTotal,2)+"</td><td></td></tr>";
			cart['total'] = cartTotal;
			qty.value = '';
			price.innerHTML = '';
			document.getElementById('productList').selectedIndex = 0;
		}
		function removeItem(x){
			cart.splice(x,1);
			renderCart();
		}
		function checkout(event){
			event.preventDefault();
			var x = JSON.stringify(cart);
			document.forms[0].elements['cart'].value = x;
			document.forms[0].submit();
		}
		function formatNum(num,digits) {
                num=num*1;
			return num.toFixed(digits).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
		}
	</script>
</body>

</html>




