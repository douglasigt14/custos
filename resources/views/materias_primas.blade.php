@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Matérias Primas - Cadastro</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<table class="table table-hover table-striped menor myTable">
									<thead>
										<tr>
											<th>Cod</th>
											<th>Item</th>
											<th class='center'>Dt. Atualz. Focco</th>
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
											<td class='center texto-verde'>{{$item->custo}}</td>
											<td id='EditarValor{{$item->cod_item}}' class='center texto-azul'>{{$item->custo_futuro}}</td>
											<td class='center'>{{$item->perc}}%</td>
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
						,"order": [[ 1, "asc" ]]
					});

					$('.myTable').on( 'click', 'tbody td:not(:first-child)', function (e) {
						editor.inline( this );
					} );
                } );

				@foreach ($itens as $item)
					$(function () {
						$("#EditarValor{{$item->cod_item}}").dblclick(function () {
							var conteudoOriginal = $(this).text();

							$(this).addClass("celulaEmEdicao");
							$(this).html("<input type='text' class='form-control' value='" + conteudoOriginal + "' />");
							$(this).children().first().focus();

							$(this).children().first().keypress(function (e) {
								if (e.which == 13) {
									var novoConteudo = $(this).val();
									$(this).parent().text(novoConteudo);
									$(this).parent().removeClass("celulaEmEdicao");


									let url = "{{asset('')}}";
									const URL_TO_FETCH = url+"ins_up_custo_futuro/{{$item->cod_item}}/"+novoConteudo;
									fetch(URL_TO_FETCH, {
										method: 'get' //opcional 
									})
									.then(function(response) { 
										// use a resposta 
									})
									.catch(function(err) { 
										console.error(err); 
									});

								}

								

							});

						$(this).children().first().blur(function(){
							$(this).parent().text(conteudoOriginal);
							$(this).parent().removeClass("celulaEmEdicao");
						});
						});
				});
				@endforeach
		</script>
@endpush