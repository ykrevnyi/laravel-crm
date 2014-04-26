<?php 
	$monthes = array(
	    1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля',
	    5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа',
	    9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
	);
?>

<div class="container">

	<div class="row">
		<div class="col-lg-12">
			<h1>Транзакции</h1>
		</div>
	</div>

	<br>

	<div class="row page-filter">
		<div class="col-lg-7">
			<form action="">
				<div class="pull-left filter-name-container">
					{{ Form::label('filter_name', 'Фильтр', array('class' => 'filter-name-field-label')) }}
					{{ Form::text('filter_name', Input::get('filter_name', ''), array('id' => 'filter_name', 'class' => 'filter-name-field form-control')) }}
				</div>

				<div id="reportrange" class="pull-left">
				    <i class="glyphicon glyphicon-time"></i>
				    <span>
				    	<?php echo($date_from_formated->format('j ') . $monthes[ $date_from_formated->format('n') ] . $date_from_formated->format(' Y')); ?>
				    	 - 
				    	<?php echo($date_to_formated->format('j ') . $monthes[ $date_to_formated->format('n') ] . $date_to_formated->format(' Y')); ?>
			    	</span>
				    <b class="caret"></b>
				</div>

				<input type="hidden" name="date_from" id="date_from" value="{{ $date_from }}">
				<input type="hidden" name="date_to" id="date_to" value="{{ $date_to }}">

				<button type="submit" class="filter-search-btn btn btn-info">
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</form>
		</div>
		<div class="col-lg-5 text-right">
			<a id="add-transaction" href="#" class="btn btn-info">
				<span class="glyphicon glyphicon-plus"></span>
				Добавить новую транзакцию
			</a>
		</div>
	</div>

	<br>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h5 class="pull-left">Список транзакий</h5>
				</div>

				@if ( ! count($transactions))
					<div class="empty-message text-center">
						<span class="glyphicon glyphicon-transfer"></span>
						<h3>Нет транзакций :(</h3>
					</div>
				@else
					<table class="vertical-aligned table table-bordered">
						<tr>
							<th></th>
							<th>№</th>
							<th>Название</th>
							<th>Кол-во</th>
							<th>Назначение</th>
							<th>Счет</th>
							<th>Создана</th>
							<th>Обновлена</th>
							<th></th>
						</tr>

						@foreach ($transactions as $transaction)
							@if ($transaction->trans_is_expense)
								<tr class="active">
									<td class="text-center"><span class="glyphicon glyphicon-arrow-left"></span></td>
							@else
								<tr class="success">
									<td class="text-center"><span class="glyphicon glyphicon-arrow-right"></span></td>
							@endif
								
								<td>{{ $transaction->trans_id }}</td>
								<td>{{ $transaction->trans_name }}</td>
								<td>{{ $transaction->trans_value }}</td>
								<td>{{ $transaction->trans_purpose }}</td>
								<td>{{ $transaction->money_account_name }}</td>
								<td>{{ $transaction->trans_created_at }}</td>
								<td>{{ $transaction->trans_updated_at }}</td>
								<td class="text-center">
									<a href="#" class="delete-transaction btn btn-danger" data-id="{{ $transaction->trans_id }}"><span class="glyphicon glyphicon-remove"></span></a>
								</td>
							</tr>
						@endforeach
					</table>
				@endif
			</div>
		</div>
	</div>

</div>



<script type="text/javascript">
	// Remove transaction
	$('.delete-transaction').on('click', function(e) {
		var $this = $(this);

		$this.attr('disabled', 'disabled');

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

			$this.removeAttr('disabled', 'disabled');
		});

		e.preventDefault();
	});

	$('#add-transaction').on('click', function(e) {
		$.fancybox.open({
			href: '/transactions/modal',
			type: 'iframe',
			padding: 0,
			maxWidth: 780
		});

		e.preventDefault();
	});

	// Init date range filter
	$('#reportrange').daterangepicker(
	    {
	      ranges: {
			'Сегодня': [moment(), moment()],
			'Вчера': [moment().subtract('days', 1), moment().subtract('days', 1)],
			'Последние 7 дней': [moment().subtract('days', 6), moment()],
			'Последние 30 дней': [moment().subtract('days', 29), moment()],
			'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
			'Последний месяц': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
	      },
	      format: 'DD-MM-YYYY',
	      startDate: "{{ $date_from }}",
	      endDate: "{{ $date_to }}"
	    },
	    function(start, end) {
	        $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));

	        $('#date_from').val(start.format('DD-MM-YYYY'));
	        $('#date_to').val(end.format('DD-MM-YYYY'));
	    }
	);
</script>