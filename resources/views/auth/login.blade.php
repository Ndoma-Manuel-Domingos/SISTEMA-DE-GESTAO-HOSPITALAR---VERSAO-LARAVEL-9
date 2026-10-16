<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ 'Sistema de Gestão Hospitalar' }} | {{ 'Gestão Clínica Integrada' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <style>
        :root {
            --primary: #087f8c;
            --primary-dark: #05636d;
            --primary-light: #e8f8f9;
            --blue: #1268a9;
            --dark: #102f3b;
            --text: #29404a;
            --muted: #7b8d95;
            --border: #e1eaed;
            --background: #f5f9fa;
            --white: #ffffff;
        }
        * {
            box-sizing: border-box;
        }
        html,
        body {

            width: 100%;
            min-height: 100%;

            margin: 0;

            font-family: 'Inter', sans-serif;

            background: var(--background);

            color: var(--text);

        }


        body {

            overflow-x: hidden;

        }


        /* =====================================================
           CONTAINER
        ====================================================== */

        .hospital-login {

            min-height: 100vh;

            display: flex;

            background: var(--white);

        }


        /* =====================================================
           LADO ESQUERDO
        ====================================================== */

        .hospital-panel {

            position: relative;

            width: 55%;

            min-height: 100vh;

            overflow: hidden;

            display: flex;

            align-items: center;

            padding: 70px;

            color: white;

            background:

                linear-gradient(
                    135deg,
                    rgba(4, 66, 76, .97),
                    rgba(8, 127, 140, .91)
                ),

                url('/dist/img/hospital-background.jpg');

            background-size: cover;

            background-position: center;

        }


        /* =====================================================
           EFEITOS DE FUNDO
        ====================================================== */

        .hospital-panel::before {

            content: "";

            position: absolute;

            width: 650px;

            height: 650px;

            border-radius: 50%;

            border: 1px solid
                rgba(255,255,255,.08);

            right: -300px;

            top: -220px;

        }


        .hospital-panel::after {

            content: "";

            position: absolute;

            width: 500px;

            height: 500px;

            border-radius: 50%;

            border: 1px solid
                rgba(255,255,255,.06);

            left: -280px;

            bottom: -250px;

        }


        /* =====================================================
           GRID DECORATIVO
        ====================================================== */

        .medical-grid {

            position: absolute;

            inset: 0;

            opacity: .08;

            background-image:

                linear-gradient(
                    rgba(255,255,255,.4) 1px,
                    transparent 1px
                ),

                linear-gradient(
                    90deg,
                    rgba(255,255,255,.4) 1px,
                    transparent 1px
                );

            background-size: 45px 45px;

        }


        /* =====================================================
           CONTEÚDO
        ====================================================== */

        .hospital-content {

            position: relative;

            z-index: 5;

            width: 100%;

            max-width: 650px;

        }


        /* =====================================================
           LOGO
        ====================================================== */

        .hospital-brand {

            display: flex;

            align-items: center;

            gap: 15px;

            margin-bottom: 75px;

        }


        .hospital-logo {

            width: 62px;

            height: 62px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 17px;

            background: white;

            color: var(--primary);

            font-size: 28px;

            box-shadow:
                0 15px 35px
                rgba(0,0,0,.15);

        }


        .hospital-brand-name {

            font-size: 21px;

            font-weight: 800;

            letter-spacing: -.5px;

        }


        .hospital-brand-subtitle {

            display: block;

            margin-top: 4px;

            font-size: 11px;

            font-weight: 500;

            letter-spacing: .3px;

            color:
                rgba(255,255,255,.68);

        }


        /* =====================================================
           TITULO
        ====================================================== */

        .hospital-content h1 {

            margin: 0;

            max-width: 600px;

            font-size: 46px;

            line-height: 1.13;

            letter-spacing: -1.8px;

            font-weight: 800;

        }


        .hospital-content h1 span {

            color: #8ee5eb;

        }


        .hospital-description {

            max-width: 570px;

            margin-top: 24px;

            margin-bottom: 42px;

            color:
                rgba(255,255,255,.76);

            font-size: 15px;

            line-height: 1.8;

        }


        /* =====================================================
           RECURSOS
        ====================================================== */

        .medical-services {

            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 13px;

            max-width: 530px;

        }


        .medical-service {

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 14px;

            border-radius: 11px;

            background:
                rgba(255,255,255,.08);

            border:
                1px solid
                rgba(255,255,255,.09);

            backdrop-filter: blur(8px);

            font-size: 12px;

            font-weight: 500;

        }


        .medical-service i {

            width: 30px;

            height: 30px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 8px;

            background:
                rgba(255,255,255,.12);

            color: #a5edf1;

        }


        /* =====================================================
           INDICADOR DE SEGURANÇA
        ====================================================== */

        .security-status {

            display: flex;

            align-items: center;

            gap: 9px;

            margin-top: 42px;

            font-size: 11px;

            color:
                rgba(255,255,255,.63);

        }


        .security-dot {

            width: 8px;

            height: 8px;

            border-radius: 50%;

            background: #6ee7b7;

            box-shadow:
                0 0 0 5px
                rgba(110,231,183,.12);

        }


        /* =====================================================
           LADO DO LOGIN
        ====================================================== */

        .login-panel {

            width: 45%;

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 50px;

            background: white;

        }


        .login-container {

            width: 100%;

            max-width: 430px;

        }


        /* =====================================================
           CABEÇALHO
        ====================================================== */

        .login-heading {

            margin-bottom: 34px;

        }


        .login-heading-icon {

            width: 52px;

            height: 52px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-bottom: 20px;

            border-radius: 14px;

            background: var(--primary-light);

            color: var(--primary);

            font-size: 21px;

        }


        .login-heading h2 {

            margin: 0;

            font-size: 28px;

            line-height: 1.25;

            font-weight: 800;

            letter-spacing: -.8px;

            color: var(--dark);

        }


        .login-heading p {

            margin-top: 9px;

            margin-bottom: 0;

            font-size: 13px;

            line-height: 1.7;

            color: var(--muted);

        }


        /* =====================================================
           CAMPOS
        ====================================================== */

        .form-field {

            margin-bottom: 20px;

        }


        .form-field label {

            display: block;

            margin-bottom: 8px;

            font-size: 12px;

            font-weight: 700;

            color: #435963;

        }


        .field-wrapper {

            position: relative;

        }


        .field-icon {

            position: absolute;

            left: 16px;

            top: 50%;

            transform: translateY(-50%);

            color: #93a7ae;

            font-size: 15px;

            z-index: 2;

        }


        .field-wrapper input {

            width: 100%;

            height: 54px;

            padding:

                0 48px;

            border:

                1px solid var(--border);

            border-radius: 11px;

            background: #fbfdfd;

            color: var(--dark);

            outline: none;

            font-size: 13px;

            transition:
                .2s ease;

        }


        .field-wrapper input:hover {

            border-color: #c9dadd;

        }


        .field-wrapper input:focus {

            background: white;

            border-color: var(--primary);

            box-shadow:

                0 0 0 4px
                rgba(8,127,140,.09);

        }


        .field-wrapper input::placeholder {

            color: #a7b5ba;

        }


        /* =====================================================
           BOTÃO SENHA
        ====================================================== */

        .password-button {

            position: absolute;

            right: 14px;

            top: 50%;

            transform: translateY(-50%);

            border: 0;

            padding: 5px;

            background: transparent;

            color: #91a4aa;

            cursor: pointer;

        }


        .password-button:hover {

            color: var(--primary);

        }


        /* =====================================================
           ERROS
        ====================================================== */

        .field-error {

            margin:

                7px 0 0;

            font-size: 11px;

            color: #dc3545;

        }


        /* =====================================================
           OPÇÕES
        ====================================================== */

        .login-options {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin:

                5px 0 24px;

        }


        .remember-user {

            display: flex;

            align-items: center;

            gap: 7px;

            font-size: 11px;

            color: var(--muted);

            cursor: pointer;

        }


        .remember-user input {

            accent-color: var(--primary);

        }


        .forgot-password {

            color: var(--primary);

            font-size: 11px;

            font-weight: 600;

            text-decoration: none;

        }


        .forgot-password:hover {

            color: var(--primary-dark);

            text-decoration: none;

        }


        /* =====================================================
           BOTÃO LOGIN
        ====================================================== */

        .login-button {

            width: 100%;

            height: 54px;

            border: 0;

            border-radius: 11px;

            background:

                linear-gradient(
                    135deg,
                    var(--primary),
                    #0b95a3
                );

            color: white;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            transition:

                transform .2s ease,
                box-shadow .2s ease;

            box-shadow:

                0 9px 22px
                rgba(8,127,140,.18);

        }


        .login-button:hover {

            transform: translateY(-1px);

            box-shadow:

                0 13px 27px
                rgba(8,127,140,.23);

        }


        .login-button:active {

            transform:
                translateY(0);

        }


        /* =====================================================
           SEGURANÇA
        ====================================================== */

        .secure-login {

            display: flex;

            align-items: center;

            gap: 11px;

            margin-top: 18px;

            padding: 12px 14px;

            border:

                1px solid #e8eeee;

            border-radius: 10px;

            background: #fafcfc;

        }


        .secure-login-icon {

            width: 31px;

            height: 31px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 8px;

            background: var(--primary-light);

            color: var(--primary);

            font-size: 12px;

        }


        .secure-login-text {

            font-size: 10px;

            line-height: 1.5;

            color: #819198;

        }


        .secure-login-text strong {

            display: block;

            color: #526870;

            font-size: 10px;

            margin-bottom: 2px;

        }


        /* =====================================================
           LINKS ADMINISTRATIVOS
        ====================================================== */

        .administrative-links {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 10px;

            margin-top: 25px;

            padding-top: 24px;

            border-top:

                1px solid #edf1f2;

        }


        .administrative-link {

            display: flex;

            align-items: center;

            gap: 9px;

            padding: 11px;

            border-radius: 9px;

            background: #fafcfc;

            border:

                1px solid #edf1f2;

            color: #63777e;

            font-size: 10px;

            font-weight: 600;

            text-decoration: none;

            transition: .2s ease;

        }


        .administrative-link:hover {

            color: var(--primary);

            background:
                var(--primary-light);

            border-color:
                #d4eef0;

            text-decoration: none;

        }


        .administrative-link i {

            color: var(--primary);

        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .login-footer {

            text-align: center;

            margin-top: 27px;

        }


        .login-footer p {

            margin: 4px 0;

            color: #9aa8ad;

            font-size: 9px;

        }


        .login-footer strong {

            color: #71838a;

            font-weight: 600;

        }


        /* =====================================================
           LOADING
        ====================================================== */

        .loading-modal {

            display: none;

            position: fixed;

            inset: 0;

            align-items: center;

            justify-content: center;

            background:
                rgba(7,35,42,.72);

            backdrop-filter:
                blur(5px);

            z-index: 999999;

        }


        .loading-box {

            width: 120px;

            height: 120px;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            gap: 12px;

            border-radius: 17px;

            background: white;

            box-shadow:
                0 20px 60px
                rgba(0,0,0,.25);

        }


        .loading-spinner {

            width: 35px;

            height: 35px;

            border:

                3px solid #dcecee;

            border-top-color:

                var(--primary);

            border-radius: 50%;

            animation:
                spin .8s linear infinite;

        }


        .loading-text {

            font-size: 10px;

            font-weight: 600;

            color: #647980;

        }


        @keyframes spin {

            to {
                transform:
                    rotate(360deg);
            }

        }


        /* =====================================================
           MOBILE
        ====================================================== */

        @media (max-width: 1100px) {

            .hospital-panel {

                width: 50%;

                padding: 45px;

            }

            .login-panel {

                width: 50%;

                padding: 35px;

            }

            .hospital-content h1 {

                font-size: 38px;

            }

        }


        @media (max-width: 850px) {

            .hospital-login {

                display: block;

            }


            .hospital-panel {

                width: 100%;

                min-height: 300px;

                padding: 35px 25px;

            }


            .hospital-content {

                max-width: 650px;

            }


            .hospital-brand {

                margin-bottom: 30px;

            }


            .hospital-content h1 {

                font-size: 31px;

            }


            .hospital-description {

                margin-bottom: 25px;

            }


            .medical-services {

                display: none;

            }


            .security-status {

                margin-top: 25px;

            }


            .login-panel {

                width: 100%;

                min-height: auto;

                padding:

                    45px 22px 30px;

            }

        }


        @media (max-width: 480px) {

            .hospital-panel {

                min-height: 250px;

                padding: 28px 20px;

            }


            .hospital-brand {

                margin-bottom: 25px;

            }


            .hospital-logo {

                width: 48px;

                height: 48px;

                font-size: 21px;

            }


            .hospital-brand-name {

                font-size: 17px;

            }


            .hospital-content h1 {

                font-size: 27px;

                letter-spacing: -.8px;

            }


            .hospital-description {

                font-size: 12px;

                margin-top: 15px;

                margin-bottom: 20px;

            }


            .login-panel {

                padding:

                    35px 18px 25px;

            }


            .login-heading h2 {

                font-size: 25px;

            }


            .administrative-links {

                grid-template-columns: 1fr;

            }

        }

    </style>
</head>
<body>
    <div class="loading-modal" id="loading-modal">
        <div class="loading-box">
            <div class="loading-spinner"></div>
            <div class="loading-text">
                A autenticar...
            </div>
        </div>
    </div>
    <main class="hospital-login">
        <section class="hospital-panel">
            <div class="medical-grid"></div>
            <div class="hospital-content">
                <div class="hospital-brand">
                    <div class="hospital-logo">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div>
                        <div class="hospital-brand-name">
                            {{ 'Gestão Hospitalar' }}
                        </div>
                        <span class="hospital-brand-subtitle">
                            {{'Sistema Integrado de Gestão de Saúde' }}
                        </span>
                    </div>
                </div>

                <h1>
                    Tecnologia para uma
                    <span>saúde mais eficiente.</span>
                </h1>
                <p class="hospital-description">

                    Uma plataforma integrada para apoiar
                    profissionais de saúde na gestão de pacientes,
                    processos clínicos e operações da instituição.

                </p>


                <!-- SERVIÇOS -->

                <div class="medical-services">


                    <div class="medical-service">

                        <i class="fas fa-user-injured"></i>

                        <span>
                            Gestão de pacientes
                        </span>

                    </div>


                    <div class="medical-service">

                        <i class="fas fa-file-medical"></i>

                        <span>
                            Informação clínica
                        </span>

                    </div>


                    <div class="medical-service">

                        <i class="fas fa-user-md"></i>

                        <span>
                            Gestão de profissionais
                        </span>

                    </div>


                    <div class="medical-service">

                        <i class="fas fa-chart-line"></i>

                        <span>
                            Gestão e indicadores
                        </span>

                    </div>


                </div>


                <!-- SEGURANÇA -->

                <div class="security-status">

                    <span class="security-dot"></span>

                    Plataforma operacional protegida

                </div>


            </div>

        </section>


        <!-- =====================================================
             PAINEL DE LOGIN
        ====================================================== -->

        <section class="login-panel">


            <div class="login-container">


                <!-- CABEÇALHO -->

                <div class="login-heading">


                    <div class="login-heading-icon">

                        <i class="fas fa-sign-in-alt"></i>

                    </div>


                    <h2>
                        Aceder ao sistema
                    </h2>


                    <p>

                        Introduza as suas credenciais para
                        entrar na plataforma.

                    </p>


                </div>


                <!-- =================================================
                     FORM
                ================================================== -->

                <form
                    action="{{ route('check') }}"
                    method="post"
                    id="login-form"
                >

                    @csrf


                    <!-- UTILIZADOR -->

                    <div class="form-field">

                        <label for="email">

                            Utilizador ou e-mail

                        </label>


                        <div class="field-wrapper">

                            <i
                                class="fas fa-user field-icon"
                            ></i>


                            <input
                                type="text"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Digite o seu utilizador"
                                autocomplete="username"
                                required
                            >

                        </div>


                        @error('email')

                            <p class="field-error">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>


                    <!-- SENHA -->

                    <div class="form-field">

                        <label for="password">

                            Palavra-passe

                        </label>


                        <div class="field-wrapper">

                            <i
                                class="fas fa-lock field-icon"
                            ></i>


                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Digite a sua palavra-passe"
                                autocomplete="current-password"
                                required
                            >


                            <button
                                type="button"
                                class="password-button"
                                id="togglePassword"
                                aria-label="Mostrar palavra-passe"
                            >

                                <i
                                    class="fas fa-eye"
                                ></i>

                            </button>

                        </div>


                        @error('password')

                            <p class="field-error">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>


                    <!-- OPÇÕES -->

                    <div class="login-options">


                        <label class="remember-user">

                            <input
                                type="checkbox"
                                name="remember"
                            >

                            Manter sessão iniciada

                        </label>


                        <a
                            href="{{ route('update_pass') }}"
                            class="forgot-password"
                        >

                            Esqueci a palavra-passe

                        </a>


                    </div>


                    <!-- BOTÃO -->

                    <button
                        type="submit"
                        class="login-button"
                    >

                        <i class="fas fa-sign-in-alt mr-2"></i>

                        Entrar no sistema

                    </button>


                </form>


                <!-- SEGURANÇA -->

                <div class="secure-login">


                    <div class="secure-login-icon">

                        <i class="fas fa-shield-alt"></i>

                    </div>


                    <div class="secure-login-text">

                        <strong>
                            Acesso protegido
                        </strong>

                        As credenciais são utilizadas
                        exclusivamente para autenticação
                        no sistema.

                    </div>


                </div>


                <!-- =================================================
                     ADMINISTRAÇÃO
                ================================================== -->

                <div class="administrative-links">


                    <a
                        href="{{ route('licenses.upload') }}"
                        class="administrative-link"
                    >

                        <i class="fas fa-key"></i>

                        Activar licença

                    </a>


                    @if (!\App\Models\HashLicenca::first())

                        <a
                            href="{{ route('register') }}"
                            class="administrative-link"
                        >

                            <i class="fas fa-hospital"></i>

                            Configuração inicial

                        </a>

                    @endif


                </div>


                <!-- =================================================
                     FOOTER
                ================================================== -->

                <div class="login-footer">

                    <p>

                        {{ $descricao ?? 'Sistema Integrado de Gestão de Saúde' }}

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
    <script src="{{ asset('dist/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script>
        $('#togglePassword').on('click', function () {
            const password = $('#password');
            const icon = $(this).find('i');
            if ( password.attr('type') === 'password') {
                password.attr('type','text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
                $(this).attr( 'aria-label', 'Ocultar palavra-passe');
            } else {
                password.attr(
                    'type',
                    'password'
                );
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
                $(this).attr(
                    'aria-label',
                    'Mostrar palavra-passe'
                );
            }
        });
        $('#login-form').on(
            'submit',
            function (e) {
                e.preventDefault();
                const form =  $(this);
                $.ajax({
                    url: form.attr('action'),
                    method:  form.attr('method'),
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        progressBeforeSend();
                    },
                    success: function (response) {
                        Swal.close();
                        showMessage(
                            'Bem-vindo!',
                            'Autenticação realizada com sucesso.',
                            'success'
                        );
                        setTimeout(
                            function () {
                                window.location.href = response.redirect;
                            }, 700
                        );
                    },
                    error: function (xhr) {
                        Swal.close();
                        if (
                            xhr.status === 422
                        ) {
                            let errors =
                                xhr.responseJSON?.errors;


                            let messages = '';


                            if (errors) {

                                $.each(
                                    errors,
                                    function (key, value) {

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
                                'Existem dados inválidos.',

                                'error'

                            );


                        } else {


                            showMessage(

                                'Não foi possível entrar',

                                xhr.responseJSON?.message ??
                                'Ocorreu um erro ao processar o acesso.',

                                'error'

                            );

                        }

                    }

                });

            }
        );


        /* =====================================================
           SWEET ALERT
        ====================================================== */

        function progressBeforeSend(

            title = 'A autenticar...',

            text = 'A validar as suas credenciais.',

            icon = 'info'

        ) {


            Swal.fire({

                title: title,

                text: text,

                icon: icon,

                allowOutsideClick: false,

                allowEscapeKey: false,

                showConfirmButton: false,

                didOpen: function () {

                    Swal.showLoading();

                }

            });

        }


        function showMessage(

            title,

            text,

            icon

        ) {


            Swal.fire({

                icon: icon,

                title: title,

                text: text,

                toast: true,

                position: 'top-end',

                showConfirmButton: false,

                timer: 4500,

                timerProgressBar: true

            });

        }


        /* =====================================================
           LOADING
        ====================================================== */

        function showProgressModal() {

            $('#loading-modal').css(
                'display',
                'flex'
            );

        }


        function hideProgressModal() {

            $('#loading-modal').hide();

        }


        /* =====================================================
           ATALHO: ALTERAR SENHA
        ====================================================== */

        document.addEventListener(
            'keydown',
            function (event) {


                if (

                    event.shiftKey &&

                    (
                        event.key === 'Q' ||
                        event.key === 'q'
                    )

                ) {


                    event.preventDefault();


                    window.location.href =
                        "{{ route('update_pass') }}";

                }

            }
        );


        /* =====================================================
           ATALHO: LICENÇA
        ====================================================== */

        document.addEventListener(
            'keydown',
            function (event) {


                if (

                    event.shiftKey &&

                    (
                        event.key === 'G' ||
                        event.key === 'g'
                    )

                ) {


                    event.preventDefault();


                    window.location.href =
                        "{{ route('licenses.create') }}";

                }

            }
        );


    </script>
</body>
</html>