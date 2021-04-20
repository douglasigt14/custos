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
								@if($_SESSION['is_admin_custos'])
								<a href='/avaliacao_custo' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-line-chart"></i></span>
										<p>
											<span class="number">&nbsp;</span>
											<span class="title">Avaliação Valor de Compra</span>
										</p>
									</div>
								</a>
								@endif
							</div>
							
                        </div>
                    
                    
                            </div>
					<!-- END OVERVIEW -->
	

       
            
@endsection	
