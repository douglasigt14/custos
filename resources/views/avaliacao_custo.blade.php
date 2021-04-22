@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Avaliação do Vlr Compra x Vlr Reposição </h3>
						</div>
						<div class="panel-body">
							<div class="row">
							  <form action="">
								<div class="col col-md-3">
									<label>Data de Entrada - Inicial</label>
									<input type="date" name="dt_inicial" class="form-control" required ='true'>
								</div>
								<div class="col col-md-3">
									<label>Data de Entrada - Final</label>
									<input type="date" name="dt_final"  class="form-control" required ='true'>
								</div>
								<div class="col col-md-2">
									<label>&nbsp;</label>
									<button type='submit' class="btn btn-primary btn-block">Buscar</button>
								</div>
								<div class="col col-md-4"></div>
							  </form>
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