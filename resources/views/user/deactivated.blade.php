@extends('layouts.authenticated')

@section('pagetitle','Manage all users')

@section('content')
    <grid url="{{route('users.deactivated.data')}}" title="Deactivated User list" mode="edit" @config="catchGridConfig($event)"
          :row-menu="rowMenu"></grid>
    <modal-custom v-model="rightDialog" title="Additional rights" :color="'secondary'" width="600">
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
                        v-model="userHasRights"
                        hide-details
                        color="primary"
                ></v-checkbox>
            </v-flex>
        </v-layout>
        <template slot="buttons">
            <v-btn flat @click="updateRights()" :loading="updating">Save</v-btn>
        </template>
    </modal-custom>

    <modal-custom v-model="roleDialog" title="Roles" color="primary" width="600">
        <v-layout row wrap slot="content">
            <v-flex xs12 class="subheader">Select user roles</v-flex>
            <v-flex xs12 v-show="loading" class="text-xs-center">
                <v-progress-circular indeterminate color="primary"></v-progress-circular>
            </v-flex>
            <v-flex xs12 sm6 md6 v-for="(role,index) in roles" v-show="!loading"
                    :key="index">
                <v-checkbox
                        :label="role.rolename"
                        :value="role.userroleid"
                        v-model="userHasRoles"
                        hide-details
                        color="primary"
                ></v-checkbox>
            </v-flex>
        </v-layout>
        <template slot="buttons">
            <v-btn flat @click="updateRoles()" :loading="updating">Save</v-btn>
        </template>
    </modal-custom>
@endsection


@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {
                return {
                    rightDialog: false,
                    roleDialog: false,
                    loading: false,
                    updating: false,
                    rowid: null,
                    rights: [],
                    roles: [],
                    userHasRights: [],
                    userHasRoles: []
                }
            },
            mounted() {
                this.rights = this.$store.state.server.data.rights;
                this.roles = this.$store.state.server.data.roles;
            },
            watch: {
                rightDialog(val) {
                    if (!val)
                        this.userHasRights = [];
                },
                roleDialog(val) {
                    if (!val)
                        this.userHasRoles = [];
                }
            },
            computed: {
                rowMenu() {
                    return [
                        {
                            label: 'Manage Roles',
                            icon: 'person',
                            closure: function (row, rowid) {
                                this.roleDialog = true;
                                this.rowid = rowid;
                                this.getRoles(rowid);
                            }.bind(this)
                        },
                        {
                            label: 'Additional rights',
                            icon: 'gavel',
                            show: function (row) {
                                return false;
                            }.bind(this),
                            closure: function (row, rowid) {
                                this.rightDialog = true;
                                this.rowid = rowid;
                                this.getRights(rowid);
                            }.bind(this)
                        },
                        {
                            label: 'Reactivate User',
                            icon: 'autorenew',
                            closure: function (row, rowid) {
                                this.activateUser(rowid);
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
                async activateUser(userid) {
                    let answer = await this.$dialog("You are about to reactivate this user profile", "Are you sure you want to do this?", "Success", null, "gavel", "25%", true, {
                        yes: {
                            text: "Yes",
                            color: "black"
                        }, no: {
                            text: "No",
                            color: "black"
                        }
                    });
                    this.loading = true;
                    if (answer === "yes") {
                        this.$http.post('/users/' + userid + '/activate', $userid = userid).then((response) => {
                            this.loading = false;
                            if (response.status === 200) {
                                this.$snackbar("User has been reactivated succesfully", "success", "check", "bottom", "right", 3000)
                                this.refreshGrid();
                            } else {
                                this.$snackbar("Something went wrong while trying to run your request", "error", "error", "bottom", "right", 3000)
                            }
                        }, (error) => {
                            this.loading = false
                            this.$snackbar("Something went wrong while trying to run your request", "error", "error", "bottom", "right", 3000)
                            console.log(error)
                        });
                    }
                },
                getRights(userid) {
                    this.loading = true;
                    this.$http.get('/users/' + userid + '/rights').then((response) => {
                        this.loading = false;
                        this.userHasRights = response.body;
                    }, (error) => {
                        this.loading = false
                    });
                },
                updateRights() {
                    if (this.rowid !== null) {
                        this.updating = true;
                        this.$http.post('/users/' + this.rowid + '/rights', {data: this.userHasRights}).then(() => {
                            this.updating = false;
                            this.rightDialog = false;
                            this.$snackbar('Rights updated', 'success', 'check', 'top', 'right', 5000);
                        }, (error) => {
                            this.updating = false;
                        });
                    }
                },
                getRoles(userid) {
                    this.loading = true;
                    this.$http.get('/users/' + userid + '/roles').then((response) => {
                        console.log(response);
                        this.loading = false;
                        this.userHasRoles = response.body;
                    }, (error) => {
                        this.loading = false
                    });
                },
                updateRoles() {
                    if (this.rowid !== null) {
                        this.updating = true;
                        this.$http.post('/users/' + this.rowid + '/roles', {data: this.userHasRoles}).then(() => {
                            this.updating = false;
                            this.roleDialog = false;
                            this.$snackbar('Roles updated', 'success', 'check', 'top', 'right', 5000);
                        }, (error) => {
                            this.updating = false;
                        });
                    }
                }
            }
        });
    </script>
@endprepend
