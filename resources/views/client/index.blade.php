@extends('layouts.authenticated')

@section('pagetitle', 'Manage all clients')

@section('content')
    <grid url="{{ route('clients.list') }}" title="Client list" mode="addEdit"
        :row-menu="rowMenu"@config=" catchGridConfig($event)">
        <template slot="main-menu">
            {{-- <v-btn flat @click="openInNewTab" :disabled="loading">
                Extract Clients
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
                    return [{
                            label: 'Manage Contacts',
                            icon: 'people',
                            closure: function(row, rowid) {
                                document.location.href = `/clients/${rowid}/contact`;
                            }.bind(this)
                        },

                    ]
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
