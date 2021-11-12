angular.module('App', [])
 					.controller('Controller', function($scope,$http) {
              
              $scope.titulo = 'Simulação Cotação';

              $scope.itens = [
                {item: '',vpc: 0, com: 0, preco: 0, custo_atual: 0, custo_futuro: 0,ml: 0,preco_nordeste: 0,desconto: 0,ativo: 1,cor_ativo: 'white',comunicado: 0, desc_comunicado: 'Não Comunicado', cor_comunicado : '#FF5E38'},
              ];

              $scope.lista_itens = [];

              $scope.aliquota = 0;

              $scope.select_custo = 'custo_atual';


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
                    $scope.itens[i].custo_atual = json.custo_atual;
                    $scope.itens[i].custo_futuro = json.custo_futuro;

                    let fator = json.fator;

                    vpc = parseFloat($scope.itens[i].vpc);
                    com = parseFloat($scope.itens[i].com);

                    var oldstr= $scope.itens[i].preco.toString();  
                    $scope.itens[i].preco  = oldstr.toString().replace(",",".");
                    preco = parseFloat($scope.itens[i].preco);


                    var oldstr= $scope.itens[i].vpc.toString();  
                    $scope.itens[i].vpc  = oldstr.toString().replace(",",".");
                    vpc = parseFloat($scope.itens[i].vpc);


                    var oldstr= $scope.itens[i].com.toString();  
                    $scope.itens[i].com  = oldstr.toString().replace(",",".");
                    com = parseFloat($scope.itens[i].com);

                    custo = $scope.select_custo == 'custo_atual' ? parseFloat($scope.itens[i].custo_atual) : parseFloat($scope.itens[i].custo_futuro);

                    preco_nordeste = parseFloat($scope.itens[i].preco_nordeste);

                  $scope.itens[i].desconto = ((((preco / preco_nordeste)*100)-100)*-1);

                  $scope.itens[i].desconto = parseFloat($scope.itens[i].desconto);
                  $scope.itens[i].desconto =  $scope.itens[i].desconto.toFixed(4); 
                  var oldstr= $scope.itens[i].desconto.toString();  
                  $scope.itens[i].desconto  = oldstr.toString().replace(".",",");
                  $scope.itens[i].desconto  = $scope.itens[i].desconto+"%";

                 $scope.itens[i].preco_nordeste = parseFloat($scope.itens[i].preco_nordeste);
                  $scope.itens[i].preco_nordeste =  $scope.itens[i].preco_nordeste.toFixed(2); 
                  var oldstr= $scope.itens[i].preco_nordeste.toString();  
                  $scope.itens[i].preco_nordeste  = oldstr.toString().replace(".",",");

                  var oldstr= $scope.itens[i].preco.toString();  
                  $scope.itens[i].preco  = oldstr.toString().replace(".",",");


                  var oldstr= $scope.itens[i].vpc.toString();  
                  $scope.itens[i].vpc  = oldstr.toString().replace(".",",");


                  var oldstr= $scope.itens[i].com.toString();  
                  $scope.itens[i].com  = oldstr.toString().replace(".",",");
                  
                  if( custo != 0 ){

                    $scope.itens[i].ml =  ( (100 - (parseFloat(fator) + vpc + com + parseFloat($scope.aliquota) )) - (custo*100) / preco); 

                   $scope.itens[i].ml = $scope.itens[i].ml.toFixed(2);

                   var oldstr= $scope.itens[i].ml.toString();
                   $scope.itens[i].ml  = oldstr.toString();//.replace(".","A");
                }
                  //  console.log($scope.itens[i]);
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
