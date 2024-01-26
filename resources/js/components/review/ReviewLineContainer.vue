<template>
  <v-expansion-panel
      :style="captureBarStyle"
      v-model="panel"
      expand
  >

    <v-expansion-panel-content>

      <template v-slot:header>
        <v-layout row>

          <v-flex xs2 class="l-center">
            <v-avatar
                tile
                size="30"
            >
              <img :src="fileTypeIcon" alt="file">
            </v-avatar>
            <span class="subheading ml-2">{{ fileTypeDescription }}</span>
          </v-flex>

          <v-flex xs2 class="c-m-center">
            <small class="grey--text">Reference</small>
            <span class="subheading">{{ reference }}</span>
          </v-flex>

          <v-flex xs2 class="c-m-l-center">
            <small class="grey--text">Organisation Name</small>
            <span class="subheading">{{ companyName }}</span>
          </v-flex>

          <v-flex xs1 class="c-m-center">
            <small class="grey--text">Files</small>
            <span class="subheading grey--text">{{ evaluationAttachments.length + files.length}}</span>
          </v-flex>

          <v-flex xs2 class="c-m-center">
            <small class="grey--text">Measurement Service</small>
            <span class="subheading">{{ serviceDescription }}</span>
          </v-flex>

          <v-flex xs1 class="c-m-center">
            <small class="grey--text">Submit Date</small>
            <div class="subheading">{{ submitDate }}</div>
          </v-flex>

          <v-flex xs2 class="c-center">
            <v-menu offset-y v-if="!loading">
              <template v-slot:activator="{ on }">
                <v-chip
                    label
                    outline
                    :color="stateColor"
                    class="c-chip-style"
                    @click.native.stop
                    v-on="on"
                    :disabled="loading"
                >
                  {{ stateDescription }}
                </v-chip>

              </template>
              <v-list dense>
                <v-list-tile v-for="state in availableStates" @click="confirmStateSwitch(state)">
                  <v-list-tile-content>
                    <v-list-tile-title>{{ getStateText(state) }}</v-list-tile-title>
                  </v-list-tile-content>
                  <v-list-tile-action>
                    <v-icon>{{ getStateIcon(state) }}</v-icon>
                  </v-list-tile-action>
                </v-list-tile>
              </v-list>
            </v-menu>

            <template v-else>
              <v-progress-circular indeterminate :color="getStateColor(state)" class="ml-5">
              </v-progress-circular>
            </template>

          </v-flex>

        </v-layout>
      </template>

      <v-card>
        <v-divider></v-divider>
        <v-card-text>

          <v-layout row>

            <v-flex xs4 class="c-m-center pl-2">
              <small class="grey--text">Client Name or Code</small>
              <span class="subheading">{{ entityName }}</span>
            </v-flex>

            <!-- Field Values-->
            <v-flex xs3 class="c-m-center" style="margin-left: -5px">
              <small class="grey--text">User</small>
              <div>{{ userName }}</div>
            </v-flex>

            <v-flex xs3 class="c-m-center" style="margin-left: -10px">
              <small class="grey--text">Measurement Date</small>
              <span class="subheading">{{ measurementDate }}</span>
            </v-flex>

            <template v-if="notification&&notification.length>0">
              <v-flex xs3 style="margin-left: -10px">
                <span class="subheading">
                  <div><v-icon color="error" medium>info</v-icon>
                  {{notification[0].notedescription}}</div>
                </span>
              </v-flex>
            </template>

          </v-layout>
        </v-card-text>

        <v-divider></v-divider>

        <v-layout row>
          <v-flex xs12>
            <rocket-file-upload
                label="Uploaded files"
                v-model="evaluationAttachments"
                :url="fileUrl"
                :max-files="getAmountOfEvaluations"
                :intent="availableIntents"
            ></rocket-file-upload>
          </v-flex>
        </v-layout>

        <v-divider></v-divider>

        <v-layout row class="pb-1">
          <v-flex xs12>
            <rocket-file-upload label="Reports" :url="`${baseUrl}/upload`" v-model="attachments"
                                :max-files="4"></rocket-file-upload>
          </v-flex>
        </v-layout>

        <template v-if="notes&&notes.length>0">
          <v-divider></v-divider>

          <v-layout row>
            <v-flex xs12 class="pl-4 pr-4 pt-2">
              <template v-for="note in notes">
                <small class="grey--text">{{ note.user.name }} | {{ formatDateTime(note.created_at) }}</small>
                <p>{{ note.notedescription }}</p>
              </template>
            </v-flex>
          </v-layout>
        </template>

      </v-card>

    </v-expansion-panel-content>

  </v-expansion-panel>
</template>

<script>
import FileUploader from "../core/grid/fields/FileUploader";
import EvaluationMixin from "../mixins/evaluation_mixin";

