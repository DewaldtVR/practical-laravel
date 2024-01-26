@extends('layouts.authenticated')

@section('pagetitle', $client->name . "'s Contacts")

@section('content')
    <grid url="{{ route('relatedparties.list', [$client->clientid]) }}" title="Contact List" mode="crud"
        :row-menu="rowMenu"@config=" catchGridConfig($event)">
        <template slot="main-menu">

        </template>
    </grid>

@endsection


@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {
                return {
                    loading: false
                }
            },
            mounted() {

            },
            watch: {

            },
            computed: {
                rowMenu() {
                    return [{
                        label: 'Manage Clients',
                        icon: 'people',
                        closure: function(row, rowid) {
                            // console.log(row)
                            document.location.href =
                                `/clients/${row.clientid}/relatedparty/${rowid}/kycfiles`;
                        }.bind(this)
                    }, ]
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
