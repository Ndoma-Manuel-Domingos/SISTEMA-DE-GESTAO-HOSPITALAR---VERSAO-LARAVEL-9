<?php

namespace App\Enums;

enum ConsultaEventoEnum: string
{
    case CONSULTA_INICIADA = 'consulta_iniciada';
    case GRAVACAO_INICIADA = 'gravacao_iniciada';
    case GRAVACAO_FINALIZADA = 'gravacao_finalizada';
    case AUDIO_GUARDADO = 'audio_guardado';
    case TRANSCRICAO = 'transcricao';
    case DIAGNOSTICO = 'diagnostico';
    case RECEITA = 'receita';
    case CONSULTA_FINALIZADA = 'consulta_finalizada';
}
