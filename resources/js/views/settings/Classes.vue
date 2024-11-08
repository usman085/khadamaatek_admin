<template>
  <v-container>
    <div class="d-flex justify-space-between">
      <router-link class="profile-link" active-class :exact="true" :to="{name: 'AddClass'}">
        <v-btn color="#6A158E" dark>+ Add Class</v-btn>
      </router-link>

      <bread-crumbs :items="breadItems"></bread-crumbs>
    </div>

    <div class="nmt-1">
      <class-table></class-table>
    </div>
  </v-container>
</template>

<script>
import BreadCrumbs from "../../components/BreadCrumbs";
import ClassTable from "../../components/settings/ClassTable";

export default {
  name: "Classes",
  components: { ClassTable, BreadCrumbs },
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