@extends('commons.template')

@section('conteudo')

		
	<!-- OVERVIEW -->
	<div class="panel panel-headline">
		<div class="panel-heading">
			<h3 class="panel-title">Simulação de Cotação</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col col-md-10">
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
			</div>
			<br><br>
			<div  id='info_cliente' style='display: none'>

			<div class="row">
				<div class="col col-md-4">
					<label>Cliente</label>
					<input type="text" name='cliente' id='cliente' class='form-control' readonly='true'>
				</div>
				<div class="col col-md-4">
					<label>Representante</label>
					<input type="text" name='representante' id='representante' class='form-control' readonly='true'>
				</div>
				<div class="col col-md-3">
					<label>Aumento</label>
					<input type="text" name='aumento' id='aumento' class='form-control'>
				</div>
				<div class="col col-md-1">
					<label>&nbsp;</label>
					<button class="btn btn-primary">Aplicar</button>
				</div>
			</div><br>
			<div class="row">
				<div class="col col-md-4">
					<label>Data Inicial</label>
					<input type="date" name="dt_inicial" id="dt_inicial" class="form-control">
				</div>
				<div class="col col-md-4">
					<label>Data Final</label>
					<input type="date" name="dt_final" id="dt_final" class="form-control">
				</div>
				<div class="col col-md-4">
					<label>Aliquota</label>
					<input type="text" name="aliquota" id="aliquota" class="form-control">
				</div>
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
			let cliente = document.querySelector('#cliente');
			let representante = document.querySelector('#representante');
			
			let result = busca_cliente.split("-");
			let cod_cli = result[0];
			

			let url = "{{asset('')}}";
			const URL_TO_FETCH = url+"buscar_clientes_info/"+cod_cli;
			fetch(URL_TO_FETCH, {
				method: 'get' //opcional 
			})
			.then((response) => response.json())
         	.then((json) => {
				 info_cliente.style.display = 'block';
				cliente.value = json.cod_e_descricao;
				representante.value = json.representante;
			})
			.catch(function(err) { 
				console.error(err); 
			});

		}
	</script>
@endpush