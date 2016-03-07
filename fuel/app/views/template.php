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
		<ul>
			<li><a href="/">Top</a></li>
			<li><a href="/announcements">Announcements</a></li>
			<li><a href="/ranking">Ranking</a></li>
		<?php if($is_signin): ?>
			<li><a href="/questions">Questions</a></li>
			<li><a href="/questionnaire">Questionnaire</a></li>
			<li class="logout">
				<form action="" method="post">
					<input type="hidden" name="logout" value="1">
					<button class="normal-button">Logout</button>
				</form>
			</li>
			<li class="header_user"><a href="/setting"><?= $user->username; ?> (<?php if($user->team != null) echo $user->team->name; ?>)</a></li>
		<?php else: ?>
			<li class="logout">
				<a href="/signin" class="normal-button">Signin</a>
			</li>
			<li class="logout">
				<a href="/signup" class="normal-button">Signup</a>
			</li>
		<?php endif; ?>
		</ul>
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
