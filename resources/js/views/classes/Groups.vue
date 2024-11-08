<template>
  <v-container>
    <div class="d-flex justify-end">
      <bread-crumbs :items="breadItems"></bread-crumbs>
    </div>

    <div class="nmt-1">
      <group-table></group-table>
    </div>
  </v-container>
</template>

<script>
import BreadCrumbs from "../../components/BreadCrumbs";
import GroupTable from "../../components/classes/GroupTable";

export default {
  name: "Classes",
  components: { GroupTable, BreadCrumbs },
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
          text: this.$route.meta.title,
          disabled: true,
          to: {
            name: "Classes"
          }
        }
      ]
    };
  }
};
</script>

<style scoped>
</style>