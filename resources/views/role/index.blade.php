@extends('layouts.authenticated')

@section('pagetitle','Manage all roles')

@section('content')

    <grid url="{{route('roles.list')}}" title="Role list" mode="crud" :row-menu="rowMenu"></grid>
    <modal-custom v-model="dialog" title="Additional rights" color="primary" width="600">
        <v-layout row wrap slot="content">
            <v-flex xs12 class="subheader">Select any additional rights to add</v-flex>
            <v-flex xs12 v-show="loading" class="text-xs-center">
                <v-progress-circular indeterminate color="primary"></v-progress-circular>
            </v-flex>
            <v-flex xs12 sm6 md6 v-for="(right,index) in rights" v-show="!loading"
                    :key="index">
                <v-checkbox
                        :label="right.rightname"
                        :value="right.userrightid"
                        v-model="roleHas"
                        hide-details
                        color="primary"
                ></v-checkbox>
            </v-flex>
        </v-layout>
        <template slot="buttons">
            <v-btn flat @click="updateRights()" :loading="updating">Save</v-btn>
        </template>
    </modal-custom>
@endsection


@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {
                return {
                    dialog: false,
                    loading: false,
                    updating: false,
                    rowid: null,
                    rights: [],
                    roleHas: []
                }
            },
            mounted() {
                this.rights = this.$store.state.server.data.rights;
            },
            watch: {
                rightDialog(val) {
                    if (!val)
                        this.userHasRights = [];
                }
            },
            computed: {
                rowMenu() {
                    return [
                        {
                            label: 'Manage rights',
                            icon: 'gavel',
                            closure: function (row, rowid) {
                                this.dialog = true;
                                this.rowid = rowid;
                                this.getRights(rowid);
                            }.bind(this)
                        }
                    ]
                }
            },
            methods: {
                getRights(rowid) {
                    this.loading = true;
                    this.$http.get('/roles/' + rowid + '/rights').then((response) => {
                        console.log(response.body);
                        this.loading = false;
                        this.roleHas = response.body;
                    }, (error) => {
                        this.loading = false
                    });
                },
                updateRights() {
                    if (this.rowid !== null) {
                        this.updating = true;
                        this.$http.post('/roles/' + this.rowid + '/rights', {data: this.roleHas}).then(() => {
                            this.updating = false;
                            this.dialog = false;
                            this.$snackbar('Rights updated', 'success', 'check', 'top', 'right', 5000);
                        }, (error) => {
                            this.updating = false;
                        });
                    }
                }
            }
        });
    </script>
@endprepend
