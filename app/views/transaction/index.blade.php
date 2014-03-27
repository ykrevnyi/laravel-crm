<table class="table">
	
	<tr>
		<th>id</th>
		<th>name</th>
		<th>value</th>
		<th>is expense</th>
		<th>purpose</th>
		<th>money account</th>
		<th>created at</th>
		<th>updated at</th>
		<th>delete</th>
	</tr>

	@foreach ($transactions as $transaction)
		<tr>
			<td>{{ $transaction->trans_id }}</td>
			<td>{{ $transaction->trans_name }}</td>
			<td>{{ $transaction->trans_value }}</td>
			<td>{{ $transaction->trans_is_expense }}</td>
			<td>{{ $transaction->trans_purpose }}</td>
			<td>{{ $transaction->money_account_name }}</td>
			<td>{{ $transaction->trans_created_at }}</td>
			<td>{{ $transaction->trans_updated_at }}</td>
			<td><a href="#" class="delete-transaction" data-id="{{ $transaction->trans_id }}">remove</a></td>
		</tr>
	@endforeach

</table>


<!-- Large modal -->
<div class="text-center">
	<button class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Добавить транзакцию</button>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="form-horizontal" id="transaction-form">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Создать новую транзакцию</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Приход/расход</label>
						<div class="col-sm-8">
							<select name="is_expense">
								<option value="0">Приход</option>
								<option value="1">Расход</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="transaction-name" class="col-sm-4 control-label">Название</label>
						<div class="col-sm-8">
							<input type="text" name="name" id="transaction-name">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label">Назначение</label>
						<div class="col-sm-8">
							<select name="transaction_purpose_id">
								@foreach ($purposes as $purpose)
									<option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Тип валюты</label>
						<div class="col-sm-8">
							<select name="money_account">
								@foreach ($money_accounts as $account)
									<option value="{{ $account->id }}">{{ $account->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="transaction-price" class="col-sm-4 control-label">Стоимость</label>
						<div class="col-sm-8">
							<input type="text" name="price" id="transaction-price" class="typeahead">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label">Привязка</label>
						<div class="col-sm-8">
							<select id="relation" name="relation" class="col-md-6">
								<option value="none" data-relation="none">без привязки</option>
								<option value="user" data-relation="user">к пользователю</option>
								<option value="project" data-relation="project">к проекту</option>
							</select>

							<div id="relation-user" class="col-md-6 relation-field" style="display: none">
								<input type="text" class="typeahead" id="relation_to_user">
								<input type="hidden" name="relation_to_user" id="relation_to_user_input" value="">
							</div>

							<div id="relation-project" class="col-md-6 relation-field" style="display: none">
								<input type="text" class="typeahead" id="relation_to_project">
								<input type="hidden" name="relation_to_project" id="relation_to_project_input" value="">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
					<button type="submit" class="btn btn-primary">Сохранить</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#relation').on('change', function() {
		var relatedInput = $(this).find('option:checked').data('relation');
		$('.relation-field').hide();

		$('#relation-' + relatedInput).show();
	});

	// Add new transaction
	$('#transaction-form').on('submit', function(e) {
		var form = $(this).serialize(),
			errorContainer = $('#transaction-error-container'),
			btn = $(this).find('button[type=submit]');

		btn.button('loading');

		$.ajax({
			url: '/transactions',
			method: 'post',
			dataType: 'json',
			data: form
		}).done(function(resp) {
			if (resp.error) {
				noty({
					text: resp.error, 
					timeout: 2500, 
					layout: "topCenter", 
					type: "error"
				});
			} else {
				noty({
					text: resp.success, 
					timeout: 2500, 
					layout: "topCenter", 
					type: "success"
				});

				// Reload page
				window.location.reload();
			};

			btn.button('reset');
		});

		e.preventDefault();
	});

	// Remove transaction
	$('.delete-transaction').on('click', function(e) {
		var $this = $(this);

		$.ajax({
			url: '/transactions/' + $this.data('id'),
			dataType: 'json',
			method: 'delete'
		}).done(function(resp) {
			if (resp.error) {
				noty({
					text: resp.error, 
					timeout: 2500, 
					layout: "topCenter", 
					type: "error"
				});
			} else {
				$this.closest('tr').remove();

				noty({
					text: resp.success, 
					timeout: 2500, 
					layout: "topCenter", 
					type: "success"
				});
			}
		});

		e.preventDefault();
	});
</script>

<script type="text/javascript" src="/public/js/typehead.js"></script>
<script type="text/javascript">
	// instantiate the bloodhound suggestion engine
	var numbers = new Bloodhound({
		datumTokenizer: function(d) { 
			return Bloodhound.tokenizers.whitespace(d.fullname);
		},
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		local: [
			@foreach ($users['users'] as $user)
				{ fullname: '{{ $user->firstname . ' ' . $user->lastname }}', user_id: '{{ $user->id }}' },
			@endforeach
		]
	});

	// initialize the bloodhound suggestion engine
	numbers.initialize();

	// instantiate the typeahead UI
	$('#relation_to_user.typeahead').typeahead(null, {
		displayKey: 'fullname',
		source: numbers.ttAdapter()
	}).on('typeahead:selected', function(obj, data) {
		$('#relation_to_user_input').val(data.user_id);
	});
</script>

<script type="text/javascript">
	// instantiate the bloodhound suggestion engine
	var projects = new Bloodhound({
		datumTokenizer: function(d) { 
			return Bloodhound.tokenizers.whitespace(d.projectName);
		},
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		local: [
			@foreach ($projects as $project)
				{ projectName: '{{ $project->proj_name }}', project_id: '{{ $project->proj_id }}' },
			@endforeach
		]
	});

	// initialize the bloodhound suggestion engine
	projects.initialize();

	// instantiate the typeahead UI
	$('#relation_to_project.typeahead').typeahead(null, {
		displayKey: 'projectName',
		source: projects.ttAdapter()
	}).on('typeahead:selected', function(obj, data) {
		$('#relation_to_project_input').val(data.project_id);
	});
</script>