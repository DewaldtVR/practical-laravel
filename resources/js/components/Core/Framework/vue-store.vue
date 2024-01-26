<template>
    <div></div>
</template>

<script>
    export default {
        props: {server: {required: true}},
        name: "vue-store",
        data() {
            return {}
        },
        mounted() {
            this.processServerData();
        },
        methods: {
            processServerData() {
                // let data = {};
                // if (this.data !== null) {
                //     let keys = Object.keys(this.server);
                //     for (let key of keys) {
                //         data[key]=keys
                //     }
                // }
                this.updateStore(this.server);
            },
            updateStore(obj = {}) {
                this.$store.commit('BRIDGE_DATA', obj);
            }
        }
    }
</script>

<style scoped>

</style>