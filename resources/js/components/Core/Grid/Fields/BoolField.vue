<template>
    <div>
        <v-checkbox
                :name="name"
                :ref="name"
                :rules="validation"
                @input="updateValidators()"
                v-model="innerValue"
                :label="label"
                color="primary"
        ></v-checkbox>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                required: true,
                default: 0
            },
            validators: {
                type: Array, default: function () {
                    return []
                }
            },
            name: {
                required: true
            },
            label: {
                required: true
            },
            items: {
                default: function () {
                    return [];
                }
            },
        },
        name: "crud-bool",
        data() {
            return {
                innerValue: null,
                validationTriggered: false
            }
        },
        watch: {
            value(val) {
                this.innerValue = val;
            },
            innerValue(val) {
                console.log("bool", val);
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
            this.innerValue = parseInt(this.value || 0);
            this.updateValidators(null, true);
        },
        computed: {
            validation() {
                return this.constructValidators();
            },
            requiredField() {
                return this.validators.findIndex(val => val.type === 'required') > -1;
            },
            requiredMessage() {
                if (!this.requiredField) return null;
                else {
                    let idx = this.validators.findIndex(val => val.type === 'required');
                    return this.validators[idx].description;
                }
            },
            valid() {
                return this.innerValue === 0 || this.innerValue === 1;
            },
            hasError() {
                return this.validationTriggered && !this.valid;
            }
        },
        methods: {
            emitAction(action, obj) {
                this.$emit(action, obj);
            },
            updateValidators(obj = null, init = false) {
                if (!obj) {
                    obj = {
                        fieldName: this.fieldName,
                        valid: this.valid,
                        clause: this.initValidation
                    };
                }
                if (this.requiredField)
                    this.emitAction('validators', obj);
            },
            initValidation() {
                this.validationTriggered = !this.valid;
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
            }
        }
    }
</script>

<style scoped>

</style>