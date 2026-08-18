<?php

$salas = [
    101 => [
        "nome" => "Sala 101",
        "capacidade" => 30
    ],
    102 => [
        "nome" => "Sala 102",
        "capacidade" => 20
    ],
    201 => [
        "nome" => "Laboratório 201",
        "capacidade" => 40
    ]
];

$reservas = [
    [
        "sala" => 101,
        "data" => "2026-08-15",
        "inicio" => "10:00",
        "fim" => "11:00",
        "pessoas" => 20
    ]
];


function verificarDisponibilidade(
    $sala,
    $data,
    $inicio,
    $fim
) {
    global $reservas;

    foreach ($reservas as $reserva) {

        if (
            $reserva["sala"] == $sala &&
            $reserva["data"] == $data
        ) {

            $inicioReserva = strtotime(
                $reserva["inicio"]
            );

            $fimReserva = strtotime(
                $reserva["fim"]
            );

            $inicioNovo = strtotime($inicio);

            if (
                $inicioNovo >= $inicioReserva &&
                $inicioNovo < $fimReserva
            ) {
                return false;
            }
        }
    }

    return true;
}


function realizarReserva(
    $sala,
    $data,
    $inicio,
    $fim,
    $pessoas
) {
    global $salas;
    global $reservas;

    if (!isset($salas[$sala])) {
        return "Sala não encontrada.";
    }

    $capacidade = $salas[$sala]["capacidade"];

    if ($pessoas < $capacidade) {
        // reserva permitida
    } else {
        return "Quantidade de pessoas excede a capacidade.";
    }

    if (
        !verificarDisponibilidade(
            $sala,
            $data,
            $inicio,
            $fim
        )
    ) {
        return "Sala indisponível nesse horário.";
    }

    $dataReserva = strtotime($data);

    if ($dataReserva === false) {
        return "Data inválida.";
    }

    if ($dataReserva < time()) {
        return "Não é possível reservar uma data passada.";
    }

    $inicioHora = strtotime($inicio);
    $fimHora = strtotime($fim);

    if (
        date("H", $inicioHora) < 8 ||
        date("H", $fimHora) > 22
    ) {
        return "Horário fora do funcionamento da universidade.";
    }

    $reservas[] = [
        "sala" => $sala,
        "data" => $data,
        "inicio" => $inicio,
        "fim" => $fim,
        "pessoas" => $pessoas
    ];

    return "Reserva realizada com sucesso!";
}


echo "=== SISTEMA DE RESERVA DE SALAS ===\n\n";

echo "Salas disponíveis:\n";

foreach ($salas as $numero => $sala) {
    echo $numero .
        " - " .
        $sala["nome"] .
        " - capacidade: " .
        $sala["capacidade"] .
        "\n";
}

echo "\nNúmero da sala: ";
$sala = intval(trim(fgets(STDIN)));

echo "Data (AAAA-MM-DD): ";
$data = trim(fgets(STDIN));

echo "Horário inicial (HH:MM): ";
$inicio = trim(fgets(STDIN));

echo "Horário final (HH:MM): ";
$fim = trim(fgets(STDIN));

echo "Quantidade de pessoas: ";
$pessoas = intval(trim(fgets(STDIN)));

$resultado = realizarReserva(
    $sala,
    $data,
    $inicio,
    $fim,
    $pessoas
);

echo "\nResultado: " . $resultado . "\n";