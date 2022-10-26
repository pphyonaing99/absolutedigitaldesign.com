<!DOCTYPE html>
<html>
<head>
	<title>Test Real Data Mail</title>
	<style type="text/css">
		table { 
			width: 750px; 
			border-collapse: collapse; 
			margin:50px auto;
			}

		/* Zebra striping */
		tr:nth-of-type(odd) { 
			background: #eee; 
			}

		th { 
			background: #3498db; 
			color: white; 
			font-weight: bold; 
			text-align: center;
			}

		td, th { 
			padding: 10px; 
			border: 1px solid #ccc; 
			text-align: center; 
			font-size: 18px;
			}

		p{
			color:blue;
			font-weight: bold; 
		}

		#date{
			color:blue;
			font-weight: bold; 
			
		}

		#indate{
			color:red;
			font-weight: bold; 
		}

		/* 
		Max width before this PARTICULAR table gets nasty
		This query will take effect for any screen smaller than 760px
		and also iPads specifically.
		*/
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {

			table { 
			  	width: 100%; 
			}

			/* Force table to not be like tables anymore */
			table, thead, tbody, th, td, tr { 
				display: block; 
			}
			
			/* Hide table headers (but not display: none;, for accessibility) */
			thead tr { 
				position: absolute;
				top: -9999px;
				left: -9999px;
			}
			
			tr { border: 1px solid #ccc; }
			
			td { 
				/* Behave  like a "row" */
				border: none;
				border-bottom: 1px solid #eee; 
				position: relative;
				padding-left: 50%; 
			}

			td:before { 
				/* Now like a table header */
				position: absolute;
				/* Top/left values mimic padding */
				top: 6px;
				left: 6px;
				width: 45%; 
				padding-right: 10px; 
				white-space: nowrap;
				/* Label the data */
				content: attr(data-column);

				color: #000;
				font-weight: bold;
			}

		}
	</style>
</head>
<body>
	<h1 style="text-align: center;font-weight: bold;">Dear {{ $supplier_name }},</h1>

	<h3 style="color: red;text-align: center;">{{ $body_text }}</h3>

	<h3 style="text-align:center"><b><i>We would like to Order this items</i> </b></h3>

	

	<div id="text">
		<table>
		  <thead>
		    <tr>
			    <th>#</th>
			    <th>Product Name</th>
				<th>Brand</th>
				
			    <th>Quantity</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php $i=1; ?>
		  	@if(json_decode($item_list) != null)
		  	@foreach($item_list as $list)
		    <tr>
			    <td>{{ $i++ }}</td>
			    <td data-column="First Name">{{ $list->product->name }}</td>
				<td data-column="First Name">{{ $list->product->brand->name }}</td>
			    <td data-column="Last Name">{{ $list->order_qty }}</td>
		    </tr>
		    @endforeach
		  	@endif
		  </tbody>
		</table>
		<p style="text-align:right"><span id="date">Please deliver the products by this date <span id="indate">{{ $req_date }}</span> before!!</span></p>
	</div>
</body>
</html>