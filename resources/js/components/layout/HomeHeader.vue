<template>
  <div>
    <header class="main-header">
      <top-bar></top-bar>
      <menu-bar></menu-bar>

      <b-container fluid>
        <b-row>
          <b-col xl="4" lg="5" md="6" cols="12">
            <h1 class="main-header__title">
              WE
              <span class="main-header__title-bold">BUILT</span>
            </h1>
            <h1 class="main-header__title">
              <span class="main-header__title-light">THE</span>
              <span class="main-header__title-light-white">TRUST</span>
            </h1>

            <p
              class="main-header__desc"
            >Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

            <b-button variant="outline-primary" class="main-header__btn">Our Services</b-button>
          </b-col>
        </b-row>
      </b-container>
    </header>
  </div>
</template>

<script>
import TopBar from "./TopBar";
import MenuBar from "./MenuBar";
export default {
  components: {
    TopBar,
    MenuBar
  }
};
</script>

<style lang="scss" scoped>
.main-header {
  padding-left: 6rem;
  min-height: 70rem;
  background-image: url("../../assets/Home/home-header.png");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;

  &__title {
    color: #ffffff;
    font: 400 8rem Poppins;
    margin-bottom: 0;

    &-bold {
      font-weight: Bold;
      color: #ce9718;
    }
    &-light {
      font-weight: 300;
      color: #ce9718;

      &-white {
        font-weight: bold;
        border-bottom: 5px solid #ce9718;
        color: #ffffff;
        position: relative;
        top: -34px;
      }
    }
  }

  &__desc {
    font: 300 25px/35px Poppins;
    color: #ffffff;
  }

  &__btn {
    padding: 7px 4rem;
    border: 2px solid #ce9718;
    font: 400 30px/46px Poppins;
    letter-spacing: 0.23px;
    color: #ce9718;
  }
}
</style>