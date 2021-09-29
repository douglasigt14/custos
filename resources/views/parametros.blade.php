@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Parâmetros</h3>
						</div>
						<div class="panel-body">
							@foreach ($parametros as $parametro)
							<div class="row">
							<form action='/parametros' method="POST">
								@csrf
								<input type="hidden" name="id" value='{{$parametro->id}}'>
								
									<div class="col col-md-3">
										<label> {{$parametro->desc}}</label>
										<input value='{{$parametro->valor}}' class='form-control' type='text' name="valor">
									</div>
									<div class="col col-md-2">
										<br>
										<button type='submit' class="btn btn-primary btn-block">Salvar</button>
									</div>
								</div>
							</form>
							<br>
							@endforeach
                        </div>
                    </div>
@endsection	