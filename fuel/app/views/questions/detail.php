<table class="normal-table">
	<tr>
		<th class="middle">Category</th>
		<td class="middle"><?= $question->category->title; ?></td>
	</tr>
	<tr>
		<th class="middle">Score</th>
		<td><?= $question->point; ?></td>
	</tr>
</table>
<div class="body-area">
<?= nl2br(htmlspecialchars_decode($question->body)); ?>
</div>
<?php if($log == null): ?>
<form method="post" action="" class="normal-form">
	<input type="hidden" name="csrf_token" value="<?= $user->csrf_token; ?>">
	<fieldset>
		<?php if($status == 1): ?>
			<p class="solved-text">Congratulations!</p>
		<?php elseif($status == 2): ?>
			<p class="error">Try Again.</p>
		<?php elseif($status == 3): ?>
			<p class="error">Your account has locked.<br>Please wait 5 minutes.</p>
		<?php endif; ?>
		<label for="answer">Answer:</label>
		<input type="text" name="answer" id="answer" value="">
	</fieldset>
	<button type="submit" class="normal-button center">Submit</button>
</form>
<?php else: ?>
	<?php if($status == 1): ?>
		<p class="solved-text">Congratulations!</p>
	<?php else: ?>
		<p class="solved-text">Your team has already solved this question.</p>
	<?php endif; ?>
<?php endif; ?>