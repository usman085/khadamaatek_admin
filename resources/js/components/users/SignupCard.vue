<template>
  <div>
    <div class="signin-container__card">
      <h1 class="main-heading text-uppercase">
        Signup WITH
        <span class="main-heading__secondary">khADAMATEEK</span>
      </h1>
      <form action="#" @submit.prevent="handleRegister">
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
            />
          </div>

          <button
            class="btn btn-secondary signin-container__card-btn btn-block"
            type="submit"
          >Signup</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import FlagsDropdown from "flags-dropdown-vue";

export default {
  name: "SignupCard",
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

    handleRegister: function () {
      axios
        .get(window.axios.defaults.backEndBaseURL + "/sanctum/csrf-cookie")
        .then((reponse) => {
          this.$store
            .dispatch("register", this.formData)
            .then(() => {
              this.$router.push({ name: "Verify" });
            })
            .catch((err) => {
              console.log(err.response.data.errors);
              this.$toasted.show(err.response.data.message, {
                theme: "toasted-primary",
                icon: "fa-exclamation-triangle",
                position: "top-right",
                duration: 3500,
              });
            });
        });
    },
  },
};
</script>

<style>
</style>