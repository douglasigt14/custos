@extends('commons.template')

@section('conteudo')

		
                    <!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Custos</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<a href='/materias_primas' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-cube"></i></span>
										<p>
											<span class="number">{{$qtde->materias_primas}}</span>
											<span class="title">Materias Primas<br><br></span>
										</p>
									</div>
								</a>

								<a href='/custo_item_comercial' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-money"></i></span>
										<p>
											<span class="number">&nbsp;</span>
											<span class="title">Custo Item Comercial<br><br></span>
										</p>
									</div>
								</a>								
									
								
								<a href='/margem_lucro' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-bar-chart"></i></span>
										<p>
											<span class="number">&nbsp;</span>
											<span class="title">Margens de Lucro<br><br></span>
										</p>
									</div>
								</a>
								<a href='/avaliacao_custo' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-line-chart"></i></span>
										<p>
											<span class="number">&nbsp;</span>
											<span class="title">Avaliação Valor de Compra</span>
										</p>
									</div>
								</a>
								
							</div>
							<div class="row">
								<div data-toggle="modal" data-target="#modalPedidos" class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-line-chart"></i></span>
										<p>
											<span class="number">&nbsp;</span>
											<span class="title">Margens Pedidos</span>
										</p>
									</div>
								</div>

								<a href='/parametros' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-cogs"></i></span>
										<p>
											<span class="number">&nbsp;</span>
											<span class="title">Parâmetros</span>
										</p>
									</div>
								</a>
							</div>
							
                        </div>
                    
                    
                            </div>
					<!-- END OVERVIEW -->
	
<!-- Modal -->
<div class="modal fade" id="modalPedidos" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title">Margens Pedidos</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<form action='/margem_pedidos' method="GET">
		   <div class="row">
			   <div class="col col-md-1"></div>
			   <div class="col col-md-5">
				    <label>Data Inicial</label>
					<input type="date" name='dt_inicial' class="form-control" required>
			   </div>
			   <div class="col col-md-5">
				   <label>Data Final</label>
					<input type="date" name='dt_final' class="form-control" required>
			   </div>
			   <div class="col col-md-1"></div>
		   </div>
		</div>
		<div class="modal-footer">
		  <button type="submit" class="btn btn-secondary">Selecionar</button>
		</div>
	</form>
	  </div>
	</div>
</div>
       
            
@endsection	
