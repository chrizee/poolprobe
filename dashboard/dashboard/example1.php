<?php
/**
 * DashboardBuilder
 *
 * @author Diginix Technologies www.diginixtech.com
 * Support <support@dashboardbuider.net> - https://www.dashboardbuilder.net
 * @copyright (C) 2018 Dashboardbuilder.net
 * @version 2.1.5
 * @license: license.txt
 */

include("inc/dashboard_dist.php");  // copy this file to inc folder 


// for chart #1
$data = new dashboardbuilder(); 
$data->type =  "kpi";

$data->source =  "Database"; 
$data->rdbms =  "sqlite"; 
$data->servername =  "";
$data->username =  "administrator";
$data->password =  "admin01";
$data->dbname =  "data\Northwind.db";
$data->xaxisSQL[0]=  "SELECT printf(^$%d^, avg(UnitPrice*Quantity)) as amount FROM [Order Details];";
$data->xaxisCol[0]=  "amount";

$data->name = "7";
$data->title = "Average Product Price";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "true";
$data->showline = "true";
$data->height = "68";
$data->width = "";
$data->col = "0";
$data->tracename[0]=  "Last 100 Subscriptions";

$result[0] = $data->result();

// for chart #2
$data = new dashboardbuilder(); 
$data->type =  "kpi";

$data->source =  "Database"; 
$data->rdbms =  "sqlite"; 
$data->servername =  "";
$data->username =  "administrator";
$data->password =  "admin01";
$data->dbname =  "data\Northwind.db";
$data->xaxisSQL[0]=  "SELECT sum(UnitsOnOrder) as unitorder FROM Products";
$data->xaxisCol[0]=  "unitorder";

$data->name = "7";
$data->title = "Units Order";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "";
$data->showline = "";
$data->height = "68";
$data->width = "";
$data->col = "1";
$data->tracename[0]=  "Number of Order Last month  <span style='color:green;'>▲</span>";

$result[1] = $data->result();

// for chart #3
$data = new dashboardbuilder(); 
$data->type =  "kpi";

$data->source =  "Database"; 
$data->rdbms =  "sqlite"; 
$data->servername =  "";
$data->username =  "administrator";
$data->password =  "admin01";
$data->dbname =  "data\Northwind.db";
$data->xaxisSQL[0]=  "SELECT printf(^%d%^, avg(UnitPrice)) as amount FROM [Order Details]";
$data->xaxisCol[0]=  "amount";

$data->name = "8";
$data->title = "Average Sales";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "";
$data->showline = "";
$data->height = "68";
$data->width = "";
$data->col = "2";
$data->tracename[0]=  "Averge Profit Previous Month <span style='color:red;'>▼</span>";

$result[2] = $data->result();

// for chart #4
$data = new dashboardbuilder(); 
$data->type =  "kpi";

$data->source =  "Database"; 
$data->rdbms =  "sqlite"; 
$data->servername =  "";
$data->username =  "administrator";
$data->password =  "admin01";
$data->dbname =  "data\Northwind.db";
$data->xaxisSQL[0]=  "SELECT printf(^%0.2f^,avg(UnitsOnOrder*5)) as unitorder FROM Products";
$data->xaxisCol[0]=  "unitorder";

$data->name = "9";
$data->title = "Visitors";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "";
$data->showline = "";
$data->height = "67";
$data->width = "";
$data->col = "3";
$data->tracename[0]=  "Average Users visited per day";

$result[3] = $data->result();

// for chart #5
$data = new dashboardbuilder(); 
$data->type =  "area";

