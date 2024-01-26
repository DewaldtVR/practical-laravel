<template>
  <v-expansion-panel :style="captureBarStyle" expand>

    <v-expansion-panel-content>

      <template v-slot:header>
        <v-layout row wrap>

          <v-flex xs12 md2 class="l-center">
            <v-avatar
                tile
                size="30"
            >
              <img :src="fileTypeIcon" alt="file">
            </v-avatar>
            <span class="subheading ml-2">{{ kycTypeDescription }}</span>
          </v-flex>

          <v-flex xs12 md2 class="c-m-center">
            <small class="grey--text ellipse-text">Reference</small>
            <span class="subheading ellipse-text">{{ reference }}</span>
          </v-flex>

          <v-flex xs12 md4 class="c-m-center">
            <small class="grey--text ellipse-text">Client Name or Code</small>
            <span class="subheading ellipse-text">{{ entityName }}</span>
          </v-flex>

          <v-flex xs12 md2 class="c-m-center">
            <small class="grey--text">Submit Date</small>
            <span class="subheading">{{ uploadDate }}</span>
          </v-flex>

          <!--   Conditional flex statements   -->
          <v-flex xs12 md2 v-if="isComplete" class="l-center">

            <template v-if="files.length===0">
              <v-chip
                  label
                  outline
                  color="error"
                  class="c-chip-style"
                  @click.native.stop
              >
                No Reports
              </v-chip>
            </template>

            <template v-else>
              <v-menu
                  v-model="menu"
                  :close-on-content-click="false"
                  :nudge-width="200"
                  offset-x
                  left
              >
                <template v-slot:activator="{ on }">
                  <v-chip
                      label
                      outline
                      :color="stateColor"
                      class="c-chip-style"
                      @click.native.stop
                      v-on="on"
                  >
                    Reports Avail - {{ files.length }}
                  </v-chip>
                </template>

                <v-card>
                  <v-card-title>
                    Download files
                  </v-card-title>

                  <v-divider></v-divider>

                  <v-list dense>
                    <template v-for="file in files">
                      <v-list-tile :key="file.fileid" @click="downloadFile(file)">
                        <v-list-tile-action>
                          <v-avatar
                              tile
                              size="20"
                          >
                            <img :src="getFileIcon(file.originalfilename)" alt="file">
                          </v-avatar>
                        </v-list-tile-action>
                        <v-list-tile-title>{{ file.originalfilename }}</v-list-tile-title>
                      </v-list-tile>
                    </template>
                  </v-list>

                  <v-divider></v-divider>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn flat @click="menu = false">Close</v-btn>
                  </v-card-actions>
                </v-card>
              </v-menu>
            </template>

          </v-flex>

          <v-flex xs12 md2 v-else class="l-center">
            <v-chip
                :color="stateColor"
                label
                class="c-chip-style"
                v-if="!$vuetify.breakpoint.smAndDown"
                outline
            >
              <span>{{ stateDescription }}</span>
              <v-icon right>
                {{ stateIcon }}
              </v-icon>
            </v-chip>

            <v-icon v-else :color="stateColor"> {{ stateIcon }}</v-icon>
          </v-flex>
        </v-layout>
      </template>

      <v-card>

        <v-layout row wrap>

          <v-flex xs12 md4 offset-md4 class="c-m-center">
            <small class="grey--text">Measurement Service</small>
            <span class="subheading">{{ serviceDescription }}</span>
          </v-flex>

          <v-flex xs12 md2 class="c-m-center" style="margin-left: -24px">
            <small class="grey--text">Measurement Date</small>
            <span class="subheading">{{ measurementDate }}</span>
          </v-flex>


          <v-flex>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-menu offset-y>
                <v-btn
                    slot="activator"
                    icon
                >
                  <v-icon>more_vert</v-icon>
                </v-btn>
                <v-list>
                  <v-list-tile
                      @click="requestCancellation"
                  >
                    <v-list-tile-title>Request Cancellation</v-list-tile-title>
                  </v-list-tile>
                </v-list>
              </v-menu>
            </v-card-actions>
          </v-flex>


        </v-layout>

        <v-layout row wrap>

          <v-flex xs12>
            <v-divider></v-divider>
          </v-flex>

          <v-flex xs12>
            <rocket-file-upload
                label="Uploaded files"
                v-model="attachments"
                :url="fileUrl"
                :max-files="4"
            ></rocket-file-upload>
          </v-flex>

          <template v-if="latestNote&&!isComplete">
            <v-flex xs12>
              <v-divider></v-divider>
            </v-flex>

            <v-flex xs12 class="pl-4 pr-4 pt-4">
              <p>{{ formatDate(latestNote.created_at) }}</p>
              <p>{{ latestNote.notedescription }}</p>
            </v-flex>
          </template>

        </v-layout>
      </v-card>

    </v-expansion-panel-content>
  </v-expansion-panel>
