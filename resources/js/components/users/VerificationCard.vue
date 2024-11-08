<template>
  <div>
    <div class="signin-container__card text-center">
      <h1 class="main-heading text-uppercase">
        VERIFICATION WITH
        <span class="main-heading__secondary">khADAMATEEK</span>
      </h1>
      <p
        class="signin-container__text-content"
      >we sent you a four digit code to your phone number +{{phoneNumber}}</p>

      <form action="#" @submit.prevent="verify">
        <div class="form-group">
          <div class="verify-input-group mb-3">
            <input
              type="text"
              class="form-control verify-input-group__input"
              v-model="code_obj.verify_code1"
              maxlength="1"
              required
            />
            <input
              type="text"
              class="form-control verify-input-group__input"
              v-model="code_obj.verify_code2"
              maxlength="1"
              required
            />
            <input
              type="text"
              class="form-control verify-input-group__input"
              v-model="code_obj.verify_code3"
              maxlength="1"
              required
            />
            <input
              type="text"
              class="form-control verify-input-group__input"
              v-model="code_obj.verify_code4"
              maxlength="1"
              required
            />
          </div>
        </div>

        <button class="btn btn-secondary signin-container__card-btn btn-block" type="submit">Verify</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "VerificationCard",
  components: {},
  data() {
    return {
      code_obj: {
        verify_code1: "",
        verify_code2: "",
        verify_code3: "",
        verify_code4: "",
      },

      formData: {
        verify_code: "",
      },
      error: "",
      phoneNumber:'',
    };
  },
  methods: {
    verify: function () {
      this.formData.verify_code = Object.values(this.code_obj).join("");

      this.$store
        .dispatch("verify", this.formData)
        .then(() => {
          this.$router.push({ name: "Signin" });
        })
        .catch((err) => {
          console.log(err.response.data.errors);
          this.$toasted.show(err.response.data.message, {
            theme: "toasted-primary",
            icon: "fa-exclamation-triangle",
            position: "top-right",
            duration: 3000,
          });
        });
    },
  },
    created() {
        const loggedIn = JSON.parse(localStorage.getItem("user"));
        this.phoneNumber = loggedIn.user.phone_no ;
    },
};
</script>

<style lang="scss">
.verify-input-group {
  display: flex;
  justify-content: center;
  align-items: center;

  &__input {
    padding: 1.8rem 1.4rem;
    height: calc(2.2rem + 0.75rem + 2px);
    text-align: left;
    font: 400 14px/35px Poppins;
    letter-spacing: 0px;
    color: #d1d3d6;
    margin-right: 15px;
    max-width: 50px;
    text-align: center;
  }
}
</style>