$data->source =  "Database"; 
$data->rdbms =  "sqlite"; 
$data->servername =  "";
$data->username =  "administrator";
$data->password =  "admin01";
$data->dbname =  "data\Northwind.db";
$data->xaxisSQL[0]=  "SELECT strftime(^%Y-%m^,o.shippeddate) as xaxis, sum(d.quantity) as yaxis from `Order Details` d, orders o where o.orderid = d.orderid group by strftime(^%Y-%m^,o.orderdate) limit 50";
$data->xaxisCol[0]=  "xaxis";
$data->xaxisSQL[1]=  "SELECT strftime('%Y-%m',o.shippeddate) as xaxis, sum(d.quantity) as yaxis from `Order Details` d, orders o where o.orderid = d.orderid group by strftime('%Y-%m',o.orderdate) limit 50";
$data->xaxisCol[1]=  "xaxis";
$data->yaxisSQL[0]=  "SELECT strftime(^%Y-%m^,o.shippeddate) as xaxis, sum(d.quantity) as yaxis from `Order Details` d, orders o where o.orderid = d.orderid group by strftime(^%Y-%m^,o.orderdate) limit 50";
$data->yaxisCol[0]=  "yaxis";
$data->yaxisSQL[1]=  "SELECT strftime(^%Y-%m^,o.shippeddate) as xaxis, sum(d.quantity) as yaxis, sum(d.UnitPrice) as yaxis2 from `Order Details` d, orders o where o.orderid = d.orderid group by strftime(^%Y-%m^,o.orderdate) limit 50";
$data->yaxisCol[1]=  "yaxis2";

$data->name = "0";
$data->title = "Price vs Quantity";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "";
$data->showline = "";
$data->height = "199";
$data->width = "";
$data->col = "4";
$data->tracename[0]=  "Sales Price";
$data->tracename[1]=  "Quantity";

$result[4] = $data->result();

// for chart #6
$data = new dashboardbuilder(); 
$data->type =  "stack";

$data->source =  "Database"; 
$data->rdbms =  "sqlite"; 
$data->servername =  "";
$data->username =  "administrator";
$data->password =  "admin01";
$data->dbname =  "data\Northwind.db";
$data->xaxisSQL[0]=  "select c.categoryname, sum(a.quantity) as ^Sales 1997^, sum(a.quantity)+1000 as ^Sales 1998^ from products b, `Order Details` a, categories c where a.productid = b.productid and c.categoryid = b.categoryid group by c.categoryid order by c.categoryid";
$data->xaxisCol[0]=  "Sales 1997";
$data->xaxisSQL[1]=  "select c.categoryname, sum(a.quantity) as ^Sales 1997^, sum(a.quantity)+1000 as ^Sales 1998^ from products b, `Order Details` a, categories c where a.productid = b.productid and c.categoryid = b.categoryid group by c.categoryid order by c.categoryid";
$data->xaxisCol[1]=  "Sales 1998";
$data->yaxisSQL[0]=  "select c.categoryname, sum(a.quantity) as ^Sales 1997^, sum(a.quantity)+1000 as ^Sales 1998^ from products b, `Order Details` a, categories c where a.productid = b.productid and c.categoryid = b.categoryid group by c.categoryid order by c.categoryid";
$data->yaxisCol[0]=  "CategoryName";
$data->yaxisSQL[1]=  "select c.categoryname, sum(a.quantity) as ^Sales 1997^, sum(a.quantity)+1000 as ^Sales 1998^ from products b, `Order Details` a, categories c where a.productid = b.productid and c.categoryid = b.categoryid group by c.categoryid order by c.categoryid";
$data->yaxisCol[1]=  "CategoryName";

$data->name = "1";
$data->title = "";
$data->orientation = "h";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "true";
$data->showline = "true";
$data->height = "201";
$data->width = "";
$data->col = "5";
$data->tracename[0]=  "Sales 1997";
$data->tracename[1]=  "Sales 1998";

$result[5] = $data->result();

// for chart #7
$data = new dashboardbuilder(); 
$data->type =  "donut";

