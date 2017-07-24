<?php 
	session_start();
	$i = '';
?>
<?php
	if (isset($_POST['pid'])) {
		$pid = $_POST['pid'];
		$quantity = $_POST['qty'];
		$wasFound = false;
		$i = 0;
		//if cart session variable is not set or cart array is empty
		if (!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) < 1) {
			//what run if cart is empty or not set
			$_SESSION['cart_array'] = array(1 => array('item_id' => $pid, 'quantity' => $quantity ));
		} 
		else {
		// RUN IF THE CART HAS AT LEAST ONE ITEM IN IT
		foreach ($_SESSION['cart_array'] as $each_item) { 
		      $i++;
		      while (list($key, $value) = each($each_item)) {
				  if ($key == 'item_id' && $value == $pid) {
					  // That item is in cart already so let's adjust its quantity using array_splice()
					  array_splice($_SESSION['cart_array'], $i-1, 1, array(array('item_id' => $pid, 'quantity' => $each_item['quantity'] + $quantity)));
					  $wasFound = true;
				  } // close if condition
		      } // close while loop
	       } // close foreach loop
		   if ($wasFound == false) {
			   array_push($_SESSION['cart_array'], array('item_id' => $pid, 'quantity' => $quantity));
		   }
		}
		header("location: cart");
		exit();
	}

?>
<?php 
//       Section 3 (if user chooses to adjust item quantity)
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
    // execute some code
	$item_to_adjust = $_POST['item_to_adjust'];
	$quantity = $_POST['quantity'];
	$quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
	if ($quantity < 1) { $quantity = 1; }
	if ($quantity == "") { $quantity = 1; }
	$i = 0;
	foreach ($_SESSION["cart_array"] as $each_item) { 
		$i++;
		while (list($key, $value) = each($each_item)) {
			if ($key == "item_id" && $value == $item_to_adjust) {
			  // That item is in cart already so let's adjust its quantity using array_splice()
			  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
			} // close if condition
		} // close while loop
	} // close foreach loop
}
?>
<?php 
//       Section 4 (if user wants to remove an item from cart)
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
    // Access the array and run code to remove that array index
 	$key_to_remove = $_POST['index_to_remove'];
	if (count($_SESSION["cart_array"]) <= 1) {
		unset($_SESSION["cart_array"]);
	} else {
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION["cart_array"]);
	}
}
?> 
<?php
// if useer choses to empty his/her shopping cart
	if (isset($_GET['cmd']) && $_GET['cmd'] == 'emptycart') {
		unset($_SESSION['cart_array']);
	}

?>

<?php
	//render the cart for the user to view
	$cartOutput = '';
	$cartTotal = '';
	$cartTotalM = '';
	$product_qty_array = '';
	$product_id_array = '';
	$quantity_array = '';
	if (!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) < 1) {
		$cartvide = '<h2 align="center" style="padding-bottom: 200px;">your shopping cart is empty!!<br>
		 <a href="index" style="color: green;  font-size: 60%; text-decoration: underline">Go to Shop Now</a></h2>';
	}
	else{
		$i=0;
		foreach ($_SESSION['cart_array'] as $each_item) {
			$i++;
			$item_id = $each_item['item_id'];
			include("db.php");
			$sql = $con ->query("SELECT * FROM products WHERE id = '$item_id' LIMIT 1");
			while ($row = mysqli_fetch_array($sql)) {
				$ItemName = $row['Name'];
				$ItemId = $row['id'];
				$ItemMPrice = $row['price_member'];
				$ItemNMPrice = $row['price_non_member'];
				$itemPic = $row['pic'];
				//$details = $row['details'];
				$product_qty_array .= "$ItemName ".$each_item['quantity']."/";
			}
			$totalItemMPrice = $ItemMPrice * $each_item['quantity'];
			$totalItemNMPrice = $ItemNMPrice * $each_item['quantity'];
			$cartTotalM = $totalItemMPrice + $cartTotalM;
			$cartTotal = $totalItemNMPrice + $cartTotal;
			// Create the product array variable
			$product_id_array .= "".$each_item['item_id'].",";
			$quantity_array .= "".$each_item['quantity'].",";  
			$cartOutput.='
					<tbody>
						<tr>
							<td>'.$i.'</td>
							<td>'.$ItemName.'<br><img src="img/pro/'.$itemPic.'" width="50px"></td>
							<td>
								<form action="cart" method="post">
									<input name="quantity" type="text" value="' . $each_item['quantity'] . '" size="2" maxlength="4" />
									<input class="btn btn-success btn btn-xs" name="adjustBtn' . $item_id . '" type="submit" value="Update" />
									<input name="item_to_adjust" type="hidden" value="' . $item_id . '" />
								</form>
							</td>
							<td>Frw '.number_format($ItemMPrice).'</td>
							<td>Frw '.number_format($ItemNMPrice).'</td>
							<td>Frw '.number_format($totalItemMPrice).'</td>
							<td>Frw '.number_format($totalItemNMPrice).'</td>
							<td>
								<form action="cart" method="post">
									<button class="btn btn-danger btn-xs" name="deleteBtn' . $item_id . '" type="submit"> <i class="fa fa-trash-o text-success"></i></button>
									<input name="index_to_remove" type="hidden" value="' . $i . '" />
								</form>
							</td>
						</tr>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</tbody>';
		}
	}

?>