angular.module('App', [])
 					.controller('Controller', function($scope,$http) {
              
              $scope.titulo = 'Simulação Cotação';

              $scope.itens = [
                {item: '',vpc: 0, com: 0, preco: 0, custo: 0,ml: 0,preco_nordeste: 0,desconto: 0,ativo: 1,cor_ativo: 'white',comunicado: 0, desc_comunicado: 'Não Comunicado', cor_comunicado : '#FF5E38'},
              ];


              $scope.inserir = function(){
                $scope.itens.push({item: '',vpc: 0, com: 0, preco: 0, custo: 0,ml: 0,preco_nordeste: 0,desconto: 0,ativo: 1,cor_ativo: 'white',comunicado: 0, desc_comunicado: 'Não Comunicado', cor_comunicado : '#FF5E38'});
               // $scope.remover_lista();
            };

            $scope.remover = function(item,i){
              if($scope.itens.length == 1){
                    
               }
               else{
                $scope.itens.splice(i,1);
                //$scope.lista_itens.push ( { 0: item.item, DESCRICAO: item.item } );
                //$scope.lista_itens = $scope.lista_itens.filter( onlyUnique );
              }
                
            };

              $scope.voltar = function(pagina){
                console.log(pagina);
								window.location.assign(pagina);
							};
	 	});
