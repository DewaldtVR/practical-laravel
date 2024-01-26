@extends('layouts.authenticated')

@section('pagetitle','My Profile')

@section('content')
    <v-container grid-list-md>
        <v-layout row wrap>
            @if(\Illuminate\Support\Facades\Session::has("message"))
                <v-card color="error">
                    <v-card-title class="white--text">
                        {{\Illuminate\Support\Facades\Session::get("message")}}
                    </v-card-title>
                </v-card>
            @endif
            <v-flex xs12>
                <v-card>
                    <v-toolbar color="primary" class="white--text">
                        <v-toolbar-title>
                            Details
                        </v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-text-field
                                label="Name"
                                name="name"
                                :error-messages="errors.first('details_input.name')"
                                v-validate="'required'"
                                v-model="user.name"
                                :data-vv-scope="'details_input'"
                                data-vv-as="name">

                        </v-text-field>
                        <v-text-field
                                label="Email Address"
                                name="email"
                                :error-messages="errors.first('details_input.email')"
                                v-validate="'required'"
                                v-model="user.email"
                                :data-vv-scope="'details_input'"
                                data-vv-as="email">
                        </v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="validate()">Update Details</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>

            <v-flex xs12 style="margin-top: 20px">
                <v-card>
                    <v-card-text>
                        <p>Update your password</p>
                        <v-text-field
                                :label="'Current Password'"
                                name="current_password"
                                :error-messages="errors.first('security.current_password')"
                                v-validate="'required'"
                                v-model="currentPassword"
                                :data-vv-scope="'security'"
                                data-vv-as="current"
                                type="password"
                        >
                        </v-text-field>
                        <v-text-field
                                ref="password"
                                :label="'Password'"
                                name="password"
                                :error-messages="errors.first('security.password')&&'Password should be at least 8 characters long, and contain 1 capital letter, one lower case letter and 1 special character'"
                                v-validate="{required:true, regex:passwordRegex}"
                                v-model="password"
                                :data-vv-scope="'security'"
                                data-vv-as="password"
                                type="password"
                        >
                        </v-text-field>
                        <v-text-field
                                :label="'Confirm'"
                                name="confirm"
                                :error-messages="errors.first('security.confirm')"
                                :data-vv-scope="'security'"
                                data-vv-as="password"
                                v-validate="'required|confirmed:password'"
                                v-model="confirmPassword"

                                type="password"
                        >
                        </v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" @click="validatePassword()">Update Password</v-btn>
                    </v-card-actions>
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
                    user: {},
                    password: null,
                    currentPassword: null,
                    confirmPassword: null
                }
            },
            mounted() {
                this.user = this.$store.state.server.data.user;
            },
            methods: {
                validate() {
                    this.$validator.validateAll('details_input').then((valid) => {
                        console.log(this.errors);
                        if (valid) {
                            this.$http.post('/users/' + this.user.userid, {
                                name: this.user.name,
                                email: this.user.email
                            }).then((response) => {
                                this.$snackbar('Details updated', 'success', 'checkmark', 'top', 'right');

                            }, (error) => {
                                this.displayErrors(error.body);
                            });
                        } else {
                            this.$snackbar('Some fields are required', 'error', 'warning', 'top', 'right');
                        }
                    })
                },
                validatePassword() {
                    this.$validator.validateAll('security').then((valid) => {
                        if (valid) {
                            this.$http.post('/users/' + this.user.userid + '/password', {
                                password: this.currentPassword,
                                new_password: this.password
                            }).then((response) => {
                                this.$snackbar('Password updated', 'success', 'checkmark', 'top', 'right');

                            }, (error) => {
                                if (error.status === 401) {
                                    this.$snackbar('The password entered does not match our records. Please enter the correct password and try again.', 'error', 'warning', 'top', 'right');

                                } else {
                                    this.displayErrors(error.body);
                                }
                            });
                        } else {
                            this.$snackbar('Some fields are required', 'error', 'warning', 'top', 'right');
                        }
                    })
                },
                displayErrors(error) {
                    if (error.hasOwnProperty('errors')) {
                        let keys = Object.keys(error.errors);
                        if (keys.length > 0) {
                            this.$snackbar(error.errors[keys[0]][0], 'error', 'warning', 'top', 'right');
                        }
                    }
                }
            },
            computed :{
                passwordRegex() {
                    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&]).{8,15}$/;
                },
            }
        });
    </script>
@endprepend
