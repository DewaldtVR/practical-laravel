<template>
    <v-dialog
            ref="dialog"
            v-model="dialog"
            :return-value.sync="time"
            persistent
            lazy
            full-width
            width="290px"
            @input="updateValidators()"
    >
        <v-text-field
                :ref="name"
                slot="activator"
                v-model="time"
                :label="label"
                prepend-icon="access_time"
                :rules="validation"
                readonly
        ></v-text-field>
        <v-time-picker v-model="time" actions format="24hr">
            <v-spacer></v-spacer>
            <v-btn flat color="primary" @click="dialog = false">Cancel</v-btn>
            <v-btn flat color="primary" @click="$refs.dialog.save(time)">OK</v-btn>
        </v-time-picker>
    </v-dialog>
</template>

<script>
    export default {
        props: {
            value: {required: true},
            validators: {
                type: Array, default: function () {
                    return []
                }
            },
            masks: {
                type: Array, default: function () {
                    return []
                }
            },
            prefix: {type: String, default: null},
            name: {required: true},
            label: {required: true}
        },
        name: "crud-time",
        data() {
            return {
                time: null,
                dialog: false
            }
        },
        watch: {
            value(val) {
                this.time = val;
            },
            time(val) {
                this.$emit('input', val);
                if (val) {
                    this.updateValidators({fieldName: this.name, valid: true})
                }
            },
            validation() {
                this.updateValidators();
            }
        },
        mounted() {
            this.initTime();
            this.updateValidators(null, true);
        },
        computed: {
            validation() {
                return this.constructValidators();
            }
        },
        methods: {
            initTime() {
                if (this.value !== null) {
                    this.time = window.moment(this.value).format('HH:mm');
                }
            },
            emitAction(action, obj) {
                this.$emit(action, obj);
            },
            updateValidators(obj = null, init = false) {
                if (!init) this.$refs[this.name].validate(true);
                if (!obj) {
                    obj = {
                        fieldName: this.name,
                        valid: init ? false : this.$refs[this.name].valid,
                        clause: this.initValidation
                    };
                }
                this.emitAction('validators', obj);
            },
            constructValidators() {
                let validators = [];
                if (this.validators.length > 0) {
                    this.validators.forEach((v) => {
                        if (v.type === 'required')
                            validators.push((val) => val !== null && val !== '' || v.description);
                        if (v.type === 'pattern')
                            validators.push((val) => this.matchPattern(v.value, val) || v.description);

                    });
                }
                return validators;
            },
            initValidation() {
                this.$refs[this.name].validate(true);
            }
        }
    }
</script>

<style scoped>

</style>