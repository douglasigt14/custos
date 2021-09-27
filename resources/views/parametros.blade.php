@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Parâmetros</h3>
						</div>
						<div class="panel-body">
							<form action='/parametros' method="POST">
								@csrf
								<div class="row">
									<div class="col col-md-3">
										<label> % Ultilizada em Roupeiros</label>
										<input class='form-control' type='number' min=0 name="parametro_ml_roupeiros">
									</div>
									<div class="col col-md-2">
										<br>
										<button type='submit' class="btn btn-primary btn-block">Salvar</button>
									</div>
								</div>
							</form>
							
                        </div>
                    </div>
@endsection	