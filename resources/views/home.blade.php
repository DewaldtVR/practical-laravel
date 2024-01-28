@extends('layouts.authenticated')

@section('pagetitle', 'Home')

@section('content')

    <v-container v-if="role === 1">
        <div>
            Welcome to Practical Admin Portal
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
            computed: {},
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
            }
        });
    </script>
@endprepend
