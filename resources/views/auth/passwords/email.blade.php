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
                                <div class="headline">Password reset</div>
                            </v-card-title>

                            @if (session('status'))
                                <v-card-text>
                                   <v-list-tile>
                                       <v-list-tile-content>
                                           We've sent you an email.
                                       </v-list-tile-content>
                                       <v-list-tile-action>
                                           <v-icon color="success">check_circle</v-icon>
                                       </v-list-tile-action>
                                   </v-list-tile>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn flat href="/password/reset">I didn't receive it?</v-btn>
                                </v-card-actions>
                            @else

                                <v-card-text>
                                    <p>Please provide your email address below and we'll send you an email with
                                        instructions to reset your password.</p>
                                    <form ref="emailForm" method="POST" action="{{ route('password.email') }}">
                                        {{csrf_field()}}
                                        <v-text-field
                                                :prepend-icon="'mail'"
                                                placeholder="Email" name="email"
                                                :error="@if ($errors->has('email')) true @else false @endif"
                                                :error-messages="errors.first('email')||'{{ $errors->first('email') }}'"
                                                type="email"
                                                v-validate="'required|email'"
                                                v-model="email"
                                        ></v-text-field>
                                    </form>
                                </v-card-text>
                                <v-card-actions>
                                    <v-btn flat href="/">cancel</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn flat @click.native="submit" :loading="loading">reset password</v-btn>
                                </v-card-actions>

                            @endif
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
                    loading: false
                }
            },
            methods: {
                submit: function () {
                    this.$validator.validateAll().then((valid) => {
                        if (valid === true) {
                            this.loading= true;
                            this.$refs.emailForm.submit();
                        }
                    });
                }
            }
        });
    </script>
@endprepend
