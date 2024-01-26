@extends('layouts.authenticated')

@section('content')
    <v-layout row wrap>

        <v-flex xs12>
            <div class="headline">User Portal</div>
            <p>Submit your completed templates here. Monitor the status of each submission. The final report can be downloaded from here.</p>
        </v-flex>

        <v-flex xs12>
            <v-divider></v-divider>
        </v-flex>

        <v-flex xs12 class="mt-3">
            <report-input-container
                    :incomplete="incomplete"
{{--                    :file-types="templates"--}}
                    @created="refresh"
            ></report-input-container>
        </v-flex>

        <v-flex xs12 class="mt-3">
            <v-divider></v-divider>
        </v-flex>

        <template v-if="loading">
            <v-flex class="mt-5">
                <v-progress-circular indeterminate color="secondary">
                </v-progress-circular>
                <span class="ml-2 grey--text">Looking for previous reports...</span>
            </v-flex>
        </template>

        <template v-for="eval in evaluations">
            <v-flex class="mt-3" :key="eval.evaluationid" xs12>
                <report-line-container :evaluation="eval"></report-line-container>
            </v-flex>
        </template>

    </v-layout>
@endsection

@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {
                return {
                    incomplete: null,
                    // templates: null,
                    initiated: false,
                    loading: false,
                    evaluations: []
                }
            },
            mounted() {
                this.incomplete = this.$store.state.server.data.incomplete;
                // this.templates = this.$store.state.server.data.templates;
                this.refresh();
            },
            methods: {
                async refresh() {
                    this.loading = true;
                    let response = await this.$http.get("evaluations/refresh");
                    if (response.status === 200)
                        this.evaluations = response.body;
                    this.loading = false;
                }
            }
        });
    </script>
@endprepend
