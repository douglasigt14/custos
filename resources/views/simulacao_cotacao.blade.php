@extends('commons.template')

@section('conteudo')

		
	<!-- OVERVIEW -->
	<div class="panel panel-headline">
		<div class="panel-heading">
			<h3 class="panel-title">@{{ titulo }}</h3>
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
					<div class="col col-md-6">
						<label>Cliente</label>
						<input type="text" name='cliente' id='cliente' class='form-control' readonly='true'>
					</div>
					<div class="col col-md-6">
						<label>Representante</label>
						<input type="text" name='representante' id='representante' class='form-control' readonly='true'>
					</div>
					{{-- <div class="col col-md-2">
						<label>Aumento</label>
						<input type="text" name='aumento' id='aumento' class='form-control'>
					</div>
					<div class="col col-md-1">
						<label>&nbsp;</label>
						<button class="btn btn-primary">Aplicar</button>
					</div> --}}
				</div><br>
				<div class="row">
					<div class="col col-md-5">
						<label>Data Inicial</label>
						<input type="date" value='{{$dt_inicial}}' name="dt_inicial" id="dt_inicial" class="form-control">
					</div>
					<div class="col col-md-5">
						<label>Data Final</label>
						<input type="date" value='{{$dt_final}}' name="dt_final" id="dt_final" class="form-control">
					</div>
					<div class="col col-md-2">
						<label>Aliquota</label>
						<input type="text" name="aliquota" id="aliquota" class="form-control">
					</div>
				</div><br>
				<div class="row">
					<div class="col col-md-12">
						<div class="form-group">
							<label>Observação</label>
							<textarea class="form-control" rows="3"></textarea>
						  </div>
					</div>
				</div>
				<div class="row" ng-repeat="item in itens track by $index">
					<div class="col col-md-3">
						<label>Item</label>
						<input list="itens" class='form-control' id='item' name="itens[]" required>
						<datalist id="itens">
							@foreach ($itens as $item)
							   <option value="{{$item->descricao}}">
							@endforeach
						</datalist>
					</div>
					<div class="col col-md-1">
						<label>VPC</label>
						<input type="text" name='vpcs[]'  class="form-control">
					</div>
					<div class="col col-md-1">
						<label>COM</label>
						<input type="text" name='coms[]'  class="form-control">
					</div>
					<div class="col col-md-1">
						<label>P.NEG</label>
						<input type="text" name='precos_n[]'  class="form-control">
					</div>
					<div class="col col-md-1">
						<label>P.CHEIO</label>
						<input type="text" readonly='true' name='precos_c[]'  class="form-control">
					</div>
					<div class="col col-md-1">
						<label>DESC</label>
						<input type="text" readonly='true' name='descs[]'  class="form-control">
					</div>
					<div class="col col-md-1">
						<label>ML</label>
						<input type="text" readonly='true' name='mls[]'  class="form-control">
					</div>
					<div class="col col-md-1">
						<label>&nbsp;</label>
						<button class="btn btn-primary btn-sm btn-block"><b><i class="fa fa-calculator"></i></b></button>
					</div>
					<div class="col col-md-1">
						<label>&nbsp;</label>
						<button ng-click="remover(item,$index)" class="btn btn-danger btn-sm btn-block"><b><i class="fa fa-minus"></i></b></button>
					</div>
					<div class="col col-md-1">
						<label>&nbsp;</label>
						<button ng-click="inserir(item)" class="btn btn-success btn-sm btn-block"><b><i class="fa fa-plus"></i></b></button>
					</div><br>
				</div>
			</div><!-- FIM INFO CLIENTE VIA JAVASCRIPT-->
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


		function buscar_info_itens(){
			// let busca_cliente = document.querySelector('#busca_cliente').value;
		}
	</script>
@endpush