<div>
	<div class="clock">
		<p id="time"><?= date("m/d H:i:s"); ?></p>
		<div>
			<p><?= date("m/d H:i", $start_at); ?></p>
			<div class="total"><div class="now" id="now"></div></div>
			<p><?= date("m/d H:i", $finish_at); ?></p>
		</div>
	</div>
	<div class="messages" id="messages">
	</div>
	<table class="normal-table">
		<tr>
			<th class="small">Rank</th>
			<th>Team</th>
			<th>Score</th>
			<th>First Score</th>
			<th>Total Score</th>
		</tr>
		<tbody id="ranking_tbody">
		</tbody>
	</table>
	<div class="big-chart">
		<h3>Total</h3>
		<canvas id="total" height="300" width="800"></canvas>
	</div>
	<div class="big-chart">
		<h3>Score</h3>
		<canvas id="score" height="300" width="800"></canvas>
	</div>
	<div class="big-chart">
		<h3>First Score</h3>
		<canvas id="first_point" height="300" width="800"></canvas>
	</div>
</div>
<?= Asset::js("jquery.min.js"); ?>
<?= Asset::js("Chart.min.js"); ?>
<?= Asset::js("ranking.js"); ?>
<audio id="correct" preload="auto">
	<source src="/assets/sounds/correct_answer1.mp3" type="audio/mp3">
</audio>