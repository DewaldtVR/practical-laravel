<template>
  <div class="mt-3 mb-4">
    <div class="mt-2 mb-3 subheading">{{ label }}</div>
    <vue-editor
        v-model="innerValue"
        :name="name"
        @input="updateValidators()"
        :editor-options="editorSettings"
    />
  </div>
</template>

<script>
import {VueEditor, Quill} from "vue2-editor";

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
  name: "crud-html",
  components: {VueEditor},
  data() {
    return {
      innerValue: null,
      validationTriggered: false,
      editorSettings: {
        modules: {}
      }
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
    valid() {
      return this.innerValue !== null && this.innerValue !== '';
    }
  },
  methods: {
    emitAction(action, obj) {
      this.$emit(action, obj);
    },
    updateValidators(obj = null, init = false) {
      if (!obj) {
        obj = {
          fieldName: this.name,
          valid: this.valid,
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
      this.validationTrigger = true;
    }
  }
}
</script>

<style scoped>

</style>