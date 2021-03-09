@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Matérias Primas</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<table class="table table-striped myTable">
									<thead>
										<tr>
											<th>Cod</th>
											<th>Item</th>
											<th class='center'>Data Atualiza</th>
											<th class='center'>Unid. Med.</th>
											
											<th class='center'>Custo Focco</th>
											<th class='center'>Custo Futuro</th>
											<th class='center'>Perc. (%)</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($itens as $item)
										<tr>
											<td>{{$item->cod_item}}</td>
											<td>{{$item->desc_tecnica}}</td>
											
											<td class='center'>{{date("d/m/Y", strtotime($item->dt_atualiza))}}</td>
											<td class='center'>{{$item->unid_med}}</td>
											<td class='center texto-verde'>{{number_format($item->valor,4,',','.')}}</td>
											<td class='center texto-azul'>{{number_format($item->valor,4,',','.')}}</td>
											<td class='center'>0%</td>
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
						"pageLength": 1000
					});
                } );
		</script>
@endpush