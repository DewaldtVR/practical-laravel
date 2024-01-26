<template>
  <div>
    <v-list>
      <div :class="hasError?'error--text subheading mb-3':'subheading mb-3'" v-if="label!==null">{{ label }}</div>
      <v-list-tile v-for="(file,index) in fileList" :key="index" avatar>

        <template v-if="file.uploading">
          <v-list-tile-avatar>
            <v-progress-circular :value="file.percentUploaded" color="primary"></v-progress-circular>
          </v-list-tile-avatar>
        </template>

        <template v-if="!file.thumbnail&&!file.uploading">
          <v-list-tile-avatar>
            <v-avatar
                :tile="true"
                :size="30"
            >
              <img :src="getSvgFileIcon(file.originalfilename)" alt="type">
            </v-avatar>
          </v-list-tile-avatar>
        </template>

        <template v-else-if="!file.uploading">
          <v-list-tile-avatar>
            <v-avatar
                :tile="false"
                :size="45"
                color="grey lighten-4"
            >
              <img :src="file.thumbnail" alt="avatar">
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

        <v-list-tile-action v-if="fileDeleting(file)===true">
          <v-progress-circular indeterminate color="primary"></v-progress-circular>
        </v-list-tile-action>

        <v-list-tile-action v-else>
          <v-menu offset-y offset-x left nudge-left min-width="150" origin="center center"
                  transition="scale-transition" bottom>
            <v-btn
                slot="activator"
                icon
            >
              <v-icon>more_vert</v-icon>
            </v-btn>
            <v-list>
              <v-list-tile
                  @click="downloadFile(file)"
              >
                <v-list-tile-content>
                  <v-list-tile-title>Download</v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action class="text-xs-right">
                  <v-icon>get_app</v-icon>
                </v-list-tile-action>
              </v-list-tile>
              <v-list-tile
                  @click="deleteFile(file)"
              >
                <v-list-tile-content>
                  <v-list-tile-title>Delete</v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action class="text-xs-right">
                  <v-icon>delete</v-icon>
                </v-list-tile-action>
              </v-list-tile>
            </v-list>
          </v-menu>
        </v-list-tile-action>
      </v-list-tile>

      <v-list v-if="fileList.length!==maxFiles" two-line>
        <v-list-tile class="grey--text">

          <v-list-tile-action>
            <v-btn icon @click="addFile()">
              <v-icon :color="'success'">add_circle</v-icon>
            </v-btn>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>
              Add file
            </v-list-tile-title>
            <v-list-tile-sub-title v-if="requiredField&&hasError" class="error--text">
              {{ requiredMessage }}
            </v-list-tile-sub-title>
          </v-list-tile-content>

        </v-list-tile>
      </v-list>
    </v-list>


    <input
        type="file"
        :id="id"
        :ref="id"
        :multiple="maxFiles>1"
        ref="myFiles"
        class="custom-file-input"
        @change="handleFileSelect($event)"
    />

  </div>
</template>

<script>
import icons from "../../../icons";

export default {
  props: {
    url: {type: String, required: true},
    maxFiles: {type: Number, default: 1},
    label: {type: String, default: null},
    validators: {
      type: Array, default: function () {
        return []
      }
    },
    extra: {
      type: Object
    },
    value: {
      required: true,
      default: function () {
        return []
      }
    },
    domId: {
      type: String,
      default: '_file_input'
    }
  },
  name: "MultiFile",
  data() {
    return {
      files: [],
      deleteQueue: [],
      id: null,
      validationTriggered: false
    }
  },
  watch: {
    'files': {
      handler: function (val) {
        this.$emit('input', val);
        if (val.length > 0) this.updateValidators({
          fieldName: this.extra.key, valid: true
        });
      }, deep: true
    },
    'value': {
      handler: function (val) {
        this.files = val;
        console.log("Value");
      }, deep: true
    },
  },
  mounted() {
    this.id = 'file_input_' + this.getRandomId();
    this.files = this.value;
    this.updateValidators(null, true);
  },
  computed: {
    fileList() {
      if (this.files.length > 0)
        return this.files;
      else return [];
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
      return this.fileList.length > 0
    },
    hasError() {
      return this.validationTriggered && !this.valid;
    }
  },
  methods: {
    addFile() {
      if (this.id !== null) {
        document.getElementById(this.id).click();
      }
    },
    getRandomId() {
      let text = '';
      let possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

      for (let i = 0; i < 5; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

      return text;
    },
    handleFileSelect() {
      let files = this.$refs[this.id].files;
      if (files.length + this.fileList.length > this.maxFiles) {
        console.log("Too many files selected");
      } else {
        let keys = Object.keys(files);
        if (keys.length > 0) {
          for (let key of keys) {
            let idx = this.files.findIndex(item => item.orginalfilename === files[key].name);
            if (idx < 0)
              this.initFileUpload(files[key]);

          }
        }
      }
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
      this.files.push(fileObj);
      this.$forceUpdate();
    },
    startXMLRequest(fileObj) {
      let self = this;
      let formData = new FormData();
      formData.append("file", fileObj.file);
      formData.append('_token', Laravel.csrfToken);
      formData.append('command', "upload");

      if (this.extra) {
        for (let key of Object.keys(this.extra)) {
          formData.append(key, this.extra[key]);
        }
      }

      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          fileObj.uploading = false;
          fileObj.fileid = JSON.parse(this.response).fileid;
          self.$emit("uploaded", {
            relatedKey: self.extra ? self.extra.relatedKey : null,
            key: self.extra ? self.extra.key : null,
            value: JSON.parse(this.response).fileid
          });
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
      let data = {command: 'delete', fileid: file.fileid};

      if (this.extra) {
        for (let key of Object.keys(this.extra)) {
          data[key] = this.extra[key];
        }
      }

      this.deleteQueue.push(file.fileid);
      this.$http.post(this.url, data).then((response) => {
        if (response.status === 200) {
          let idx = this.files.findIndex(item => item.fileid === file.fileid);
          if (idx > -1) {
            this.files.splice(idx, 1);
          }
          this.deleteQueue.splice(this.deleteQueue.indexOf(file.fileid), 1);
          this.updateValidators(null, true);
        }
      });
    },
    fileDeleting(file) {
      return this.deleteQueue.indexOf(file.fileid) > -1;
    },
    updateValidators(obj = null, init = false) {
      if (!obj) {
        obj = {
          fieldName: this.extra.key,
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
    emitAction(action, obj) {
      this.$emit(action, obj);
    },
    getSvgFileIcon(fileName) {
      let ext = fileName.split('.').pop();
      let icon = icons[`.${ext}`];
      return `/svg/${icon || 'unknown'}.svg`;
    }
  }
}
</script>

<style scoped>
.custom-file-input {
  display: none;
}
</style>