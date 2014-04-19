<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Bootstrap core CSS -->
		<link href="/public/css/bootstrap.css" rel="stylesheet">
		<link href="/public/css/style.css" rel="stylesheet">
		<link href="/public/css/select2.css" rel="stylesheet">
		<link href="/public/css/datepicker.css" rel="stylesheet">
		<link href="/public/css/jquery.fancybox.css" rel="stylesheet">

		<script type="text/javascript" src="//code.jquery.com/jquery.js"></script>
		<script type="text/javascript" src="/public/js/select2.min.js"></script>
		<script type="text/javascript" src="/public/js/bootstrap-datepicker.js"></script>
	</head>

	<body>
	<div class="container">
		<form class="form-horizontal" id="transaction-form" action="{{ URL::route('transactionModalPost') }}" method="post">
			<div class="modal-header">
				<h4 class="modal-title">Создать новую транзакцию</h4>
			</div>
			<div class="modal-body">

				@if (Session::has('success'))
					<div class="alert alert-success">
						{{ Session::get('success') }}
						<?php Session::remove('success') ?>
					</div>
				@endif

				<!-- Define is expence -->
				@if ($errors->has('is_expense'))
					<div class="form-group has-error">
				@else
					<div class="form-group">
				@endif
					<label for="" class="col-sm-4 control-label">Приход/расход</label>
					<div class="col-sm-8">
						<select name="is_expense">
							@if (Input::old('is_expense'))
								<option value="0">Приход</option>
								<option value="1" selected="selected">Расход</option>
							@else
								<option value="0" selected="selected">Приход</option>
								<option value="1">Расход</option>
							@endif
						</select>
					</div>
				</div>

				<!-- Define transaction name -->
				@if ($errors->has('name'))
					<div class="form-group has-error">
				@else
					<div class="form-group">
				@endif
					<label for="transaction-name" class="col-sm-4 control-label">Название</label>
					<div class="col-sm-8">
						<input type="text" name="name" class="form-control input-sm" value="{{ Input::old('name') }}">
					</div>
				</div>

				<!-- Define transaction purpose -->
				@if ($errors->has('transaction_purpose_id'))
					<div class="form-group has-error">
				@else
					<div class="form-group">
				@endif
					<label class="col-sm-4 control-label">Назначение</label>
					<div class="col-sm-8">
						<select name="transaction_purpose_id">
							@foreach ($purposes as $purpose)
								@if ($purpose->id == Input::old('transaction_purpose_id'))
									<option selected="selected" value="{{ $purpose->id }}">{{ $purpose->name }}</option>
								@else
									<option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>

				<!-- Define transaction money account -->
				@if ($errors->has('money_account'))
					<div class="form-group has-error">
				@else
					<div class="form-group">
				@endif
					<label for="" class="col-sm-4 control-label">Тип валюты</label>
					<div class="col-sm-8">
						<select name="money_account">
							@foreach ($money_accounts as $account)
								@if ($account->id == Input::old('money_account'))
									<option selected="selected" value="{{ $account->id }}">{{ $account->name }}</option>
								@else
									<option value="{{ $account->id }}">{{ $account->name }}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>

				<!-- Define transaction price -->
				@if ($errors->has('price'))
					<div class="form-group has-error">
				@else
					<div class="form-group">
				@endif
					<label for="transaction-price" class="col-sm-4 control-label">Стоимость</label>
					<div class="col-sm-8">
						<input type="text" name="price" id="transaction-price" class="form-control input-sm" value="{{ Input::old('price') }}">
					</div>
				</div>

				<!-- Define transaction link -->
				@if ($errors->has('relation'))
					<div class="form-group has-error">
				@else
					<div class="form-group">
				@endif
					<label class="col-sm-4 control-label">Привязка</label>
					<div class="col-sm-8">
						{{ Form::select('relation', $relation_types, Input::old('relation'), array('id' => 'relation')); }}

						<!-- Show link to user select -->
						@if (Input::old('relation') == 'user')
							<div id="relation-user" class="col-md-6 relation-field">
								{{ Form::select('relation_to_user', $users, Input::old('relation_to_user')) }}
							</div>
						@else
							<div id="relation-user" class="col-md-6 relation-field" style="display: none">
								{{ Form::select('relation_to_user', $users) }}
							</div>
						@endif

						<!-- Show link to project select -->
						@if (Input::old('relation') == 'project')
							<div id="relation-project" class="col-md-6 relation-field">
								{{ Form::select('relation_to_project', $projects, Input::old('relation_to_project')) }}
							</div>
						@else
							<div id="relation-project" class="col-md-6 relation-field" style="display: none">
								{{ Form::select('relation_to_project', $projects) }}
							</div>
						@endif
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" onclick="parent.$.fancybox.close();">Закрыть</button>
				<button type="submit" class="btn btn-primary" onclick="$('body').addClass('loading');">Сохранить</button>
			</div>
		</form>

		<script type="text/javascript">
			$('#relation').on('change', function() {
				var relatedInput = $(this).find('option:checked').val();
				console.log(relatedInput);
				$('.relation-field').hide();

				$('#relation-' + relatedInput).show();
			});

			$('select').select2();
		</script>
	</div>
	</body>
</html>