<!DOCTYPE html>
<html lang="en">
<head>
	<title>Users</title>
</head>
<body><?php $this->get_user_name();?>
	<div class="wrap">
		<h2>Registered Users</h2>
		<hr>
			<form action="" id="frm">
			<table class="recentusers">
			<?php echo $this->wpb_recently_registered_users();?>
			</form>
			<?php echo $this->remove_logged_in_user();?>
			</table>
		</div>
	</body>
</html>