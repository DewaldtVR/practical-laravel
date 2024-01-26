@extends("layouts.app_background")

@section("main_app_content")
    <activity></activity>
    <framework :session="{{json_encode(Session::all())}}"></framework>
    <v-navigation-drawer
            v-model="drawer"
            app
            clipped
    >
        <v-list dense>

            <main-menu :items="{{json_encode($main)}}"></main-menu>

{{--            <v-flex class="text-xs-center" style="position: absolute;bottom: 20px">--}}
{{--                <img src="/img/logo_side.png" alt="avatar" style="max-width: 50%">--}}
{{--            </v-flex>--}}
        </v-list>
    </v-navigation-drawer>

    <v-toolbar color="primary" dark app clipped-left>

        <v-toolbar-side-icon @click.stop="drawer = !drawer" >
            <v-icon v-if="drawer">close</v-icon>
        </v-toolbar-side-icon>

{{--        <div style="background-image: url('/img/logo_light_side.png');width: 220px;height: 64px;background-size: auto 40px;background-position: left center;"></div>--}}
        <v-toolbar-title>
            <div class="hidden-xs-only">@yield("pagetitle")</div>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
            @yield("top_menu")
            <top-menu :items="{{json_encode($top)}}"></top-menu>
            <v-menu offset-y left>
                <v-btn slot="activator" icon>
                    <v-icon>account_circle</v-icon>
                </v-btn>
                <v-list>
                    <v-list-tile @click="logout()">
                        <v-list-tile-content>
                            <v-list-tile-title>Logout</v-list-tile-title>
                        </v-list-tile-content>
                        <v-list-tile-action>
                            <v-icon>exit_to_app</v-icon>
                        </v-list-tile-action>
                    </v-list-tile>
                    <v-list-tile @click="myProfile()">
                        <v-list-tile-content>
                            <v-list-tile-title>My Profile</v-list-tile-title>
                        </v-list-tile-content>
                        <v-list-tile-action>
                            <v-icon>person</v-icon>
                        </v-list-tile-action>
                    </v-list-tile>
                </v-list>
            </v-menu>
        </v-toolbar-items>
    </v-toolbar>

    @yield("right_drawer")

    <main>
        <v-content>
            <v-container>
                @yield("content")
            </v-container>
        </v-content>
    </main>

    <form ref="logoutForm" id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
@endsection


@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {

            },
            methods: {
                myProfile() {
                    document.location.href = '/profile';
                }
            }
        });
    </script>

@endprepend