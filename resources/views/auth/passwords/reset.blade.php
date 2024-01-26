@extends('layouts.light')

@section('main_app_content')
    <v-content>
        <v-container fluid grid-list-md>
            <v-layout align-center justify-center row wrap>
                <v-flex xs12 md4 sm8>
                    <div class="text-xs-center ma-5">
                        <img src="{{Config::get('app.logo')}}" class="app-clean-logo">
                    </div>
                    <div class="ma-2">
                        <v-card>
                            <v-card-title>
                                <div class="headline">Reset your password</div>
                            </v-card-title>
                            <v-card-text>
                                <form ref="resetForm" method="POST" action="{{url("/password/reset")}}">
                                    {{ csrf_field() }}

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <v-text-field
                                            :prepend-icon="'mail'"
                                            placeholder="Email" name="email"
                                            :error="@if ($errors->has('email')) true @else false @endif"
                                            :error-messages="errors.first('email')||'{{ $errors->first('email') }}'"
                                            type="email"
                                            v-validate="'required|email'"
                                            v-model="email"
                                    ></v-text-field>

                                    <v-text-field
                                            id="password"
                                            :prepend-icon="'lock'"
                                            ref="password"
                                            placeholder="Password" password name="password"
                                            :error-messages="errors.first('password')&&'Password should be at least 8 characters long, and contain 1 capital letter, one lower case letter and 1 special character'"
                                            :value="'{{ old('password') }}'"
                                            type="password"
                                            v-validate="{required:true, regex:passwordRegex}"
                                            data-vv-as="password"
                                            v-model="password"
                                    ></v-text-field>

                                    <v-text-field
                                            id="password_confirmation"
                                            :prepend-icon="'lock'"
                                            placeholder="Confirm password" password name="password_confirmation"
                                            :error-messages="errors.first('password_confirmation')"
                                            type="password"
                                            v-validate="'required|confirmed:password'"
                                            data-vv-as="password"
                                            v-model="confirm_password"
                                    ></v-text-field>

                                </form>
                            </v-card-text>

                            <v-card-actions>
                                <v-btn flat href="/">cancel</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn flat @click.native="submit">reset</v-btn>
                            </v-card-actions>

                        </v-card>
                    </div>
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
@endsection

@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {
                return {
                    email: null,
                    password: null,
                    confirm_password: null,
                    loading: false
                }
            },
            methods: {
                submit: function () {
                    this.$validator.validateAll().then((valid) => {
                        if (valid === true) {
                            this.$refs.resetForm.submit();
                        }
                    });
                }
            },
            computed: {
                passwordRegex() {
                    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&]).{8,15}$/;
                },
            }
        });
    </script>
@endprepend
