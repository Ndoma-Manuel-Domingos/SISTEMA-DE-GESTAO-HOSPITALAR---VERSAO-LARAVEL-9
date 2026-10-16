<!DOCTYPE html>
<html lang="pt-pt">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ 'Configuração da Instituição' }}
        |
        {{ 'Sistema Integrado de Gestão' }}
    </title>


    <!-- =========================================================
         FONTES
    ========================================================== -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <!-- =========================================================
         FONT AWESOME
    ========================================================== -->

    <link
        rel="stylesheet"
        href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"
    >


    <!-- =========================================================
         SWEET ALERT
    ========================================================== -->

    <link
        rel="stylesheet"
        href="{{ asset('dist/css/sweetalert2.min.css') }}"
    >


    <!-- =========================================================
         ADMINLTE
    ========================================================== -->

    <link
        rel="stylesheet"
        href="{{ asset('dist/css/adminlte.css') }}"
    >


    <style>

        /* =====================================================
           VARIÁVEIS
        ====================================================== */

        :root {

            --primary: #087f8c;
            --primary-dark: #05636d;
            --primary-light: #e8f8f9;

            --secondary: #1268a9;

            --dark: #102f3b;
            --text: #2c424c;
            --muted: #7b8d95;

            --border: #dfeaec;

            --background: #f4f8f9;

            --white: #ffffff;

        }


        /* =====================================================
           RESET
        ====================================================== */

        * {
            box-sizing: border-box;
        }


        html,
        body {

            width: 100%;
            min-height: 100%;

            margin: 0;

            font-family:
                'Inter',
                sans-serif;

            color: var(--text);

            background:
                var(--background);

        }


        body {

            overflow-x: hidden;

        }


        /* =====================================================
           LAYOUT
        ====================================================== */

        .setup-page {

            min-height: 100vh;

            display: flex;

            background:
                #ffffff;

        }


        /* =====================================================
           PAINEL ESQUERDO
        ====================================================== */

        .setup-panel {

            position: relative;

            width: 39%;

            min-height: 100vh;

            overflow: hidden;

            display: flex;

            align-items: center;

            padding: 60px;

            color: white;

            background:

                linear-gradient(
                    145deg,
                    rgba(4,66,76,.98),
                    rgba(8,127,140,.94)
                ),

                url('/dist/img/hospital-background.jpg');

            background-size: cover;

            background-position: center;

        }


        /* =====================================================
           EFEITOS
        ====================================================== */

        .setup-panel::before {

            content: "";

            position: absolute;

            width: 620px;

            height: 620px;

            border-radius: 50%;

            border:
                1px solid
                rgba(255,255,255,.08);

            top: -270px;

            right: -310px;

        }


        .setup-panel::after {

            content: "";

            position: absolute;

            width: 430px;

            height: 430px;

            border-radius: 50%;

            border:
                1px solid
                rgba(255,255,255,.07);

            bottom: -250px;

            left: -230px;

        }


        .setup-grid {

            position: absolute;

            inset: 0;

            opacity: .07;

            background-image:

                linear-gradient(
                    rgba(255,255,255,.5) 1px,
                    transparent 1px
                ),

                linear-gradient(
                    90deg,
                    rgba(255,255,255,.5) 1px,
                    transparent 1px
                );

            background-size:
                42px 42px;

        }


        /* =====================================================
           CONTEÚDO ESQUERDO
        ====================================================== */

        .setup-panel-content {

            position: relative;

            z-index: 3;

            width: 100%;

            max-width: 480px;

        }


        /* =====================================================
           BRAND
        ====================================================== */

        .brand {

            display: flex;

            align-items: center;

            gap: 14px;

            margin-bottom: 65px;

        }


        .brand-logo {

            width: 58px;

            height: 58px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 16px;

            background:
                white;

            color:
                var(--primary);

            font-size: 25px;

            box-shadow:
                0 15px 35px
                rgba(0,0,0,.16);

        }


        .brand-name {

            font-size: 20px;

            font-weight: 800;

            letter-spacing:
                -.5px;

        }


        .brand-subtitle {

            display: block;

            margin-top: 4px;

            color:
                rgba(255,255,255,.65);

            font-size: 10px;

            letter-spacing:
                .2px;

        }


        /* =====================================================
           TEXTO
        ====================================================== */

        .setup-panel h1 {

            margin: 0;

            font-size: 40px;

            line-height: 1.15;

            font-weight: 800;

            letter-spacing:
                -1.5px;

        }


        .setup-panel h1 span {

            color:
                #8ee5eb;

        }


        .setup-description {

            margin-top: 20px;

            margin-bottom: 38px;

            max-width: 430px;

            color:
                rgba(255,255,255,.75);

            font-size: 13px;

            line-height: 1.8;

        }


        /* =====================================================
           PASSOS
        ====================================================== */

        .setup-steps {

            display: flex;

            flex-direction: column;

            gap: 13px;

        }


        .setup-step {

            display: flex;

            align-items: center;

            gap: 13px;

        }


        .step-number {

            flex-shrink: 0;

            width: 34px;

            height: 34px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 10px;

            background:
                rgba(255,255,255,.1);

            border:
                1px solid
                rgba(255,255,255,.1);

            font-size: 11px;

            font-weight: 700;

            color:
                #a4edf1;

        }


        .setup-step span {

            color:
                rgba(255,255,255,.78);

            font-size: 11px;

        }


        /* =====================================================
           STATUS
        ====================================================== */

        .setup-status {

            display: flex;

            align-items: center;

            gap: 9px;

            margin-top: 45px;

            color:
                rgba(255,255,255,.58);

            font-size: 10px;

        }


        .status-dot {

            width: 8px;

            height: 8px;

            border-radius: 50%;

            background:
                #6ee7b7;

            box-shadow:
                0 0 0 5px
                rgba(110,231,183,.11);

        }


        /* =====================================================
           ÁREA DIREITA
        ====================================================== */

        .form-panel {

            width: 61%;

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 50px 70px;

            background:
                #ffffff;

        }


        .form-container {

            width: 100%;

            max-width: 720px;

        }


        /* =====================================================
           CABEÇALHO
        ====================================================== */

        .form-header {

            display: flex;

            align-items: flex-start;

            justify-content: space-between;

            gap: 25px;

            margin-bottom: 32px;

        }


        .form-header-left {

            display: flex;

            align-items: flex-start;

            gap: 14px;

        }


        .header-icon {

            flex-shrink: 0;

            width: 52px;

            height: 52px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 14px;

            background:
                var(--primary-light);

            color:
                var(--primary);

            font-size: 20px;

        }


        .form-header h2 {

            margin: 0;

            color:
                var(--dark);

            font-size: 25px;

            line-height: 1.3;

            font-weight: 800;

            letter-spacing:
                -.7px;

        }


        .form-header p {

            margin:

                6px 0 0;

            color:
                var(--muted);

            font-size: 11px;

            line-height: 1.6;

        }


        .setup-badge {

            display: flex;

            align-items: center;

            gap: 7px;

            padding:
                8px 11px;

            border-radius: 8px;

            background:
                #f4fafb;

            border:
                1px solid #e2eff0;

            color:
                var(--primary);

            font-size: 9px;

            font-weight: 700;

            white-space: nowrap;

        }


        /* =====================================================
           SECÇÃO
        ====================================================== */

        .form-section {

            margin-bottom: 25px;

            padding-bottom: 25px;

            border-bottom:
                1px solid #edf1f2;

        }


        .form-section:last-of-type {

            border-bottom:
                0;

        }


        .section-title {

            display: flex;

            align-items: center;

            gap: 8px;

            margin-bottom: 17px;

            color:
                #425963;

            font-size: 11px;

            font-weight: 800;

            text-transform:
                uppercase;

            letter-spacing:
                .5px;

        }


        .section-title i {

            color:
                var(--primary);

            font-size: 12px;

        }


        /* =====================================================
           GRID
        ====================================================== */

        .fields-grid {

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap:

                0 16px;

        }


        .field {

            margin-bottom: 17px;

        }


        .field.full {

            grid-column:
                1 / -1;

        }


        .field label {

            display: block;

            margin-bottom: 7px;

            color:
                #50656e;

            font-size: 10px;

            font-weight: 700;

        }


        .required {

            color:
                #dc3545;

        }


        /* =====================================================
           INPUT
        ====================================================== */

        .input-wrapper {

            position: relative;

        }


        .input-wrapper > i {

            position: absolute;

            left: 14px;

            top: 50%;

            transform:
                translateY(-50%);

            z-index: 2;

            color:
                #98aab0;

            font-size: 13px;

        }


        .input-wrapper input,
        .input-wrapper select {

            width: 100%;

            height: 47px;

            padding:
                0 40px;

            border:
                1px solid var(--border);

            border-radius: 9px;

            outline: none;

            background:
                #fbfdfd;

            color:
                var(--dark);

            font-family:
                inherit;

            font-size: 11px;

            transition:
                .2s ease;

        }


        .input-wrapper select {

            padding-right:
                15px;

            appearance:
                auto;

        }


        .input-wrapper input:hover,
        .input-wrapper select:hover {

            border-color:
                #c9dadd;

        }


        .input-wrapper input:focus,
        .input-wrapper select:focus {

            background:
                white;

            border-color:
                var(--primary);

            box-shadow:
                0 0 0 3px
                rgba(8,127,140,.08);

        }


        .input-wrapper input::placeholder {

            color:
                #a7b5ba;

        }


        /* =====================================================
           ERROS
        ====================================================== */

        .field-error {

            margin:
                5px 0 0;

            color:
                #dc3545;

            font-size:
                9px;

        }


        /* =====================================================
           SENHA
        ====================================================== */

        .password-toggle {

            position: absolute;

            right: 13px;

            top: 50%;

            transform:
                translateY(-50%);

            border: 0;

            background:
                transparent;

            color:
                #91a4aa;

            cursor:
                pointer;

            padding:
                5px;

        }


        .password-toggle:hover {

            color:
                var(--primary);

        }


        /* =====================================================
           INFORMAÇÃO DE SEGURANÇA
        ====================================================== */

        .security-box {

            display: flex;

            align-items: center;

            gap: 10px;

            padding:
                11px 13px;

            border:
                1px solid #e7eeee;

            border-radius:
                9px;

            background:
                #fafcfc;

            margin-bottom:
                20px;

        }


        .security-icon {

            width: 31px;

            height: 31px;

            flex-shrink: 0;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 8px;

            background:
                var(--primary-light);

            color:
                var(--primary);

            font-size:
                11px;

        }


        .security-text {

            color:
                #809097;

            font-size:
                9px;

            line-height:
                1.5;

        }


        .security-text strong {

            display: block;

            color:
                #536970;

            margin-bottom:
                2px;

        }


        /* =====================================================
           BOTÕES
        ====================================================== */

        .form-actions {

            display: flex;

            align-items: center;

            gap: 12px;

        }


        .btn-create {

            flex: 1;

            height: 50px;

            border: 0;

            border-radius: 10px;

            background:

                linear-gradient(
                    135deg,
                    var(--primary),
                    #0b96a3
                );

            color:
                white;

            font-family:
                inherit;

            font-size:
                11px;

            font-weight:
                700;

            cursor:
                pointer;

            box-shadow:
                0 9px 20px
                rgba(8,127,140,.16);

            transition:
                .2s ease;

        }


        .btn-create:hover {

            transform:
                translateY(-1px);

            box-shadow:
                0 13px 25px
                rgba(8,127,140,.22);

        }


        .btn-login {

            height: 50px;

            padding:
                0 20px;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            border:
                1px solid var(--border);

            border-radius:
                10px;

            background:
                white;

            color:
                #63767e;

            font-size:
                10px;

            font-weight:
                700;

            text-decoration:
                none;

            transition:
                .2s ease;

        }


        .btn-login:hover {

            color:
                var(--primary);

            background:
                var(--primary-light);

            border-color:
                #d5ecee;

            text-decoration:
                none;

        }


        /* =====================================================
           EMPRESA EXISTENTE
        ====================================================== */

        .existing-company {

            margin-top:
                18px;

            text-align:
                center;

        }


        .existing-company button {

            border:
                0;

            background:
                transparent;

            color:
                var(--primary);

            font-family:
                inherit;

            font-size:
                10px;

            font-weight:
                600;

            cursor:
                pointer;

        }


        .existing-company button:hover {

            text-decoration:
                underline;

        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .form-footer {

            margin-top:
                25px;

            padding-top:
                18px;

            border-top:
                1px solid #edf1f2;

            text-align:
                center;

        }


        .form-footer p {

            margin:
                4px 0;

            color:
                #9aa8ad;

            font-size:
                8px;

        }


        .form-footer strong {

            color:
                #71838a;

            font-weight:
                600;

        }


        /* =====================================================
           LOADING
        ====================================================== */

        .loading-modal {

            display: none;

            position: fixed;

            inset: 0;

            align-items:
                center;

            justify-content:
                center;

            background:
                rgba(7,35,42,.72);

            backdrop-filter:
                blur(5px);

            z-index:
                999999;

        }


        .loading-box {

            width:
                125px;

            height:
                125px;

            display:
                flex;

            flex-direction:
                column;

            align-items:
                center;

            justify-content:
                center;

            gap:
                12px;

            border-radius:
                17px;

            background:
                white;

            box-shadow:
                0 20px 60px
                rgba(0,0,0,.25);

        }


        .spinner {

            width:
                34px;

            height:
                34px;

            border:
                3px solid #dcecee;

            border-top-color:
                var(--primary);

            border-radius:
                50%;

            animation:
                spin .8s linear infinite;

        }


        .loading-text {

            font-size:
                9px;

            font-weight:
                600;

            color:
                #647980;

        }


        @keyframes spin {

            to {
                transform:
                    rotate(360deg);
            }

        }


        /* =====================================================
           RESPONSIVIDADE
        ====================================================== */

        @media (max-width: 1050px) {

            .setup-panel {

                width:
                    35%;

                padding:
                    40px;

            }


            .form-panel {

                width:
                    65%;

                padding:
                    40px;

            }


            .setup-panel h1 {

                font-size:
                    33px;

            }

        }


        @media (max-width: 850px) {

            .setup-page {

                display:
                    block;

            }


            .setup-panel {

                width:
                    100%;

                min-height:
                    310px;

                padding:
                    35px 25px;

            }


            .brand {

                margin-bottom:
                    28px;

            }


            .setup-panel h1 {

                font-size:
                    29px;

            }


            .setup-description {

                margin-bottom:
                    20px;

            }


            .setup-steps {

                display:
                    none;

            }


            .setup-status {

                margin-top:
                    22px;

            }


            .form-panel {

                width:
                    100%;

                min-height:
                    auto;

                padding:
                    40px 22px;

            }

        }


        @media (max-width: 560px) {

            .form-header {

                display:
                    block;

            }


            .setup-badge {

                display:
                    inline-flex;

                margin-top:
                    14px;

            }


            .fields-grid {

                grid-template-columns:
                    1fr;

            }


            .field.full {

                grid-column:
                    auto;

            }


            .form-actions {

                flex-direction:
                    column-reverse;

            }


            .btn-create,
            .btn-login {

                width:
                    100%;

            }

        }


        @media (max-width: 420px) {

            .setup-panel {

                min-height:
                    260px;

                padding:
                    28px 18px;

            }


            .brand-logo {

                width:
                    48px;

                height:
                    48px;

                font-size:
                    21px;

            }


            .brand-name {

                font-size:
                    17px;

            }


            .setup-panel h1 {

                font-size:
                    26px;

            }


            .setup-description {

                font-size:
                    11px;

            }


            .form-panel {

                padding:
                    30px 17px;

            }


            .form-header h2 {

                font-size:
                    22px;

            }

        }

    </style>

</head>


<body>

    <div
        class="loading-modal"
        id="loading-modal"
    >

        <div class="loading-box">

            <div class="spinner"></div>

            <div class="loading-text">
                A configurar...
            </div>

        </div>

    </div>


    <!-- =========================================================
         PÁGINA
    ========================================================== -->

    <main class="setup-page">


        <!-- =====================================================
             PAINEL INSTITUCIONAL
        ====================================================== -->

        <section class="setup-panel">

            <div class="setup-grid"></div>


            <div class="setup-panel-content">


                <!-- BRAND -->

                <div class="brand">

                    <div class="brand-logo">

                        <i class="fas fa-hospital"></i>

                    </div>


                    <div>

                        <div class="brand-name">

                            {{ 'Gestão Hospitalar' }}

                        </div>


                        <span class="brand-subtitle">

                            Configuração da instituição

                        </span>

                    </div>

                </div>


                <!-- TÍTULO -->

                <h1>

                    Vamos preparar a sua
                    <span>instituição.</span>

                </h1>


                <p class="setup-description">

                    Crie a conta administrativa e configure
                    as informações básicas da sua instituição
                    para começar a utilizar a plataforma.

                </p>


                <!-- PASSOS -->

                <div class="setup-steps">


                    <div class="setup-step">

                        <div class="step-number">
                            01
                        </div>

                        <span>
                            Registar os dados da instituição
                        </span>

                    </div>


                    <div class="setup-step">

                        <div class="step-number">
                            02
                        </div>

                        <span>
                            Criar o administrador principal
                        </span>

                    </div>


                    <div class="setup-step">

                        <div class="step-number">
                            03
                        </div>

                        <span>
                            Aceder ao sistema e começar
                        </span>

                    </div>


                </div>


                <!-- STATUS -->

                <div class="setup-status">

                    <span class="status-dot"></span>

                    Configuração inicial segura

                </div>

            </div>

        </section>


        <!-- =====================================================
             FORMULÁRIO
        ====================================================== -->

        <section class="form-panel">


            <div class="form-container">


                <!-- CABEÇALHO -->

                <div class="form-header">


                    <div class="form-header-left">


                        <div class="header-icon">

                            <i class="fas fa-hospital-user"></i>

                        </div>


                        <div>

                            <h2>
                                Configuração inicial
                            </h2>

                            <p>
                                Preencha os dados abaixo para
                                criar a sua instituição.
                            </p>

                        </div>

                    </div>


                    <div class="setup-badge">

                        <i class="fas fa-shield-alt"></i>

                        Ambiente protegido

                    </div>

                </div>


                <!-- =================================================
                     FORM
                ================================================== -->

                <form
                    action="{{ route('create') }}"
                    method="post"
                    id="create-form"
                >

                    @csrf


                    <!-- =================================================
                         INFORMAÇÕES DA INSTITUIÇÃO
                    ================================================== -->

                    <div class="form-section">


                        <div class="section-title">

                            <i class="fas fa-building"></i>

                            Dados da instituição

                        </div>


                        <div class="fields-grid">


                            <!-- NOME -->

                            <div class="field full">

                                <label for="nome_empresa">

                                    Nome da instituição

                                    <span class="required">
                                        *
                                    </span>

                                </label>


                                <div class="input-wrapper">

                                    <i class="fas fa-hospital"></i>


                                    <input
                                        type="text"
                                        name="nome_empresa"
                                        id="nome_empresa"
                                        value="{{ old('nome_empresa') ?? '' }}"
                                        placeholder="Ex.: Clínica Médica Nova Vida"
                                        required
                                    >

                                </div>


                                @error('nome_empresa')

                                    <p class="field-error">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            <!-- NIF -->

                            <div class="field">

                                <label for="nif">

                                    NIF

                                    <span class="required">
                                        *
                                    </span>

                                </label>


                                <div class="input-wrapper">

                                    <i class="fas fa-id-card"></i>


                                    <input
                                        type="text"
                                        name="nif"
                                        id="nif"
                                        value="{{ old('nif') ?? '' }}"
                                        placeholder="Número de identificação fiscal"
                                        required
                                    >

                                </div>


                                @error('nif')

                                    <p class="field-error">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            <!-- EMAIL -->

                            <div class="field">

                                <label for="email">

                                    E-mail institucional

                                    <span class="required">
                                        *
                                    </span>

                                </label>


                                <div class="input-wrapper">

                                    <i class="fas fa-envelope"></i>


                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email') ?? '' }}"
                                        placeholder="email@instituicao.com"
                                        required
                                    >

                                </div>


                                @error('email')

                                    <p class="field-error">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            <!-- TIPO -->

                            <div class="field full">

                                <label for="tipo_negocio">

                                    Área / tipo de actividade

                                    <span class="required">
                                        *
                                    </span>

                                </label>


                                <div class="input-wrapper">

                                    <i class="fas fa-briefcase-medical"></i>


                                    <select
                                        name="tipo_negocio"
                                        id="tipo_negocio"
                                        required
                                    >

                                        <option value="">
                                            {{ __('messages.escolher') }}
                                        </option>


                                        @if ($tipos_entidade)

                                            @foreach (
                                                $tipos_entidade
                                                as $item
                                            )

                                                <option
                                                    value="{{ $item->id ?? '' }}"
                                                    {{ old('tipo_negocio') == ($item->id ?? '') ? 'selected' : '' }}
                                                >

                                                    {{ $item->tipo }}

                                                </option>

                                            @endforeach

                                        @endif

                                    </select>

                                </div>


                                @error('tipo_negocio')

                                    <p class="field-error">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                        </div>

                    </div>


                    <!-- =================================================
                         ADMINISTRADOR
                    ================================================== -->

                    <div class="form-section">


                        <div class="section-title">

                            <i class="fas fa-user-shield"></i>

                            Conta do administrador

                        </div>


                        <div class="fields-grid">


                            <!-- PASSWORD -->

                            <div class="field">

                                <label for="password">

                                    Palavra-passe

                                    <span class="required">
                                        *
                                    </span>

                                </label>


                                <div class="input-wrapper">

                                    <i class="fas fa-lock"></i>


                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        placeholder="Crie uma palavra-passe"
                                        required
                                    >


                                    <button
                                        type="button"
                                        class="password-toggle"
                                        data-target="password"
                                        aria-label="Mostrar palavra-passe"
                                    >

                                        <i class="fas fa-eye"></i>

                                    </button>

                                </div>


                                @error('password')

                                    <p class="field-error">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            <!-- CONFIRMAR -->

                            <div class="field">

                                <label for="r_password">

                                    Confirmar palavra-passe

                                    <span class="required">
                                        *
                                    </span>

                                </label>


                                <div class="input-wrapper">

                                    <i class="fas fa-lock"></i>


                                    <input
                                        type="password"
                                        name="r_password"
                                        id="r_password"
                                        placeholder="Repita a palavra-passe"
                                        required
                                    >


                                    <button
                                        type="button"
                                        class="password-toggle"
                                        data-target="r_password"
                                        aria-label="Mostrar palavra-passe"
                                    >

                                        <i class="fas fa-eye"></i>

                                    </button>

                                </div>


                                @error('r_password')

                                    <p class="field-error">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                        </div>

                    </div>


                    <!-- =================================================
                         SEGURANÇA
                    ================================================== -->

                    <div class="security-box">


                        <div class="security-icon">

                            <i class="fas fa-shield-alt"></i>

                        </div>


                        <div class="security-text">

                            <strong>
                                Conta administrativa protegida
                            </strong>

                            Utilize uma palavra-passe forte.
                            Esta conta terá acesso inicial
                            à administração do sistema.

                        </div>

                    </div>


                    <!-- =================================================
                         BOTÕES
                    ================================================== -->

                    <div class="form-actions">


                        <a
                            href="{{ route('login') }}"
                            class="btn-login"
                        >

                            <i class="fas fa-arrow-left"></i>

                            Já tenho uma conta

                        </a>


                        <button
                            type="submit"
                            class="btn-create"
                        >

                            <i class="fas fa-check-circle mr-2"></i>

                            Criar instituição e continuar

                        </button>


                    </div>


                </form>


                <!-- =================================================
                     EMPRESA EXISTENTE
                ================================================== -->

                @if (!\App\Models\HashLicenca::first())

                    <div class="existing-company">

                        <button
                            type="button"
                            id="existente"
                        >

                            <i class="fas fa-search mr-1"></i>

                            A minha instituição já está registada

                        </button>

                    </div>

                @endif


                <!-- =================================================
                     FOOTER
                ================================================== -->

                <div class="form-footer">

                    <p>

                        {{ 'Sistema Integrado de Gestão' }}

                    </p>


                    <p>

                        Suporte técnico:

                        <strong>
                            +244 974 507 034
                        </strong>

                    </p>


                    <p>

                        © {{ date('Y') }}

                        <strong>
                            Angoengenharia & Sistemas Informáticos
                        </strong>

                    </p>

                </div>


            </div>

        </section>

    </main>


    <!-- =========================================================
         SCRIPTS
    ========================================================== -->

    <script
        src="{{ asset('plugins/jquery/jquery.min.js') }}"
    ></script>


    <script
        src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"
    ></script>


    <script
        src="{{ asset('dist/js/sweetalert2@11.js') }}"
    ></script>


    <script
        src="{{ asset('dist/js/adminlte.min.js') }}"
    ></script>


    <script>


        /* =====================================================
           MOSTRAR / OCULTAR PASSWORD
        ====================================================== */

        $('.password-toggle').on(
            'click',
            function () {


                const target =
                    $(this).data('target');


                const input =
                    $('#' + target);


                const icon =
                    $(this).find('i');


                if (
                    input.attr('type') === 'password'
                ) {


                    input.attr(
                        'type',
                        'text'
                    );


                    icon
                        .removeClass('fa-eye')
                        .addClass('fa-eye-slash');


                    $(this).attr(
                        'aria-label',
                        'Ocultar palavra-passe'
                    );


                } else {


                    input.attr(
                        'type',
                        'password'
                    );


                    icon
                        .removeClass('fa-eye-slash')
                        .addClass('fa-eye');


                    $(this).attr(
                        'aria-label',
                        'Mostrar palavra-passe'
                    );

                }

            }
        );


        /* =====================================================
           EMPRESA EXISTENTE
        ====================================================== */

        $('#existente').on(
            'click',
            function (e) {


                e.preventDefault();


                $.ajax({

                    url:
                        `{{ route('existente') }}`,

                    method:
                        'GET',


                    beforeSend:
                        function () {

                            progressBeforeSend(
                                'A verificar...',
                                'Estamos a preparar o acesso à instituição existente.'
                            );

                        },


                    success:
                        function (response) {

                            Swal.close();


                            showMessage(
                                'Tudo certo!',
                                'A instituição foi localizada.',
                                'success'
                            );


                            if (
                                response.redirect
                            ) {

                                setTimeout(
                                    function () {

                                        window.location.href =
                                            response.redirect;

                                    },
                                    600
                                );

                            }

                        },


                    error:
                        function (xhr) {

                            Swal.close();


                            if (
                                xhr.status === 422 &&
                                xhr.responseJSON?.errors
                            ) {


                                let messages = '';


                                $.each(
                                    xhr.responseJSON.errors,
                                    function (_, value) {

                                        messages +=
                                            value + '\n';

                                    }
                                );


                                showMessage(
                                    'Dados inválidos',
                                    messages,
                                    'error'
                                );


                            } else {


                                showMessage(

                                    'Não foi possível continuar',

                                    xhr.responseJSON?.message ??
                                    'Ocorreu um erro inesperado.',

                                    'error'

                                );

                            }

                        }

                });

            }
        );


        /* =====================================================
           SUBMIT
        ====================================================== */

        $('#create-form').on(
            'submit',
            function (e) {


                e.preventDefault();


                const form =
                    $(this);


                $.ajax({

                    url:
                        form.attr('action'),

                    method:
                        form.attr('method'),

                    data:
                        form.serialize(),

                    headers: {

                        'X-CSRF-TOKEN':
                            $('meta[name="csrf-token"]').attr('content')

                    },


                    beforeSend:
                        function () {

                            progressBeforeSend(
                                'A criar a instituição...',
                                'Estamos a configurar o seu ambiente.'
                            );

                        },


                    success:
                        function (response) {

                            Swal.close();


                            showMessage(
                                'Instituição criada!',
                                'A configuração foi concluída com sucesso.',
                                'success'
                            );


                            setTimeout(
                                function () {

                                    if (
                                        response.redirect
                                    ) {

                                        window.location.href =
                                            response.redirect;

                                    }

                                },
                                800
                            );

                        },


                    error:
                        function (xhr) {

                            Swal.close();


                            if (
                                xhr.status === 422
                            ) {


                                const errors =
                                    xhr.responseJSON?.errors;


                                let messages = '';


                                if (errors) {

                                    $.each(
                                        errors,
                                        function (_, value) {

                                            if (
                                                Array.isArray(value)
                                            ) {

                                                messages +=
                                                    value.join('\n') +
                                                    '\n';

                                            } else {

                                                messages +=
                                                    value +
                                                    '\n';

                                            }

                                        }
                                    );

                                }


                                showMessage(

                                    'Verifique os dados',

                                    messages ||
                                    'Existem campos que precisam de atenção.',

                                    'error'

                                );


                            } else {


                                showMessage(

                                    'Erro',

                                    xhr.responseJSON?.message ??
                                    'Não foi possível concluir a configuração.',

                                    'error'

                                );

                            }

                        }

                });

            }
        );


        /* =====================================================
           SWEET ALERT — PROCESSAMENTO
        ====================================================== */

        function progressBeforeSend(

            title = 'Processando...',

            text = 'Por favor, aguarde.',

            icon = 'info'

        ) {


            Swal.fire({

                title:
                    title,

                text:
                    text,

                icon:
                    icon,

                allowOutsideClick:
                    false,

                allowEscapeKey:
                    false,

                showConfirmButton:
                    false,

                didOpen:
                    function () {

                        Swal.showLoading();

                    }

            });

        }


        /* =====================================================
           MENSAGENS
        ====================================================== */

        function showMessage(

            title,

            text,

            icon

        ) {


            Swal.fire({

                icon:
                    icon,

                title:
                    title,

                text:
                    text,

                toast:
                    true,

                position:
                    'top-end',

                showConfirmButton:
                    false,

                timer:
                    5000,

                timerProgressBar:
                    true

            });

        }


        /* =====================================================
           LOADING MODAL
        ====================================================== */

        function showProgressModal() {

            const modal =
                document.getElementById(
                    'loading-modal'
                );


            modal.style.display =
                'flex';

        }


        function hideProgressModal() {

            const modal =
                document.getElementById(
                    'loading-modal'
                );


            modal.style.display =
                'none';

        }


    </script>

</body>

</html>