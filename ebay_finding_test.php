<?php
ini_set('max_execution_time', 300);//5 minutes of execution
require_once('class.ebay.php');

$ebay = new ebay('TomLinge-452a-421b-bd32-289d2152277f', 'EBAY-US');
$sort_orders = $ebay->sortOrders();
?>

<form action="ebay_finding_test.php" method="post">
	<input type="text" name="search" id="search">
	<select name="sort" id="sort">
	<?php
	foreach($sort_orders as $key => $sort_order){
	?>
		<option value="<?php echo $key; ?>"><?php echo $sort_order; ?></option>
	<?php	
	}
	?>
	</select>
	<input type="submit" value="Search">
</form>

<?php
if(!empty($_POST['search']))
{
	$results = $ebay->findItemsAdvanced($_POST['search'], $_POST['sort']);
	$item_count = $results['findItemsAdvancedResponse'][0]['searchResult'][0]['@count'];
	
	echo "found ".$item_count." items";
    echo "Sorting by: ". $_POST['sort'];
	
	if($item_count > 0)
	{
		$items = $results['findItemsAdvancedResponse'][0]['searchResult'][0]['item'];

		foreach($items as $i)
		{
?>


		<li>
			<div class="item_title">
				<a href="<?php echo $i['viewItemURL'][0]; ?>"><?php echo $i['title'][0]; ?></a>
			</div>
			<div class="item_img">
				<img src="<?php echo $i['galleryURL'][0]; ?>" alt="<?php echo $i['title']; ?>">
			</div>
			<div class="item_price">
				<?php echo $i['sellingStatus'][0]['currentPrice'][0]['@currencyId']; ?>
				<?php echo $i['sellingStatus'][0]['currentPrice'][0]['__value__']; ?>
			</div>
			<div class="item_id">
				<?php
				$parts = explode('/', $i['viewItemURL'][0]);
				$id = trim(end($parts), '?');
				echo "Item ID: ".$id;
				
				echo "atau ini";
				echo "item id api".$i['itemId'][0];
				?>
			</div>
		</li>
<?php
		}//end for
	}//end if
}//end if
?>