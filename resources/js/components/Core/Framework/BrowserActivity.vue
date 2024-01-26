<template>
    <v-progress-linear v-show="activity.length>0" :indeterminate="true"
                       style="position: absolute;z-index: 1000000;margin-top: 0"
                       color="secondary"></v-progress-linear>
</template>

<script>
    import {EventBus} from "../../../core";

    export default {
        name: "browser-activity",
        data() {
            return {
                activity: []
            }
        },
        mounted() {
            EventBus.$on('add_activity', (id) => {
                this.addActivity(id)
            });

            EventBus.$on('remove_activity', (id) => {
                this.removeActivity(id);
            });
        },
        methods: {
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
            }
        }
    }
</script>

<style scoped>

</style>