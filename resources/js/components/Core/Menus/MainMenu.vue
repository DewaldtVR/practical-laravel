<template>
  <v-list>
<!--    <v-divider></v-divider>-->
    <template v-for="item in items">
      <v-list-group
          v-if="item.hasOwnProperty('submenu')"
          :prepend-icon="item.icon"
          :value="hasActiveLink(item)"
      >
        <v-list-tile slot="activator" style="width: 100%;">
          <v-list-tile-title>{{ item.label }}</v-list-tile-title>
        </v-list-tile>
        <v-list-tile v-for="(subitem, i) in item.submenu" :key="i" @click="navigate(subitem.href)"
                     :value="url===subitem.href">
          <v-list-tile-action>
            <v-icon></v-icon>
          </v-list-tile-action>
          <v-list-tile-title style="width: 100%">{{ subitem.label }}</v-list-tile-title>
          <v-list-tile-action v-if="subitem.icon">
            <v-icon :color="url===subitem.href?'secondary':null">{{ subitem.icon }}</v-icon>
          </v-list-tile-action>
        </v-list-tile>
      </v-list-group>

      <v-list-tile @click="navigate(item.href)" v-else :value="url===item.href">
        <v-list-tile-action v-if="item.icon">
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-tile-action>
        <v-list-tile-title>{{ item.label }}</v-list-tile-title>
      </v-list-tile>
    </template>
  </v-list>
</template>

<script>
export default {
  props: {items: {type: Array, required: true}},
  name: "main-menu",
  mounted() {

  },
  methods: {
    navigate(href) {
      window.location.href = href;
    },
    hasActiveLink(item) {
      let has = false;
      item.submenu.forEach((m) => {
        if (!has) {
          has = this.url === m.href;
        }
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

</style>