    {{-- @foreach($exame->items as $item)
    @foreach($item->resultado_parametro_exame as $parametro)
    @php
    $possuiImagem = false;
    @endphp
    @foreach($parametro->resultadosubparamentrosImagem as $imagem)
    @if($imagem->subparametroexame->tipo=="imagem")
    @php
    $possuiImagem = true;
    @endphp
    @endif
    @endforeach
    @if($possuiImagem)
    <div class="section">
        <div class="section-title">
            IMAGENS DO EXAME
        </div>
        <table class="info">
            <tr>
                <td>
                    <strong>Exame</strong><br>
                    {{ $item->produto->nome ?? "" }}
                </td>
                <td>
                    <strong>Categoria</strong><br>
                    {{ $item->produto ? $item->produto->categoria->categoria : "" }}
                </td>
            </tr>
        </table>
        <br>
        <table width="100%">
            @php
            $contador = 0;
            @endphp
            <tr>
                @foreach($parametro->resultadosubparamentrosImagem as $imagem)
                @if($imagem->subparametroexame->tipo=="imagem")
                @php
                $ficheiros = json_decode($imagem->ficheiros,true) ?? [];
                @endphp
                @foreach($ficheiros as $ficheiro)
                @if ($ficheiro != [])
                    
                <td width="50%" style="padding:10px;">
                    <div style="border:1px solid #DDD;padding:8px;">
                        <div style="text-align:center;font-weight:bold;margin-bottom:8px;color:#0B6FA4;">
                            {{ $imagem->subparametroexame->nome }}
                        </div>
                        <div style="text-align:center;">
                            <img src="{{ asset('/public/resultados/exames/'.$ficheiro) }}" title="" style="width:240px;height:220px;object-fit:contain;border:1px solid #CCC;">
                        </div>
                        @if(!empty($imagem->descricao))
                        <div style="margin-top:8px;font-size:10px;color:#555;text-align:center;">
                            {{ $imagem->descricao }}
                        </div>
                        @endif
                    </div>
                </td>
                @endif

                @php
                $contador++;
                @endphp

                @if($contador % 2 == 0)

            </tr>
            <tr>
                @endif
                @endforeach
                @endif
                @endforeach
            </tr>
        </table>
    </div>
    @endif
    @endforeach
    @endforeach --}}


@foreach($item->resultado_parametro_exame as $parametro)

    @php
        $imagensPreenchidas = $parametro->resultadosubparamentrosImagem
            ->filter(function ($imagem) {
                if (($imagem->subparametroexame->tipo ?? '') != 'imagem') {
                    return false;
                }

                $ficheiros = json_decode($imagem->ficheiros, true) ?? [];

                return collect($ficheiros)->contains(function ($ficheiro) {
                    return is_string($ficheiro) && trim($ficheiro) !== '';
                });
            });
    @endphp

    @if($imagensPreenchidas->isNotEmpty())

        <div class="section">

            <div class="section-title">
                IMAGENS DO EXAME
            </div>

            <table class="info">
                <tr>
                    <td>
                        <strong>Exame</strong><br>
                        {{ $item->produto->nome ?? '' }}
                    </td>

                    <td>
                        <strong>Categoria</strong><br>
                        {{ $item->produto ? $item->produto->categoria->categoria : '' }}
                    </td>
                </tr>
            </table>

            <br>

            <table width="100%" style="border-collapse:collapse;">

                @php
                    $contador = 0;
                @endphp

                <tr>
                    @foreach($imagensPreenchidas as $imagem)

                        @php
                            $ficheiros = json_decode($imagem->ficheiros, true) ?? [];

                            $ficheiros = collect($ficheiros)->filter(function ($ficheiro) {
                                return is_string($ficheiro) && trim($ficheiro) !== '';
                            });
                        @endphp

                        @foreach($ficheiros as $ficheiro)

                            <td width="50%" style="padding:10px; vertical-align:top;">

                                <div style="border:1px solid #DDD;padding:8px;">

                                    <div style="text-align:center;font-weight:bold;margin-bottom:8px;color:#0B6FA4;">
                                        {{ $imagem->subparametroexame->nome ?? '' }}
                                    </div>

                                    <div style="text-align:center;">
                                        <img
                                            src="{{ asset('/public/resultados/exames/'.$ficheiro) }}"
                                            alt="{{ $imagem->subparametroexame->nome ?? 'Imagem do exame' }}"
                                            style="width:240px;height:220px;object-fit:contain;border:1px solid #CCC;"
                                        >
                                    </div>

                                    @if(!empty($imagem->descricao))
                                        <div style="margin-top:8px;font-size:10px;color:#555;text-align:center;">
                                            {{ $imagem->descricao }}
                                        </div>
                                    @endif

                                </div>

                            </td>

                            @php
                                $contador++;
                            @endphp

                            @if($contador % 2 == 0)
                                </tr>
                                <tr>
                            @endif

                        @endforeach

                    @endforeach
                </tr>

            </table>

        </div>

    @endif

@endforeach