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
								<div class="col col-md-3">							<label>Data Inicial</label>
									<input type="date" name='dt_inicial'
									value="{{$filtros['dt_inicial'] ?? NULL}}"
									class="form-control" required>
								</div>
								<div class="col col-md-3">
									 <label>Data Final</label>
									 <input type="date" name='dt_final'
									 value="{{$filtros['dt_final'] ?? NULL}}" class="form-control" required>
								</div>
								<div class="col col-md-2">
									<label>Num Pedido</label>
									 <input type="text" value="{{$filtros['num_pedido'] ?? NULL}}" name='num_pedido' class="form-control">
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
											<div class="col col-md-6">
												<a style='color: #676a6d;'>
													<h4 style='margin-left: 15px;margin-top: 5px;margin-bottom: 5px;'>{{$pedido['num_pedido']}}</h4>
												</a>
											</div>
											<div class="col col-md-6">
												<h4 style='margin-top: 5px;margin-bottom: 5px;'>{{$pedido['dt_fat']}}</h4>
											</div>
											</div>
										<div style='margin: 10px;' id="collapse{{$pedido['num_pedido']}}" class="collapse" >=
											<table class="table table-bordered table-hover  menor myTable" style='background-color: white'>
												<thead>
													<tr>
														<th>Item</th>
														<th>Mascara</th>
														<th class='center'>Valor Uni</th>
														<th class='center'>Qtde</th>
														<th class='center'>Comissão Fat</th>
														
														<th class='center'>Custo Atual</th>
														<th 
														<th class='center'>Margem Atual</th>
														<th class='center'>Custo Futuro</th>
														<th class='center'>Margem Futura</th>
													</tr>
												</thead>
												<tbody>
													@foreach ($pedido['itens'] as $item)
														
													
													<tr>
														<td>{{$item->item}}</td>
														<td>{{$item->mascara}}</td>
														<td class='center'>{{number_format(($item->vlr_ft_item/$item->qtde),2,',','.')}}</td>
														<td class='center'>{{$item->qtde}}</td>
														<td class='center'>
															{{$item->perc_comis}}%
														</td>
														
														<td class='center'>{{number_format($item->custo_atual,2,',','.')}}</td>
														<td class='center'>{{number_format($item->margem_atual,2,',','.')}}%</td>
														<td class='center'>{{number_format($item->custo_futuro,2,',','.')}}</td>
														<td class='center'>{{number_format($item->margem_futuro,2,',','.')}}%</td>
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