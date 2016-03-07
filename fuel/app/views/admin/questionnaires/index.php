<a class="create_button" href="/admin/questionnaires/edit">Create New Questionnaire</a>
<a class="create_button" href="/admin/questionnairetitles">Questionnaire Titles</a>
<div>
	<table class="normal-table">
		<tr>
			<th class="middle">Sort</th>
			<th class="small">ID</th>
			<th>Title</th>
			<th>Body</th>
			<th>Type</th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach($questionnaires as $questionnaire): ?>
		<tr id="questionnaire_<?= $questionnaire->id; ?>">
			<td><form action="" method="post">
					<Input type="hidden" name="id" value="<?= $questionnaire->id; ?>">
					<?= Form::csrf(); ?>
					<select name="sort" onchange="submit()">
						<?php for($i = 0; $i <= 20; $i++): ?>
							<option value="<?= $i; ?>" <?php if($i == $questionnaire->sort) echo "selected"; ?>><?= $i; ?></option>
						<?php endfor; ?>
					</select>
			</form></td>
			<td><?= $questionnaire->id; ?></td>
			<td><?= $questionnaire->title->title; ?></td>
			<td><?= $questionnaire->body; ?></td>
			<td><?= Config::get("questionnaire_types")[$questionnaire->type_id]; ?></td>
			<td><a class="normal-button" href="/admin/questionnaires/edit/<?= $questionnaire->id; ?>">Edit</a></td>
			<td><button class="normal-button" onclick="deleteQuestionnaire(<?= $questionnaire->id; ?>)">Delete</button></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?= $pager; ?>
</div>

<?= Asset::js("jquery.min.js"); ?>
<?= Security::js_fetch_token(); ?>
<script>
	function deleteQuestionnaire(id){
		if(confirm('Do you want to delete it?')){
			$.ajax({
				url: '/admin/api/deletequestionnaire.json',
				type: 'POST',
				data: {
					"id": id,
					"<?= Config::get('security.csrf_token_key'); ?>": fuel_csrf_token()
				},

				complete: function(){

				},
				success: function(res) {
					$("#questionnaire_" + id).hide();
				}
			})
		}
	}
</script>