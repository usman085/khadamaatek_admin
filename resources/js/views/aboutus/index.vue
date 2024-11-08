<template>
  <main class="app-page">
    <main-header heading="About" heading_bold="KHADAMATEEK" type="about"></main-header>

    <!-- Section 1 -->
    <section class="success-section">
      <b-container>
        <b-row class="mb-4">
          <b-col md="10" sm="12">
            <h1
              class="success-section__heading"
            >we completed 1200+ projects yearly successfully & counting</h1>
            <p
              class="success-section__text-content"
            >It is a long established fact that a reader will be distracted by the readable content</p>
            <p class="success-section__text-content">It is a long established fact</p>
          </b-col>
        </b-row>

        <b-row class="mt-5">
          <b-col md="3" sm="6" v-for="(item, index) in totals" :key="index">
            <div class="success-box">
              <div class="success-box__icon">
                <img
                  :src="require(`../../assets/icons/${item.photo}`)"
                  :alt="item.photo"
                  class="img-fluid success-box__img"
                />
              </div>

              <div class="success-box__info">
                <p class="success-box__total" v-text="item.total"></p>
                <p class="success-box__title" v-text="item.title"></p>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-container>
    </section>

    <!-- Section 2 -->
    <section class="mission-section section-padding">
      <b-container>
        <b-row>
          <b-col cols="12">
            <h4 class="top-heading">About Us</h4>
          </b-col>
        </b-row>

        <b-row>
          <b-col md="6">
            <h2 class="main-heading text-uppercase">
              Our
              <span class="main-heading__secondary">MiSSION</span>
            </h2>
            <p
              class="mission-section__text"
            >Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum</p>
            <p
              class="mission-section__text"
            >Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum</p>
          </b-col>
          <b-col md="6">
            <h2 class="main-heading text-uppercase">
              Our
              <span class="main-heading__secondary">VALUES</span>
            </h2>
            <p
              class="mission-section__text"
            >Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum</p>
            <p
              class="mission-section__text"
            >Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum</p>
          </b-col>
        </b-row>
      </b-container>
    </section>

    <choose-us></choose-us>
    <download-app></download-app>
    <customer-reviews></customer-reviews>
    <subscribe></subscribe>
    <main-footer></main-footer>
  </main>
</template>

<script>
import MainHeader from "../../components/layout/Header";
import CustomerReviews from "../../components/CustomerReviews";
import ChooseUs from "../../components/ChooseUs";
import DownloadApp from "../../components/DownloadApp";
import Subscribe from "../../components/Subscribe";
import MainFooter from "../../components/layout/Footer";
export default {
  name: "AboutUs",
  components: {
    MainHeader,
    ChooseUs,
    CustomerReviews,
    DownloadApp,
    Subscribe,
    MainFooter
  },
  data() {
    return {
      totals: [
        {
          photo: "check-circle.png",
          title: "Service Completed",
          total: "100+"
        },
        {
          photo: "check-assignment.png",
          title: "active Services",
          total: "100+"
        },
        {
          photo: "users.png",
          title: "client satisfied",
          total: "90+"
        },
        {
          photo: "users.png",
          title: "country available",
          total: "56+"
        }
      ],
      services: [
        {
          name: "Iqama Renew",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Issue New Iqama",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Profession Change in Iqama",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Sponser Change in Iqama",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Passport Renew",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Issue New Passport",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "New Commercial License",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Renew License",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Check Exam Results",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Driving License Renew",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "New Registration in College",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Vehicle Rgistration Renew",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Commercial Name Registration",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Commercial Logo Registration",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Government Services",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Bank Services",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Internat Services",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Software Services",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        }
      ],

      offices: [
        {
          name: "Passport Office",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.",
          link_text: "Get Service",
          link: "#"
        },
        {
          name: "Labour Office",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.",
          link_text: "Get Service",
          link: "#"
        },
        {
          name: "Ministry of Commerce",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.",
          link_text: "Get Service",
          link: "#"
        },
        {
          name: "Municipality",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.",
          link_text: "Get Service",
          link: "#"
        },
        {
          name: "Water Telecom",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.",
          link_text: "Get Service",
          link: "#"
        },
        {
          name: "Electric Services",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.",
          link_text: "Get Service",
          link: "#"
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
.success-section {
  padding: 8rem 15px;

  &__heading {
    font-size: 42px;
    line-height: 60px;
    font-weight: 500;
    color: #000000;
    text-transform: capitalize;
  }

  &__text-content {
    font-size: 16px;
    color: #241b1b;
    text-transform: capitalize;
    margin-bottom: 5px;
  }

  & .success-box {
    display: flex;
    justify-content: center;
    align-items: center;
    text-transform: capitalize;
    transition: all 0.3s;
    padding: 30px 1rem;

    &__icon {
      max-width: 70px;
      margin-right: 15px;

      & img {
        height: 50px;
      }
    }

    &__total {
      font-size: 22px;
      font-weight: 500;
      color: #004120;
      margin-bottom: 0;
    }

    &__title {
      font-weight: 500;
      font-size: 14px;
      margin-bottom: 0;
      color: #004120;
      text-transform: capitalize;
    }

    &:hover {
      background: #f9f9ff;
      box-shadow: 0px 50px 76px #0000000d;
      border-radius: 100px 8px 100px 8px;
    }
  }
}

.mission-section {
  background-color: #f8f8f8;
  margin-bottom: 5rem;
  padding: 8rem 15px;

  &__text {
    font-size: 16px;
    color: #707070;
  }
}

.office-box {
  background: #fff;
  padding: 0;
  box-shadow: 0px 5px 25px #00000029;
  border: 5px solid #ce9718;
  margin-bottom: 3rem;

  &__name {
    background: #ce9718;
    padding: 1rem 1.3rem;
    font-size: 20px;
    font-weight: 600;
    color: #004120;
    margin: 0 -1px;
  }

  &__description {
    font-size: 14px;
    padding: 1rem 1.3rem;
    color: #0000004d;
    margin-bottom: 0;
  }

  &__link {
    font-weight: 600;
    padding: 1rem 1.3rem;
    font-size: 18px;
    color: #004120;
    margin-bottom: 0;
    display: block;
  }

  &__separator {
    display: block;
    margin-top: 3rem;
  }
}

.choose-us-section {
  background-image: url("../../assets/Home/choose-us.png");
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