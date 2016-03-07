<a class="create_button" href="/admin/questions/edit">Create New Question</a>
<div>
	<table class="normal-table">
		<tr>
			<th class="small">Open</th>
			<th class="small">Solve</th>
			<th class="small">ID</th>
			<th>Title</th>
			<th>Category</th>
			<th class="small">Score</th>
			<th class="small">First</th>
			<th class="small">Solved</th>
			<th class="small">Teams</th>
			<th class="small"></th>
			<th class="small"></th>
			<th class="small"></th>
			<th class="small"></th>
		</tr>
		<?php foreach($questions as $question): ?>
		<tr id="question_<?= $question["id"]; ?>">
			<td><input type="checkbox" onclick="changeOpened(<?= $question["id"]; ?>)" <?php if($question["is_opened"] == 1) echo "checked"; ?>></td>
			<td><input type="checkbox" onclick="changeSolved(<?= $question["id"]; ?>)" <?php if($question["is_solved"] == 1) echo "checked"; ?>></td>
			<td><?= $question["id"]; ?></td>
			<td><?= $question["title"]; ?></td>
			<td><?= $question["category"]; ?></td>
			<td><?= $question["point"]; ?></td>
			<td><?= $question["first_point"]; ?></td>
			<td><?php
				$answers = Model_Answerlog::find("all",[
					"where" => [
						["question_id", $question["id"]],
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
					echo $answer->team->name;
					$count++;
				}
			?></td>
			<td><a class="normal-button" href="/admin/questions/edit/<?= $question["id"]; ?>">Edit</a></td>
			<td><button class="normal-button" onclick="deleteQuestion(<?= $question["id"]; ?>)">Delete</button></td>
			<td><a class="normal-button" href="/admin/answerlogs/?id=<?= $question["id"]; ?>">Log</a></td>
			<td><a class="normal-button" href="/admin/questions/view/<?= $question["id"]; ?>">View</a></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?= $pager; ?>
</div>

<?= Asset::js("jquery.min.js"); ?>
<?= Security::js_fetch_token(); ?>
<script>
	function deleteQuestion(id){
		if(confirm('Do you want to delete it?')){
			$.ajax({
				url: '/admin/api/deletequestion.json',
				type: 'POST',
				data: {
					"id": id,
					"<?= Config::get('security.csrf_token_key'); ?>": fuel_csrf_token()
				},

				complete: function(){

				},
				success: function(res) {
					$("#question_" + id).hide();
				}
			})
		}
	}

	function changeOpened(id){
		$.ajax({
			url: '/admin/api/changequestionopened.json',
			type: 'POST',
			data: {
				"id": id,
				"<?= Config::get('security.csrf_token_key'); ?>": fuel_csrf_token()
			},

			complete: function(){

			},
			success: function(res) {
			}
		})
	}

	function changeSolved(id){
		$.ajax({
			url: '/admin/api/changequestionsoleved.json',
			type: 'POST',
			data: {
				"id": id,
				"<?= Config::get('security.csrf_token_key'); ?>": fuel_csrf_token()
			},

			complete: function(){

			},
			success: function(res) {
			}
		})
	}
</script>