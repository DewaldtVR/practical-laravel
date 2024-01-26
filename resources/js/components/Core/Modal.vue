<template>
    <v-layout row justify-center>
        <v-dialog v-model="show" persistent :max-width="width">
            <v-card>
                <v-card-title>
                  <v-toolbar-title>{{title}}</v-toolbar-title>
                  <v-spacer></v-spacer>
                  <v-toolbar-items class="hidden-sm-and-down">
                    <slot name="toolbaritems"></slot>
                  </v-toolbar-items>
                </v-card-title>
                <slot slot="header"></slot>
                <v-card-text>
                    <slot name="content"></slot>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn flat @click="show=!show">
                        close
                    </v-btn>
                    <slot name="buttons"></slot>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {
        props: {
            value: {required: true},
            title: {type: String, default: "Title"},
            width: {type: String, default: "450"},
            color: {type: String, default: "primary"}
        },
        name: "modal",
        data() {
            return {
                show: false
            }
        },
        mounted() {
        },
        watch: {
            value(val) {
                this.show = val
            },
            show(val) {
                this.$emit('input', val);
            }
        }
    }
</script>

<style scoped>

</style>