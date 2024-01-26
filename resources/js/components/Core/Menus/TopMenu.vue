<template>
  <v-toolbar-items style="margin-left: auto">
    <template v-for="item in items">


      <v-menu v-if="item.submenu" :key="item.id" offset-y nudge-left left>
        <v-btn slot="activator" v-if="item.icon&&!item.label" icon>
          <v-icon v-if="item.icon">{{ item.icon }}</v-icon>
        </v-btn>
        <v-btn slot="activator" flat v-else style="text-transform: none !important;">
          <v-icon v-if="item.icon" left small>{{ item.icon }}</v-icon>
          {{ item.label }}
        </v-btn>
        <v-list>
          <v-list-tile v-for="(subitem, index) in item.submenu" :key="index" @click="navigate(subitem.href)">
            <v-list-tile-content>
              <v-list-tile-title :value="url===subitem.href">{{ subitem.label }}</v-list-tile-title>
            </v-list-tile-content>
            <v-list-tile-action v-if="subitem.icon">
              <v-icon>{{ subitem.icon }}</v-icon>
            </v-list-tile-action>
          </v-list-tile>
        </v-list>
      </v-menu>
      <v-btn flat v-else :key="item.id" @click="navigate(item.href)" :value="url===item.href">
        <v-icon v-if="item.icon">{{ item.icon }}</v-icon>
        <div>{{ item.label }}</div>
      </v-btn>
    </template>
  </v-toolbar-items>
</template>

<script>
export default {
  props: {items: {type: Array, default: []}},
  name: "top-menu",
  methods: {
    navigate(href) {
      window.location.href = href;
    },
    hasActiveLink(item) {
      let has = false;
      item.submenu.forEach((m) => {
        has = m.href === this.url;
      });
      return has;
    }
  },
  computed: {
    url() {
      return window.location.href;
    }
  }
}
</script>

<style scoped>
/*.btn {*/
/*  text-transform: unset !important;*/
/*}*/
</style>