</template>

<script>

import EvaluationMixin from "../mixins/evaluation_mixin";

export default {
  name: "ReportLineContainer",
  mixins: [EvaluationMixin],
  props: {
    evaluation: {
      required: true,
      default: null,
      type: Object
    },
    refresh: {
      type: Function,
      required: true
    }
  },
  data() {
    return {
      model: null,
      file: null,
      menu: false,
      attachments: []
    }
  },
  created() {
    this.model = this.evaluation;
    this.attachments = this.model.evaluationfiles;
  },
  mounted() {
    this.file = this.model.file
  },
  computed: {
    fileUrl() {
      if (this.model) return `${this.baseUrl}/uploadEvaluation`;
    },
    baseUrl() {
      if (this.model) return `evaluations/${this.model.evaluationid}`;
    },
    captureBarStyle() {
      return {
        "border-left": `8px solid ${this.getStateColor(this.state)}`
      };
    },
    fileIcon() {
      return this.model ? `/${this.$getFileIcon(this.model.file.originalfilename)}` : null;
    },
    fileName() {
      return this.model ? this.model.file.originalfilename : null;
    },
    entityName() {
      return this.model ? this.model.entityname : null;
    },
    measurementDate() {
      return this.model ? this.$formatDate(this.model.measurement_at) : null;
    },
    uploadDate() {
      return this.model ? this.$formatDate(this.model.created_at) : null;
    },
    reference() {
      return this.model ? this.model.reference : null;
    },
    fileTypeIcon() {
      return this.model && this.model.kyctype && this.model.kyctype.coverimage
          ? this.model.filetype.coverimage.url
          : this.fileIcon;
    },
    kycTypeDescription() {
      return this.model ? this.model.kyctype.kyctypedescription : "Error";
    },
    stateDescription() {
      return this.getStateText(this.state);
    },
    stateIcon() {
      return this.getStateIcon(this.state);
    },
    serviceType() {
      return this.model ? this.model.service : null;
    },
    serviceDescription() {
      return this.model ? this.serviceTypes.filter(b => b.value === this.model.service)[0].text : null;
    },
    state() {
      return this.model ? this.model.evaluationstate : null;
    },
    stateColor() {
      return this.getStateColor(this.state);
    },
    isComplete() {
      return ['completed', 'archived'].includes(this.state);
    },
    files() {
      return this.model && this.model.files ? this.model.files : [];
    },
    availableIntents() {
      let intents = ['download'];
      if (this.state && this.state === 'incomplete')
        intents = [...intents, ...['upload', 'delete']];
      return intents;
    },
    latestNote() {
      if (!this.model || this.model.notes.length === 0) return null;
      return this.model.notes.sort(
          (a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
      )[0];
    },
  },
  methods: {
    catchGridConfig(e) {
      if (e.hasOwnProperty('refresh_func')) {
        this.refreshGrid = e['refresh_func'];
      }
    },
    refresh() {
      if (this.refreshGrid !== null)
        this.refreshGrid();
    },
    async requestCancellation() {
      let answer = await this.$dialog("You are about to request cancellation for this submisison", "Are you sure you want to do this?", "Success", null, "error", "25%", true, {
        yes: {
          text: "Yes",
          color: "black"
        },
        no: {
          text: "No",
          color: "black"
        }
      }).then(async answer => {
        if (answer === 'yes') {
          await this.$http.post(`/evaluations/${this.model.evaluationid}/requestcancellation`, {
            evaluation: this.model,
            description: "Requested Cancellation"
          })
              .then((response) => {
                console.log(response);
                this.$snackbar("Request for cancellation has been submitted. You shall receive an email shortly", "success", "check", "bottom", "right", 3000)
              }, reason => {
                console.log(reason)
              })
        }
      });
      this.loading = true;
      console.log(answer);
    },
    getFileIcon(fileName) {
      return `/${this.$getFileIcon(fileName)}`;
    },
    downloadFile(file) {
      window.location.href = `evaluations/${this.model.evaluationid}/files/${file.fileid}`;
    },
    formatDate(date) {
      return this.$formatDate(date, 'D MMM YYYY HH:mm a');
    },
    fileUpdated() {
      this.model.evaluationstate = "pending";
    }
  }
}
</script>

<style scoped>

.c-m-center {
  display: flex;
  flex-direction: column;
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

.l-center {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  align-items: center;
  align-content: stretch;
}

.c-chip-style {
  justify-content: space-around;
  min-width: 120px;
}

.ellipse-text {
  text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
}
</style>