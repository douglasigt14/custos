angular.module('App', [])
 					.controller('Controller', function($scope,$http) {
              
              $scope.titulo = 'Simulação Cotação';

              $scope.itens = [
                {item: '',vpc: 0, com: 0, preco: 0, custo_atual: 0, custo_futuro: 0,ml: 0,preco_nordeste: 0,desconto: 0,ativo: 1,cor_ativo: 'white',comunicado: 0, desc_comunicado: 'Não Comunicado', cor_comunicado : '#FF5E38'},
              ];

              $scope.lista_itens = [];


              $scope.inserir = function(){
                $scope.itens.push({item: '',vpc: 0, com: 0, preco: 0,  custo_atual: 0, custo_futuro: 0,ml: 0,preco_nordeste: 0,desconto: 0,ativo: 1,cor_ativo: 'white',comunicado: 0, desc_comunicado: 'Não Comunicado', cor_comunicado : '#FF5E38'});
               // $scope.remover_lista();
            };

            $scope.remover = function(item,i){
              if($scope.itens.length == 1){
                    
               }
               else{
                 console.log(i);
                 $scope.itens.splice(i,1);
                 console.log($scope.itens);
                // $scope.lista_itens.push ( { 0: item.item, DESCRICAO: item.item } );
                // $scope.lista_itens = $scope.lista_itens.filter( onlyUnique );
              }
                
            };

            $scope.calcularML = function(item,i){
              let partes = item.split('-'); 
              let cod_item = partes[0];
              let getUrl = window.location;
              let url = getUrl .protocol + "//" + getUrl.host+'/';
          
              const URL_TO_FETCH = url+"buscar_itens_info/"+cod_item;
              fetch(URL_TO_FETCH, {
                method: 'get' //opcional 
              })
              .then((response) => response.json())
                  .then((json) => {
                    $scope.itens[i].preco_nordeste = json.preco_nordeste;
                    
              })
              .catch(function(err) { 
                console.error(err); 
              });

            }

              $scope.voltar = function(pagina){
                console.log(pagina);
								window.location.assign(pagina);
							};
	 	});