$data->source =  "Database"; 
$data->rdbms =  "sqlite"; 
$data->servername =  "";
$data->username =  "administrator";
$data->password =  "admin01";
$data->dbname =  "data\Northwind.db";
$data->xaxisSQL[0]=  "select c.categoryname, sum(a.quantity) as ^Sales 1997^, sum(a.quantity)+1000 as ^Sales 1998^ from products b, `Order Details` a, categories c where a.productid = b.productid and c.categoryid = b.categoryid group by c.categoryid order by c.categoryid";
$data->xaxisCol[0]=  "Sales 1997";
$data->yaxisSQL[0]=  "select c.categoryname, sum(a.quantity) as ^Sales 1997^, sum(a.quantity)+1000 as ^Sales 1998^ from products b, `Order Details` a, categories c where a.productid = b.productid and c.categoryid = b.categoryid group by c.categoryid order by c.categoryid";
$data->yaxisCol[0]=  "CategoryName";

$data->name = "2";
$data->title = "Donut - Sales 1998";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "";
$data->showline = "";
$data->height = "209";
$data->width = "";
$data->col = "6";
$data->tracename[0]=  "Sales 1997";

$result[6] = $data->result();

// for chart #8
$data = new dashboardbuilder(); 
$data->type =  "map";

$data->source =  "Database"; 
$data->rdbms =  "sqlite"; 
$data->servername =  "";
$data->username =  "administrator";
$data->password =  "admin01";
$data->dbname =  "data\country.db";
$data->xaxisSQL[0]=  "SELECT * FROM GDP;";
$data->xaxisCol[0]=  "CODE";
$data->yaxisSQL[0]=  "SELECT * FROM GDP;";
$data->yaxisCol[0]=  "GDP";
$data->textSQL[0]=  "SELECT * FROM GDP;";
$data->textCol[0]=  "COUNTRY";

$data->name = "3";
$data->title = "";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "";
$data->showline = "";
$data->height = "212";
$data->width = "";
$data->col = "7";
$data->maptype[0]=  "world";

$result[7] = $data->result();

// for chart #9
$data = new dashboardbuilder(); 
$data->type =  "bar";

$data->source =  "Database"; 
$data->rdbms =  "sqlite"; 
$data->servername =  "";
$data->username =  "administrator";
$data->password =  "admin01";
$data->dbname =  "data\Northwind.db";
$data->xaxisSQL[0]=  "select c.categoryname, sum(a.quantity) as ^Sales 1997^, sum(a.quantity)+1000 as ^Sales 1998^ from products b, `Order Details` a, categories c where a.productid = b.productid and c.categoryid = b.categoryid group by c.categoryid order by c.categoryid";
$data->xaxisCol[0]=  "CategoryName";
$data->xaxisSQL[1]=  "select c.categoryname, sum(a.quantity) as 'Sales 1997', sum(a.quantity)+1000 as 'Sales 1998' from products b, `Order Details` a, categories c where a.productid = b.productid and c.categoryid = b.categoryid group by c.categoryid order by c.categoryid";
$data->xaxisCol[1]=  "CategoryName";
$data->yaxisSQL[0]=  "select c.categoryname, sum(a.quantity) as ^Sales 1997^, sum(a.quantity)+1000 as ^Sales 1998^ from products b, `Order Details` a, categories c where a.productid = b.productid and c.categoryid = b.categoryid group by c.categoryid order by c.categoryid";
$data->yaxisCol[0]=  "Sales 1997";
$data->yaxisSQL[1]=  "select c.categoryname, sum(a.quantity) as 'Sales 1997', sum(a.quantity)+1000 as 'Sales 1998' from products b, `Order Details` a, categories c where a.productid = b.productid and c.categoryid = b.categoryid group by c.categoryid order by c.categoryid";
$data->yaxisCol[1]=  "Sales 1998";

$data->name = "4";
$data->title = "";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "";
$data->showline = "";
$data->height = "213";
$data->width = "";
$data->col = "8";
$data->tracename[0]=  "Sales 1997";
$data->tracename[1]=  "Sales 1998";

