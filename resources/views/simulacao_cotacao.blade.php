@extends('commons.template')

@section('conteudo')

		
	<!-- OVERVIEW -->
	<div class="panel panel-headline">
		<div class="panel-heading">
			<h3 class="panel-title">Simulação de Cotação</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col col-md-1">
				</div>
				<div class="col col-md-8">
					<input list="clientes" class='form-control' name="cliente">
						<datalist id="clientes">
							@foreach ($clientes as $item)
							   <option value="{{$item->cod_e_descricao}}">
							@endforeach
						</datalist>
				</div>
				<div class="col col-md-2">
					<button class="btn btn-primary btn-block">Buscar</button>
				</div>
				<div class="col col-md-1">
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
			// $(document).ready( function () {
			// 	$('.myTable').DataTable({
			// 		"pageLength": 1000
			// 		,"order": [[ 8, "asc" ]]
			// 		,"searching": false
			// 		,"paging": false
			// 		,"info":  false
			// 	});
			// } );
	</script>
@endpush