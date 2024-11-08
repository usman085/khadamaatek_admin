<template>
  <b-tab title="Change PhoneNo">
    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="fullPage"></loading>

    <div class="tab-card">
      <h2 class="tab-card__title">Change Phone Number</h2>
      <p class="tab-card__description mb-5">Send Request to admin to change your phone number.</p>

      <form action="#" class="mt-5" @submit.prevent="sendRequest">
        <b-row>
          <b-col md="6">
            <div class="form-group">
              <label for="first_name">Old Number</label>
              <input
                type="text"
                class="form-control tab-card__input"
                v-model="old_number"
                :disabled="true"
                required
              />
            </div>
          </b-col>
          <b-col md="6">
            <div class="form-group">
              <label for="first_name">New Number*</label>
              <input
                type="text"
                class="form-control tab-card__input"
                v-model="formData.new_number"
                placeholder="New Phone Number"
                required
              />
            </div>
          </b-col>
        </b-row>

        <b-row>
          <b-col md="12">
            <div class="form-group">
              <label for="first_name">Reason*</label>
              <input
                type="text"
                class="form-control tab-card__input"
                v-model="formData.reason"
                placeholder="Reason to change phone number"
                required
              />
            </div>
          </b-col>
        </b-row>

        <b-row>
          <b-col md="12">
            <div class="form-group">
              <button
                class="btn btn-secondary btn-block tab-card__btn mt-4"
                type="submit"
              >Send Request</button>
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
  name: "ChangeNumber",
  components: {
    Loading,
  },
  data() {
    return {
      isLoading: false,
      fullPage: true,
      userData: "",
      old_number: "",

      formData: {
        new_number: "",
        reason: "",
      },
    };
  },
  async created() {
    const loggedIn = JSON.parse(localStorage.getItem("user"));
    if (loggedIn && loggedIn.token && loggedIn.user) {
      this.old_number = loggedIn.user.phone_no;
    } else {
      alert("user not logged in!");
    }
  },
  methods: {
    sendRequest: function () {
      this.isLoading = true;
      const loggedIn = JSON.parse(localStorage.getItem("user"));

      this.formData.user_id = loggedIn.user.id;
      this.formData.user_type = "customer";
      axios
        .post("/admin/request-change-number", this.formData)
        .then((response) => {
          console.log(response.data.message);
          alert(response.data.message);
          this.formData.new_number = "";
          this.formData.reason = "";
          this.isLoading = false;
        })
        .catch((err) => {
          alert(err.response.data.message);
          this.isLoading = false;
        });
    },
  },
};
</script>

<style>
</style>