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
											<span class="title">Materias Primas</span>
										</p>
									</div>
								</a>

								<a href='/custo_item_comercial' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-money"></i></span>
										<p>
											<span class="number">&nbsp;</span>
											<span class="title">Custo Item Comercial</span>
										</p>
									</div>
								</a>								
									
								
								<a href='/margem_lucro' class="col-md-3 cinzinha">
									<div class="metric">
										<span class="icon"><i class="fa fa-bar-chart"></i></span>
										<p>
											<span class="number">&nbsp;</span>
											<span class="title">Margens de Lucro</span>
										</p>
									</div>
								</a>
								
							</div>
							
                        </div>
                    
                    
                            </div>
					<!-- END OVERVIEW -->
	

       
            
@endsection	
