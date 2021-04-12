@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Custo Item Comercial</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<table class="table table-hover table-striped menor">
									<thead>
										<tr>
											<th>Item</th>
											<th>Nível</th>
											<th>Descrição</th>
											<th>UM</th>
											<th>Quantidade</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>{{$itens[0]->codprodutopai ?? NULL }}</td>
											<td>0</td>
											<td>{{$itens[0]->codprodutopai}}</td>
											<td>UNX</td>
										</tr>
										@foreach ($itens as $item)
											<tr>
												<td>{{$item->codproduto}}</td>
												<td>1</td>
												<td>{{$item->descfilho}}</td>
												<td>UN</td>
											</tr>
											<tr class='cinza'>
												<td colspan="100%">&nbsp;</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
                        </div>
                    </div>
@endsection	


@push('scripts')
		<script>
			 $(document).ready( function () {
                    $('.myTable').DataTable({
						"pageLength": 10
					});
                } );
		</script>
@endpush