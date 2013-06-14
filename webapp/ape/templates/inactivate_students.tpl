{box title="Inactivate Students" size=16}
	<form method="post" action="{$PHP.BASE_URL}/inactivate_students.html" enctype="multipart/form-data" class="well">
		<label for="csv">Student CSV:</label>
		<input type="file" name="csv" size="20"/>
		<p class="help-block">Format: pidm, termcode_of_active_sgbstdn_record</p>
		<button type="submit" class="btn btn-primary">Preview</button>
	</form>
{/box}
{if $students}
	{capture name=purge_link assign=purge_link}<a href="{$PHP.BASE_URL}/inactivate_students.html?purge=1">Purge Data</a>{/capture}
	{capture name=student_count assign=student_count}Records - {$students|@count}{/capture}
	{box title="Student Data" title_size=8 secondary_title="$purge_link" subheader="$student_count" size=16}
		<form method="post" action="{$PHP.BASE_URL}/inactivate_students.html?process=1" class="well form-inline">
			<label for="term">Inactivate students for termcode: </label>
			<input type="text" name="term" maxlength="6" />
			<button type="submit" class="btn btn-success">Inactivate</button>
		</form>
		<table class="table table-bordered table-striped table-condensed">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Term</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$students item=student}
				<tr>
					<td>{$student.id}</td>
					<td>{$student.name}</td>
					<td>{$student.termcode}</td>
					<td><a href="{$PHP.BASE_URL}/inactivate_students.html?process={$student.pidm}" class="btn btn-success">Process</a> <a href="{$PHP.BASE_URL}/inactivate_students.html?delete={$student.pidm}" class="btn btn-danger">Delete</a></td>
				</tr>
			{/foreach}
			</tbody>
		</table>
	{/box}
{/if}
