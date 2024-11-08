<template>
  <main class="app-page">
    <main-header heading="Khadamateek" heading_bold="SERVICES"></main-header>

    <!-- Section 1 -->
    <section class="service-section">
      <b-container>
        <b-row class="mb-4">
          <b-col md="12">
            <h4 class="top-heading">Our Services</h4>
            <h1 class="main-heading text-uppercase">
              What we Can do For
              <span class="main-heading__secondary">You</span>
            </h1>
          </b-col>
        </b-row>

        <b-row>
          <b-col md="3" sm="6" v-for="(service, index) in services" :key="index">
            <div class="service-box">
              <div class="service-box__head">
                <h2 class="service-box__name" v-text="service.name"></h2>
                <h2 class="service-box__count visible-none" v-text="(index + 1)"></h2>
              </div>

              <p class="service-box__description" v-text="service.description"></p>
            </div>
          </b-col>
        </b-row>
      </b-container>
    </section>

    <!-- Section 3 -->
    <section class="offices-section section-padding">
      <b-container>
        <b-row>
          <b-col cols="12">
            <h4 class="top-heading">Our Offices</h4>
            <h2 class="main-heading">
              Our Under Government
              <span class="main-heading__secondary">Offices</span>
            </h2>
          </b-col>
        </b-row>

        <b-row class="mt-5">
          <b-col md="4" sm="6" v-for="(office, i) in offices" :key="i">
            <span class="office-box__separator" v-if="i > 2"></span>
            <div class="office-box">
              <h2 class="office-box__name" v-text="office.name"></h2>
              <p class="office-box__description" v-text="office.description"></p>
              <a :href="office.link" class="office-box__link" v-text="office.link_text"></a>
            </div>
          </b-col>
        </b-row>
      </b-container>
    </section>

    <download-app></download-app>
    <customer-reviews></customer-reviews>
    <subscribe></subscribe>
    <main-footer></main-footer>
  </main>
</template>

<script>
import MainHeader from "../../components/layout/Header";
import CustomerReviews from "../../components/CustomerReviews";
import DownloadApp from "../../components/DownloadApp";
import Subscribe from "../../components/Subscribe";
import MainFooter from "../../components/layout/Footer";
export default {
  name: "Home",
  components: {
    MainHeader,
    CustomerReviews,
    DownloadApp,
    Subscribe,
    MainFooter
  },
  data() {
    return {
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
.service-section {
  padding: 50px 15px;
}

.offices-section {
  background-color: #004120;

  & .top-heading {
    color: #fff;
  }

  & .main-heading {
    &__secondary {
      color: #fff;
    }
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
    margin: -1px -1px;
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