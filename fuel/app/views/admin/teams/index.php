<a class="create_button" href="/admin/teams/edit">Create New Team</a>
<div>
	<table class="normal-table">
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Color</th>
			<th class="small">Solved</th>
			<th class="small">Questions</th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach($teams as $team): ?>
		<tr id="team_<?= $team->id; ?>">
			<td><?= $team->id; ?></td>
			<td><?= $team->name; ?></td>
			<td><span style="color:<?= $team->color; ?>"><?= $team->color; ?></span></td>
			<td><?php
				$answers = Model_Answerlog::find("all",[
					"where" => [
						["team_id", $team->id],
						["is_corrected", 1]
					]
				]);
				$count = 0;
				echo count($answers);
				echo "</td><td>";
				foreach($answers as $answer)
				{
					if($count != 0)
					{
						echo "<br>";
					}
					echo $answer->question->title;
					$count++;
				}
				?></td>
			<td><a class="normal-button" href="/admin/teams/edit/<?= $team->id; ?>">Edit</a></td>
			<td><button class="normal-button" onclick="deleteTeam(<?= $team->id; ?>)">Delete</button></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?= $pager; ?>
</div>
<?= Asset::js("jquery.min.js"); ?>
<?= Security::js_fetch_token(); ?>
<script>
	function deleteTeam(id){
		if(confirm('Do you want to delete it?')){
			$.ajax({
				url: '/admin/api/deleteteam.json',
				type: 'POST',
				data: {
					"id": id,
					"<?= Config::get('security.csrf_token_key'); ?>": fuel_csrf_token()
				},

				complete: function(){

				},
				success: function(res) {
					$("#team_" + id).hide();
				}
			})
		}
	}
</script>