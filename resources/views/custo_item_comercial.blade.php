@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Custo Item Comercial</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<table class="table menor">
									<thead>
										<tr>
											<th>ITEM</th>
											<th>Descrição</th>
											<th>COR</th>
											<th>UM</th>
											<th class="center">QTDE</th>
											<th class="center" colspan="3">CUSTO FOCCO</th>
											<th class="center" colspan="3">CUSTO MAN.</th>
										</tr>
									</thead>
									<tbody>
										@if ($itens)
											<tr class="preto">
												<td>{{$itens[0]->codprodutopai ?? NULL }}</td>
												<td>0-{{$itens[0]->descpai}}</td>
												<td>{{$itens[0]->corpai}}</td>
												<td>UN</td>
												<td class="center">{{number_format(1,4,',','.')}}</td>
												<td class="center texto-verde">{{number_format($itens[0]->valor_pai,4,',','.')}}</td>
												<td class="center texto-verde">{{number_format($itens[0]->valor_pai,4,',','.')}}</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
										@endif
										@foreach ($itens as $pai)
											<tr class='cinza-escuro perc-aumento'>
												<td>{{$pai->codproduto}}</td>
												<td>1-{{$pai->descfilho}}</td>
												<td>{{$pai->corfilho}}</td>
												<td>{{$pai->uni}}</td>
												<td class="center">{{number_format($pai->qtde,4,',','.')}}</td>
												<td class="center texto-verde">{{number_format($pai->valor_filho,4,',','.')}}</td>
												<td class="center texto-verde">{{number_format($pai->valor_filho*$pai->qtde,4,',','.')}}</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
									@php $cinza = true; @endphp
									@foreach ($pai->filhos as $filho)
									<tr @if($cinza) class='cinza' @endif>
										<td>{{$filho->codproduto}}</td>
										<td>2-{{$filho->descfilho}}</td>
										<td>{{$filho->corfilho}}</td>
										<td>{{$filho->uni}}</td>
										<td class="center">{{number_format($filho->qtde,4,',','.')}}</td>
										<td class="center texto-verde">{{number_format($filho->valor_filho,4,',','.')}}</td>
										<td class="center texto-verde">{{number_format($filho->valor_filho*$filho->qtde,4,',','.')}}</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
							</tr>
								@foreach ($filho->filhos as $neto)
								<tr @if($cinza) class='cinza' @endif>
									<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$neto->codproduto}}</td>
									<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3-{{$neto->descfilho}}</td>
									<td>{{$neto->corfilho}}</td>
									<td>{{$neto->uni}}</td>
									<td class="center">{{number_format($neto->qtde,4,',','.')}}</td>
									<td class="center texto-verde">{{number_format($neto->valor_filho,4,',','.')}}</td>
									<td class="center texto-verde">{{number_format($neto->valor_filho*$neto->qtde,4,',','.')}}</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
									@foreach ($neto->filhos as $bisneto)
									<tr @if($cinza) class='cinza' @endif>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$bisneto->codproduto}}</td>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4-{{$bisneto->descfilho}}</td>
										<td>{{$bisneto->corfilho}}</td>
										<td>{{$bisneto->uni}}</td>
										<td class="center">{{number_format($bisneto->qtde,4,',','.')}}</td>
										<td class="center texto-verde">{{number_format($bisneto->valor_filho,4,',','.')}}</td>
										<td class="center texto-verde">{{number_format($bisneto->valor_filho*$bisneto->qtde,4,',','.')}}</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									@foreach ($bisneto->filhos as $tataraneto)
									<tr @if($cinza) class='cinza' @endif>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$tataraneto->codproduto}}</td>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5-{{$tataraneto->descfilho}}</td>
										<td>{{$tataraneto->corfilho}}</td>
										<td>{{$tataraneto->uni}}</td>
										<td class="center">{{number_format($tataraneto->qtde,4,',','.')}}</td>
										<td class="center texto-verde">{{number_format($tataraneto->valor_filho,4,',','.')}}</td>
										<td class="center texto-verde">{{number_format($tataraneto->valor_filho*$tataraneto->qtde
											*$bisneto->qtde
											*$neto->qtde
											*$filho->qtde
											*$pai->qtde,4,',','.')}}</td>
										<td class="center texto-verde"></td>
										<td class="center texto-azul">{{number_format($tataraneto->custo_futuro,4,',','.')}}</td>
										<td class="center texto-azul">{{number_format($tataraneto->custo_futuro*$tataraneto->qtde
											*$bisneto->qtde
											*$neto->qtde
											*$filho->qtde
											*$pai->qtde,4,',','.')}}</td>
										<td class="center texto-azul"></td>
									</tr>
									@endforeach
									@endforeach
								@endforeach
								
								@php $cinza = $cinza ? false : true; 
								@endphp
							@endforeach

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