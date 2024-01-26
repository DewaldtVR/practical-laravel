<template>
    <div>
        <snackbar v-model="snackbar" :options="snackbarOptions">
        </snackbar>
        <modal v-model="dialog" :options="dialogOptions">
        </modal>
    </div>
</template>

<script>
    import {EventBus} from "../../../core";

    export default {
        props: {session: {required: true}},
        name: "framework",
        data() {
            return {
                snackbarOptions: {},
                snackbar: false,
                dialog: false,
                dialogOptions: {},
                activity: []
            }
        },
        mounted() {
            EventBus.$on('snackbar', this.initSnackBar);
            EventBus.$on('dialog', this.initDialog);
            EventBus.$on('add_activity', (id) => {
                this.addActivity(id)
            });

            EventBus.$on('remove_activity', (id) => {
                this.removeActivity(id);
            });
            this.initSession()
        },
        methods: {
            initSession() {
                if (this.session.hasOwnProperty('warning'))
                    this.$snackbar(this.session.warning, 'warning', 'lock', 'top', 'right', 5000, false);
            },
            addActivity(id) {
                let idx = this.activity.indexOf(id);
                if (idx === -1) {
                    this.activity.push(id);
                }
            },
            removeActivity(id) {
                let idx = this.activity.indexOf(id);
                if (idx !== -1) {
                    this.activity.splice(idx, 1);
                }
            },
            initSnackBar(options) {
                this.snackbar = true;
                this.snackbarOptions = options;
            },
            initDialog(options) {
                this.dialog = true;
                this.dialogOptions = options;
            },
        }
    }
</script>

<style scoped>

</style>