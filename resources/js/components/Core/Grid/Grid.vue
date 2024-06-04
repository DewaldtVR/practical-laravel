<template>
  <v-card>
    <template v-if="state!=='create'&&state!=='edit'">
      <v-card-title>
        <div class="headline">{{ title }}</div>
        <v-spacer>
        </v-spacer>
        <slot name="main-menu"></slot>
        <v-btn flat @click="state='create'" v-if="mode==='crud' || mode==='addEdit'" :disabled="loading">
          Add new
        </v-btn>
        <v-btn icon @click="state='query'" :disabled="loading">
          <v-icon>refresh</v-icon>
        </v-btn>
      </v-card-title>
      <div class="ml-3 mr-3 mb-2">
        <v-chip
            v-for="filter in filters"
            :key="filter.field"
            color="primary"
            label
            outline
            close
            @input="removeFilter(filter)"
        >
          {{ getFilterDescription(filter) }}
        </v-chip>
      </div>
      <slot></slot>
      <v-data-table
          v-model="selected"
          :headers="headers"
          :items="items"
          :pagination.sync="pagination"
          :total-items="totalItems"
          :loading="loading"
          item-key="name"
      >
        <v-progress-linear slot="progress" color="primary" indeterminate
                           style="height: 3px"></v-progress-linear>
        <template slot="headers" slot-scope="props">
          <tr style="border-bottom: 1px solid #E0E0E0">
            <th
                class="text-xs-left"
                v-for="header in props.headers"
                :key="header.text"
                v-if="header.canListView===true"
            >
              <span>{{ header.value !== 'menu' ? header.text : '' }}</span>
              <span v-if="header.value!=='menu'">
                                <grid-field-menu v-if="header.canFilterOn" :title="header.text"
                                                 :field-name="header.value"
                                                 @filter="handleFieldFilters($event)"
                                                 @clear="clearFilter($event)"></grid-field-menu>
                            </span>
            </th>
          </tr>
        </template>
        <template slot="items" slot-scope="props">
          <tr>
            <td class="text-xs-left" v-for="(head,index) in headers"
                :key="index" v-if="head.value!=='menu'&&head.canListView===true">
              <span class="grey--text">{{ head.prefix }} </span>

              <template
                  v-if="head.dataType!=='image'&&head.dataType!=='images'&&head.dataType!=='files'&&head.dataType!=='file'">
                {{ mapValue(props.item[head.value], head) || '-' }}
              </template>

              <template v-else-if="head.dataType==='image'">
                <v-avatar
                    v-if="props.item[head.value]"
                    :tile="false"
                    :size="45"
                    color="grey lighten-4"
                >
                  <img :src="props.item[head.value].url" alt="avatar">
                </v-avatar>
                <span v-else>-</span>
              </template>

              <template v-else-if="head.dataType==='file'">
                <v-avatar
                    v-if="props.item[head.value]"
                    :tile="true"
                    :size="30"
                >
                  <img :src="getSvgFileIcon(props.item[head.value].originalfilename)" alt="avatar">
                </v-avatar>
                <span v-else>-</span>
              </template>

            </td>
            <td v-else-if="rowMenu!==null&&head.value==='menu'" class="text-xs-right">
              <v-menu offset-y offset-x left nudge-left min-width="150" origin="center center"
                      v-if="showRowMenu(props.item)"
                      transition="scale-transition"
                      bottom>
                <v-btn slot="activator" icon>
                  <v-icon color="grey darken-2">more_vert</v-icon>
                </v-btn>
                <v-list>
                  <v-list-tile v-if="showRowMenuItem(item,props.item)" v-for="(item,index) in rowmenu"
                               :key="index"
                               @click="item.closure(props.item,props.item[responseData.primaryKey])">
                    <v-list-tile-content>
                      <v-list-tile-title>{{ item.label }}</v-list-tile-title>
                    </v-list-tile-content>
                    <v-list-tile-action v-if="item.icon" class="text-xs-right">
                      <v-icon>{{ item.icon }}</v-icon>
                    </v-list-tile-action>
                  </v-list-tile>
                </v-list>
              </v-menu>
            </td>
          </tr>
        </template>
      </v-data-table>
    </template>
    <template v-if="state==='create'||state==='edit'">
      <v-card-title>
        <div class="headline">{{ title }}: Add new</div>
      </v-card-title>
      <v-card-text>
        <grid-crud :db-fields="dbFields" :url="url" @cancel="state='initializing'" :row="row" :mode="this.state"
                   @created="emitCreated"
                   :primary-key="responseData.primaryKey">
        </grid-crud>
      </v-card-text>
    </template>
  </v-card>
