@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Avaliação do Vlr Compra x Vlr Reposição </h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col col-md-3">
									<input type="date" name="dt_inicial" class="form-control">
								</div>
								<div class="col col-md-3">
									<input type="date" name="dt_final"  class="form-control">
								</div>
								<div class="col col-md-2">
									<button type='submit' class="btn btn-primary">Buscar</button>
								</div>
								<div class="col col-md-4"></div>
							</div>
							<div class="row">
								<div class="col md-12">
									<table class="table table-hover menor myTable">
										<thead>
											<tr>
												
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</div>
							</div>
							
                        </div>
                    </div>
@endsection	