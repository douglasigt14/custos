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
											<th>Custo Atual</th>
											<th>Custo Reajuste</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
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