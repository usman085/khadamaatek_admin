<template>
  <div class="position-relative">
    <main class="signin-container">
      <b-container>
        <b-row>
          <b-col cols="12" class="text-center">
            <router-link :to="{name: 'Home'}">
              <img
                src="../../assets/logo/green logo.png"
                alt
                class="img-fluid signin-container__logo"
              />
            </router-link>
          </b-col>
        </b-row>

        <b-row>
          <b-col xl="6" lg="8" md="10" class="ml-auto mr-auto">
            <signin-card></signin-card>
          </b-col>
        </b-row>
      </b-container>
    </main>
    <footer class="signin-container__footer">Copyright & Design by @Softech Visions</footer>
  </div>
</template>

<script>
import SigninCard from "../../components/users/SigninCard";

export default {
  name: "Signin",
  components: {
    SigninCard
  }
};
</script>

<style lang="scss">
@import url("https://rawgit.com/beyondplus/flags-dropdown-vue/master/css/flags.min.css");
@import url("https://rawgit.com/beyondplus/flags-dropdown-vue/master/css/custom.css");

.signin-container {
  background: #f8f8f8;
  min-height: 100vh;
  min-width: 100vw;

  & .main-heading {
    font-size: 24px;
    text-transform: uppercase;
  }

  &__logo {
    height: 90px;
    margin-top: 6rem;
    margin-bottom: 3rem;
  }

  &__input {
    padding: 1.8rem 1.4rem;
    height: calc(2.2rem + 0.75rem + 2px);
    text-align: left;
    font: 400 14px/35px Poppins;
    letter-spacing: 0px;
    color: #d1d3d6;
    opacity: 1;
  }

  &__card {
    background: #ffffff;
    box-shadow: 0px 3px 30px #00000029;
    border-radius: 20px;
    padding: 6rem 5rem;
    padding-top: 8rem;

    & label {
      font-size: 14px;
      color: #004120;
    }

    &-btn {
      background: #004120;
      font-size: 18px;
      color: #f9feff;
      margin-top: 1.8rem;
    }
  }

  &__footer {
    position: absolute;
    left: 0;
    bottom: 0;
    background: #004120;
    width: 100%;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-size: 16px;
    padding: 1rem;
    text-transform: capitalize;
  }
}

.flag-box {
  background-color: #f9f9f9 !important;
  border: 0 !important;
  display: flex !important;
  align-items: center !important;
  height: calc(2.8rem + 0.75rem + 2px);
}
</style>
