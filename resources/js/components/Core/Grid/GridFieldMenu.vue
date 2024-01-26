<template>
    <v-menu
            v-model="menu"
            :close-on-content-click="false"
            :nudge-width="250"
            offset-x
            offset-y
    >
        <v-btn
                slot="activator"
                icon
                small
        >
            <v-icon small>filter_list</v-icon>
        </v-btn>

        <v-card>
            <v-subheader>{{title}}</v-subheader>
            <v-divider></v-divider>
            <div class="pl-2 pr-2 pb-1">
                <v-text-field
                        prepend-icon="search"
                        label="Search"
                        name="search"
                        :error-messages="errors.first('search_input_'+fieldName+'.search')"
                        v-validate="'required'"
                        v-model="searchQuery"
                        :data-vv-scope="'search_input_'+fieldName"
                        data-vv-as="Search"
                >

                </v-text-field>
                <br/>
                <v-btn-toggle v-model="searchMode">
                    <v-btn flat value="contains" flat>
                        Contains
                    </v-btn>
                    <v-btn flat value="starts_with" flat>
                        Starts with
                    </v-btn>
                    <v-btn flat value="ends_with" flat>
                        Ends with
                    </v-btn>
                </v-btn-toggle>
                <br/>
                <v-divider>

                </v-divider>
            </div>
            <br/>
            <v-divider></v-divider>
            <v-card-actions>
                <v-btn flat @click="apply()">Apply</v-btn>
                <v-btn flat color="primary" @click="clear()">Clear</v-btn>
                <v-btn flat @click="menu=!menu">Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-menu>
</template>

<script>
    export default {
        name: "GridFieldMenu",
        inject: ['$validator'],
        props: {
            title: {type: String, required: true},
            fieldName: {type: String, required: true},
        },
        watch: {
            menu(val) {
                if (!val) {
                    this.$validator.reset();
                }
            }
        },
        data() {
            return {
                menu: false,
                searchMode: 'contains',
                searchQuery: ''
            }
        },
        methods: {
            apply() {
                this.$validator.validateAll('search_input_' + this.fieldName).then((result) => {
                    if (result === true) {
                        this.menu = false;
                        this.$emit('filter', {
                            searchQuery: this.searchQuery,
                            mode: this.searchMode,
                            field: this.fieldName,
                            title:this.title
                        });
                    }
                })
            },
            clear() {
                this.$emit('clear', this.fieldName);
                this.menu = false;
                this.searchQuery = '';
            }
        }
    }
</script>

<style scoped>

</style>