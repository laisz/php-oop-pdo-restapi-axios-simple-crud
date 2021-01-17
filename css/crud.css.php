
<?php

	$color_deepash = "rgba(218, 218, 218, 0.87)";
	$color_info2   = "rgba(39, 170, 246, 0.698)";
	$color_white   = "#ffffff";
	$color_black   = "rgb(0, 0, 0)";

?>

<style>

@font-face {
	font-family: "Raleway";
	src: url("../fonts/Raleway-Regular.ttf") format("truetype");

	/* font-family: "century gothic";
	src: url("../fonts/GOTHIC.TTF") format("truetype"); */
}


/*
| ------------------( Special Notes )---------------------------------
| In Bootstap 3 font size was:13, but in Bootstrap 4 Font size
| increased. that's why i include default font size: 13 in the body.
| --------------------------------------------------------------------
*/

body {
	margin: 0;
	padding: 0;
	font-family: "Raleway", sans-serif;
	font-size: 13px;	
	/*font-family: "century gothic", sans-serif;*/
}

*{
	box-sizing: border-box;
}

a {
	text-decoration: none;
}


.headline {
	color: deeppink;
}

/*
|=======================
| Custom MENU CSS Start
|=======================
*/

.menu {
	
}

.menu ul {
	
}

.menu ul li {
	
}

.menu ul li a{
	
}



/*
|================
| MENU CSS End
|================
*/

/*
|================
| COMMON CSS Start
|================
*/

/*
| CUSTOM GRID CSS Start(Not Using in This Template)
*/

.mycontainer{
	width: 1200px;
	margin-left: auto;
	margin-right: auto;
	padding-left: 15px;
	padding-right: 15px;
}

.mycontainer:before,
.mycontainer:after{
	content: " ";
	clear: both;
	display: table;
	
}

.myrow{
	margin-left: -15px;
	margin-right: -15px;
}

.mycol100{
	width: 100%;
	padding-left: 15px;
	padding-right: 15px;
}
.mycol50{
	width: 50%;
	float: left;
	padding-left: 15px;
	padding-right: 15px;
}
.mycol33{
	width: 33.33%;
	float: left;
	padding-left: 15px;
	padding-right: 15px;
}
.mycol25{
	width: 25%;
	float: left;
	padding-left: 15px;
	padding-right: 15px;
}

/*
| CUSTOM GRID CSS End (Not Using in This Template)
*/



.margin-top-bottom {
	margin-top: 10px;
	margin-bottom: 10px;
}



/*
|================
| COMMON CSS End
|================
*/


/*
|========================
| COMMON CSS COLOR Start
|========================
*/



.bg-deepash {
	background: <?php echo $color_deepash; ?>;
}

.card .bg-info2 {
	background: <?php echo $color_info2; ?>;
}

.border-info2 {
	border: 1px solid <?php echo $color_info2; ?>;
}

.color-white {
	color: <?php echo $color_white; ?>;
}
.color-black {
	color: <?php echo $color_black; ?>;
}

.padding-lr-ten {
	padding-left: 10px;
	padding-right: 10px;
}

.text-center {
	text-align: center;
}

.text-justify {
	text-align: justify;
}


/*
|========================
| COMMON CSS COLOR End
|========================
*/

/*
|==========================
| Custom CSS For BootStrap
|==========================
*/






/*
|==========================
| Custom CSS For BootStrap
|==========================
*/


/*
| Other CSS (from raw.css)
*/

.go-top{
	
	background: rgb(226, 19, 153);
	color: #fff;
	font-weight: bold;
	font-size: 40px;
	position: fixed;
	bottom: 8px;
	right: 15px;
	z-index: +999;
	padding: 0px 7px;
	display: none;
	text-align: center;
	vertical-align: middle;
	cursor: pointer;
}

</style>


