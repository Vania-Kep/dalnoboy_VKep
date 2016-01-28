<div id="header">
	<div class="top-nav">
		<?php if (!isset($pageID) || $pageID!="myPassChange") { ?>
			<div class="change-pass top-nav-item">
				<a href="change-my-pass.php?">Змінити мій пароль</a>
			</div>
		<?php } ?>

		<div class="exit top-nav-item">
			<h4><a href="?logout">Вийти</a></h4>
		</div>

	</div>
	<?php if(admin_permissions($UserID, $conn) && isset($pageID)) {
		if( $pageID=="usersManagment" ) {?>
			<div class="new-user">
				<a href ="main.php?main">Main Page</a>
			</div>
		<?php
		} else {?>
			<div class="new-user">
				<a href="users.php?users">Новий користувач</a>
			</div>
		<?php
		}
	}?>
</div>