<template>
    <v-dialog
            ref="dialog"
            v-model="dialog"
            :return-value.sync="date"
            persistent
            lazy
            full-width
            width="290px"
            @input="updateValidators()"
    >
        <v-text-field
                :ref="name"
                slot="activator"
                v-model="dateFormatted"
                :label="label"
                prepend-icon="calendar_today"
                :rules="validation"
                readonly
        ></v-text-field>
        <v-date-picker v-model="date" actions>
            <v-spacer></v-spacer>
            <v-btn flat color="primary" @click="dialog = false">Cancel</v-btn>
            <v-btn flat color="primary" @click="$refs.dialog.save(date)">OK</v-btn>
        </v-date-picker>
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
        name: "crud-date",
        data() {
            return {
                date: null,
                dialog: false,
                dateFormatted: null
            }
        },
        watch: {
            value(val) {
                this.date = window.moment(val, ["YYYY-MM-DD"]).format('YYYY-MM-DD');
                console.log(this.date);
            },
            date(val) {
                this.dateFormatted = window.moment(val, ["YYYY-MM-DD"]).format('YYYY-MM-DD');
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
            this.initDate();
            this.updateValidators(null, true);
        },
        computed: {
            validation() {
                return this.constructValidators();
            }
        },
        methods: {
            initDate() {
                if (this.value !== null) {
                    this.date = window.moment(this.value, ["YYYY-MM-DD"]).format('YYYY-MM-DD');
                    console.log(this.date);
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