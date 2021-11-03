@extends('commons.template')

@section('conteudo')

		
	<!-- OVERVIEW -->
	<div class="panel panel-headline">
		<div class="panel-heading">
			<h3 class="panel-title">Margens Pedidos</h3>
		</div>
		<div class="panel-body">
			<form action='/margem_pedidos' method="GET">
			<div class="row">
				<div class="col col-md-2">							<label>Data Inicial</label>
					<input type="date" name='dt_inicial'
					value="{{$filtros['dt_inicial'] ?? NULL}}"
					class="form-control">
				</div>
				<div class="col col-md-2">
						<label>Data Final</label>
						<input type="date" name='dt_final'
						value="{{$filtros['dt_final'] ?? NULL}}" class="form-control">
				</div>
				<div class="col col-md-2">
					<label>Num Pedido</label>
						<input type="text" value="{{$filtros['num_pedido'] ?? NULL}}" name='num_pedido' class="form-control">
				</div>
				<div class="col col-md-2">
					@php
					@endphp
					<label>Status</label>
					<select name="pos" class="form-control">
						<option value="Atendido" @if($filtros['pos'] == 'Atendido') selected @endif>Atendido</option>
						<option value="Pendente"  @if($filtros['pos'] == 'Pendente') selected @endif>Pendente</option>
					</select>
				</div>
				<div class="col col-md-2">
					<label>Abaixo de ML(%)</label>
						<input type="number" value="{{$filtros['ml'] ?? NULL}}" name='ml' class="form-control">
				</div>
				<div class="col col-md-2">
					<br>
					<button type='submit' class="btn btn-primary btn-block">Filtrar</button>
				</div>
			</div>
			</form>
			<br><br>
			<div class="row">
				<div class="col col-md-12" >
					@foreach ($pedidos as $key => $pedido)
						<div style='border:solid 1px;border-color: #d3d3d3;padding: 3px;border-radius: 10px; margin: 5px;{{$key%2 == 0 ? "background-color: #d3d3d3" : "" }}'>
							<div class="row" data-toggle="collapse" data-target="#collapse{{$pedido['num_pedido']}}" aria-expanded="true"  class="card-header">
							<div class="col col-md-2">
								<a style='color: #676a6d;'>
									<h4 style='margin-left: 15px;'>{{$pedido['num_pedido']}} - {{$pedido['pos']}}</h4>
								</a>
							</div>
							<div class="col col-md-6">
								<h4>{{$pedido['cliente']}}</h4>
							</div>
							<div class="col col-md-2">
								<h4>{{$pedido['dt_fat']}}</h4>
							</div>
							<div class="col col-md-2">
								<h4>{{number_format($pedido['vlr_liq'],2,',','.')}}</h4>
							</div>
							</div>
						<div style='margin: 10px;' id="collapse{{$pedido['num_pedido']}}" class="collapse" >
							<table class="table table-bordered table-hover  menor myTable" style='background-color: white'>
								<thead>
									<tr>
										<th>Item</th>
										<th>Mascara</th>
										<th class='center'>Valor Uni</th>
										<th class='center'>Qtde</th>
										<th class='center'>Comissão Fat</th>
										
										<th class='texto-azul center'>Custo Atual</th>
										<th 
										<th class='texto-azul center'>Margem Atual</th>
										<th class='texto-verde center'>Custo Futuro</th>
										<th class='texto-verde center'>Margem Futura</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($pedido['itens'] as $item)
										
									
									<tr>
										<td style="width: 30%">{{$item->cod_item}}-{{$item->item}}</td>
										<td>{{$item->mascara}}</td>
										<td class='center'>{{number_format(($item->vlr_ft_item),2,',','.')}}</td>
										<td class='center'>{{$item->qtde}}</td>
										<td class='center'>
											{{$item->perc_comis}}%
										</td>
										
										<td class='texto-azul center'>{{number_format($item->custo_atual,2,',','.')}}</td>
										<td data-toggle="tooltip" data-placement="top" 
										title="{{$item->margem_atual_label}}" class=' texto-azul center'>{{number_format($item->margem_atual,2,',','.')}}%</td>
										<td 
										class='texto-verde center'>{{number_format($item->custo_futuro,2,',','.')}}</td>
										<td 
										data-toggle="tooltip" data-placement="top" 
										title="{{$item->margem_futuro_label}}"
										class='texto-verde center'>{{number_format($item->margem_futuro,2,',','.')}}%</td>
									</tr>

									@endforeach
								</tbody>
							</table>
						</div>

					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
			$(document).ready( function () {
				$('.myTable').DataTable({
					"pageLength": 1000
					,"order": [[ 8, "asc" ]]
					,"searching": false
					,"paging": false
					,"info":  false
				});
			} );
	</script>
@endpush