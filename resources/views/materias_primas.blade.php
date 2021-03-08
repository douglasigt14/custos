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
											<th>Item</th>
											<th class='center'>Custo Atual</th>
											<th class='center'>Custo Reajuste</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($itens as $item)
										<tr>
											<td>{{$item->cod_item}}-{{$item->desc_tecnica}}</td>
											<td class='center'>{{number_format($item->valor,4,',','.')}}</td>
											<td class='center'>{{number_format($item->valor,4,',','.')}}</td>
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
						"pageLength": 100
					});
                } );
		</script>
@endpush