<template>
  <section class="choose-us-section section-padding">
    <b-container fluid>
      <b-row>
        <b-col cols>
          <h4 class="top-heading">Our VALUES</h4>
          <h2 class="main-heading text-uppercase">
            <span class="main-heading__secondary">Why Choose</span> Khadamateek
          </h2>
        </b-col>
      </b-row>

      <b-row>
        <b-col sm="2" v-for="(item, i) in benefits" :key="i">
          <div class="choose-box">
            <div class="choose-box__icon">
              <img
                :src="require(`../assets/icons/${item.icon}`)"
                :alt="item.icon"
                class="img-fluid choose-box__icon"
              />
            </div>
            <h2 class="choose-box__title" v-text="item.name"></h2>
            <p class="choose-box__description" v-text="item.description"></p>
          </div>
        </b-col>
      </b-row>
    </b-container>
  </section>
</template>

<script>
export default {
  name: "ChooseUs",
  data() {
    return {
      benefits: [
        {
          icon: "save-time.png",
          name: "Time Saving",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua."
        },
        {
          icon: "save-time.png",
          name: "Trust Worthly",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua."
        },
        {
          icon: "save-time.png",
          name: "Done Guarantee",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua."
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
.choose-us-section {
  background-image: url("../assets/Home/choose-us.png");
  background-repeat: no-repeat;
  background-size: 100% 100%;
  background-position: top;
  min-height: 70rem;
  padding: 12rem 20px;
  padding-left: 6rem;

  & .top-heading {
    color: #ce9718;
  }

  & .main-heading {
    &__secondary {
      color: #fff;
    }
  }

  & .choose-box {
    margin-top: 8rem;

    & * {
      margin-bottom: 12px;
    }

    &__icon img {
      max-width: 70px;
    }

    &__title {
      font-weight: 600;
      font-size: 22px;
      color: #ffffff;
    }

    &__description {
      font-size: 12px;
      color: #ffffff;
    }
  }
}
</style>