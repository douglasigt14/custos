@extends('commons.template')

@section('conteudo')

	<style>
		.campos{
			padding: 0.1rem !important;
		}
	</style>	
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
					<button type='button' ng-click="buscar_info_clientes()"  class="btn btn-primary btn-block">Buscar</button>
				</div>
			</div>
			<br><br>
			<form action="/simulacao_cotacao/salvar" method="POST">
			@csrf
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
					<div class="col col-md-4">
						<label>Data Inicial</label>
						<input type="date" value='{{$dt_inicial}}' name="dt_inicial" id="dt_inicial" class="form-control" required>
					</div>
					<div class="col col-md-4">
						<label>Data Final</label>
						<input type="date" value='{{$dt_final}}' name="dt_final" id="dt_final" class="form-control" required>
					</div>
					<div class="col col-md-2">
						<label>Aliquota</label>
						<input type="text" name="aliquota" ng-model='aliquota' id="aliquota" class="form-control" required>
					</div>
					<div class="col col-md-2">
						<label>Custo</label>
						<select name="select_custo" class='form-control' ng-model="select_custo">
							<option value="custo_atual">Custo Atual</option>
							<option value="custo_futuro">Custo Futuro</option>
						</select>
					</div>
				</div><br>
				<div class="row">
					<div class="col col-md-12">
						<div class="form-group">
							<label>Observação</label>
							<textarea class="form-control" name='obs' rows="3"></textarea>
						  </div>
					</div>
				</div>
				<div class="row" ng-repeat="item in itens track by $index">
					<div class="col campos col-md-3">
						<label>Item</label>
						<input autocomplete="off" list="itens" class='form-control' ng-model='item.item' id='item' name="itens[]" required>
						<datalist id="itens">
							@foreach ($itens as $item)
							   <option value="{{$item->descricao}}">
							@endforeach
						</datalist>
					</div>
					<div class="col campos col-md-1">
						<label>VPC</label>
						<input autocomplete="off" ng-model='item.vpc' type="text" name='vpcs[]'  class="form-control" required>
					</div>
					<div class="col campos col-md-1">
						<label>COM</label>
						<input autocomplete="off" ng-model='item.com' type="text" name='coms[]'  class="form-control" required>
					</div>
					<div class="col campos col-md-1">
						<label>P.NEG</label>
						<input autocomplete="off"type="text" ng-model='item.preco' name='precos[]'  class="form-control" required>
					</div>
					<div class="col campos col-md-1">
						<label>P.CHEIO</label>
						<input style='background-color: #d3d3d3' type="text" ng-model='item.preco_nordeste' ng-readonly="true" name='precos_c[]'  class="form-control"  step=0.0001  min=0 onBlur="if(this.value==''){this.value='0'};" required>
					</div>
					<div class="col campos col-md-1">
						<label>DESC</label>
						<input style='background-color: #d3d3d3' type="text" ng-model='item.desconto' ng-readonly="true" name='descs[]'  step=0.0001  min=0 onBlur="if(this.value==''){this.value='0'};"  class="form-control" required>
					</div>
					<div class="col campos col-md-1">
						<label>ML</label>
						<input style='background-color: #d3d3d3' type="text" ng-model='item.ml' ng-readonly="true" name='mls[]'  step=0.0001  min=0 onBlur="if(this.value==''){this.value='0'};"   class="form-control" required>
					</div>
					<div class="col col-md-1">
						<label>&nbsp;</label>
						<button  type='button' ng-click="calcularML(item.item,$index)" class="btn btn-primary btn-sm btn-block"><b><i class="fa fa-calculator"></i></b></button>
					</div>
					
					<div class="col col-md-1">
						<label>&nbsp;</label>
						<button  type='button' ng-click="inserir(item)" class="btn btn-success btn-sm btn-block"><b><i class="fa fa-plus"></i></b></button>
					</div>

					<div class="col col-md-1">
						<label>&nbsp;</label>
						<button type='button' ng-click="remover(item,$index)" class="btn btn-danger btn-sm btn-block"><b><i class="fa fa-minus"></i></b></button>
					</div><br>
				</div><br>
				<div class="row">
					<div class="col col-md-2">
						<button ng-click="calcularTudo()" type='button' class="btn btn-primary btn-block">Calcular Tudo</button>
					</div>
					<div class="col col-md-8"></div>
					<div class="col col-md-2">
						<button type='submit' target='_blank' class="btn btn-primary btn-block">Salvar</button>
					</div>
				</div>
			</form>
			</div><!-- FIM INFO CLIENTE VIA JAVASCRIPT-->
		</div>
	</div>
@endsection
