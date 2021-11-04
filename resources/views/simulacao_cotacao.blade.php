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
					<input value='{{$cliente_selected}}' list="clientes" class='form-control' id='busca_cliente' name="cliente_selected" required>
						<datalist id="clientes">
							@foreach ($clientes as $item)
							   <option value="{{$item->cod_e_descricao}}">
							@endforeach
						</datalist>
					
				</div>
				<div class="col col-md-2">
					<button type='button' onclick='buscar_info_clientes()' class="btn btn-primary btn-block">Buscar</button>
				</div>
				<div class="col col-md-1">
				</div>
			</div>
			<br><br>
			<div class="row" id='info_cliente' style='display: nome'>
				<div class="col col-md-6">
					<input type="text" class='form-control'>
				</div>
				<div class="col col-md-6">
					<input type="text" class='form-control'>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		function buscar_info_clientes(){
			let busca_cliente = document.querySelector('#busca_cliente').value;
			let info_cliente = document.querySelector('#info_cliente');
			let result = busca_cliente.split("-");
			let cod_cli = result[0];
			console.log(cod_cli);

			info_cliente.style.display = 'block';

		}
	</script>
@endpush