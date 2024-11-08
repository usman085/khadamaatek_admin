<template>
  <v-container>
    <div class="d-flex justify-space-between">
      <div style="min-width: 200px">
        <v-tabs v-model="tab" grow>
          <v-tab class="c-tab">Payment</v-tab>
          <v-tab class="c-tab">Earning</v-tab>
          <v-tab class="c-tab">Bad Dept</v-tab>
          <v-tab class="c-tab">Tutor Earning</v-tab>
        </v-tabs>
      </div>
      <bread-crumbs :items="breadItems"></bread-crumbs>
    </div>

    <div class="nmt-1">
      <v-tabs-items v-model="tab">
        <v-tab-item>
          <payment-table></payment-table>
        </v-tab-item>
        <v-tab-item>
          <earning-table></earning-table>
        </v-tab-item>
        <v-tab-item>
          <baddept-table></baddept-table>
        </v-tab-item>
        <v-tab-item>
          <tutor-earning-table></tutor-earning-table>
        </v-tab-item>
      </v-tabs-items>
    </div>
  </v-container>
</template>

<script>
import BreadCrumbs from "../../components/BreadCrumbs";
import PaymentTable from "../../components/accounts/PaymentTable";
import EarningTable from "../../components/accounts/EarningTable";
import BaddeptTable from "../../components/accounts/BaddeptTable";
import TutorEarningTable from "../../components/accounts/TutorEarningTable";

export default {
  name: "Accounts",
  components: {
    PaymentTable,
    EarningTable,
    BaddeptTable,
    TutorEarningTable,
    BreadCrumbs
  },
  data() {
    return {
      tab: null,
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
            name: this.$route.name
          }
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
.nmt-1 {
  margin-top: -12px;
}
.c-tab {
  background: #f2f0f0;
  transition: background-color 0.2s;
  &.v-tab--active {
    background: white;
  }
}
</style>