<div id="header">
	<div class="exit">
		<h4><a href="?logout">Вийти</a></h4>
	</div>
	<?php if(admin_permissions($UserID, $conn)) {
		if(isset($_GET["users"])) {?>
			<div class="new-user">
				<a href ="?main">Main Page</a>
			</div>
		<?php
		} else {?>
			<div class="new-user">
				<a href="?register">Новий користувач</a>
			</div>
		<?php
		}
	}?>
</div>