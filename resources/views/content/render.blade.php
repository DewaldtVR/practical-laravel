@extends('layouts.light')

@section('main_app_content')
    <v-content>
        <v-container class="ql-editor">
            <v-layout row wrap>
                <v-flex xs12 sm12 md10 lg8 xl8 offset-md1 offset-lg2 offset-xl2>
                    <img src="{{Config::get('app.logo')}}" class="render-page-logo">
                </v-flex>
                <v-flex xs12 sm12 md10 lg8 xl8 offset-md1 offset-lg2 offset-xl2>
                    <div v-html="content"></div>
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
                    content: null
                }
            },
            mounted() {
                this.content = this.$store.state.server.data.content;
            }
        });
    </script>

    <style>
        .render-page-logo {
            max-height: 100px;
        }

        /*Override app background here*/
        #app {
            background-color: white;
        }
    </style>
@endprepend
