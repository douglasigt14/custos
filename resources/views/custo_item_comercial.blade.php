@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">CUSTO {{$itens[0]->descpai ?? NULL ? ': '.$itens[0]->descpai.' - '.$itens[0]->corpai : NULL }}</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<form action="">
									<div class="col col-md-3">
										<label>COD ITEM</label>
										<input class='form-control' list="itens" @if($cod_item) readonly = 'true' @endif name="cod_item" value='{{$cod_item}}' required ='true' autocomplete="off">
										<datalist id="itens">
											@foreach ($lista_itens as $item)
												<option value="{{$item->cod_item}}">{{$item->item}}</option>	
											@endforeach
										</datalist>
									</div>
									@if ($lista_cores)
									<div class="col col-md-3">
										<label for="itens">CONFIGURADO</label>
										<input class='form-control' list="cores" name="id_masc" value='{{$id_masc}}' required ='true' autocomplete="off">
										<datalist id="cores">
											@foreach ($lista_cores as $item)
												<option value="{{$item->id_cor}}">{{$item->cor}} - {{number_format($item->valor_mat,4,',','.')}}</option>	
											@endforeach
										</datalist>
									</div>
									@endif
									<div class="col col-md-2">
										<br>
										<button class="btn btn-primary" type='submit'>Buscar</button>
									</div>
									@if($cod_item)
									<div class="col col-md-2">
										<br>
										<a href='/custo_item_comercial' class="btn btn-danger" type='submit'>Trocar Item</a>
									</div>
									@endif
								</form>
							</div>
							<br>
							<div class="row">
								@if ($itens)
								<table class="table menor">
									<thead>
										<tr>
											<th>ITEM</th>
											<th>Descrição</th>
											<th>MASC</th>
											<th>UM</th>
											<th class="center">QTDE</th>
											<th class="center" colspan="3">CUSTO ATUAl</th>
											<th class="center" colspan="3">CUSTO FUTURO</th>
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
												
												<td></td>
												<td></td>
												<td class="center texto-azul-claro">{{number_format($custo_item_futuro,4,',','.')}}</td>
												<td></td>
												<td></td>
												<td class="center texto-verde">{{number_format($custo_item_focco,4,',','.')}}</td>
											</tr>
										@endif
										@foreach ($itens as $pai)
											<tr class='preto perc-aumento'>
												<td>{{$pai->codproduto}}</td>
												<td>1-{{$pai->descfilho}}</td>
												<td>{{$pai->corfilho}}</td>
												<td>{{$pai->uni}}</td>
												<td class="center">{{number_format($pai->qtde,4,',','.')}}</td>
												<td></td>
												<td></td>
												
												<td class="center texto-azul-claro"><b>{{
													$pai->custo_futuro_soma ?
												number_format($pai->custo_futuro_soma,4,',','.') : NULL}}</b></td>

												<td></td>
												<td></td>

												<td class="center texto-verde"><b>{{
													$pai->custo_focco_soma ?
												number_format($pai->custo_focco_soma,4,',','.') : NULL}}</b></td>

											</tr>
									@php $cinza = true; @endphp
									@foreach ($pai->filhos as $filho)
									<tr @if($cinza) class='cinza' @endif>
										<td>{{$filho->codproduto}}</td>
										<td><b>2-{{$filho->descfilho}}</b></td>
										<td>{{$filho->corfilho}}</td>
										<td>{{$filho->uni}}</td>

										<td class="center">{{number_format($filho->qtde,4,',','.')}}</td>
										
										<td></td>
										<td></td>
										<td class="center texto-azul"><b>{{
											$filho->custo_futuro_soma ?
										number_format($filho->custo_futuro_soma,4,',','.') : NULL}}</b></td>
										
										<td></td>

										<td></td>

										<td class="center texto-verde"><b>{{
											$filho->custo_focco_soma ?
										number_format($filho->custo_focco_soma,4,',','.') : NULL}}</b></td>
										
										
										
							</tr>
								@foreach ($filho->filhos as $neto)
								<tr @if($cinza) class='cinza' @endif>
									<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$neto->codproduto}}</td>
									<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3-{{$neto->descfilho}}</td>
									<td>{{$neto->corfilho}}</td>
									<td>{{$neto->uni}}</td>

									<td class="center">{{number_format($neto->qtde,4,',','.')}}</td>

									<td class="center texto-azul">{{
										$neto->custo_futuro ?
										number_format($neto->custo_futuro,4,',','.') : NULL}}</td>
										
										<td class="center texto-azul">{{
										$neto->custo_futuro ? 
										number_format($neto->custo_futuro
											*$neto->qtde
											*$filho->qtde
											*$pai->qtde,4,',','.') : NULL}}
										</td>
	
										<td class="center texto-azul"></td>

									<td @if($neto->valor_filho != $neto->custo_futuro) class='sublinhado-vermelho center texto-verde' @endif  class="center texto-verde">{{
									$neto->custo_futuro ? 
 									number_format($neto->valor_filho,4,',','.') : NULL}}</td>
									
									<td class="center texto-verde">
										{{
									$neto->custo_futuro ? 
									number_format($neto->valor_filho
										*$neto->qtde
										*$filho->qtde
										*$pai->qtde,4,',','.') : NULL}}
									</td>
									
									<td class="center texto-verde"></td>

									

								</tr>
									@foreach ($neto->filhos as $bisneto)
									<tr @if($cinza) class='cinza' @endif>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$bisneto->codproduto}}</td>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4-{{$bisneto->descfilho}}</td>
										<td>{{$bisneto->corfilho}}</td>
										<td>{{$bisneto->uni}}</td>

										<td class="center">{{number_format($bisneto->qtde,4,',','.')}}</td>

										<td class="center texto-azul">{{
											$bisneto->custo_futuro ?
											number_format($bisneto->custo_futuro,4,',','.') : NULL}}
											</td>
	
											<td class="center texto-azul">{{
											$bisneto->custo_futuro ? 
											number_format($bisneto->custo_futuro
												*$bisneto->qtde
												*$neto->qtde
												*$filho->qtde
												*$pai->qtde,4,',','.') : NULL}}
											</td>
											<td></td>
										<td @if($bisneto->valor_filho != $bisneto->custo_futuro) class='sublinhado-vermelho center texto-verde' @endif class="center texto-verde">{{
										$bisneto->custo_futuro ?
										number_format($bisneto->valor_filho,4,',','.') : NULL}}</td>

										<td class="center texto-verde">{{
										$bisneto->custo_futuro ?
										number_format($bisneto->valor_filho
											*$bisneto->qtde
											*$neto->qtde
											*$filho->qtde
											*$pai->qtde,4,',','.') : NULL}}
										</td>

										<td class="center texto-verde"></td>
										
										

										
									</tr>
									@foreach ($bisneto->filhos as $tataraneto)
									<tr @if($cinza) class='cinza' @endif>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$tataraneto->codproduto}}</td>
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5-{{$tataraneto->descfilho}}</td>
										<td>{{$tataraneto->corfilho}}</td>
										<td>{{$tataraneto->uni}}</td>

										<td class="center">{{number_format($tataraneto->qtde,4,',','.')}}</td>
										<td class="center texto-azul">{{number_format($tataraneto->custo_futuro,4,',','.')}}</td>

										<td class="center texto-azul">{{
										$tataraneto->custo_futuro ?
										number_format($tataraneto->custo_futuro*$tataraneto->qtde
											*$bisneto->qtde
											*$neto->qtde
											*$filho->qtde
											*$pai->qtde,4,',','.') : NULL}}
										</td>

										<td class="center texto-azul"></td>
										<td @if($tataraneto->valor_filho != $tataraneto->custo_futuro) class='sublinhado-vermelho center texto-verde' @endif class="center texto-verde">{{number_format($tataraneto->valor_filho,4,',','.')}}</td>

										<td class="center texto-verde">{{number_format($tataraneto->valor_filho*$tataraneto->qtde
											*$bisneto->qtde
											*$neto->qtde
											*$filho->qtde
											*$pai->qtde,4,',','.')}}
										</td>

										<td class="center texto-verde"></td>

										
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
								@endif
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