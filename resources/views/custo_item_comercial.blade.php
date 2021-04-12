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
											<th>Item</th>
											<th>Nível</th>
											<th>Descrição</th>
											<th>UM</th>
											<th class="center">Quantidade</th>
											<th class="center">Valor</th>
										</tr>
									</thead>
									<tbody>
										<tr class="preto">
											<td>{{$itens[0]->codprodutopai ?? NULL }}</td>
											<td>0</td>
											<td>{{$itens[0]->descpai}}</td>
											<td>UN</td>
											<td class="center">1</td>
											<td class="center">{{$itens[0]->valor_pai}}</td>
										</tr>
										
										@foreach ($itens as $pai)
											<tr class='cinza-escuro'>
												<td>{{$pai->codproduto}}</td>
												<td><b>1</b></td>
												<td>{{$pai->descfilho}}</td>
												<td>UN</td>
												<td class="center">{{$pai->qtde}}</td>
												<td class="center">{{$pai->valor_filho}}</td>
											</tr>
											@php $cinza = true; @endphp
											@foreach ($pai->filhos as $filho)
											<tr @if($cinza) class='cinza' @endif>
												<td>{{$filho->codproduto}}</td>
												<td>2</td>
												<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$filho->descfilho}}</td>
												<td>UN</td>
												<td class="center">{{$filho->qtde}}</td>
												<td class="center">{{$filho->valor_filho*$filho->qtde}}</td>
											</tr>
												@foreach ($filho->filhos as $neto)
												<tr @if($cinza) class='cinza' @endif>
													<td>{{$neto->codproduto}}</td>
													<td>3</td>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$neto->descfilho}}</td>
													<td>UN</td>
													<td class="center">{{$neto->qtde}}</td>
													<td class="center">{{$neto->valor_filho}}</td>
												</tr>
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