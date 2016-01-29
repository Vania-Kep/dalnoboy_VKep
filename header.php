<?php 
	function checkSelectedTopNavItem($pageID, $top_item) {
		return $pageID == $top_item ? 'selected-nav' : '';
	}
?>
<div id="header">
	<div class="top-nav">

		<div class="site-main top-nav-item <?=checkSelectedTopNavItem($pageID, 'main')?>">
			<a href="index.php?">Головна</a>
		</div>
		<div class="top-nav-item <?=checkSelectedTopNavItem($pageID, 'waybills')?>">
			<a href="waybills.php">Маршрути</a>
		</div>

		<div class="change-pass top-nav-item <?=checkSelectedTopNavItem($pageID, 'myPassChange')?>">
			<a href="change-my-pass.php">Змінити мій пароль</a>
		</div>

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

