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
									@foreach ($pedidos as $pedido)
										<div style='border:solid 1px;border-color: #d3d3d3;padding: 7px;'>
											<div class="row">
											<div class="col col-md-6">
												<a style='color:black' data-toggle="collapse" data-target="#collapse{{$pedido['num_pedido']}}" aria-expanded="true"  class="card-header">
													<h3>{{$pedido['num_pedido']}}</h3>
												</a>
											</div>
											<div class="col col-md-6">
												<h3>{{$pedido['dt_emis']}}</h3>
											</div>
											</div>
										<div id="collapse{{$pedido['num_pedido']}}" class="collapse" >
											<table class="table table-hover table-striped menor myTable">
												<thead>
													<tr>
														<th>Item</th>
														<th class='center'>Valor</th>
														<th class='center'>Custo Atual</th>
														<th class='center'>Custo Futuro</th>
													</tr>
												</thead>
												<tbody>
													@foreach ($pedido['itens'] as $item)
														
													
													<tr>
														<td>{{$item->item}}</td>
														<td class='center'>{{number_format($item->valor,2,',','.')}}</td>
														<td class='center'></td>
														<td class='center'></td>
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