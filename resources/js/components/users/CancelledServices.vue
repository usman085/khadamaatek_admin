<template>
  <b-tab title="Cancelled Services" title-link-class="subtabs">
    <div class="tab-card">
      <h2 class="tab-card__title mb-5">Cancelled Services</h2>

      <p class="alert alert-info" v-if="errorMessage">{{ errorMessage }}</p>
      <b-table hover :items="cancelledServices" class="tab-card__table">
        <template v-slot:cell(order_no)="data">
          <b class="secondary-color">{{ data.item.order_no }}</b>
        </template>
      </b-table>
    </div>
  </b-tab>
</template>

<script>
export default {
  name: "CancelledServices",
  async created() {
    const loggedin = JSON.parse(localStorage.getItem("user"));

    const getPendingOrders = await axios
      .post("customer/get-orders?filter=5", { id: loggedin.user.id })
      .then(({ data }) => {
        if (data.orders && data.orders.length > 0) {
          data.orders.forEach((row) => {
            let obj = {
              order_no: row.order_no,
              // service_id: row.service.id,
              department: row.department.name,
              service_category: row.category.name,
              service_name: row.service.name,
              status: row.status.name,
              price: row.agreed_fee,
            };
            this.cancelledServices.push(obj);
          });
        } else {
          this.errorMessage = data.message;
        }
      })
      .catch((err) => {
        console.log(err);
      });
  },
  data() {
    return {
      errorMessage: "",
      cancelledServices: [],
    };
  },
};
</script>

<style>
</style>