@extends('layouts.authenticated')

@section('pagetitle', 'Home')

@section('content')

    <v-container v-if="role === 1">
        <div>
            Welcome to BFS Admin Portal
        </div>
    </v-container>


@endsection

@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {
                return {
                    creator: false,
                    reviewer: false,
                    superuser: false,
                    role: null
                }
            },
            mounted() {
                this.getRoles();
                // this.isUser();
                console.log(this.$store.state.server.data.role);
            },
            computed: {
                // Return when getting flagged - true/false
                // isUser() {
                //     if(this.role !== 2 && this.role !== 3 && this.role >= 0)
                //     {
                //         return this.superuser = true;
                //     }
                //     else if(this.role !== 1 && this.role !== 3 && this.role >= 0)
                //     {
                //         return this.reviewer = true;
                //     }
                //     else
                //         return this.creator = true;
                // }
            },
            methods: {
                init() {
                    this.creator = false;
                    this.reviewer = false;
                    this.superuser = false;
                    this.role = null;
                },
                getRoles() {
                    this.loading = true;
                    this.$http.get(`/users/` + this.$store.state.server.data.user.userid + `/roles`).then((
                        response) => {
                            this.loading = false;
                            this.role = response.data[0];
                            console.log(this.role);
                        }, (error) => {
                            console.log(error);
                            this.loading = false
                        });
                },
                // triggerDialog() {
                //     this.$dialog("Delete Record", "Are you sure?", "primary", true, "warning", "35%", true, {
                //         yes: {
                //             label: "Do it!",
                //             color: "success"
                //         },
                //         no: {
                //             label: "Don't do it!",
                //         }
                //     }).then((val) => {
                //         if (val === 'yes') this.$snackbar('Delete in progress...', 'warning', 'warning', 'top', 'right', 5000, true);
                //         if (val === 'no') this.$addactivity('deleting_something');
                //         if(val==='close') this.$removeactivity('deleting_something');
                //     });
                // }
            }
        });
    </script>
@endprepend
