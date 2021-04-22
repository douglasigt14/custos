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
									<input type="date" name="dt_inicial" class="form-control" value='{{$dt_inicial}}' required ='true'>
								</div>
								<div class="col col-md-3">
									<label>Data de Entrada - Final</label>
									<input type="date" name="dt_final"  class="form-control" required ='true' value='{{$dt_inicial}}'>
								</div>
								<div class="col col-md-2">
									<label>&nbsp;</label>
									<button type='submit' class="btn btn-primary btn-block">Buscar</button>
								</div>
								<div class="col col-md-4"></div>
							  </form>
							</div><br><br>

							@if($dados)
							<table class="table table-hover menor myTable">
								<thead>
									<tr>
										<th>COD ITEM</th>
										<th>DESC TECNICA</th>
										<th>DT ENT</th>
										<th>VLR COMPRA</th>
										<th>CUSTO COMPRA</th>
										<th>VLR FRETE</th>
										<th>CUSTO FRETE</th>
										<th>CUSTO TOT NF</th>
										<th>ICMS</th>
										<th>DT REPOS</th>
										<th>CUSTO GRAV</th>
										<th>TRANS</th>
										<th>QTDE</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										@foreach ($dados as $item)
											<td>{{$item->cod_item}}</td>
											<td>{{$item->desc_tecnica}}</td>
											<td>{{$item->dt_ent_data}}</td>
											<td>{{$item->vlr_compra}}</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										@endforeach
									</tr>
								</tbody>
							</table>
							@endif				
                        </div>
                    </div>
@endsection	