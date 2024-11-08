<template>
  <v-container>
    <div class="d-flex justify-space-between">
      <h2 color="#6A158E" class="page-heading" v-text="page_title"></h2>

      <bread-crumbs :items="breadItems"></bread-crumbs>
    </div>

    <div class="nmt-1">
      <group-form></group-form>
    </div>
  </v-container>
</template>

<script>
import BreadCrumbs from "../../components/BreadCrumbs";
import GroupForm from "../../components/classes/GroupForm";
export default {
  name: "Tutors",
  components: { GroupForm, BreadCrumbs },
  data() {
    return {
      page_title: this.$route.meta.title,
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
            name: this.$route.meta.routeName
          }
        }
      ]
    };
  }
};
</script>

<style scoped>
.page-heading {
  font: 300 22px/26px;
  font-family: "Gotham Narrow";
  color: #6a158e;
}
</style>