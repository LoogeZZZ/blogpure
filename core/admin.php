<?php
	if (!isset($_SERVER["PHP_AUTH_USER"])) {
		header("WWW-Authenticate: Basic realm='Опасная зона!'");
		header("HTTP/1.0 401 Unauthorized");
		echo "Приходите еще";
		exit;
	} else {
		if($_SERVER["PHP_AUTH_USER"] == "admin" and$_SERVER["PHP_AUTH_PW"] == "1234") $_SESSION["admin"] = true;
	}

	$action = "";
	$form_data = "";

	if(isset($_GET["admin"])):
		$action = "/?create";
		$h2 = "Добавить запись";
		$form_data = built_edit_form($data);
	elseif(isset($_GET["edit"])):
		$action = "/?update";
		$h2 = "Изменить запись";
		$form_data = built_edit_form($data);
	elseif(isset($_GET["remove"])):
		$action = "/?delete";
		$h2 = "Удалить запись";
		$form_data = built_remove_form($data);
	endif;
?>

<section>
	<h2><?=$h2?></h2>
	<form action="<?=$action?>" method="post">
		<?=$form_data?>
	</form>
</section>