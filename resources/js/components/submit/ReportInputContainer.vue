<template>
  <v-card :style="captureBarStyle">
    <v-layout row wrap class="mt-1">

      <!--File type-->
      <v-flex xs12 md2 class="pl-4">
        <v-select
            label="KYC Type"
            :items="kycTypeList"
            item-value="kyctypeid"
            item-text="kyctypedescription"
            v-model="kycType"
            v-show="canEdit"
            :clearable="!!kycType"
        ></v-select>
      </v-flex>

      <!--Entity name / code-->
      <v-flex xs12 md2 class="pl-4">
        <v-text-field
            label="Client Name or Code"
            v-model="nameOrCode"
            v-show="canEdit"
        ></v-text-field>
      </v-flex>

      <!--Service type-->
      <v-flex xs12 md3 class="pl-4">
        <v-select
            label="Measurement Service"
            :items="serviceTypes"
            item-value="value"
            item-text="text"
            v-model="serviceType"
            v-show="canEdit"
            :clearable="!!serviceType"
            class="no-wrap"
        ></v-select>
      </v-flex>

      <!--Measurement date-->
      <v-flex xs12 md3 class="pl-4">
        <v-menu
            ref="measurement_menu"
            v-model="dateMenu"
            :close-on-content-click="false"
            :return-value.sync="measurementDate"
            lazy
            transition="scale-transition"
            offset-y
            full-width
            min-width="290px"
        >
          <template v-slot:activator="{ on }">
            <v-text-field
                :value="measurementDateFormat"
                label="Measurement Date"
                readonly
                v-on="on"
                v-show="canEdit"
                append-icon="event"
            ></v-text-field>
          </template>
          <v-date-picker v-model="measurementDate" no-title scrollable>
            <v-spacer></v-spacer>
            <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
            <v-btn flat color="primary" @click="$refs.measurement_menu.save(measurementDate)">OK</v-btn>
          </v-date-picker>
        </v-menu>
      </v-flex>

      <v-flex xs12 md2 class="c-center">
        <v-btn v-show="canEdit"
               :disabled="!canSubmit"
               @click="submit"
               :loading="loading"
               small
               color="success"
        >submit</v-btn>
        <v-btn icon :disabled="!isDirty" v-show="canEdit">
          <v-icon color="warning" @click="deleteEvaluation" :disabled="loading">cancel</v-icon>
        </v-btn>
      </v-flex>

      <!--File uploader-->
      <v-flex xs12>
        <single-file
            label="Uploaded files"
            v-model="file"
            :url="fileUrl"
            :before-create="model===null?initEvaluation:null"
        ></single-file>
      </v-flex>

    </v-layout>
  </v-card>
</template>

<script>
import EvaluationMixin from "../mixins/evaluation_mixin";

export default {
  name: "ReportInputContainer",
  mixins: [EvaluationMixin],
  props: {
    incomplete: {
      default: null,
      type: Object
    },
    kycTypes: {
      required: true
    }
  },
  data() {
    return {
      loading: false,
      model: null,
      dateMenu: false,
      file: null, // for data
      measurementDate: null, // for data
      kycType: null,
      serviceType: null,
      nameOrCode: null
    }
  },
  watch: {
    incomplete(val) {
      this.model = val;
      if (val && val.file)
        this.file = val.file;
    }
  },
  computed: {
    captureBarStyle() {
      return {
        "border-left": `8px solid ${this.getStateColor('completed')}`
      };
    },
    fileUrl() {
      if (this.model) return `${this.baseUrl}/upload`;
    },
    baseUrl() {
      if (this.model) return `evaluations/${this.model.evaluationid}`;
    },
    kycTypeList() {
      if (!this.kycTypes) return [];
      else return this.kycTypes;
    },
    measurementDateFormat() {
      return this.measurementDate ? this.formatDate(this.measurementDate) : null;
    },
    canSubmit() {
      return this.file && this.kycType && this.nameOrCode && this.measurementDate;
    },
    isDirty() {
      return this.file || this.kycType || this.nameOrCode || this.measurementDate;
    },
    canEdit() {
      return this.file !== null;
    }
  },
  methods: {
    initEvaluation() {
      return new Promise((resolve, reject) => {
        this.$http.post("evaluations/create").then((response) => {

          if (response.status !== 200)
            return reject();

          this.model = response.body;
          return resolve();

        });
      });
    },
    submit() {
      if (!this.canSubmit) return null;

      this.loading = true;

      let data = {
        kyctypeid: this.kycType,
        servicetype: this.serviceType,
        measurementdate: this.measurementDate,
        entityname: this.nameOrCode
      };

      this.$http.put(this.baseUrl, data).then((response) => {
        this.loading = false;
        if (response.status === 200) {
          this.clear();
          this.$emit("created");
          this.$dialog('Done',
              'Your report has been submitted!', 'success',
              true, 'check_circle', '25%', true, {
                close: 'close'
              });
        }
      }).catch((error) => {
        this.loading = false;
        this.$snackbar('Your submission failed to process', 'error', 'warning', 'bottom', 'right', 5000);
      });
    },
    async deleteEvaluation() {
      let result = await this.$dialog('Delete submission', 'Are you sure?', null, null, null, '25%', true, {
        yes: {
          text: 'Delete',
          color: 'error'
        },
        no: 'cancel'
      });

      if (result === 'no') return;

      let response = await this.$http.delete(this.baseUrl);

      if (response.status === 200)
        this.clear();
    },
    clear() {
      this.model = null;
      this.file = null;
      this.measurementDate = null;
      this.kycType = null;
      this.nameOrCode = null;
    },
    formatDate(date) {
      return this.$formatDate(date);
    }
  }
}
</script>

<style scoped>
.c-center {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: center;
  align-items: center;
  align-content: stretch;
}

.r-center {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: flex-end;
  align-items: center;
  align-content: stretch;
}
</style>