$result[8] = $data->result();

// for chart #10
$data = new dashboardbuilder(); 
$data->type =  "bubble";

$data->source =  "Database"; 
$data->rdbms =  "sqlite"; 
$data->servername =  "";
$data->username =  "administrator";
$data->password =  "admin01";
$data->dbname =  "data\Northwind.db";
$data->xaxisSQL[0]=  "select p.reorderlevel as Demand, p.unitprice as ^Unit Price^, sum(o.quantity) as Sales, p.productname as ^Product^ from products p, ^Order Details^ o where o.productid = p.productid group by product having p.unitprice < 100 and demand > 5 limit 5";
$data->xaxisCol[0]=  "Sales";
$data->xaxisSQL[1]=  "select p.reorderlevel as Demand, p.unitprice as 'Unit Price', sum(o.quantity) as Sales, p.productname as 'Product' from products p, 'Order Details' o where o.productid = p.productid group by product having p.unitprice < 100 and demand > 5 limit 5";
$data->xaxisCol[1]=  "Sales";
$data->yaxisSQL[0]=  "select p.reorderlevel as Demand, p.unitprice as ^Unit Price^, sum(o.quantity) as Sales, p.productname as ^Product^ from products p, ^Order Details^ o where o.productid = p.productid group by product having p.unitprice < 100 and demand > 5 limit 5";
$data->yaxisCol[0]=  "Unit Price";
$data->yaxisSQL[1]=  "select p.reorderlevel as Demand, p.unitprice as 'Unit Price', sum(o.quantity) as Sales, p.productname as 'Product' from products p, 'Order Details' o where o.productid = p.productid group by product having p.unitprice < 100 and demand > 5 limit 5";
$data->yaxisCol[1]=  "Demand";
$data->sizeSQL[0]=  "select p.reorderlevel as Demand, p.unitprice as ^Unit Price^, sum(o.quantity) as Sales, p.productname as ^Product^ from products p, ^Order Details^ o where o.productid = p.productid group by product having p.unitprice < 100 and demand > 5 limit 5";
$data->sizeCol[0]=  "Demand";
$data->sizeSQL[1]=  "select p.reorderlevel as Demand, p.unitprice as ^Unit Price^, sum(o.quantity) as Sales, p.productname as ^Product^ from products p, ^Order Details^ o where o.productid = p.productid group by product having p.unitprice < 100 and demand > 5 limit 5";
$data->sizeCol[1]=  "Unit Price";
$data->textSQL[0]=  "select p.reorderlevel as Demand, p.unitprice as ^Unit Price^, sum(o.quantity) as Sales, p.productname as ^Product^ from products p, ^Order Details^ o where o.productid = p.productid group by product having p.unitprice < 100 and demand > 5 limit 5";
$data->textCol[0]=  "Product";
$data->textSQL[1]=  "select p.reorderlevel as Demand, p.unitprice as ^Unit Price^, sum(o.quantity) as Sales, p.productname as ^Product^ from products p, ^Order Details^ o where o.productid = p.productid group by product having p.unitprice < 100 and demand > 5 limit 5";
$data->textCol[1]=  "Product";

$data->name = "6";
$data->title = "";
$data->orientation = "";
$data->xaxistitle = "";
$data->yaxistitle = "";
$data->showgrid = "";
$data->showline = "";
$data->height = "200";
$data->width = "";
$data->col = "9";
$data->tracename[0]=  "Demand";
$data->tracename[1]=  "Sales";

$result[9] = $data->result();?>

<!DOCTYPE html>
<html>
<head>
	<script src="assets/js/dashboard.min.js"></script> <!-- copy this file to assets/js folder -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> <!-- Bootstrap CSS file, change the path accordingly -->
	
