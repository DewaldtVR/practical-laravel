@extends('layouts.authenticated')

@section('pagetitle', $client->name . "'s Contacts")

@section('content')
    <grid url="{{ route('contacts.list', [$client->clientid]) }}" title="Contacts List" mode="crud"
        :row-menu="rowMenu"@config=" catchGridConfig($event)">
        <template slot="main-menu">
            {{-- <v-btn flat @click="openInNewTab" :disabled="loading">
                Extract Client's Related Party
            </v-btn> --}}
        </template>
    </grid>

@endsection


@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {
                return {
                    loading: false,
                }
            },
            mounted() {},
            watch: {

            },
            computed: {
                rowMenu() {

                }
            },
            methods: {
                catchGridConfig(e) {
                    if (e.hasOwnProperty('refresh_func')) {
                        this.refreshGrid = e['refresh_func'];
                    }
                },
                refresh() {
                    if (this.refreshGrid !== null)
                        this.refreshGrid();
                },

            }
        });
    </script>
@endprepend
