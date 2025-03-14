<?php

namespace App\Enum;

enum FormasPagamento: string
{
    case DINHEIRO = 'Dinheiro';
    case CREDITO = "Cartão de Crédito";
    case DEBITO = "Cartão de Débito";
}
