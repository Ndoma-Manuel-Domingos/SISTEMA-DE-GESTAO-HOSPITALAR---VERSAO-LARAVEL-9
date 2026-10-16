    <div class="section" style="margin-top:25px;">
        <div class="section-title">
            {{ strtoupper($dado->produto->nome ?? '') }}
        </div>
        <table class="info" style="margin-bottom:15px;">
            <tr>
                <td width="35%">
                    <strong>Categoria</strong><br>
                    {{ $dado->produto ? $dado->produto->categoria->categoria : '' }}
                </td>

                <td width="20%">
                    <strong>Código</strong><br>
                    {{ $dado->produto->codigo ?? '-' }}
                </td>

                <td width="20%">
                    <strong>Valor</strong><br>
                    {{ number_format($dado->valor, 2, ',', '.') }}
                </td>

                <td width="25%">
                    <strong>Estado</strong><br>
                    <span style="color:#2e7d32;font-weight:bold;">
                        FINALIZADO
                    </span>
                </td>
            </tr>
        </table>
        @foreach($dado->resultado_parametro_exame as $parametro)
            @php
                $resultadosPreenchidos = $parametro->resultadosubparamentros
                    ->filter(function ($resultado) {
                        return !is_null($resultado->valor)
                            && trim((string) $resultado->valor) !== ''
                            && in_array(
                                $resultado->subparametroexame->tipo ?? '',
                                [
                                    'lista',
                                    'numero',
                                    'texto',
                                    'textarea',
                                    'booleano',
                                    'data'
                                ]
                            );
                    });
            @endphp
            @if($resultadosPreenchidos->isNotEmpty())

                <table style="margin-top:10px; width:100%; border-collapse:collapse;">

                    <tr>
                        <td colspan="5"
                            style="background:#0B6FA4;color:white;font-weight:bold;padding:8px;">
                            {{ strtoupper($parametro->nome) }}
                        </td>
                    </tr>

                    <tr style="background:#F3F7FA;">
                        <th style="border:1px solid #DDD;padding:6px;">
                            Código
                        </th>

                        <th style="border:1px solid #DDD;padding:6px;">
                            Parâmetro
                        </th>

                        <th style="border:1px solid #DDD;padding:6px;">
                            Resultado
                        </th>

                        <th style="border:1px solid #DDD;padding:6px;">
                            Unidade
                        </th>

                        <th style="border:1px solid #DDD;padding:6px;">
                            Valor de Referência
                        </th>
                    </tr>

                    @foreach($resultadosPreenchidos as $resultado)

                        <tr>
                            <td style="border:1px solid #DDD;padding:6px;">
                                {{ $resultado->subparametroexame->codigo ?? '-' }}
                            </td>

                            <td style="border:1px solid #DDD;padding:6px;">
                                {{ $resultado->subparametroexame->nome ?? '-' }}
                            </td>

                            <td style="border:1px solid #DDD;padding:6px;">
                                <strong style="font-size:12px;color:#0B6FA4;">
                                    {{ $resultado->valor }}
                                </strong>
                            </td>

                            <td style="border:1px solid #DDD;padding:6px;">
                                @if(($resultado->subparametroexame->tipo ?? '') == 'lista')

                                    {{ $resultado->subparametroexame->opcoes ?? '-' }}

                                @elseif(($resultado->subparametroexame->tipo ?? '') == 'booleano')

                                    {{ $resultado->subparametroexame->texto_sim ?? '' }}/{{ $resultado->subparametroexame->texto_nao ?? '' }}

                                @else

                                    {{ $resultado->subparametroexame->unidade ?? '-' }}

                                @endif
                            </td>

                            <td style="border:1px solid #DDD;padding:6px;">
                                {{ $resultado->subparametroexame->valor_referencia ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </table>
                <br>
            @endif
        @endforeach
    </div>
