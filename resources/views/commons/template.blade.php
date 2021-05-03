<!doctype html>
<html lang="pt-br">

<head>
	<title>Custos</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/linearicons/style.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/datatables.net-dt/css/jquery.dataTables.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap4-toggle/css/bootstrap4-toggle.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/card_upload.css')}}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/main.css')}}?{{date("YmdHis")}}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{asset('assets/css/demo.css')}}">
	
     @stack('styles')
</head>
{{-- class="layout-fullwidth" --}}
<body @yield('tela_inteira') > 
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand brand-modificado">
				<a href="/"><img src="{{asset('assets/img/logo.png')}}" alt="Klorofil Logo" class="img-responsive logo logo-modificado"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					{{-- <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button> --}}
                </div>
                {{-- Area de Pesquisa --}}
				{{-- <form class="navbar-form navbar-left">
					<div class="input-group">
						<input type="text" value="" class="form-control" placeholder="Search dashboard...">
						<span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
					</div>
				</form> --}}
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
                        {{-- Area de Notificações --}}
						{{-- <li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger">5</span>
							</a>
							<ul class="dropdown-menu notifications">
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-danger"></span>You have 9 unfinished tasks</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Monthly report is available</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Weekly meeting in 1 hour</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Your request has been approved</a></li>
								<li><a href="#" class="more">See all notifications</a></li>
							</ul>
						</li> --}}
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('assets/img/semfotocircular.png')}}" class="img-circle" alt="Avatar"> <span>
							{{ $_SESSION['usuario_custos']}}
						</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a data-toggle="modal" 
                                data-target="#modalSenha_template" 
                                onclick="mostrarModalSenha_template(event)"
								data-item-senha-id=
								{{$_SESSION['id_custos']}}
								>
								<i class="fa fa-key"></i> <span>Mudar Senha</span></a></li>
								<li><a href="/logout"><i class="lnr lnr-exit"></i> <span>Sair</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="/" @if(Route::current()->uri() == '/') class="active" @endif><i class="lnr lnr-home"></i> <span>Pagina Inicial</span></a></li>

						<li><a href="materias_primas" @if(Route::current()->uri() == 'materias_primas') class="active" @endif><i class="fa fa-cube"></i> <span>Materias Primas</span></a></li>

						<li><a href="custo_item_comercial" @if(Route::current()->uri() == 'custo_item_comercial') class="active" @endif><i class="fa fa-money"></i> <span>Custo Item Comercial</span></a></li>
						<li><a href="margem_lucro" @if(Route::current()->uri() == 'margem_lucro') class="active" @endif><i class="fa fa-bar-chart"></i> <span>Margens de Lucro</span></a></li>
						<li><a href="avaliacao_custo" @if(Route::current()->uri() == 'avaliacao_custo') class="active" @endif><i class="fa fa-line-chart"></i> <span>Avaliação Vlr de Compra</span></a></li>
						
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					@if (\Session::has('error'))
						<div class="alert alert-danger alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button>	
								<strong>{!! \Session::get('error') !!}</strong>
						</div>
					@endif

					@if (\Session::has('sucesso'))
						<div class="alert alert-success alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button>	
								<strong>{!! \Session::get('sucesso') !!}</strong>
						</div>
					@endif
									
					@yield('conteudo')
                
                </div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
		</footer>
	</div>

	<div class="modal fade" id="modalSenha_template" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Mudar Senhar</h4>
      </div>
      <div class="modal-body">
          <div class="row">
              <form action="/mudar_senha" method="post" onsubmit="onAddOperator(event)">
              @csrf
              @method('patch')
               <input type="hidden" id='item-senha-id' name='id' class='form-control'>
			  <div class="col col-md-4">
                  <label>Senha Atual</label>
                 
                   <input type="password" type="text" name='senha_atual' class='form-control' required>
              </div>
			   <div class="col col-md-4">
                  <label>Nova Senha</label>
                 
                   <input type="password" type="text" name='senha' class='form-control' required>
              </div>
              <div class="col col-md-4">
                  <label>Confirmar Nova Senha</label>
                  <input type="password"  name='confirmar_senha' class='form-control' required>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-info">Alterar</button>
      </form>
      </div>
    </div>
  </div>
</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="{{url('assets/vendor/jquery/jquery.min.js')}}"></script>
	<script src="{{url('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{url('assets/vendor/datatables.net/js/jquery.dataTables.js')}}"></script>
	<script src="{{url('assets/vendor/bootstrap4-toggle/js/bootstrap4-toggle.min.js')}}"></script>
	<script src="{{url('assets/scripts/klorofil-common.js')}}"></script>
	<script src="{{url('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script>
		 function mostrarModalSenha_template(event) {
                const button = event.currentTarget
                const id = document.querySelector("#modalSenha_template #item-senha-id")
                id.value = button.getAttribute("data-item-senha-id")
            }
	</script>
    
     @stack('scripts')
</body>

</html>
