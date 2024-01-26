<template>
    <v-snackbar
            :color="options.fill?options.messagetype:''"
            :timeout="options.duration"
            :top="options.vertical === 'top'"
            :bottom="options.vertical === 'bottom'"
            :right="options.horizontal === 'right'"
            :left="options.horizontal === 'left'"
            v-model="show"
    >
        {{ options.message }}
        <v-icon v-if="options.icon" :color="!options.fill?options.messagetype:''">{{options.icon}}</v-icon>
    </v-snackbar>
</template>

<script>
    export default {
        props: {
            options: {
                type: Object, default: {
                    duration: 3000,
                    horizontal: 'top',
                    vertical: 'right',
                    messagetype: 'success',
                    message: "Snackbar!",
                    icon: 'check',
                    fill: false
                }
            },
            value: {type: Boolean, default: false}
        },
        name: "snackbar",
        data() {
            return {
                show: false
            }
        },
        watch: {
            value(val) {
                this.show = val;
            },
            show(val) {
                this.$emit('input', val);
            }
        }
    }
</script>

<style scoped>

</style>