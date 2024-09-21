<?php

class Carta {
    private int $numero;
    private string $nome;
    private int $pontuacao; //para a pontuação do usuario

    public function __construct() {
        $this->pontuacao = 100;  
    }

    // GETs & SETs
    public function setNumero(int $numero): self {
        $this->numero = $numero;
        return $this;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): self {
        $this->nome = $nome;
        return $this;
    }

    public function getPontuacao(): int {
        return $this->pontuacao;
    }

    public function __toString() {
        return "Nome: " . $this->nome . " | Número: " . $this->numero;
    }

    // Métodos
    public function perderPontos() { // tira pontos a cada vez que erra
        $this->pontuacao -= 10;
    }

    public function ganharPontos() { // ganha pontos a cada vez que acerta
        $this->pontuacao += 10;
    }
}

$escolha = 0;
$baralho = array();
$arrayCartaEscolhida = array();
$arrayCartaSorteada = array();
$pontuacaoHistorico = array();

do {
    print "\n *--------- MENU -----------------------* \n";
    print " 1 -------- SORTEAR ------------------* \n";
    print " 2 -------- LISTAR CARTAS SORTEADAS --*\n";
    print " 3 -------- LISTAR CARTAS QUE VOCÊ ESCOLHEU *\n";
    print " 4 -------- PONTUAÇÃO FINAL ----------*\n";
    print " 5 -------- HISTÓRICO DE PONTUAÇÃO ---*\n";
    print " 0 -------- SAIR ---------------------* \n";

    $escolha = (int)readline("De qual serviço você precisa? \n");

    switch ($escolha) {
        case 0:
            print "SAINDO DO PROGRAMA...\n";
            break;

        case 1:
            for ($i = 0; $i < 7; $i++) {
                $cartas = new Carta();
                $cartas->setNome(readline("Informe o nome da carta: "));
                $cartas->setNumero(readline("Informe o número da carta: "));
                array_push($baralho, $cartas);
            }

            sleep(2);

            foreach ($baralho as $i => $b) {
                print ($i + 1) . " - " . $b . "\n";
            }

            $indiceCartaSorteada = array_rand($baralho);  // vai receber o indice
            $cartaSorteada = $baralho[$indiceCartaSorteada];

            array_push($arrayCartaSorteada, $cartaSorteada);

            do {
                $cartaEscolhida = (int)readline("Adivinhe o índice da carta sorteada (1 a " . count($baralho) . "): ");
                array_push($arrayCartaEscolhida, $cartaEscolhida);

                if ($cartaEscolhida - 1 == $indiceCartaSorteada) {  
                    print "PARABÉNS, A CARTA ESCOLHIDA FOI SORTEADA!!\n";
                    $cartaSorteada->ganharPontos();
                } else {
                    print "Infelizmente a carta que você escolheu não foi sorteada. Tente novamente!\n";
                    $cartaSorteada->perderPontos();
                }

                array_push($pontuacaoHistorico, $cartaSorteada->getPontuacao());

                sleep(2);

                foreach ($baralho as $i => $b) {
                    print ($i + 1) . " - " . $b . "\n";
                }

            } while ($cartaEscolhida - 1 != $indiceCartaSorteada);  

            break;

        case 2:
            print "\n--- Cartas sorteadas ---\n";
            foreach ($arrayCartaSorteada as $i => $s) {
                print ($i + 1) . " - " . $s . "\n";
            }
            break;

        case 3:
            print "\n--- Cartas escolhidas ---\n";
            foreach ($arrayCartaEscolhida as $i => $e) {
                print ($i + 1) . " - " . $e . "\n";
            }
            break;

        case 4:
            print "A sua pontuação atual é de " . $cartaSorteada->getPontuacao() . " pontos \n";
            break;

        case 5:
            print "\n--- Histórico de Pontuação ---\n";
            foreach ($pontuacaoHistorico as $i => $p) {
                print "Tentativa " . ($i + 1) . ": " . $p . " pontos\n";
            }
            break;

        default:
            print "OPÇÃO INVÁLIDA! ";
            break;
    }

} while ($escolha != 0);
