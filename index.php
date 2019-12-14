<?php

function crear_mazo($nro):array {
    $mazo= array();
    $h= 0;
    while ($h < $nro){
        $i = 0;
        $j = 1;
        while ($i < 4){
            $j=1;
            while ($j <= 13){
                $mazo[] = ($j);
                $j = $j + 1;
            }
            $i = $i + 1;
        }
        $h = $h + 1;
    }
    shuffle($mazo);
    return $mazo;
}

function sumar_cartas($mano):int {
    $i=0;
    $suma=0;
    while ($i < count($mano)){
        if ($mano[$i] > 10){
            $suma = $suma + 10;
        }elseif (($mano[$i] == 1) && ($suma+10 <= 21)){
            $suma = $suma + 11;
        }else{
            $suma = $suma + $mano[$i];
        }
        $i = $i + 1; 
    }
    return $suma;
}

function jugar(&$mazo):int {
    $mano = array();
    while (sumar_cartas($mano) < 21){
        $mano[] = (array_pop($mazo));
        print("Mano: \n");
        print_r($mano);
    }
    print("\n");
    print("Total:" . sumar_cartas($mano));
    print("\n");
    return sumar_cartas($mano);
}

function jugar_varios(&$mazo, $cant_jugadores):array {
    $i=0;
    $resultado=array();
    while ($i < $cant_jugadores){
        print("Jugador" . $i . ": \n");
        $resultado[] = jugar($mazo);
        $i = $i + 1;
    }
    return $resultado;
}

function ver_quien_gano($listaResultados):array {
    $i=0;
    $ganador=0;
    $cuanto=0;
    $lista=array(count($listaResultados));
    while ($i < count($listaResultados)){
        if ($listaResultados[$i] > $cuanto){
            $ganador= $i;
            $cuanto = $listaResultados[$i];
        }
        $i = $i + 1;
    }
    $lista[$ganador]= 1;
    return $lista;
}

function sumar_resultado_partidas($lista_resultados): array{
    $j=0;
    $cantidad_jugadores = count($lista_resultados[0]);
    $cantidad_repeticiones = count($lista_resultados);
    $resultado_total = array_fill(0,$cantidad_jugadores,0);
    $res = array_fill(0,$cantidad_jugadores,"");
    while ($j < $cantidad_jugadores){ # hace 5 que son la cant de jugadores
        $i=0;
        while ($i < $cantidad_repeticiones){ # hace 10 veces que repite
            $resultado_total[$j] = $resultado_total[$j] + $lista_resultados[$i][$j];
            $i = $i + 1;
        }
        $res[$j] = "Jugador " . $j . ":" . $resultado_total[$j] . " partidas ganadas \n"; 
        $j = $j +1;
    }
    foreach ($res as $k => $v){
        print($v);
    }
    return $res;
}

function experimentar($repeticiones, $jugadores): array{
    $i=0;
    $resultado_final = array();
    while ($i < $repeticiones){
        print("Repeticion n°" . $i . ": \n");
        print("\n");
        $mazo = crear_mazo(round($jugadores/2));
        $resultado_parcial = ver_quien_gano(jugar_varios($mazo, $jugadores));
        $resultado_final[]= $resultado_parcial;
        $i = $i + 1;
    }
    return sumar_resultado_partidas($resultado_final);
}

$mazo = crear_mazo(1);
//jugar($mazo);
 //$res1 = ver_quien_gano(jugar_varios($mazo,3));
 //print_r($res1);
$numero_de_jugadores=6;
$numero_de_repeticiones=10;
$res2 = experimentar($numero_de_repeticiones, $numero_de_jugadores);
?>