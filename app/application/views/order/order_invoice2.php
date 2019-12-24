<!DOCTYPE html>
<html lang="en">

<head>
	<title>INVOICE</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
		.borderless td, .borderless tr {
    	border: none !important;
		}
	</style>
</head>

<body>
	<div style="width:90%;margin:auto">
		<h1 class="text-center">INVOICE</h1>
		<div class="table-responsive text-left">
			<table class="table borderless table-condensed" >
				<tbody>
					<tr>
						<td colspan="5">Vital Wellspring Education Pte. Ltd.<br></td>
					</tr>
					<tr>
						<td colspan="5">Regristration No: 201706222D<br></td>
					</tr>
					<tr>
						<td colspan="5">55 Market Street, #10-05<br></td>
					</tr>
					<tr>
						<td colspan="5">Singapore 048941<br></td>
					</tr>
					<tr>
						<td colspan="3">Phone: +65 93844842<br></td>
						<td colspan="2">Date:
							<?=date("d M Y",strtotime($dbdata['receipt_date']));?><br></td>
					</tr>
					<tr>
						<td colspan="3">natureFA@vital-wellspring.com<br></td>
						<td colspan="2">Invoice NO:
							<?=$dbdata['receipt_num'];?><br></td>
					</tr>
					<tr>
						<td colspan="5"><strong><span style="text-decoration: underline;">Ship To</span></strong></td>
					</tr>
					<tr>
						<td colspan="5">
							<?=$dbdata['name_buy']?><br></td>
					</tr>
					<tr>
						<td colspan="5">
							<?=$dbdata['country'];?>
							<?=$dbdata['county'];?>
							<?=$dbdata['area'];?>
							<?=$dbdata['address'];?>
							<br>
						</td>
					</tr>
					<tr>
						<td colspan="5"><strong><span style="text-decoration: underline;">Bill To</span></strong></td>
					</tr>
					<tr>
						<td colspan="5">
							<?=$dbdata['receipt_title'];?>
							&nbsp;
							<?=$dbdata['receipt_code'];?>
							<br>
						</td>
					</tr>
					<tr>
						<td colspan="5">
							<?=$dbdata['receipt_address'];?>
							<br>
						</td>
					</tr>
					<tr>
						<td colspan="5"></td>
					</tr>
					<tr style="border-top:3px black solid !important;border-bottom:3px black solid !important;">
						<th colspan="2">Description</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th>Amount</th>
					</tr>
					<?foreach ($oddata as $key => $value) {?>
					<tr>
						<td colspan="2">
							<?=$value['prd_name'];?><br></td>
						<td>
							<?=$value['number'];?>
						</td>
						<td>
							<?=$this->data['web_config']['currency'];?>
							<?=$value['price'];?>
						</td>
						<td>
							<?=$this->data['web_config']['currency'];?>
							<?=$value['total_price'];?><br></td>
					</tr>
					<?}?>
					<tr style="border-top:2px black solid  !important;">
						<td colspan="5"></td>
					</tr>
					<tr>
						<td>Subtotal (Inc. GST)</td>
						<td>
							<?=$this->data['web_config']['currency'];?>
							<?=$dbdata['pay_price'];?>
						</td>
						<td colspan="3"></td>
					</tr>
					<tr>
						<td>-Used bonus points</td>
						<td>
							<?=$this->data['web_config']['currency'];?>
							<?=$dbdata['use_dividend_cost'];?>
							(<?=$dbdata['use_dividend'];?>points)
						</td>
						<td colspan="3"></td>
					</tr>
					<tr>
						<td>-Used shopping money</td>
						<td>
							<?=$this->data['web_config']['currency'];?>
							<?=$dbdata['use_shopping_money'];?>
						</td>
						<td colspan="3"></td>
					</tr>
					<tr>
						<td>+shipping</td>
						<td>
							<?=$this->data['web_config']['currency'];?>
							<?=$dbdata['lway_price'];?>
						</td>
						<td colspan="3"></td>
					</tr>
					<tr>
						<td><strong>Total (Inc. GST)</strong></td>
						<td><strong>
								<?=$this->data['web_config']['currency'];?>
								<?=($dbdata['total_price']-($dbdata['use_dividend']/30));?></strong></td>
						<td colspan="3"></td>
					</tr>
					<tr>
						<td>GST(7%)</td>
						<td>
							<?=$this->data['web_config']['currency'];?>
							<?=(($dbdata['total_price']-($dbdata['use_dividend']/30))*0.07);?>
						</td>
						<td colspan="3"></td>
					</tr>
					<tr>
						<td colspan="5"></td>
					</tr>
					<tr>
						<td colspan="5">Returns are subject to Vital Wellspring Terms and Conditions.</td>
					</tr>
					<tr>
						<td colspan="5">Refer to <span style="text-decoration: underline;">www.naturefa.com</span> for the Returns and Refund Policy and more instructions.</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>

</html>
