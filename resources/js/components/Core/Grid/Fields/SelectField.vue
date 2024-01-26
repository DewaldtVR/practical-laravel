<template>
    <div>

        <template v-if="items && items.length < 4">
            <div class="subheading mt-3">{{label}}</div>
            <v-radio-group v-model="innerValue"
                           :name="name"
                           :ref="name"
                           :rules="validation"
                           @input="updateValidators()">
                <v-radio
                        v-for="item in items"
                        :key="item['id']"
                        :label="item['text']"
                        :value="item['id']"
                        color="primary"
                ></v-radio>
            </v-radio-group>
        </template>

        <template v-else>
            <v-select
                    :name="name"
                    :ref="name"
                    :label="label"
                    v-model="innerValue"
                    :rules="validation"
                    @input="updateValidators()"
                    :items="items"
                    item-value="id"
                    item-text="text"
                    autocomplete
            ></v-select>
        </template>

    </div>
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
            name: {required: true},
            label: {required: true},
            items: {
                default: function () {
                    return [];
                }
            },
        },
        name: "crud-select",
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
            requiredField() {
                return this.validators.findIndex(val => val.type === 'required') > -1;
            },
        },
        methods: {
            emitAction(action, obj) {
                this.$emit(action, obj);
            },
            updateValidators(obj = null, init = false) {
                if (this.requiredField) {
                    if (!init) this.$refs[this.name].validate(true);
                    if (!obj) {
                        obj = {
                            fieldName: this.name,
                            valid: init ? false : this.$refs[this.name].valid,
                            clause: this.initValidation
                        };
                    }
                    this.emitAction('validators', obj);
                }
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