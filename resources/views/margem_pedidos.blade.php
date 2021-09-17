@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Margens Pedidos</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col col-md-3">							<label>Data Inicial</label>
									<input type="date" name='dt_inicial' class="form-control">
								</div>
								<div class="col col-md-3">
									 <label>Data Final</label>
									 <input type="date" name='dt_final' class="form-control">
								</div>
								<div class="col col-md-2">
									<label>Num Pedido</label>
									 <input type="text" name='num_pedido' class="form-control">
								</div>
								<div class="col col-md-2">
									<label>Abaixo de ML(%)</label>
									 <input type="text" name='ml' class="form-control">
								</div>
								<div class="col col-md-2">
									<br>
									<button type='submit' class="btn btn-primary btn-block">Filtrar</button>
								</div>
							</div>
							
                        </div>
                    </div>
@endsection	