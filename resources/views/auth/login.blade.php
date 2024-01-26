@extends('layouts.light')

@section('main_app_content')
    <v-content>
        <v-container fluid grid-list-md>
            <v-layout align-center justify-center row wrap>
                <v-flex xs12 md4 sm8>
                    <div class="text-xs-center ma-5">
                        {{--                        <h4>{{Config::get('app.name')}}</h4> --}}
                    </div>
                    <div class="ma-2">
                        <v-card>
                            <v-card-text>
                                <div class="headline">Log in</div>
                                <form ref="loginForm" method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}
                                    <v-text-field :prepend-icon="'mail'" placeholder="Email" name="email"
                                        :error="@if ($errors->has('email')) true @else false @endif"
                                        :error-messages="errors.first('email') || '{{ $errors->first('email') }}'"
                                        type="email" v-validate="'required|email'" v-model="email"></v-text-field>
                                    <v-text-field :prepend-icon="'lock'" placeholder="Password" password name="password"
                                        :error="@if ($errors->has('password')) true @else false @endif"
                                        :error-messages="errors.first('password') &&
                                            'Password should be at least 8 characters long, and contain 1 capital letter, one lower case letter and 1 special character'"
                                        :value="'{{ old('password') }}'" type="password" {{--                                            v-validate="{required:true,regex:passwordRegex}" --}}
                                        v-model="password" data-vv-as="password"></v-text-field>
                                    <v-checkbox name="remember" label="Remember me"></v-checkbox>
                                    <a href="/password/reset" class="blue--text">forgot your password?</a> <small
                                        class="grey--text"> Or send an email to info@bfs.com.na</small>
                                </form>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn flat href="/register">register</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" @click.native="submit()">Log in</v-btn>
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
                    email: '',
                    password: ''
                }
            },
            methods: {
                submit: function() {
                    this.$validator.validateAll().then((valid) => {
                        if (valid === true) {
                            this.$refs.loginForm.submit();
                        }
                    });
                }
            },
            computed: {
                passwordRegex() {
                    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&]).{8,15}$/;
                }
            }
        });
    </script>
@endprepend
