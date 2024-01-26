@extends('layouts.authenticated')

@section('pagetitle','Templates')

@section('content')

    <v-layout row wrap>
        <v-flex xs12 sm4 md3 lg3 xl2 v-for="template in templates" :key="template.filetypeid">
            <v-card class="ma-3" style="user-select: none" v-ripple
                    :href="'/filetypes/'+template.filetypeid+'/download'">
                <v-responsive :aspect-ratio="1">
                    <v-container fill-height fluid>
                        <v-flex justify="center" class="text-xs-center">
                            <img alt="template" :src="getSvgFileIcon(template)" style="max-height: 130px;"/>
                            <div class="subheading font-weight-bold">
                                @{{ template.filetypedescription }}
                            </div>
                            <span><small class="grey--text">Click to download</small></span>
                        </v-flex>
                    </v-container>
                </v-responsive>
            </v-card>
        </v-flex>
    </v-layout>

@endsection


@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {
                return {
                    templates: []
                }
            },
            mounted() {
                this.templates = this.$store.state.server.data.templates;
            },
            watch: {},
            computed: {},
            methods: {
                getSvgFileIcon(template) {
                    if (!template.coverimage)
                        return this.$getFileIcon(template.file.originalfilename);
                    return template.coverimage.url;
                }
            }
        });
    </script>

    <style>

    </style>
@endprepend
