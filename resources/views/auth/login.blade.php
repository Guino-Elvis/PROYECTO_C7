<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            <a href="{{ route('register') }}"
                class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                {{ __('Registrar') }}
            </a>
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>


    </x-authentication-card>



    <div class="login-wrap">
        <div class="login-html">
            <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1"
                class="tab">Sign In</label>
            <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2"
                class="tab">Sign
                Up</label>
            <div class="login-form">

                <div class="sign-in-htm">
                    <x-validation-errors class="mb-4 bg-white rounded-xl px-5 py-5" />

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="group">
                            <label class="label" for="email" value="{{ __('Email') }}">Correo electrónico</label>
                            <input id="email" type="email" name="email" :value="old('email')" required
                                autofocus autocomplete="username" class="input" />
                        </div>
                        <div class="group">
                            <label for="password" value="{{ __('Password') }}" class="label">Password</label>
                            <input id="password" class="input" type="password" name="password" required
                                autocomplete="current-password">

                        </div>
                        <div class="block mt-4 mb-4">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>
                        <div class="group">
                            <input type="submit" class="button" style="cursor: pointer;" value="Iniciar sesion">
                        </div>
                        <div class="hr"></div>

                        @if (Route::has('password.request'))
                            <div class="foot-lnk">
                                <a class="underline text-xl text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            </div>
                        @endif
                    </form>
                </div>

                <div class="sign-up-htm flex w-auto h-full">
                    <x-validation-errors class="mb-4 bg-white rounded-xl px-5 py-5" />
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="group">
                            <label for="name" value="{{ __('Name') }}" class="label">Username</label>
                            <input id="name" type="text" name="name" :value="old('name')" required
                                autofocus autocomplete="name" class="input">
                        </div>
                        <div class="group">
                            <label for="email" value="{{ __('Email') }}" class="label">Email</label>
                            <input id="email" type="email" name="email" :value="old('email')" required
                                autocomplete="username" class="input">
                        </div>
                        <div class="flex flex-row gap-4">
                            <div class="group">
                                <label for="apellido_p" value="{{ __('Apellido Paterno') }}" class="label">Apellido
                                    Paterno</label>
                                <input id="apellido_p" type="text" name="apellido_p" :value="old('apellido_p')"
                                    required autocomplete="name" class="input">
                            </div>
                            <div class="group">
                                <label for="apellido_m" value="{{ __('Apellido Materno') }}" class="label">Apellido
                                    Materno</label>
                                <input id="apellido_m" type="text" name="apellido_m" :value="old('apellido_m')"
                                    required autocomplete="name" class="input">
                            </div>
                        </div>

                        <div class="group">
                            <label for="direccion" value="{{ __('Direccion') }}" class="label">Direccion</label>
                            <input id="direccion"  type="text" name="direccion"
                            :value="old('direccion')"
                            required autocomplete="direccion" class="input">
                        </div>

                        <div class="flex flex-row gap-4">
                            <div class="group">
                                <label for="dni" value="{{ __('DNI') }}" class="label">DNI</label>
                                <input id="dni"  type="text" name="dni"
                                    :value="old('dni')" required autocomplete="dni" class="input">
                            </div>
                            <div class="group">
                                <label for="telefono" value="{{ __('Telefono') }}" class="label">Telefono</label>
                                <input id="telefono"  type="text" name="telefono"
                                    :value="old('telefono')" required autocomplete="telefono" class="input">
                            </div>
                        </div>

                        <div class="group">
                            <label for="password" value="{{ __('Password') }}" class="label">Password</label>
                            <input id="password"  type="password" name="password" required
                                autocomplete="new-password" class="input">
                        </div>
                        <div class="group">
                            <label for="password_confirmation" value="{{ __('Confirm Password') }}"
                                class="label">Confirm Password</label>
                            <input id="password_confirmation"  type="password"
                                name="password_confirmation" required autocomplete="new-password" class="input">
                        </div>
                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="mt-4">
                                <x-label for="terms">
                                    <div class="flex items-center">
                                        <x-checkbox name="terms" id="terms" required />

                                        <div class="ml-2">
                                            {!! __('Acepto los :terms_of_service y :privacy_policy', [
                                                'terms_of_service' =>
                                                    '<a target="_blank" href="' .
                                                    route('terms.show') .
                                                    '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                    __('Términos de servicio') .
                                                    '</a>',
                                                'privacy_policy' =>
                                                    '<a target="_blank" href="' .
                                                    route('policy.show') .
                                                    '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                    __('Política de privacidad') .
                                                    '</a>',
                                            ]) !!}
                                        </div>
                                    </div>
                                </x-label>
                            </div>
                        @endif
                        <div class="group">
                            <input type="submit" class="button" value="Registrar" style="cursor: pointer;">
                        </div>

                        <div class="hr"></div>
                        <div class="foot-lnk">
                            <a href="{{ route('login') }}">¿Ya estas registrado?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>




