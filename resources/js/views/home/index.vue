<template>
  <main class="home app-page">
    <main-header></main-header>

    <!-- Section 1 -->
    <section class="home-service-section">
      <b-container>
        <b-row class="mb-4">
          <b-col md="8">
            <h4 class="top-heading">Our Services</h4>
            <h1 class="main-heading text-uppercase">
              What we Can do For
              <span class="main-heading__secondary">You</span>
            </h1>
          </b-col>
          <b-col md="4" class="text-right align-self-center">
            <router-link :to="{name: 'Services'}" class="view-all-link">
              View all
              <b-icon-list-ul></b-icon-list-ul>
            </router-link>
          </b-col>
        </b-row>

        <b-row>
          <b-col md="3" sm="6" v-for="(service, index) in services" :key="index">
            <div class="service-box">
              <div class="service-box__head">
                <h2 class="service-box__name" v-text="service.name"></h2>
                <h2 class="service-box__count" v-text="(index + 1)"></h2>
              </div>

              <p class="service-box__description" v-text="service.description"></p>
            </div>
          </b-col>
        </b-row>
      </b-container>

      <b-container style="margin-top: 8rem">
        <b-row class="mb-4">
          <b-col md="12">
            <h1 class="main-heading text-uppercase">
              <span class="main-heading__secondary">Other</span>
              Services
            </h1>
          </b-col>
        </b-row>

        <b-row>
          <b-col md="3" sm="6" v-for="(service, index) in other_services" :key="index">
            <div class="service-box other">
              <div class="service-box__head">
                <h2 class="service-box__name" v-text="service.name"></h2>
                <h2 class="service-box__count" v-text="(index + 1)"></h2>
              </div>

              <p class="service-box__description" v-text="service.description"></p>
            </div>
          </b-col>
        </b-row>
      </b-container>
    </section>

    <!-- Section 2 -->
    <section class="process-section">
      <b-container>
        <b-row>
          <b-col cols="12" class="text-center">
            <h4 class="top-heading">OUR Process</h4>
            <h2 class="main-heading text-uppercase">How we WOrk</h2>
          </b-col>
        </b-row>

        <b-row>
          <b-col cols="12" class="text-center">
            <div class="process-box">
              <div class="process-col">
                <div class="process-col__icon">
                  <img src="../../assets/icons/request-icon.png" alt class="img-fluid" />
                </div>
                <h2 class="process-col__title">Request Send</h2>

                <p
                  class="process-col__description"
                >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
              </div>
              <div class="process-seprator"></div>

              <div class="process-col">
                <div class="process-col__icon">
                  <img src="../../assets/icons/Professional Contact.png" alt class="img-fluid" />
                </div>
                <h2 class="process-col__title">Professional Conatct</h2>

                <p
                  class="process-col__description"
                >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
              </div>
              <div class="process-seprator"></div>

              <div class="process-col">
                <div class="process-col__icon">
                  <img src="../../assets/icons/Payment-icon.png" alt class="img-fluid" />
                </div>
                <h2 class="process-col__title">Payment for Work Complete</h2>

                <p
                  class="process-col__description"
                >Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
              </div>
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
            <fieldset class="office-box">
              <legend class="office-box__name" v-text="office.name"></legend>
              <p class="office-box__description" v-text="office.description"></p>
            </fieldset>
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
import MainHeader from "../../components/layout/HomeHeader";
import CustomerReviews from "../../components/CustomerReviews";
import ChooseUs from "../../components/ChooseUs";
import DownloadApp from "../../components/DownloadApp";
import Subscribe from "../../components/Subscribe";
import MainFooter from "../../components/layout/Footer";
export default {
  name: "Home",
  components: {
    MainHeader,
    CustomerReviews,
    ChooseUs,
    DownloadApp,
    Subscribe,
    MainFooter
  },
  data() {
    return {
      services: [
        {
          name: "Different Iqama Services",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Passport Services",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Different License Services",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        },
        {
          name: "Registration Services",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,"
        }
      ],

      other_services: [
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
          name: "Internet Services",
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
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum."
        },
        {
          name: "Labour Office",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum."
        },
        {
          name: "Ministry of Commerce",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum."
        },
        {
          name: "Municipality",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum."
        },
        {
          name: "Water Telecom",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum."
        },
        {
          name: "Electric Services",
          description:
            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum."
        }
      ],
    };
  }
};
</script>

<style lang="scss" scoped>
.home-service-section {
  padding: 50px 15px;
  background-image: url("../../assets/Home/Vector-Object.png");
}

.process-section {
  padding: 50px 15px;
  background-image: url("../../assets/Home/process-bg.png");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;

  & .top-heading {
    margin-top: 5rem;
    color: #fff;
  }
}

.process-box {
  display: flex;
  justify-content: space-around;
  padding: 5rem 15rem;
  padding-right: 20rem;
}

.process-col {
  & * {
    margin-bottom: 1.2rem;
  }

  &__icon img.img-fluid {
    height: 60px;
  }

  &__title {
    font-size: 20px;
    font-weight: 600;
    color: #ffffff;
  }

  &__description {
    font-size: 14px;
    color: #ce9718;
  }
}

.process-seprator {
  min-width: 130px;
  border-top: 2px solid #ffffff;
  margin-top: 5rem;
}

.office-box {
  background: #fff;
  box-shadow: 0px 5px 25px #00000029;
  border: 3px solid #ce9718;
  padding: 10px 15px;
  margin-bottom: 3rem;

  &__name {
    width: inherit;
    padding: 0 10px;
    border-bottom: none;
    font-size: 20px;
    font-weight: 600;
    color: #004120;
  }

  &__description {
    font-size: 14px;
    color: #0000004d;
  }

  &__separator {
    display: block;
    margin-top: 3rem;
  }
}
</style>