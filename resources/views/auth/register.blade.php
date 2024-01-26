@extends('layouts.light')

@section('main_app_content')
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-container grid-list-lg>
                <v-layout row wrap>
                    <v-flex xs12 md8 offset-md2 lg6 offset-lg3 xl4 offset-xl4>
                        <v-card>
                            <v-card-title class="pt-5">
                                <v-spacer></v-spacer>
                                <div class="stepper-line" :style="stepperLineStyle(step === 1)"></div>
                                <div class="stepper-line" :style="stepperLineStyle(step === 2)"></div>
                                <v-spacer></v-spacer>
                            </v-card-title>

                            <v-card-text class="register-wrapper">

                                <div class="text-xs-center">
                                    <img class="logo-wrapper" src="/img/logo_side.png">
                                </div>

                                <v-flex xs12 sm10 offset-sm1 md8 offset-md2 lg8 mb-24>

                                    <div class="headline pt-3">Registration</div>
                                    <div class="subheading pb-3">Step @{{ step }} of 3: @{{ stepText }}
                                    </div>

                                    <transition name="fade">

                                        <form ref="person_form" data-vv-scope="person" v-show="step===1 && show">
                                            <v-text-field name="name" label="Contact name" append-icon="person"
                                                :error-messages="errors.first('person.name')" v-validate="'required'"
                                                data-vv-as="contact name"
                                                v-model="contactPerson.contactname"></v-text-field>

                                            <v-select label="Country" name="country" item-value="countryid"
                                                item-text="countryname" :items="countries"
                                                :error-messages="errors.first('person.country')" data-vv-as="country"
                                                v-model="contactPerson.country"></v-select>

                                            <v-text-field name="contactnumber" label="Contact number"
                                                append-icon="smartphone"
                                                :error-messages="errors.first('person.contactnumber')"
                                                data-vv-as="contact number"
                                                v-model="contactPerson.contactnumber"></v-text-field>

                                            <v-text-field name="email" label="Email address" append-icon="mail"
                                                :error-messages="errors.first('person.email')" data-vv-as="email address"
                                                v-model="contactPerson.email"></v-text-field>

                                            <v-select name="type" label="Occupation" :items="userTypes"
                                                item-value="usertypeid" item-text="usertypedescription" v-validate="''"
                                                :error-messages="errors.first('person.type')" data-vv-as="user type"
                                                v-model="contactPerson.type"></v-select>
                                        </form>
                                    </transition>

                                    <transition name="fade">
                                        <form ref="password_form" novalidate data-vv-scope="password"
                                            v-show="step===2 && show">
                                            <v-text-field ref="password" name="password" label="Enter password"
                                                type="password" append-icon="lock"
                                                :error-messages="errors.first('password.password') &&
                                                    'Password should be at least 8 characters long, and contain 1 capital letter, one lower case letter and 1 special character'"
                                                v-validate="{required:true,regex:passwordRegex}" data-vv-as="password"
                                                v-model="password.password"></v-text-field>

                                            <v-text-field name="confirm" label="Confirm password" type="password"
                                                append-icon="lock" :error-messages="errors.first('password.confirm')"
                                                v-validate="'required|confirmed:password'" data-vv-as="password"
                                                v-model="password.password_confirmation"></v-text-field>

                                            <div class="mt-2 mb-2">
                                                <a href="{{ url('/web-contents/terms_and_conditions') }}"
                                                    target="_blank">Terms and conditions</a>
                                            </div>

                                            <v-checkbox class="mt-3" name="terms" label="Accept terms" color="secondary"
                                                v-model="terms" :error="touched && !terms"></v-checkbox>

                                            <div class="mt-3">
                                                <ul>
                                                    <li v-for="error in formErrors" class="error--text">
                                                        @{{ error }}
                                                    </li>
                                                </ul>
                                            </div>

                                        </form>
                                    </transition>

                                </v-flex>

                            </v-card-text>

                            <v-card-actions class="ml-3 mr-3 mt-3 pb-3">
                                <v-btn flat @click="back" :disabled="loading"> @{{ backButtonText }}
                                </v-btn>
                                <v-spacer></v-spacer>
                                <v-btn flat @click="next" :loading="loading">@{{ nextButtonText }}
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-layout>
    </v-container>
@endsection


@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {
                return {
                    touched: false,
                    loading: false,
                    show: true,
                    step: 1,
                    stepDescriptions: {
                        1: "Contact Information",
                        2: "Set Password"
                    },
                    countries: [],
                    userTypes: [],
                    contactPerson: {
                        contactname: null,
                        country: null,
                        contactnumber: null,
                        email: null,
                        type: null,
                    },
                    password: {
                        password: null,
                        password_confirmation: null
                    },
                    terms: null,
                    formErrors: []
                }
            },
            watch: {
                step() {
                    this.show = false;
                    setTimeout(() => {
                        this.show = true
                    }, 250);
                }
            },
            computed: {
                passwordRegex() {
                    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&]).{8,15}$/;
                },
                stepText() {
                    return this.stepDescriptions[this.step];
                },
                nextButtonText() {
                    if (this.step === 2)
                        return "create account";

                    return "next";
                },
                backButtonText() {
                    if (this.step === 1)
                        return "cancel";

                    return "back";
                },
                scope() {
                    if (this.step === 1)
                        return "person";

                    if (this.step === 2)
                        return "password";
                }
            },
            mounted() {
                // this.countries = this.$store.state.server.data.countries;
                this.userTypes = this.$store.state.server.data.userTypes;
            },
            methods: {
                startLoading() {
                    this.touched = true;
                    this.loading = true;
                },
                stopLoading() {
                    this.loading = false;
                },
                stepperLineStyle(active) {
                    return {
                        "background-color": active ? "#F6DE65" : "#E6E6E6"
                    };
                },
                async next() {
                    if (await this.tryValidate(this.scope) && this.step < 2)
                        this.step++;
                    else if (this.terms)
                        this.submit();
                },
                back() {
                    if (this.step > 1)
                        this.step--;
                    else window.history.back();
                },
                async tryValidate(scope) {
                    if (this.step === 2) this.touched = true;
                    return await this.$validator.validateAll(scope);
                },
                submit() {
                    this.formErrors = [];
                    this.startLoading();

                    let data = {
                        ...this.contactPerson,
                        ...this.company,
                        ...this.password
                    };

                    this.$http.post("/register", data).then((response) => {
                        this.stopLoading();
                        if (response.status === 200)
                            document.location = "/home";

                        if (response.status === 422)
                            this.$snackbar('Validation errors', 'error', 'error', 'top', 'center', 10000);

                    }).catch((error) => {
                        this.stopLoading();
                        if (error.status === 422) {
                            for (let key of Object.keys(error.body.errors))
                                this.formErrors = [...this.formErrors, ...error.body.errors[key]];
                        }
                    });
                }
            }
        });
    </script>

    <style>
        .stepper-line {
            height: 5px;
            width: 15%;
            margin: 5px;
            border-radius: 2.5px;
        }

        .logo-wrapper {
            max-width: 60%
        }

        .register-wrapper {
            height: 650px;
        }
    </style>
@endprepend
