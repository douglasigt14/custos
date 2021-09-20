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
									class="form-control">
								</div>
								<div class="col col-md-3">
									 <label>Data Final</label>
									 <input type="date" name='dt_final'
									 value="{{$filtros['dt_final'] ?? NULL}}" class="form-control">
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
										<div style='border:solid 1px;border-color: #d3d3d3'>
											<a style='color:black' data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="card-header" id="headingOne">
												<h3>{{$pedido['num_pedido']}}</h3>
											</a>
										
										<div id="collapseOne" class="collapse" aria-labelledby="headingOne">
											
										</div>

									</div>
									@endforeach
								</div>
							</div>
                        </div>
                    </div>
@endsection	