<style>
@media screen and (min-width: 960px) {
.id0 {position:absolute;margin-top:0px;}
.id1 {position:absolute;margin-top:0px;}
.id2 {position:absolute;margin-top:0px;}
.id3 {position:absolute;margin-top:0px;}
.id4 {position:absolute;margin-top:146px;}
.id5 {position:absolute;margin-top:147px;}
.id6 {position:absolute;margin-top:422px;}
.id7 {position:absolute;margin-top:422px;}
.id8 {position:absolute;margin-top:421px;}
.id9 {position:absolute;margin-top:146px;}

}
.panel-heading {line-height:0.7em;}
#kpi {font-size:34px; font-weight:bold;text-align:center;}
#kpi_legand {font-size:11px; color:#999;text-align:center;}
</style>
</head>
<body> 
<div class="container-fluid main-container">
<div class="col-md-12 col-lg-12 col-xs-12">
<div class="row">
<div class="col-md-3 col-lg-3 col-md-offset-0 col-lg-offset-0 col-xs-12 id0">
<div class="panel panel-default">
<div class="panel-heading">Average Product Price</div>
	<div class="panel-body">
		<?php echo $result[0];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-3 col-lg-3 col-md-offset-3 col-lg-offset-3 col-xs-12 id1">
<div class="panel panel-default">
<div class="panel-heading">Units Order</div>
	<div class="panel-body">
		<?php echo $result[1];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-3 col-lg-3 col-md-offset-6 col-lg-offset-6 col-xs-12 id2">
<div class="panel panel-default">
<div class="panel-heading">Average Sales</div>
	<div class="panel-body">
		<?php echo $result[2];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-3 col-lg-3 col-md-offset-9 col-lg-offset-9 col-xs-12 id3">
<div class="panel panel-default">
<div class="panel-heading">Visitors</div>
	<div class="panel-body">
		<?php echo $result[3];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-5 col-lg-5 col-md-offset-7 col-lg-offset-7 col-xs-12 id4">
<div class="panel panel-default">
<div class="panel-heading">Price vs Quantity</div>
	<div class="panel-body">
		<?php echo $result[4];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-3 col-lg-3 col-md-offset-0 col-lg-offset-0 col-xs-12 id5">
<div class="panel panel-default">
<div class="panel-heading">Stack Chart</div>
	<div class="panel-body">
		<?php echo $result[5];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-4 col-lg-4 col-md-offset-0 col-lg-offset-0 col-xs-12 id6">
<div class="panel panel-default">
<div class="panel-heading">Donut - Sales 1998</div>
	<div class="panel-body">
		<?php echo $result[6];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-5 col-lg-5 col-md-offset-4 col-lg-offset-4 col-xs-12 id7">
<div class="panel panel-default">
<div class="panel-heading">Map Chart</div>
	<div class="panel-body">
		<?php echo $result[7];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-3 col-lg-3 col-md-offset-9 col-lg-offset-9 col-xs-12 id8">
<div class="panel panel-default">
<div class="panel-heading">Bar Chart</div>
	<div class="panel-body">
		<?php echo $result[8];?>
	</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-4 col-lg-4 col-md-offset-3 col-lg-offset-3 col-xs-12 id9">
<div class="panel panel-default">
<div class="panel-heading">Bubble Chart</div>
	<div class="panel-body">
		<?php echo $result[9];?>
	</div>
</div>
</div>
</div>
</div>
</div>
</body>
<script>
	Plotly.relayout("col0", {height:68});
	
	Plotly.relayout("col1", {height:68});
	
	Plotly.relayout("col2", {height:68});
	
	Plotly.relayout("col3", {height:67});
	
	Plotly.relayout("col4", {height:199});
	
	Plotly.relayout("col5", {height:201});
	
	Plotly.relayout("col6", {height:209});
	
	Plotly.relayout("col7", {height:212});
	
	Plotly.relayout("col8", {height:213});
	
	Plotly.relayout("col9", {height:200});
	
</script>