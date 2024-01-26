<template>
  <v-layout row justify-center>
    <v-dialog v-model="show" :max-width="options.width" :hide-overlay="!options.overlay" persistent>
      <v-card>
        <v-toolbar dark v-if="options.toolbar" :color="options.type?options.type:'info'" flat>
          <v-icon v-if="options.icon">
            {{ options.icon }}
          </v-icon>
          <v-toolbar-title>{{ options.title }}</v-toolbar-title>
        </v-toolbar>
        <v-card-title v-else :class="'headline'">{{ options.title }}</v-card-title>
        <v-card-text class="text-xs-center">
          <div v-html="options.content"></div>
          <template v-if="options.field&&options.field.label&&options.field.prop">
            <v-text-field :label="options.field.label" v-model="meta[options.field.prop]" multi-line>
            </v-text-field>
          </template>
        </v-card-text>
        <v-card-actions>
          <template v-for="(button,index) in buttons">
            <v-btn :key="index" :color="button.color?button.color:''" :flat="!button.fill"
                   @click="promiseResolve(button.value)">
              {{ button.text }}
            </v-btn>
          </template>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
export default {
  props: {value: {required: true}, options: {type: Object}},
  name: "dialog",
  data() {
    return {
      show: false,
      meta: {}
    }
  },
  mounted() {

  },
  watch: {
    value(val) {
      this.show = val
    },
    show(val) {
      this.$emit('input', val);
    }
  },
  computed: {
    buttons() {
      let buttons = [];
      if (this.options.hasOwnProperty('buttons')) {
        let keys = Object.keys(this.options.buttons);
        for (let key of keys) {
          let obj = this.options.buttons[key];
          if (typeof obj === 'object') {
            let button = {};
            if (obj.hasOwnProperty('label')) {
              button.text = obj.label;
            } else {
              button.text = key;
            }
            if (obj.hasOwnProperty('color')) {
              button.color = obj.color;
            }
            button.fill = obj.fill;
            button.value = key;
            buttons.push(button);
          } else {
            buttons.push({text: this.options.buttons[key], value: key})
          }
        }
      }
      return buttons;
    }
  },
  methods: {
    promiseResolve(data) {
      if (this.options.field && this.options.field.prop)
        this.options.promise.resolve({response: data, meta: this.meta});
      else this.options.promise.resolve(data);
      this.show = false;
    }
  }
}
</script>

<style scoped>

</style>