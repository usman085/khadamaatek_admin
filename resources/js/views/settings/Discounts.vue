<template>
  <v-container>
    <div class="d-flex justify-space-between">
      <router-link class="profile-link" active-class :exact="true" :to="{name: 'AddDiscount'}">
        <v-btn color="#6A158E" dark>+ Add Discount</v-btn>
      </router-link>

      <bread-crumbs :items="breadItems"></bread-crumbs>
    </div>

    <div class="nmt-1">
      <discounts-table></discounts-table>
    </div>
  </v-container>
</template>

<script>
import BreadCrumbs from "../../components/BreadCrumbs";
import DiscountsTable from "../../components/settings/DiscountsTable";

export default {
  name: "Classes",
  components: { DiscountsTable, BreadCrumbs },
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