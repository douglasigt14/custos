@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Matérias Primas - Cadastro</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col col-md-8"></div>
								<div class="col col-md-2">
									<form action="" method="post">
										@csrf
										@method('delete')
										{{-- <button type='submit' class="btn btn-primary btn-block">Igualar Valores</button> --}}
									</form>
								</div>
								<div class="col col-md-2">
									<a target='_blank' href='relatorios/rel_itens_reajustados' class="btn btn-primary">Itens Reajustados</a>
								</div>
							</div>
							<br>
							<div class="row">
								<table class="table table-hover table-striped menor myTable">
									<thead>
										<tr>
											<th>Cod</th>
											<th>Item</th>
											<th>Fornecedor</th>
											<th class='center'>Dt. Atualz. Focco</th>
											<th class='center'>Unid. Med.</th>
											
											<th class='center'>Custo Atual</th>
											<th class='center'>Custo Futuro</th>
											<th class='center'>Perc. (%)</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($itens as $item)
										<tr>
											<td>{{$item->cod_item}}</td>
											<td>{{$item->desc_tecnica}}</td>
											<td class='EditarValorFor' id='EditarValorFor{{$item->cod_item}}'>{{$item->fornecedor}}</td>
											<td class='center'>{{date("d/m/Y", strtotime($item->dt_atualiza))}}</td>
											<td class='center'>{{$item->unid_med}}</td>
											<td id='EditarValor{{$item->cod_item}}' class='center texto-azul'>{{$item->custo_futuro}}</td>
											
											<td class='center texto-verde'>{{$item->custo}}</td>
											
											<td id='Perc{{$item->cod_item}}' class='center {{$item->cor_perc}}'>{{$item->perc}}%</td>
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
						,"paging": false
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

				var datalist = "<datalist id='fors'>";
							@foreach ($fornecedores as $for)
								datalist = datalist+"<option value='{{$for->descricao}}'>"; 
							@endforeach
							datalist = datalist+'</datalist>';

				@foreach ($itens as $item)
					$(function () {
						$("#EditarValor{{$item->cod_item}}").dblclick(function () {
							var conteudoOriginal = $(this).text();
							let evento = "mascara(this,moeda)";
							$(this).addClass("celulaEmEdicao");
							$(this).html("<input onKeyPress="+evento+" type='text' class='form-control' value='"+conteudoOriginal+ "' />");
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

									let custo_focco = "{{$item->custo}}";
									let custo_futuro = novoConteudo;

									custo_focco = custo_focco.toString().replace(",",".");
									custo_futuro = custo_futuro.toString().replace(",",".");
									custo_focco = parseFloat(custo_focco);
									custo_futuro = parseFloat(custo_futuro);
									

									let perc = (custo_focco/custo_futuro  *100)-100;

									perc =   perc.toFixed(2); 
									let cor = '';
									if(perc > 0 ){
										cor = '#A52A2A';
									}
									else if (perc < 0) {
										cor = 'green';
									}	
									else{
										cor = '#676a6d';
									}	
									var oldstr=  perc.toString();  
									perc  = oldstr.toString().replace(".",",");

									document.getElementById('Perc{{$item->cod_item}}').innerHTML = perc+'%';

									document.getElementById('Perc{{$item->cod_item}}').style.color = cor;

								}

								

							});

						$(this).children().first().blur(function(){
							$(this).parent().text(conteudoOriginal);
							$(this).parent().removeClass("celulaEmEdicao");
						});
						});
				});

				$(function () {
						$("#EditarValorFor{{$item->cod_item}}").dblclick(function () {
							

							var conteudoOriginal = $(this).text();
							$(this).addClass("celulaEmEdicao");
							$(this).html("<input type='text' class='form-control' value='" + conteudoOriginal + "' />");
							$(this).children().first().focus();

							$(this).children().first().keypress(function (e) {
								if (e.which == 13) {
									var novoConteudo = $(this).val();
									$(this).parent().text(novoConteudo);
									$(this).parent().removeClass("celulaEmEdicao");

									if(!novoConteudo){
										novoConteudo= "0";
									}
									let url = "{{asset('')}}";
									const URL_TO_FETCH = url+"ins_up_fornecedor/{{$item->cod_item}}/"+novoConteudo;
									fetch(URL_TO_FETCH, {
										method: 'get' //opcional 
									})
									.then(function(response) { 
										// use a resposta 
									})
									.catch(function(err) { 
										console.error(err); 
									});

									let custo_focco = "{{$item->custo}}";
									let custo_futuro = novoConteudo;

									custo_focco = custo_focco.toString().replace(",",".");
									custo_futuro = custo_futuro.toString().replace(",",".");
									custo_focco = parseFloat(custo_focco);
									custo_futuro = parseFloat(custo_futuro);
									

									let perc = (custo_focco/custo_futuro  *100)-100;

									perc =   perc.toFixed(2); 
									let cor = '';
									if(perc > 0 ){
										cor = '#A52A2A';
									}
									else if (perc < 0) {
										cor = 'green';
									}	
									else{
										cor = '#676a6d';
									}	
									var oldstr=  perc.toString();  
									perc  = oldstr.toString().replace(".",",");

									document.getElementById('Perc{{$item->cod_item}}').innerHTML = perc+'%';

									document.getElementById('Perc{{$item->cod_item}}').style.color = cor;

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