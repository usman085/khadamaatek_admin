<template>
  <div>
    <top-bar></top-bar>
    <menu-bar logoType="green logo.png"></menu-bar>

    <header class="main-header" v-if="type !== 'user'">
      <b-container fluid>
        <b-row>
          <b-col xl="4" lg="5" md="6" cols="12">
            <h1 class="main-header__title">
              {{ heading }}
              <span class="main-header__title-bold">{{ heading_bold }}</span>
            </h1>

            <p
              class="main-header__description"
              v-if="type== 'about'"
            >Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

            <!-- <div class="main-header__input-box" v-else>
              <input
                type="text"
                class="form-control main-header__input"
                placeholder="Search Services"
              />
              <button class="btn btn-secondary main-header__btn">Search</button>
            </div> -->
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
  name: "Header",
  props: {
    heading: {
      type: String,
      default: "Khadamateek"
    },
    heading_bold: {
      type: String,
      default: "SERVICES"
    },
    type: {
      type: String,
      default: "default"
    }
  },
  components: {
    TopBar,
    MenuBar
  }
};
</script>

<style lang="scss" scoped>
.main-header {
  padding: 12rem 5rem;
  padding-left: 6rem;
  background-image: url("../../assets/Home/header.png");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;

  &__title {
    font-size: 6rem;
    color: #ce9718;
    margin-bottom: 5rem;

    &-bold {
      font-size: 8rem;
      font-weight: bold;
      color: #ffffff;
      border-bottom: 5px solid #ce9718;
    }
  }

  &__input-box {
    position: relative;
  }

  &__input {
    background: #ffffff;
    font: 400 14px/26px Poppins;
    color: #7c7c7c;
    border-radius: 10px;
    padding: 28px 15px;
  }

  &__btn {
    background: #ce9718;
    border-radius: 10px;
    position: absolute;
    top: 10%;
    right: 1.5%;
    padding: 10px 4rem;
    font-size: 18px;
    font-weight: 500;
    color: #004120;
  }

  &__description {
    font-weight: 300;
    font-size: 20px;
    color: #ffffff;
  }
}
</style>