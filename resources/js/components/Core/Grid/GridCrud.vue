<template>
  <v-layout row wrap>
    <v-flex xs12 v-for="(field,index) in dbFields" :key="index">
      <div v-if="initialised&&field.canAddEdit===true" class="pl-2 pr-2">

        <crud-text v-if="field.dataType==='text'" :masks="field.masks" :validators="field.validators"
                   :prefix="field.prefix"
                   :label="field.label" :name="field.fieldName" v-model="record[field.fieldName].value"
                   @validators="updateValidators($event)"></crud-text>

        <crud-html v-if="field.dataType==='richtxt'" :masks="field.masks" :validators="field.validators"
                   :prefix="field.prefix"
                   :label="field.label" :name="field.fieldName" v-model="record[field.fieldName].value"
                   @validators="updateValidators($event)"></crud-html>

        <crud-time v-if="field.dataType==='time'" :masks="field.masks" :validators="field.validators"
                   :prefix="field.prefix"
                   :label="field.label" :name="field.fieldName" v-model="record[field.fieldName].value"
                   @validators="updateValidators($event)"></crud-time>

        <crud-date v-if="field.dataType==='date'" :masks="field.masks" :validators="field.validators"
                   :prefix="field.prefix"
                   :label="field.label" :name="field.fieldName" v-model="record[field.fieldName].value"
                   @validators="updateValidators($event)"></crud-date>

        <crud-enum v-if="field.dataType==='enum'" :masks="field.masks" :validators="field.validators"
                   :prefix="field.prefix"
                   :items="field.values"
                   :label="field.label" :name="field.fieldName" v-model="record[field.fieldName].value"
                   @validators="updateValidators($event)"></crud-enum>

        <crud-select v-if="field.dataType==='select'" :validators="field.validators"
                     :items="field.values"
                     :label="field.label" :name="field.fieldName" v-model="record[field.fieldName].value"
                     @validators="updateValidators($event)"></crud-select>

        <crud-bool v-if="field.dataType==='bool'" :validators="field.validators"
                   :items="field.values"
                   :default="field.default"
                   :label="field.label" :name="field.fieldName" v-model="record[field.fieldName].value"
                   @validators="updateValidators($event)"></crud-bool>

        <crud-decimal v-if="field.dataType==='decimal'" :masks="field.masks" :validators="field.validators"
                      :prefix="field.prefix"
                      :label="field.label" :name="field.fieldName" v-model="record[field.fieldName].value"
                      @validators="updateValidators($event)"></crud-decimal>

        <crud-range v-if="field.dataType==='range'" :masks="field.masks" :validators="field.validators"
                    :prefix="field.prefix"
                    :min="field.min"
                    :max="field.max"
                    :label="field.label" :name="field.fieldName" v-model="record[field.fieldName].value"
                    @validators="updateValidators($event)"></crud-range>


        <div v-if="field.dataType==='image' || field.dataType === 'file'" class="mt-3">
          <multi-file @uploaded="handleFileUploaded($event)"
                      :max-files="1" :url="url"
                      :validators="field.validators"
                      v-model="files[field.fieldName]"
                      @validators="updateValidators($event)"
                      :label="field.label"
                      :extra="{relatedKey:field.relatedKey,key:field.fieldName,primaryKey:primaryKey,[primaryKey]:record[primaryKey]}">
          </multi-file>
        </div>

      </div>
    </v-flex>
    <v-flex xs12>
      <div style="height: 20px;"></div>
      <v-btn color="primary" @click="submit()" :loading="loading">save</v-btn>
      <v-btn color="secondary" @click="emitAction('cancel')">cancel</v-btn>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  props: {
    dbFields: {type: Array, default: [], required: true},
    url: {required: true},
    row: {type: Object, default: null},
    mode: {type: String, default: 'create'},
    primaryKey: {required: true},
  },
  name: "grid-crud",
  data() {
    return {
      files: {},
      record: {},
      invalidList: [],
      registeredValidators: {},
      loading: false,
      initialised: false
    }
  },
  mounted() {
    this.init();
  },
  watch: {},
  computed: {},
  methods: {
    init() {
      this.dbFields.forEach((f) => {
        this.record[f.fieldName] = {
          dataType: f.dataType,
          value: null
        };
        if (this.row !== null) {
          if (this.row.hasOwnProperty(f.fieldName)) {
            if (f.dataType === 'select') {
              this.$set(this.record, f.fieldName, {
                dataType: f.dataType,
                relatedKey: f.relatedKey,
                value: this.row[f.fieldName] ? this.row[f.fieldName][f.relatedKey] : null
              });
            } else if (f.dataType === 'image' || f.dataType === 'file') {
              this.$set(this.record, f.fieldName, {
                dataType: f.dataType,
                relatedKey: f.relatedKey,
                value: [this.row[f.fieldName]] || []
              });
              this.$set(this.files, f.fieldName, this.row[f.fieldName] ? [this.row[f.fieldName]] : [])
            } else {
              this.$set(this.record, f.fieldName, {
                dataType: f.dataType,
                value: this.row[f.fieldName]
              });
            }
          }
        }
      });
      if (this.row !== null) {
        this.$set(this.record, this.primaryKey, this.row[this.primaryKey]);
      }
      this.initialised = true;
    },
    updateValidators(e) {
      let idx = this.invalidList.indexOf(e.fieldName);
      if (!e.valid && idx === -1) {
        this.invalidList.push(e.fieldName);
        if (e.hasOwnProperty("clause"))
          this.registeredValidators[e.fieldName] = e.clause;
      } else if (e.valid && idx !== -1) {
        this.invalidList.splice(idx, 1);
        delete this.registeredValidators[e.fieldName];
      }
    },
    emitAction(action) {
      this.$emit(action);
    },
    submit() {
      if (this.invalidList.length > 0) {

        for (let key of Object.keys(this.registeredValidators)) {
          this.registeredValidators[key]();
        }

        this.$snackbar('Some fields are required', 'error', 'warning', 'top', 'right', 5000);
      } else {
        if (this.mode === 'create')
          this.create();
        else if (this.mode === 'edit')
          this.update();
      }
    },
    cleanRecord() {
      let data = this.record;
      if (typeof data === "object") {
        for (let key of Object.keys(data)) {
          if (data[key].hasOwnProperty("dataType"))
            if (data[key].dataType === "image" || data[key].dataType === "file")
              delete data[key];
        }
      }
      return data;
    },
    create() {
      this.doCommand('create-record', this.record).then((response) => {
        this.emitAction('cancel');
        this.emitAction('created');
        this.loading = false;
      }, (error) => {
        // console.log(error)
      });
    },
    update() {
      this.doCommand('update-record', this.cleanRecord()).then((response) => {
        // console.log(response.body);
        this.emitAction('cancel');
        this.emitAction('updated');
        this.loading = false;
      }, (error) => {
        // console.log(error);
      });
    },
    doCommand(command, data = null) {
      this.loading = true;
      return this.$http.post(this.url, {command: command, data: data});
    },
    handleFileUploaded(e) {
      if (e) this.record[e.key].value = e.value;
    },
  }
}
</script>

<style scoped>

</style>