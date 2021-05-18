<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatorio</title>
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}?{{date("YmdHis")}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <script type="text/javascript">
        function printpage()
          {
          window.print()
          }
    </script>
    
    @stack('styles')
</head>
<body onload="printpage()" class="preto-total">
    <div>
        <img class="img-logo-cabecario" src="{{asset('img/logo.png')}}" height="100" width="200">
        <div class="div-container-cabecario">
        <p class='titulo-cabecario'>TUBOARTE INDÚSTRIA E COMERCIO EIRELI</p>
        <p class='subtitulo-cabecario'>RUA 12 DE AGOSTO, S/Nº - BAIRRO NOVA BRASÍLIA</p>
        <p class='subtitulo-cabecario'>FONE: (88) 3522-8300 FAX: (88) 3522-8304</p>
        <p class='subtitulo-cabecario'>SITE: www.tuboarte.com.br</p></div><br><br>

        <center><p class='titulo-relatorio'>@yield('titulo')</p></center><br><br>

        @yield('conteudo')
    </div>
</body>
</html>
