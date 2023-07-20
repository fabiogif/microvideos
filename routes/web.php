<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {

//return view('welcome');


   // $timeA = '2022-11-20';
//    $timeA = '2022-11-20';





//Musica patinho

    /*
$patinhos = readline('Digite a quantidade de patinhos:');


      if(!is_numeric($patinhos) || $patinhos <= 1 || $patinhos >= 10)
      {
          echo 'Invalid patinhos' . PHP_EOL;
          exit;
      }

      for($i = $patinhos; $i > 0; $i--){
          echo $i != 1 ? "$i patinhos foram passear " : " 1 patinho foi passear ";
          echo "  \n Além das montanhas Para brincar \n A mamãe gritou Quá, quá, quá, quá! \n";
          switch($i){
              case 2:
                 echo "Mas só 1 patinho voltou de lá \n";
                 break;
             case 1:
                 echo "Mas nenhum patinho voltou de lá \n";
                 break;
              default:
                  echo "Mas só". ($i -1)." patinhos voltaram de lá \n";
                  break;

          }

      }



        //Conversaão de unidades
        $unidades = array('MM' => 1, 'CM' => 10, 'M' => 1000, 'KM' => 100000);

        $unidadeValidas = implode(',', array_keys($unidades));

        $unidadeInformada =  readline("Digite uma unidade: $unidadeValidas :");

        if(!array_key_exists(strtoupper($unidadeInformada), $unidades)){
            echo 'Entrada invalida \n\n';
            exit;
        }

        $valorBase =  readline("Digite um valor: ");
        if(!is_numeric($valorBase))
        {
            echo 'Numero informado não é valido ' . PHP_EOL;
            exit;
        }

        $valorFinal = $valorBase * $unidades[strtoupper($unidadeInformada)]. PHP_EOL;

        foreach ($unidades as $key => $valor)
        {
            echo '> '.($valorFinal / $valor)." ".$key." ".PHP_EOL;
        }

        return false;

 */


   /* $nomes = [];
    do{

        echo "[1] Adicionar \n";
        if(count($nomes) > 2) {
            echo "[2] Listar \n";
            echo "[3] Sortear \n";
        }
        echo "[4] Sair \n";

        $opcoes = readline('Informe uma opção:');

        switch ($opcoes)
        {
            case '1':
                $nomes[] =  readline('informe um novo nome: ');
                echo "\n";
                break;
            case '2':
                if(count($nomes) >= 1) {
                    foreach ($nomes as $nome) {
                        echo ">> " . $nome;
                        echo "\n";
                    }
                }
                break;
            case '3':
                if(count($nomes) >= 2) {
                    $indices = array_rand($nomes);
                    echo "Nome sorteado:". ($nomes[$indices]);
                    echo "\n\n";
                    unset($nomes[$indices]);
                }
                break;
        }
    }
    while($opcoes != 4);




    //Contador de cedulas
    $cedulas = [5, 10, 20, 50, 100];
    echo 'Cedulas disponiveis: '. implode(', ', $cedulas)."\n";

    $valorSaque = readline('Informe o valor do saque: ');

    if(($valorSaque % $cedulas[0]) > 0) {
        echo  'Valor não autorizado \n';
        exit;
    }

    rsort($cedulas);
    $valorRestante = $valorSaque;
    foreach ($cedulas as $cedula)
    {
        if($cedula > $valorRestante) {
            continue;
        }

        $quant = floor($valorRestante / $cedula);

        $valorRestante -= ($cedula * $quant);

        $cedulaSaque[$cedula] = $quant;

    }

    echo "\n";

    echo 'Saque de  : '.$valorSaque;
    echo "\n";

    foreach ($cedulaSaque as $cedula => $quant)
    {

        echo "=>". $quant."x" ."R$: ".$cedula;
        echo "\n";
    }


*/
});
