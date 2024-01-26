<template>
  <div>
    <v-list>
      <small v-if="label&&file" class="grey--text pl-4">{{ label }}</small>

      <v-list-tile v-if="file" avatar>

        <template v-if="file.uploading&&file.uploading===true">
          <v-list-tile-avatar>
            <v-progress-circular :value="file.percentUploaded" color="primary"></v-progress-circular>
          </v-list-tile-avatar>
        </template>

        <template v-else-if="!file.thumbnail">
          <v-list-tile-avatar>
            <v-avatar
                :tile="true"
                :size="30"
            >
              <img :src="getFileIcon(file.originalfilename)" alt="type">
            </v-avatar>
          </v-list-tile-avatar>
        </template>

        <v-list-tile-content>
          <v-list-tile-title>{{ file.originalfilename }}</v-list-tile-title>
          <v-list-tile-sub-title v-if="file.uploading&&file.uploading===true">
            {{ realFileSize(file.bytesUploaded) }} of {{ realFileSize(file.size) }} uploaded...
          </v-list-tile-sub-title>
          <v-list-tile-sub-title v-else>
            {{ realFileSize(file.size) }}
          </v-list-tile-sub-title>
        </v-list-tile-content>

        <v-list-tile-action v-if="deleting">
          <v-progress-circular indeterminate color="primary"></v-progress-circular>
        </v-list-tile-action>

        <v-list-tile-action v-else>
          <v-menu offset-y>
            <v-btn
                slot="activator"
                icon
            >
              <v-icon>more_vert</v-icon>
            </v-btn>
            <v-list>
              <v-list-tile
                  @click="downloadFile(file)"
                  v-if="intent.includes('download')"
              >
                <v-list-tile-title>Download</v-list-tile-title>
              </v-list-tile>
              <v-list-tile
                  @click="deleteFile(file)"
                  v-if="intent.includes('delete')"
              >
                <v-list-tile-title>Delete</v-list-tile-title>
              </v-list-tile>
            </v-list>
          </v-menu>
        </v-list-tile-action>

      </v-list-tile>
      <v-list v-if="file===null" class="pa-0">
        <v-list-tile class="grey--text">
          <v-list-tile-action>
            <v-btn icon @click="addFile()" :disabled="!intent.includes('upload')">
              <v-icon color="success">add_circle</v-icon>
            </v-btn>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>
              Click to upload new file
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-list>
    <input
        type="file"
        :id="id"
        :ref="id"
        ref="file"
        class="custom-file-input"
        @change="handleFileSelect($event)"
    />
  </div>
</template>

<script>
export default {
  props: {
    url: {type: String, required: true},
    label: {type: String, default: null},
    value: {
      required: true,
    },
    beforeCreate: {
      type: Function,
      default: null
    },
    intent: {
      type: Array,
      default: function () {
        return ['upload', 'download', 'delete'];
      }
    }
  },
  name: "FileUploader",
  data() {
    return {
      file: null,
      deleting: false,
      id: null,
    }
  },
  watch: {
    'file': {
      handler: function (val) {
        this.$emit('input', val);
      }, deep: true
    },
    'value': {
      handler: function (val) {
        this.file = val;
      }, deep: true
    },
  },
  mounted() {
    this.file = this.value;
    this.id = 'file_input_' + this.getRandomId();
  },
  methods: {
    addFile() {
      if (this.id !== null)
        document.getElementById(this.id).click();
    },
    getRandomId() {
      return this.$getUuid();
    },
    async handleFileSelect() {
      if (this.beforeCreate)
        await this.beforeCreate();

      let file = this.$refs[this.id].files[0];
      this.initFileUpload(file);
    },
    initFileUpload(file) {
      let fileObj = {
        file,
        originalfilename: file.name,
        size: file.size,
        mimetype: file.type,
        bytesUploaded: 0,
        uploading: true,
        percentUploaded: 0.0,
        hasError: false,
      };

      this.startXMLRequest(fileObj);
      this.file = fileObj;
      this.$forceUpdate();
    },
    startXMLRequest(fileObj) {
      const self = this;
      let formData = new FormData();
      formData.append("file", fileObj.file);
      formData.append('_token', Laravel.csrfToken);
      formData.append('command', "upload");

      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          let rsp = JSON.parse(this.response);
          fileObj.uploading = false;
          fileObj.fileid = rsp.fileid;
          self.$emit('uploaded', rsp);
          self.$refs[self.id].value = null;
        }
      };
      xhttp.addEventListener('progress', function (e) {
        var done = e.position || e.loaded, total = e.totalSize || e.total;
      }, false);
      if (xhttp.upload) {
        xhttp.upload.onprogress = function (e) {
          let done = e.position || e.loaded, total = e.totalSize || e.total;
          fileObj.bytesUploaded = done;
          fileObj.size = total;
          fileObj.percentUploaded = (Math.floor(done / total * 1000) / 10);
        };
      }
      xhttp.open('POST', this.url);
      xhttp.send(formData);
    },
    realFileSize(size) {
      if (size === 0)
        return '0 B';
      let i = Math.floor(Math.log(size) / Math.log(1024));
      return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
    },
    isImage(file) {
      let imgTypes = ['image/png', 'image/jpg'];
      return imgTypes.indexOf(file.mimetype) > -1;
    },
    downloadFile(file) {
      this.$http.post(this.url, {command: 'download', fileid: file.fileid}).then((response) => {
        if (response.status === 200 && response.body.hasOwnProperty('url')) {
          window.open(response.body.url);
        }
      });
    },
    deleteFile(file) {
      this.deleting = true;
      this.$http.post(this.url, {command: 'delete', fileid: file.fileid}).then((response) => {
        if (response.status === 200) {
          this.deleting = false;
          this.file = null;
          this.$refs[this.id].value = null;
        }
      });
    },
    getFileIcon(fileName) {
      return `/${this.$getFileIcon(fileName)}`;
    }
  }
}
</script>

<style scoped>
.custom-file-input {
  display: none;
}
</style>