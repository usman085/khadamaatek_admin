<template>
  <v-container>
    <div class="d-flex justify-end">
      <bread-crumbs :items="breadItems"></bread-crumbs>
    </div>

    <div class="nmt-1">
      <permissions-table></permissions-table>
    </div>
  </v-container>
</template>

<script>
import BreadCrumbs from "../../components/BreadCrumbs";
import PermissionsTable from "../../components/settings/PermissionsTable";

export default {
  name: "Classes",
  components: { PermissionsTable, BreadCrumbs },
  data() {
    return {
      breadItems: [
        {
          text: "Dashboard",
          disabled: false,
          href: "/",
          to: {
            name: "DashBoard"
          }
        },
        {
          text: "Settings",
          disabled: false,
          to: {
            name: "Settings"
          }
        },
        {
          text: this.$route.meta.title,
          disabled: true,
          to: {
            name: this.$route.name
          }
        }
      ]
    };
  }
};
</script>

<style scoped>
</style>