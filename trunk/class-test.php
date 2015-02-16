<!DOCTYPE>
<style type="text/css">
body {
  font-size: 14px;
  font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;

  }
.menuheader{
	width: 100%;
}
.menuheader a {
text-decoration: none;
}	
header.menuheader ul li {
display: inline-block;
}
</style>
<body>
<h1>Book Appointment</h1>
<header class="menuheader">
	<nav>
		<ul>
		<li>
			<?php 
			echo $this->menu();
			?>
		</li>
	</ul>
	</nav>	
</header>
<div><?php $this->check_page();?></div>
</body>