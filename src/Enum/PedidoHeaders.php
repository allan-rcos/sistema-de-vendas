<?php

namespace App\Enum;

enum PedidoHeaders: string
{
    case ID = "ID";
    case TOTAL = "Total";
    case FORMA_DE_PAGAMENTO = "Forma de Pagamento";
    case CREATED_AT = "Data de Criação";
}