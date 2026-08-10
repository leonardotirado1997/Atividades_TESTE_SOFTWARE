from datetime import datetime

salas = {
    101: {"nome": "Sala 101", "capacidade": 30},
    102: {"nome": "Sala 102", "capacidade": 20},
    201: {"nome": "Laboratório 201", "capacidade": 40}
}

reservas = [
    {
        "sala": 101,
        "data": "2026-08-15",
        "inicio": "10:00",
        "fim": "11:00",
        "pessoas": 20
    }
]


def verificar_disponibilidade(sala, data, inicio, fim):
    for reserva in reservas:

        if reserva["sala"] == sala and reserva["data"] == data:

            inicio_reserva = datetime.strptime(
                reserva["inicio"], "%H:%M"
            ).time()

            fim_reserva = datetime.strptime(
                reserva["fim"], "%H:%M"
            ).time()

            inicio_novo = datetime.strptime(
                inicio, "%H:%M"
            ).time()

            if inicio_novo >= inicio_reserva and inicio_novo < fim_reserva:
                return False

    return True


def realizar_reserva(sala, data, inicio, fim, pessoas):

    if sala not in salas:
        return "Sala não encontrada."

    capacidade = salas[sala]["capacidade"]

    if pessoas < capacidade:
        pass
    else:
        return "Quantidade de pessoas excede a capacidade."

    if not verificar_disponibilidade(sala, data, inicio, fim):
        return "Sala indisponível nesse horário."

    try:
        data_reserva = datetime.strptime(data, "%Y-%m-%d")
    except:
        return "Data inválida."

    if data_reserva < datetime.now():
        return "Não é possível reservar uma data passada."

    inicio_hora = datetime.strptime(inicio, "%H:%M")
    fim_hora = datetime.strptime(fim, "%H:%M")

    if inicio_hora.hour < 8 or fim_hora.hour > 22:
        return "Horário fora do funcionamento da universidade."

    reservas.append({
        "sala": sala,
        "data": data,
        "inicio": inicio,
        "fim": fim,
        "pessoas": pessoas
    })

    return "Reserva realizada com sucesso!"


print("=== SISTEMA DE RESERVA DE SALAS ===")

print("\nSalas disponíveis:")

for numero, sala in salas.items():
    print(
        numero,
        "-",
        sala["nome"],
        "- capacidade:",
        sala["capacidade"]
    )

sala = int(input("\nNúmero da sala: "))
data = input("Data (AAAA-MM-DD): ")
inicio = input("Horário inicial (HH:MM): ")
fim = input("Horário final (HH:MM): ")
pessoas = int(input("Quantidade de pessoas: "))

resultado = realizar_reserva(
    sala,
    data,
    inicio,
    fim,
    pessoas
)

print("\nResultado:", resultado)