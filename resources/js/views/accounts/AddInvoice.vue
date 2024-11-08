<template>
  <v-container>
    <div class="d-flex justify-space-between">
      <h2 color="#6A158E" class="page-heading" v-text="page_title"></h2>

      <bread-crumbs :items="breadItems"></bread-crumbs>
    </div>

    <div class="nmt-1">
      <invoice-form></invoice-form>
    </div>
  </v-container>
</template>

<script>
import BreadCrumbs from "../../components/BreadCrumbs";
import InvoiceForm from "../../components/accounts/InvoiceForm";
export default {
  name: "AddInvoice",
  components: { InvoiceForm, BreadCrumbs },
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
          text: "Accounts",
          disabled: false,
          to: {
            name: "Accounts"
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
.page-heading {
  font: 300 22px/26px;
  font-family: "Gotham Narrow";
  color: #6a158e;
}
</style>