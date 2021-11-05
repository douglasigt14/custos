angular.module('App', [])
 					.controller('Controller', function($scope,$http) {
              
              // $interpolateProvider.startSymbol('[[');
              // $interpolateProvider.endSymbol(']]');

              $scope.titulo = 'Simulação Cotação';

              $scope.voltar = function(pagina){
                console.log(pagina);
								window.location.assign(pagina);
							};
	 	});
