import Vue from "vue";
import Vue2Editor from "vue2-editor";
import icons from "./components/icons.js";
import moment from "moment";

Vue.use(Vue2Editor);

require('./RequestActivity');
let _promiseHandler = require('./promiseHandler');


Vue.component('main-menu', require('./components/core/menus/MainMenu.vue').default);
Vue.component('top-menu', require('./components/core/menus/TopMenu.vue').default);
Vue.component('vue-store', require('./components/core/state/vue-store').default);
Vue.component('multi-file', require('./components/core/grid/fields/MultiFile.vue').default);
Vue.component('rocket-file-upload', require('./components/core/grid/fields/MultiFileUploader.vue').default);
Vue.component('single-file', require('./components/core/grid/fields/FileUploader.vue').default);

Vue.component('crud-text', require('./components/core/grid/fields/TextField.vue').default);
Vue.component('crud-time', require('./components/core/grid/fields/TimeField.vue').default);
Vue.component('crud-date', require('./components/core/grid/fields/Date.vue').default);
Vue.component('crud-enum', require('./components/core/grid/fields/EnumField.vue').default);
Vue.component('crud-select', require('./components/core/grid/fields/SelectField.vue').default);
Vue.component('crud-decimal', require('./components/core/grid/fields/DecimalField.vue').default);
Vue.component('crud-range', require('./components/core/grid/fields/RangeField.vue').default);
Vue.component('crud-bool', require('./components/core/grid/fields/BoolField.vue').default);
Vue.component('crud-html', require('./components/core/grid/fields/HtmlField.vue').default);


Vue.component('grid', require('./components/core/grid/Grid.vue').default);
Vue.component('grid-crud', require('./components/core/grid/GridCrud.vue').default);
Vue.component('grid-field-menu', require('./components/core/grid/GridFieldMenu.vue').default);

Vue.component('framework', require('./components/core/framework/Framework.vue').default);
Vue.component('snackbar', require('./components/core/framework/Snackbar.vue').default);
Vue.component('modal-custom', require('./components/core/Modal.vue').default);
Vue.component('modal', require('./components/core/framework/Modal.vue').default);
Vue.component('activity', require('./components/core/framework/BrowserActivity.vue').default);


export const EventBus = new Vue();
Vue.prototype.$snackbar = function (message, messagetype, icon, vertical, horizontal, duration, fill) {
    let opt = {};
    opt.message = message;
    opt.messagetype = messagetype;
    opt.vertical = vertical;
    opt.horizontal = horizontal;
    opt.duration = duration;
    opt.icon = icon;
    opt.fill = fill;
    EventBus.$emit('snackbar', opt);
};

Vue.prototype.$dialog = function (title, content, type, toolbar, icon, width, overlay, buttons, input) {
    let opt = {};
    opt.title = title;
    opt.content = content;
    opt.type = type;
    opt.toolbar = toolbar;
    opt.icon = icon;
    opt.width = width;
    opt.overlay = overlay;
    opt.buttons = buttons;
    opt.field = input;
    var promise = (0, _promiseHandler.createPromiseHandler)();
    opt.promise = promise;
    EventBus.$emit('dialog', opt);
    return promise;
};

Vue.prototype.$addactivity = function (id) {
    EventBus.$emit('add_activity', id);
};

Vue.prototype.$removeactivity = function (id) {
    EventBus.$emit('remove_activity', id);
};

Vue.prototype.$getFileIcon = function (fileName) {
    let ext = fileName.split('.').pop();
    let icon = icons[`.${ext}`];
    return `/svg/${icon || 'unknown'}.svg`;
};

Vue.prototype.$formatDate = function (date, format = "L") {
    return moment(date).format(format);
};

Vue.prototype.$getUuid = function (date) {
    return Math.floor(Math.random() * 100);
};