@extends('layouts.light')

@section('main_app_content')
    <v-container>
        <v-layout>
            <v-flex xs8 offset-md2>
                <v-card>
                    <v-toolbar flat>Verify Your Email Address</v-toolbar>
                    <v-card-text>
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <v-btn @click="submit" flat :loading="loading">Click here</v-btn>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
@endsection

@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {
                return {
                    loading: false
                }
            },
            methods: {
                submit: async function () {
                    this.loading = true;
                    await this.$http.post("/email/verification-notification");
                    this.$snackbar("Verification email sent", "check", "success", "top", "center");
                    this.loading = false;
                }
            }
        });
    </script>
@endprepend
