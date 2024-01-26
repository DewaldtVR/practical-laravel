@extends('layouts.authenticated')

@section('content')
    <v-container>
        <v-card>
            <v-card-title>
                <div class="headline">Notification Message</div>
            </v-card-title>
            <v-card-text>
                <v-flex xs12>
                    <v-text-field :label="'Title'" v-model="notification.title" required type="text">
                    </v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field :label="'Message'" v-model="notification.message" type="text">
                    </v-text-field>
                </v-flex>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="submit" flat>Submit</v-btn>
                </v-card-actions>
            </v-card-text>
        </v-card>
    </v-container>

    <v-container>
        <v-card>
            <v-card-title>
                <div class="headline">Selected Users</div>
                <v-spacer></v-spacer>
                <v-btn v-if="allUsers.length === 0" @click="selectAllUsers" flat>
                    Select All Users
                </v-btn>
                <v-btn v-if="allUsers.length > 0" @click="deselectAllUsers" flat>
                    Deselect All Selected Users
                </v-btn>
            </v-card-title>
            <v-card-text>
                <p v-if="selectedUsers.length === 0 && allUsers.length === 0">No Users Selected</p>
                <p v-if="allUsers.length > 0">Users Selected</p>
                <v-chip v-for="user in selectedUsers" :key="user._id"
                        close
                        @input="deselectUser(user._id)">
                    @{{ user.first_name }} @{{ user.last_name }} (@{{ user.email_address }})
                </v-chip>
            </v-card-text>

        </v-card>
    </v-container>

    <v-container>
{{--        <grid url="{{route('appusers.data', ['condensed'=>'1'])}}" title="App user list" mode="view"--}}
{{--              :row-menu="rowMenu"></grid>--}}
    </v-container>

@endsection

@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {
                return {
                    selectedUsers: [],
                    isSelect: true,
                    allUsers: [],
                    errors: [],
                    loading: false,
                    rules: [
                        value => !!value || 'Required.'
                    ],
                    config: null,
                    notification: {
                        users: [],
                        title: null,
                        message: null,
                    }
                }
            },
            mounted() {
            },
            watch: {
                checkFields() {
                    (this.notification.users.length <= 0) ? this.errors['appUsers'] = "Please select user/users" : this.errors['appUsers'] = "";
                    (this.notification.title == null) ? this.errors['title'] = "Title required" : this.errors['title'] = "";
                    (this.notification.message == null) ? this.errors['message'] = "Message required" : this.errors['message'] = "";
                }
            },
            computed: {
                rowMenu() {
                    return [{
                        label: 'Select',
                        icon: 'check_circle',
                        closure: function (row, userId) {
                            this.isSelect = true;
                            this.allUsers = [];
                            this.selectedUsers.push(row);
                        }.bind(this),
                        show: (row, userId) => {
                            return this.selectedUsers.indexOf(row) === -1;
                        }
                    },
                        {
                            label: 'Deselect',
                            icon: 'close',
                            closure: function (row, userId) {
                                this.isSelect = true;
                                this.allUsers = [];
                                this.deselectUser(row);
                            }.bind(this),
                            show: (row, userId) => {
                                return this.selectedUsers.indexOf(row) > -1;
                            }
                        }
                    ]
                },
            },
            methods: {
                selectAllUsers() {
                    this.allUsers = this.$store.state.server.data.users;
                    this.selectedUsers = [];
                    this.isSelect = false;
                },
                deselectAllUsers() {
                    this.allUsers = [];
                    this.notification.users = [];
                },
                selectAllNonMXConnectedUsers() {
                    this.deselectAllUsers();
                    this.allUsers = this.$store.state.server.data.users;
                    this.allUsers.filter((user) => user.mxID == null && (user.isSyncedWithMX == null || user.isSyncedWithMX === false) );
                    this.isSelect = false;
                },
                selectAllMXConnectedUsers() {
                    this.deselectAllUsers();
                  this.allUsers = this.$store.state.server.data.users;
                  this.allUsers.filter((user) => user.mxID != null && user.isSyncedWithMX != null);
                  this.select = false;
                },
                submit() {
                    (this.isSelect) ? this.notification.users = this.selectedUsers.map((user) => user._id) : this.notification.users = this.allUsers.map((user) => user._id);
                    this.checkFields();
                    if (this.notification.title !== null && this.notification.title !== "" &&
                        this.notification.message !== null && this.notification.message !== "" &&
                        this.notification.users.length > 0) {
                        this.loading = true;
                        this.$http.post('/notifications/submitUsers', {'data': this.notification}).then((response) => {
                            this.loading = false;
                            this.$snackbar('Notifications Successfully Created', 'success', 'check', 'top', 'right', 5000);
                            this.clearFields();
                        });
                    } else {
                        let errorMsg = "";
                        for (const [key, value] of Object.entries(this.errors)) {
                            errorMsg += value + ", \n";
                        }
                        this.$dialog('Error', errorMsg, 'warning', false, 'alert', '20%', true, {
                                okay: {label: 'Okay', color: 'primary', fill: true}
                            }
                        )
                    }
                },
                checkFields() {
                    (this.notification.users.length <= 0) ? this.errors['appUsers'] = "Please select user/users" : this.errors['appUsers'] = "";
                    (this.notification.title == null || this.notification.title === "") ? this.errors['title'] = "Title required" : this.errors['title'] = "";
                    (this.notification.message == null || this.notification.message === "") ? this.errors['message'] = "Message required" : this.errors['message'] = "";
                },
                deselectUser(user) {
                    let idx = this.selectedUsers.indexOf(user);
                    this.selectedUsers.splice(idx, 1);
                },
                clearFields() {
                    this.selectedUsers = [];
                    this.notification = {
                        users: [],
                        title: null,
                        message: null,
                    };
                }
            }
        });
    </script>
@endprepend