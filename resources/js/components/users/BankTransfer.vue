<template>
  <b-tab title="Bank Transfer Payment" title-link-class="subtabs">
    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="fullPage"></loading>

    <div class="tab-card">
      <h2 class="tab-card__title">Bank Transfer Payment</h2>
      <p
        class="tab-card__description mb-5"
      >You can access and modify your personal details (name, address, telephone number, etc) in order to facilitate your future purchases.</p>
      <div class="alert alert-info" v-if="respMessage">{{ respMessage }}</div>
      <form action="#" @submit.prevent="bankTransfer">
        <!-- <b-row>
          <b-col md="6">
            <div class="form-group">
              <label class="tab-card__label" for="account_title">Account Title *</label>
              <input
                type="text"
                class="form-control tab-card__input"
                id="account_title"
                name="account_title"
                v-model="formData.account_title"
              />
            </div>
          </b-col>

          <b-col md="6">
            <div class="form-group">
              <label class="tab-card__label" for="account_num">Account Number *</label>
              <input
                type="text"
                class="form-control tab-card__input"
                id="account_num"
                name="account_num"
                v-model="formData.account_num"
              />
            </div>
          </b-col>
        </b-row>-->
        <!-- <b-col md="6">
            <div class="form-group">
              <label class="tab-card__label" for="sort_code">Sort Code *</label>
              <input
                type="text"
                class="form-control tab-card__input"
                id="sort_code"
                name="sort_code"
                v-model="formData.sort_code"
              />
            </div>
        </b-col>-->

        <b-row>
          <b-col md="6">
            <div class="form-group">
              <label class="tab-card__label" for="amount">Amount *</label>
              <input
                type="number"
                class="form-control tab-card__input"
                id="amount"
                name="amount"
                v-model="formData.amount"
              />
            </div>
          </b-col>

          <b-col md="6">
            <div class="form-group">
              <label class="tab-card__label" for="sort_code">Deposit Slip *</label>
              <input
                type="file"
                ref="deposit_slip"
                class="form-control tab-card__input"
                id="deposit_slip"
                name="deposit_slip"
                @change="attachDepostSlip"
              />
            </div>
          </b-col>
        </b-row>

        <b-row>
          <b-col md="12">
            <div class="form-group">
              <button class="btn btn-secondary btn-block tab-card__btn mt-4">Submit</button>
            </div>
          </b-col>
        </b-row>
      </form>
    </div>
  </b-tab>
</template>

<script>
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
import "vue-form-generator/dist/vfg.css";

export default {
  name: "BankTransfer",
  components: {
    Loading,
  },
  data() {
    return {
      isLoading: false,
      fullPage: true,
      respMessage: "",
      formData: {
        account_title: "",
        account_num: "",
        sort_code: "",
        amount: "",
        deposit_slip: "",
      },
    };
  },
  methods: {
    attachDepostSlip(event) {
      var files = event.target.files || event.dataTransfer.files;
      if (!files.length) return;
      this.formData.deposit_slip = files[0];
    },

    bankTransfer() {
      this.isLoading = true;
      let errors = false;
      const profileComplete = localStorage.getItem("isProfileComplete");
      let loggedin = JSON.parse(localStorage.getItem("user"));

      if (profileComplete && profileComplete === "false") {
        errors = true;
        this.$toasted.show("Please Complete your profile to order!!!", {
          theme: "toasted-primary",
          icon: "fa-exclamation-triangle",
          position: "top-right",
          duration: 3500,
        });
      }

      if (!errors) {
        // set new form data
        var formData = new FormData();
        for (var property in this.formData) {
          formData.append(property, this.formData[property]);
        }
        formData.append("etype", "bankTransfer");
        formData.append("customer_id", loggedin.user.id);

        axios
          .post("/customer/bank-transfer", formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then(({ data }) => {
            this.respMessage = data.message;
            // form reset
            for (var property in this.formData) {
              this.formData[property] = "";
            }
            this.$refs.deposit_slip.value = null;
            this.isLoading = false;
            setTimeout(() => {
              this.respMessage = "";
            }, 2000);
          })
          .catch((err) => {
            this.isLoading = false;
            this.respMessage = err.response.data.message;
            let errors = err.response.data.errors;
            for (var property in errors) {
              this.$toasted.show(errors[property][0], {
                theme: "toasted-primary",
                icon: "fa-exclamation-triangle",
                position: "top-right",
                duration: 3000,
              });
            }
            setTimeout(() => {
              this.respMessage = "";
            }, 2000);
          });
      } else {
        this.isLoading = false;
      }
    },
  },
};
</script>

<style>
</style>