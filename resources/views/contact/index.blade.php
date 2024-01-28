@extends('layouts.authenticated')

@section('pagetitle', 'Manage all Contacts')

@section('content')
    <grid url="{{ route('contacts.list') }}" title="Contact list" mode="addEdit"
        :row-menu="rowMenu"@config=" catchGridConfig($event)">
        <template slot="main-menu">
            < </template>
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
                            label: 'Manage Clients',
                            icon: 'people',
                            // closure: function(row, rowid) {
                            //     document.location.href = `/contacts/${rowid}/clients`;
                            // }.bind(this)
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
