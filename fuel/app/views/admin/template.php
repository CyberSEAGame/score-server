<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?= $title; ?></title>
	<?= Asset::css('style.css'); ?>
</head>
<body>
	<div class="container">
		<header>
			<?php if($is_signin): ?>
			<ul>
				<li><a href="/admin">Top</a></li>
				<li><a href="/admin/teams">Teams</a></li>
				<li><a href="/admin/users">Users</a></li>
				<li><a href="/admin/categories">Categories</a></li>
				<li><a href="/admin/questions">Questions</a></li>
				<li><a href="/admin/announcements">Announcements</a></li>
				<li><a href="/admin/questionnaires">Questionnaires</a></li>
				<li><a href="/admin/upload">Upload</a></li>
				<li><a href="/admin/setting">Setting</a></li>
				<li class="logout">
					<form action="" method="post">
						<input type="hidden" name="logout" value="1">
						<button class="normal-button">Logout</button>
					</form>
				</li>
			</ul>
			<?php endif; ?>
		</header>
		<section>
			<h1><?= $title; ?></h1>
<?= $content; ?>
		</section>
		<footer>
			<p>Created by Yuichi HATTORI</p>
		</footer>
	</div>
</body>
</html>
