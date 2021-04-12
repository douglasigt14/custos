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
											<th class="center">CUSTO MAT</th>
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
												<td class="center">{{number_format($itens[0]->valor_pai,4,',','.')}}</td>
											</tr>
										@endif
										@foreach ($itens as $pai)
											<tr class='cinza-escuro'>
												<td>{{$pai->codproduto}}</td>
												<td>1-{{$pai->descfilho}}</td>
												<td>{{$pai->corfilho}}</td>
												<td>UN</td>
												<td class="center">{{number_format($pai->qtde,4,',','.')}}</td>
												<td class="center">{{number_format($pai->valor_filho,4,',','.')}}</td>
											</tr>
											@php $cinza = true; @endphp
											@foreach ($pai->filhos as $filho)
											<tr @if($cinza) class='cinza' @endif>
												<td>{{$filho->codproduto}}</td>
												<td>2-{{$filho->descfilho}}</td>
												<td>{{$filho->corfilho}}</td>
												<td>UN</td>
												<td class="center">{{number_format($filho->qtde,4,',','.')}}</td>
												<td class="center">{{number_format($filho->valor_filho,4,',','.')}}</td>
											</tr>
												@foreach ($filho->filhos as $neto)
												<tr @if($cinza) class='cinza' @endif>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$neto->codproduto}}</td>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3-{{$neto->descfilho}}</td>
													<td>{{$neto->corfilho}}</td>
													<td>UN</td>
													<td class="center">{{number_format($neto->qtde,4,',','.')}}</td>
													<td class="center">{{number_format($neto->valor_filho,4,',','.')}}</td>
												</tr>
													@foreach ($neto->filhos as $bisneto)
													<tr @if($cinza) class='cinza' @endif>
														<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$bisneto->codproduto}}</td>
														<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4-{{$bisneto->descfilho}}</td>
														<td>{{$bisneto->corfilho}}</td>
														<td>UN</td>
														<td class="center">{{number_format($bisneto->qtde,4,',','.')}}</td>
														<td class="center">{{number_format($bisneto->valor_filho,4,',','.')}}</td>
													</tr>
													@foreach ($bisneto->filhos as $tataraneto)
													<tr @if($cinza) class='cinza' @endif>
														<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$tataraneto->codproduto}}</td>
														<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5-{{$tataraneto->descfilho}}</td>
														<td>{{$tataraneto->corfilho}}</td>
														<td>UN</td>
														<td class="center">{{number_format($tataraneto->qtde,4,',','.')}}</td>
														<td class="center">{{number_format($tataraneto->valor_filho,4,',','.')}}</td>
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