</template>

<script>
import icons from "../../icons.js";

export default {
  props: {
    url: {required: true},
    title: {default: 'grid Title'},
    rowMenu: {
      type: Array, default: function () {
        return [];
      }
    },
    mode: {type: String, default: 'view'},
    dateFormat: {type: String, default: 'D MMM YYYY'},
    timeFormat: {type: String, default: 'HH:mm a'},
    dateTimeFormat: {type: String, default: 'D MMM YYYY HH:mm a'}
  },
  name: "thunder-grid",
  data() {
    return {
      loading: false,
      state: 'initializing',

      pagination: {
        sortBy: 'name',
        rowsPerPage: 25
      },
      totalItems: 0,
      selected: [],
      responseData: null,
      items: [],
      row: {},
      filters: {},
      filterState: {}
    }

  },
  watch: {
    state(val) {
      if (val === 'query')
        this.getGridData();
      if (val === 'initializing')
        this.init();
    },
    pagination: {
      handler() {
        this.handlePaging();
      }, deep: true
    }
  },
  mounted() {
    this.init();
    this.emitGridDefinitions();
  },
  computed: {
    dbFields() {
      if (this.responseData.hasOwnProperty('fields')) {
        return this.responseData.fields;
      } else {
        return [];
      }
    },
    headers() {
      let data = this.responseData;
      if (data !== null && data.hasOwnProperty('fields')) {
        let headers = [];
        data.fields.forEach((f) => {
          let obj = {};
          obj.text = f.label;
          obj.value = f.fieldName;
          obj.dataType = f.dataType;
          obj.descriptor = f.descriptor;
          obj.prefix = f.prefix;
          obj.values = f.values;
          obj.canFilterOn = f.canFilterOn;
          obj.canListView = f.canListView;
          obj.canAddEdit = f.canAddEdit;
          headers.push(obj);
        });
        if (this.rowmenu.length > 0) {
          headers.push({text: 'Menu', value: 'menu', dataType: ''});
        }
        return headers;
      } else {
        return [];
      }
    },
    rowmenu() {
      let menu = [];
      if (this.mode === 'crud') {
        menu.push({
          label: 'Edit', icon: 'create', closure: (row, rowid) => {
            this.row = row;
            this.state = "edit";
          }
        });
        menu.push({
          label: 'Unlink', icon: 'delete', closure: this.deleteRecord
        });
      }

      if (this.mode === 'edit') {
        menu.push({
          label: 'Edit', icon: 'create', closure: (row, rowid) => {
            this.row = row;
            this.state = "edit";
          }
        });
      }

      if (this.mode === 'addEdit') {
        menu.push({
          label: 'Edit', icon: 'create', closure: (row, rowid) => {
            this.row = row;
            this.state = "edit";
          }
        });
      }

      if (this.mode === 'delete') {
        menu.push({
          label: 'Unlink', icon: 'delete', closure: this.deleteRecord
        });
      }

      if (this.rowMenu !== null) {
        this.rowMenu.forEach((m) => {
          menu.push(m);
        })
      }
      return menu;
    }
  },
  methods: {
    init() {
      this.row = {};
      this.items = [];
      this.getDefinition();
    },
    emitGridDefinitions() {
      this.$emit('config', {
        'refresh_func': this.refreshGrid
      });
    },
    resetPagination() {
      return !(JSON.stringify(this.filters) === JSON.stringify(this.filterState));
    },
    getPageState() {
      let state = JSON.parse(JSON.stringify(this.pagination));
      if (this.resetPagination()) state.page = 1;
      this.filterState = JSON.parse(JSON.stringify(this.filters));
      return state;
    },
    getGridData() {
      this.doCommand('query', {
        filters: this.filters,
        pagination: this.getPageState()
      }).then((response) => {
        this.items = response.body["data"];
        this.totalItems = response.body["pagination"]["totalItems"];
        this.state = 'done';
        this.loading = false;
      })
    },
    getDefinition() {
      this.doCommand('definition').then((response) => {
        this.responseData = response.body;
        this.state = 'query';
        this.loading = false;
      }, (error) => {
        this.$snackbar('Something went wrong', 'error', 'warning', 'top', 'right', 5000, true);
      })
    },
    doCommand(command, data = null) {
      this.loading = true;
      return this.$http.post(this.url, {command: command, data}, {});
    },
    deleteRecord(row, rowid) {
      this.$dialog('Delete', 'You are about to delete ' + row[this.responseData.descriptor] + ', Are you sure?', 'warning', false, 'alert', '20%', true, {
            yes: {label: 'Yes', color: 'primary', fill: true},
            cancel: {label: 'Cancel', color: 'secondary', fill: true}
          }
      ).then((result) => {
        if (result === "yes")
          this.deleteAction(rowid);
      })
    },
    deleteAction(rowid) {
      this.doCommand('delete-record', rowid).then((response) => {
            this.$snackbar('Deleted', 'success', 'check', 'top', 'right', 5000);
            this.state = 'query';
          }, (error) => {
            this.$snackbar('Something went wrong', 'error', 'warning', 'top', 'right', 5000);
          }
      )
    },
    handlePaging() {
      this.getGridData()
    },
    mapValue(val, head) {
      if (val !== null) {
        if (head.dataType === 'datetime')
          return this.parseDateTime(val, this.dateTimeFormat);

        if (head.dataType === 'time')
          return this.parseDateTime(val, this.timeFormat);

        if (head.dataType === 'date')
          return this.parseDateTime(val, this.dateFormat);

        if (head.dataType === 'enum') {
          let formatted = val;
          head.values.forEach((value) => {
            if (value["value"] === val) {
              formatted = value["text"];
            }
          });
          return formatted;
        }
        if (head.dataType === 'text')
          if (val.length > 100) return `${val.substring(0, 100)}...`
          else return val;

        if (head.dataType === 'range')
          return parseInt(val);

        if (head.dataType === 'decimal')
          return val;

        if (head.dataType === 'select')
          return val[head.descriptor];

        if (head.dataType === 'bool') {
          let formatted = val;
          head.values.forEach((value) => {
            if (value["value"] === val) {
              formatted = value["text"];
            }
          });
          return formatted;
        }
      } else return val;

    },
    parseDateTime(date, format = this.dateFormat) {
      return moment(date).format(format);
    },
    handleFieldFilters(event) {
      this.$set(this.filters, event['field'], event);
      this.getGridData();
    },
    clearFilter(event) {
      if (this.filters.hasOwnProperty(event)) {
        delete this.filters[event];
        this.getGridData();
      }
    },
    removeFilter(filter) {
      delete this.filters[filter['field']];
      this.$forceUpdate();
      this.getGridData();
    },
    getFilterDescription(filter) {
      if (filter.hasOwnProperty('mode')) {
        if (filter['mode'] === 'contains') {
          return filter['title'] + ' -> Contains: "' + filter['searchQuery'] + '"';
        } else if (filter['mode'] === 'starts_with') {
          return filter['title'] + ' -> Starts with: "' + filter['searchQuery'] + '"';
        } else if (filter['mode'] === 'ends_with') {
          return filter['title'] + ' -> Ends with: "' + filter['searchQuery'] + '"';
        }
      }
    },
    emitCreated() {
      this.$emit("created");
    },
    showRowMenuItem(item, row) {
      if (item.hasOwnProperty('show'))
        return item.show(row, row[this.responseData.primaryKey]);
      else return true;
    },
    showRowMenu(row) {
      let show = 0;
      this.rowmenu.forEach((item) => {
        if (this.showRowMenuItem(item, row)) {
          show++;
        }
      });
      return show > 0;
    },
    refreshGrid() {
      this.getGridData();
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

</style>