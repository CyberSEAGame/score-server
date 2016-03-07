<a class="create_button" href="/admin/categories/edit">Create New Category</a>
<div>
	<table class="normal-table">
		<tr>
			<th>Sort</th>
			<th>ID</th>
			<th>Title</th>
			<th>Num</th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach($categories as $category): ?>
		<tr id="category_<?= $category["id"]; ?>">
			<td><form action="" method="post">
					<Input type="hidden" name="id" value="<?= $category["id"]; ?>">
					<?= Form::csrf(); ?>
					<select name="sort" onchange="submit()">
						<?php for($i = 0; $i <= 20; $i++): ?>
							<option value="<?= $i; ?>" <?php if($i == $category["sort"]) echo "selected"; ?>><?= $i; ?></option>
						<?php endfor; ?>
					</select>
			</form></td>
			<td><?= $category["id"]; ?></td>
			<td><?= $category["title"]; ?></td>
			<td><?= $category["c"]; ?></td>
			<td><a class="normal-button" href="/admin/categories/edit/<?= $category["id"]; ?>">Edit</a></td>
			<td><button class="normal-button" onclick="deleteCategory(<?= $category["id"]; ?>)">Delete</button></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?= $pager; ?>
</div>

<?= Asset::js("jquery.min.js"); ?>
<?= Security::js_fetch_token(); ?>
<script>
	function deleteCategory(id){
		if(confirm('Do you want to delete it?')){
			$.ajax({
				url: '/admin/api/deletecategory.json',
				type: 'POST',
				data: {
					"id": id,
					"<?= Config::get('security.csrf_token_key'); ?>": fuel_csrf_token()
				},

				complete: function(){

				},
				success: function(res) {
					$("#category_" + id).hide();
				}
			})
		}
	}
</script>