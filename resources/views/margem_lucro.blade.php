@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Margem de Lucro </h3>
						</div>
						<div class="panel-body">
							<table class="table table-hover menor myTable">
								<thead>
									<tr>
										<th colspan="3"></th>
										<th colspan="3" class='center cinza'>COMISSÃO DE 5%</th>
										<th colspan="3" class='center'>COMISSÃO DE 4%</th>
										<th colspan="3" class='center cinza'>COMISSÃO DE 3%</th>
									</tr>
									<tr>
										<th>COD</th>
										<th>ITEM</th>
										<th>CONFIG.</th>
										<th class='center cinza'>M. ATUAL</th>
										<th class='center cinza'>M. FUTURA</th>
										<th class='center cinza'>DIF.</th>
										<th class='center'>M. ATUAL</th>
										<th class='center'>M. FUTURA</th>
										<th class='center'>DIF.</th>
										<th class='center cinza'>M. ATUAL</th>
										<th class='center cinza'>M. FUTURA</th>
										<th class='center cinza'>DIF.</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($itens as $item)
										<tr>
											<td>{{$item->cod_item}}</td>
											<td><a class='preto-link' href="/custo_item_comercial?cod_item={{$item->cod_item}}&id_masc={{$item->id_masc}}">{{$item->descricao}}</a></td>
											<td>{{$item->cor}}</td>

											{{-- COMISSÃO DE 5 --}}

											<td 
											data-toggle="tooltip" data-placement="top" 
											title="(( 100-54.6-{{$item->custo_manual}}*100/{{$item->preco_com_5}})/100)*100"
											class='texto-azul center'>{{number_format($item->margem_manual_5,2,',','.')}}%</td>
											<td 
											data-toggle="tooltip" data-placement="top" 
											title="(( 100-54.6-{{$item->custo_focco}}*100/{{$item->preco_com_5}})/100)*100"
											class='texto-verde center'>{{number_format($item->margem_focco_5,2,',','.')}}%</td>
											<td class='center'>{{number_format($item->margem_focco_5-$item->margem_manual_5,2,',','.')}}%</td>

											{{-- COMISSÃO DE 4 --}}
											<td 
											data-toggle="tooltip" data-placement="top" 
											title="(( 100-54.6-{{$item->custo_manual}}*100/{{$item->preco_com_4}})/100)*100"
											class='texto-azul center'>{{number_format($item->margem_manual_4,2,',','.')}}%</td>
											<td 
											data-toggle="tooltip" data-placement="top" 
											title="(( 100-54.6-{{$item->custo_focco}}*100/{{$item->preco_com_4}})/100)*100"
											class='texto-verde center'>{{number_format($item->margem_focco_4,2,',','.')}}%</td>
											<td class='center'>{{number_format($item->margem_focco_4-$item->margem_manual_4,2,',','.')}}%</td>

											{{-- COMISSÃO DE 3 --}}
											<td 
											data-toggle="tooltip" data-placement="top" 
											title="(( 100-54.6-{{$item->custo_manual}}*100/{{$item->preco_com_3}})/100)*100"
											class='texto-azul center'>{{number_format($item->margem_manual_3,2,',','.')}}%</td>
											<td 
											data-toggle="tooltip" data-placement="top" 
											title="(( 100-54.6-{{$item->custo_focco}}*100/{{$item->preco_com_3}})/100)*100"
											class='texto-verde center'>{{number_format($item->margem_focco_3,2,',','.')}}%</td>
											<td class='center'>{{number_format($item->margem_focco_3-$item->margem_manual_3,2,',','.')}}%</td>


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