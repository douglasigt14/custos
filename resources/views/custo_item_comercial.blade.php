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
											<th>NÍVEL</th>
											<th>Descrição</th>
											<th>COR</th>
											<th>UM</th>
											<th class="center">QTDE</th>
											<th class="center">CUSTO MAT</th>
										</tr>
									</thead>
									<tbody>
										<tr class="preto">
											<td>{{$itens[0]->codprodutopai ?? NULL }}</td>
											<td>0</td>
											<td>{{$itens[0]->descpai}}</td>
											<td>{{$itens[0]->corpai}}</td>
											<td>UN</td>
											<td class="center">1</td>
											<td class="center">{{number_format($itens[0]->valor_pai,4,',','.')}}</td>
										</tr>
										
										@foreach ($itens as $pai)
											<tr class='cinza-escuro'>
												<td>{{$pai->codproduto}}</td>
												<td><b>1</b></td>
												<td>{{$pai->descfilho}}</td>
												<td>{{$pai->corfilho}}</td>
												<td>UN</td>
												<td class="center">{{$pai->qtde}}</td>
												<td class="center">{{number_format($pai->valor_filho,4,',','.')}}</td>
											</tr>
											@php $cinza = true; @endphp
											@foreach ($pai->filhos as $filho)
											<tr @if($cinza) class='cinza' @endif>
												<td>{{$filho->codproduto}}</td>
												<td>2</td>
												<td>{{$filho->descfilho}}</td>
												<td>{{$filho->corfilho}}</td>
												<td>UN</td>
												<td class="center">{{$filho->qtde}}</td>
												<td class="center">{{number_format($filho->valor_filho,4,',','.')}}</td>
											</tr>
												@foreach ($filho->filhos as $neto)
												<tr @if($cinza) class='cinza' @endif>
													<td>{{$neto->codproduto}}</td>
													<td>3</td>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$neto->descfilho}}</td>
													<td>{{$neto->corfilho}}</td>
													<td>UN</td>
													<td class="center">{{$neto->qtde}}</td>
													<td class="center">{{number_format($neto->valor_filho,4,',','.')}}</td>
												</tr>
													@foreach ($neto->filhos as $bisneto)
													<tr @if($cinza) class='cinza' @endif>
														<td>{{$bisneto->codproduto}}</td>
														<td>4</td>
														<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$bisneto->descfilho}}</td>
														<td>{{$bisneto->corfilho}}</td>
														<td>UN</td>
														<td class="center">{{$bisneto->qtde}}</td>
														<td class="center">{{number_format($bisneto->valor_filho,4,',','.')}}</td>
													</tr>
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