<style>
    body {
        margin: 0;
        color: #6a6f8c;
        background: #c8c8c8;
        font: 600 16px/18px 'Open Sans', sans-serif;
    }

    *,
    :after,
    :before {
        box-sizing: border-box
    }

    .clearfix:after,
    .clearfix:before {
        content: '';
        display: table
    }

    .clearfix:after {
        clear: both;
        display: block
    }

    a {
        color: inherit;
        text-decoration: none
    }

    .login-wrap {
        width: 100%;
        margin: auto;
        max-width: 525px;
        min-height: 670px;
        position: relative;
        background: url(https://raw.githubusercontent.com/khadkamhn/day-01-login-form/master/img/bg.jpg) no-repeat center;
        box-shadow: 0 12px 15px 0 rgba(0, 0, 0, .24), 0 17px 50px 0 rgba(0, 0, 0, .19);
    }

    .login-html {
        width: 100%;
        height: 100%;
        position: absolute;
        padding: 90px 70px 50px 70px;
        background: rgba(40, 57, 101, .9);
    }

    .login-html .sign-in-htm,
    .login-html .sign-up-htm {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        position: absolute;
        transform: rotateY(180deg);
        backface-visibility: hidden;
        transition: all .4s linear;
    }

    .login-html .sign-in,
    .login-html .sign-up,
    .login-form .group .check {
        display: none;
    }

    .login-html .tab,
    .login-form .group .label,
    .login-form .group .button {
        text-transform: uppercase;
    }

    .login-html .tab {
        font-size: 22px;
        margin-right: 15px;
        padding-bottom: 5px;
        margin: 0 15px 10px 0;
        display: inline-block;
        border-bottom: 2px solid transparent;
    }

    .login-html .sign-in:checked+.tab,
    .login-html .sign-up:checked+.tab {
        color: #fff;
        border-color: #1161ee;
    }

    .login-form {
        min-height: 345px;
        position: relative;
        perspective: 1000px;
        transform-style: preserve-3d;
    }

    .login-form .group {
        margin-bottom: 15px;
    }

    .login-form .group .label,
    .login-form .group .input,
    .login-form .group .button {
        width: 100%;
        color: #fff;
        display: block;
    }

    .login-form .group .input,
    .login-form .group .button {
        border: none;
        padding: 15px 20px;
        border-radius: 25px;
        background: rgba(255, 255, 255, .1);
    }

    .login-form .group input[data-type="password"] {
        text-security: circle;
        -webkit-text-security: circle;
    }

    .login-form .group .label {
        color: #aaa;
        font-size: 12px;
    }

    .login-form .group .button {
        background: #1161ee;
    }

    .login-form .group label .icon {
        width: 15px;
        height: 15px;
        border-radius: 2px;
        position: relative;
        display: inline-block;
        background: rgba(255, 255, 255, .1);
    }

    .login-form .group label .icon:before,
    .login-form .group label .icon:after {
        content: '';
        width: 10px;
        height: 2px;
        background: #fff;
        position: absolute;
        transition: all .2s ease-in-out 0s;
    }

    .login-form .group label .icon:before {
        left: 3px;
        width: 5px;
        bottom: 6px;
        transform: scale(0) rotate(0);
    }

    .login-form .group label .icon:after {
        top: 6px;
        right: 0;
        transform: scale(0) rotate(0);
    }

    .login-form .group .check:checked+label {
        color: #fff;
    }

    .login-form .group .check:checked+label .icon {
        background: #1161ee;
    }

    .login-form .group .check:checked+label .icon:before {
        transform: scale(1) rotate(45deg);
    }

    .login-form .group .check:checked+label .icon:after {
        transform: scale(1) rotate(-45deg);
    }

    .login-html .sign-in:checked+.tab+.sign-up+.tab+.login-form .sign-in-htm {
        transform: rotate(0);
    }

    .login-html .sign-up:checked+.tab+.login-form .sign-up-htm {
        transform: rotate(0);
    }

    .hr {
        height: 2px;
        margin: 60px 0 50px 0;
        background: rgba(255, 255, 255, .2);
    }

    .foot-lnk {
        text-align: center;
    }
</style>
