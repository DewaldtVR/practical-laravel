<template>
    <v-text-field
            :name="name"
            :ref="name"
            :label="label"
            :mask="mask"
            :prefix="prefix"
            v-model="innerValue"
            :rules="validation"
            counter
            maxlength="255"
            @input="updateValidators()"
    ></v-text-field>
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
        name: "crud-decimal",
        data() {
            return {
                innerValue: null
            }
        },
        watch: {
            value(val) {
                this.innerValue = val;
            },
            innerValue(val) {
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
            this.innerValue = this.value;
            this.updateValidators(null, true);
        },
        computed: {
            validation() {
                return this.constructValidators();
            },
            mask() {
                return this.constructMasks();
            }
        },
        methods: {
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
            constructMasks() {
                let mask = "";
                if (this.masks.length > 0) {
                    this.masks.forEach((m) => {
                        mask = m.mask;
                    });
                }
                return mask;
            },
            matchPattern(pattern, val) {
                let tester = RegExp(pattern);
                return tester.test(val);
            },
            initValidation() {
                this.$refs[this.name].validate(true);
            }
        }
    }
</script>

<style scoped>

</style>