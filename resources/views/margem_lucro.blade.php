@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Margem de Lucro </h3>
						</div>
						<div class="panel-body">
							<table class="table table-hover table-striped menor myTable">
								<thead>
									<tr>
										<th>Cod</th>
										<th>Item</th>
										<th>Custo Atual</th>
										<th>Custo Futuro</th>
										<th>Margem de Lucro Atual</th>
										<th>Margem de Lucro Futuro</th>
										<th>Diferença</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($itens as $item)
										<tr>
											<td>{{$item->cod_item}}</td>
											<td>{{$item->descricao}}</td>
											<td class='texto-azul'>{{number_format($item->custo_manual,4,',','.')}}</td>
											<td class='texto-verde'>{{number_format($item->custo_focco,4,',','.')}}</td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
									@endforeach
								</tbody>
							</table>
                        </div>
                    </div>
@endsection	


@push('scripts')
		<script>
			 $(document).ready( function () {
                    $('.myTable').DataTable({
						"pageLength": 1000
						,"order": [[ 1, "asc" ]]
					});
                } );


				function mascara(o,f){
					v_obj=o
					v_fun=f
					setTimeout("execmascara()",1)
				}

				function execmascara(){
					v_obj.value=v_fun(v_obj.value)
				}

				function moeda(v){
					v=v.replace(/\D/g,"") // permite digitar apenas numero
					v=v.replace(/(\d{1})(\d{17})$/,"$1.$2") // coloca ponto antes dos ultimos digitos
					v=v.replace(/(\d{1})(\d{13})$/,"$1.$2") // coloca ponto antes dos ultimos 13 digitos
					v=v.replace(/(\d{1})(\d{10})$/,"$1.$2") // coloca ponto antes dos ultimos 10 digitos
					v=v.replace(/(\d{1})(\d{7})$/,"$1.$2") // coloca ponto antes dos ultimos 7 digitos
					v=v.replace(/(\d{1})(\d{1,4})$/,"$1,$2") // coloca virgula antes dos ultimos 4 digitos
					return v;
				}
		</script>
@endpush