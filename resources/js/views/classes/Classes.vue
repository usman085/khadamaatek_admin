<template>
  <v-container>
    <div class="d-flex justify-space-between">
      <router-link class="profile-link" active-class :exact="true" :to="{name: 'AddGroup'}">
        <v-btn color="#6A158E" dark>+ Add Group</v-btn>
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
import ClassTable from "../../components/classes/ClassTable";

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