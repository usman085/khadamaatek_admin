<template>
  <div>
    <div class="signin-container__card">
      <h1 class="main-heading text-uppercase">
        SIGNIN WITH
        <span class="main-heading__secondary">khADAMATEEK</span>
      </h1>
      <form action="#" @submit.prevent="handleLogin">
        <div class="form-group">
          <label for>Mobile Number</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <flags-dropdown v-on:change="optionSelected" :selected="country_iso"></flags-dropdown>
            </div>
            <input
              type="text"
              class="form-control signin-container__input"
              placeholder="Enter your Phone number"
              v-model="formData.phone_no"
              required
            />
          </div>

          <div class="alert alert-danger" role="alert" v-if="error">{{ error }}</div>
          <button
            class="btn btn-secondary signin-container__card-btn btn-block"
            type="submit"
          >Sign in</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import FlagsDropdown from "flags-dropdown-vue";

export default {
  name: "SigninCard",
  components: {
    FlagsDropdown,
  },
  data() {
    return {
      country_iso: "sa",
      formData: {
        phone_code: "966",
        phone_no: "",
      },
      error: "",
      secrets: [],
    };
  },
  methods: {
    optionSelected: function (data) {
      //console.log(data.id)
      this.formData.phone_code = data.phonecode;
      this.country_iso = data.iso;
    },

    handleLogin: function () {
      axios
        .get(window.axios.defaults.backEndBaseURL + "/sanctum/csrf-cookie")
        .then((reponse) => {
          // console.log(reponse);jhgh
          this.$store
            .dispatch("login", this.formData)
            .then(() => {
              this.$router.push({ name: "Home" });
            })
            .catch((err) => {
              this.error = err.response.data.errors.phone_no[0];
              setTimeout(() => {
                this.error = "";
              }, 2000);
              console.log(err.response.data.errors);
            });
        });
    },
  },
};
</script>

<style>
</style>