export default {
  name: "ReviewLineContainer",
  mixins: [
    EvaluationMixin
  ],
  components: {FileUploader},
  props: {
    evaluation: {
      required: true,
      default: null,
      type: Object
    },
    expanded: {
      default: false,
      type: Boolean
    }
  },
  data() {
    return {
      loading: false,
      model: null,
      panel: [],
      menu: true,
      attachments: [],
      evaluationAttachments: [],
      file: null
    }
  },
  created() {
    this.model = this.evaluation;
    this.attachments = this.model.files;
    this.evaluationAttachments = this.model.evaluationfiles;
    //this.panel.push(this.expanded);
  },
  mounted() {
    this.file = this.model.file;
  },
  computed: {
    getAmountOfEvaluations(){
      return this.evaluationAttachments === null ? null : this.evaluationAttachments.length ;
    },
    captureBarStyle() {
      return {
        "border-left": `8px solid ${this.stateColor}`
      };
    },
    state() {
      return this.model ? this.model.evaluationstate : null;
    },
    stateDescription() {
      return this.getStateText(this.state);
    },
    stateColor() {
      return this.getStateColor(this.state);
    },
    stateIcon() {
      return this.getStateIcon(this.state);
    },
    serviceDescription() {
      return this.model ? this.serviceTypes.filter(b => b.value === this.model.service)[0].text : null;
    },
    companyName() {
      return this.model && this.model.company
          ? this.model.company.companyname
          : "None";
    },
    reference() {
      return this.model && this.model.reference
          ? this.model.reference
          : "No Reference";
    },
    entityName() {
      return this.model
          ? this.model.entityname
          : "No Entity";
    },
    submitDate() {
      return this.model ? this.$formatDate(this.model.created_at) : null;
    },
    files() {
      return this.model ? this.model.files : [];
    },
    userName() {
      return this.model && this.model.user
          ? this.model.user.email
          : "No User";
    },
    fileName() {
      return this.model && this.model.file
          ? this.model.file.originalfilename
          : "No User";
    },
    fileIcon() {
      return this.model ? this.getFileIcon(this.model.file.originalfilename) : null;
    },
    fileTypeIcon() {
      return this.model && this.model.filetype.coverimage
          ? this.model.filetype.coverimage.url
          : this.fileIcon;
    },
    fileTypeDescription() {
      return this.model ? this.model.filetype.filetypedescription : "Error";
    },
    measurementDate() {
      return this.model ? this.$formatDate(this.model.measurement_at) : null;
    },
    baseUrl() {
      return this.model ? `review-evaluations/${this.model.evaluationid}` : null;
    },
    availableStates() {
      return Object.keys(this.stateProps).filter(state => state !== this.state && state !== 'created');
    },
    notes() {
      if (!this.model)
        return [];
      return this.model.notes;
    },
    notification() {
      console.log(this.model.notifications)
      if (!this.model)
        return [];
      return this.model.notifications;
    },
    fileUrl() {
      if (this.model) return `${this.baseUrl}/download`;
    },
    availableIntents() {
      return ['download'];
    },
  },
  methods: {
    getFileIcon(fileName) {
      return `/${this.$getFileIcon(fileName)}`
    },
    confirmStateSwitch(newState) {
      let html = `You are about to update the report state from
                    <strong>${this.getStateText(this.state)}</strong> to
                    <strong>${this.getStateText(newState)}</strong>.
                    <br>Are you sure?`;

      let input;

      if (newState === 'incomplete')
        input = {label: 'What is missing?', prop: 'description'};

      this.$dialog("Update Report state",
          html, 'primary', true,
          null, '25%', true,
          {yes: 'update', no: 'cancel'},
          input
      ).then(async (response) => {
        if (response.response && response.response === 'yes') {
          if (response.meta.description !== null && response.meta.description !== '') {
            await this.$http.post(`${this.baseUrl}/create-note`, {description: response.meta.description});
            this.updateState(newState);
          }
        } else if (response === 'yes') {
          this.updateState(newState);
        }
      });
    },
    updateState(newState) {
      this.loading = true;
      this.$http.patch(`${this.baseUrl}/update-state`, {state: newState}).then((response) => {
        this.loading = false;
        if (response.status === 200) {
          this.$snackbar('State update success',
              'success', 'check', 'bottom', 'right');
          this.model.evaluationstate = newState; //Assign selected state after server update confirmed
        }
      }).catch(_ => {
        //this.loading = false;
        this.$snackbar('state update failed',
            'error', 'error', 'bottom', 'right');
      });
    },
    formatDateTime(date) {
      return this.$formatDate(date, 'D MMM YYYY HH:mm a');
    },
  }
}
</script>

<style scoped>
.c-chip-style {
  width: 120px;
  justify-content: space-around;
}

.c-m-center {
  display: flex;
  flex-direction: column;
  align-content: stretch;
}

.l-center {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  align-items: center;
  align-content: stretch;
}

.c-m-l-center {
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
  justify-content: center;
  align-items: flex-start;
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

.c-center {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  justify-content: center;
  align-items: center;
  align-content: stretch;
}

.ellipse-text {
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
}
</style>