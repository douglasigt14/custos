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
									@foreach ($dados as $item)
									<tr>
											<td>{{$item->cod_item}}</td>
											<td>{{$item->desc_tecnica}}</td>
											<td>{{$item->dt_ent_data}}</td>

											<td>{{number_format($item->vlr_compra,4,',','.')}}</td>

											<td>{{number_format($item->custo_compra,4,',','.')}}</td>
											
											<td>{{number_format($item->vlr_frete,4,',','.')}}</td>
											
											<td>{{number_format($item->custo_frete,4,',','.')}}</td>

											<td>{{number_format($item->custo_tot_nf,4,',','.')}}</td>

											<td>{{$item->icms}}%</td>
											<td>{{$item->dt_repos}}</td>

											<td>{{number_format($item->custo_grav,4,',','.')}}</td>

											<td>{{is_numeric($item->trans) ? number_format($item->trans,4,',','.'): $item->trans}}</td>

											<td>{{number_format($item->qtde,2,',','.')}}</td>
										
									</tr>
									@endforeach
								</tbody>
							</table>
							@endif				
                        </div>
                    </div>
@endsection	