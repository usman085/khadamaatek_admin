<template>
  <section class="reviews-section">
    <b-container>
      <b-row>
        <b-col md="8">
          <h5 class="top-heading">Our Reviews</h5>
          <h1 class="main-heading text-uppercase">
            WE trusT our customers and they
            <span class="main-heading__secondary">trust us too</span>
          </h1>
        </b-col>
      </b-row>

      <b-row>
        <b-col md="10">
          <vueper-slides
            class="no-shadow"
            :arrows="false"
            :visible-slides="2"
            slide-multiple
            :gap="3"
            :slide-ratio="1 / 4"
            :dragging-distance="200"
            :breakpoints="{ 800: { visibleSlides: 2, slideMultiple: 2 } }"
          >
            <vueper-slide v-for="(review, i) in reviews" :key="i">
              <template v-slot:content>
                <div class="vueperslide__content-wrapper">
                  <div class="customer-review">
                    <div class="customer-review__head">
                      <img
                        :src="require(`../assets/Home/${review.avatar}`)"
                        :alt="review.avatar"
                        class="img-fluid customer-review__avatar"
                      />

                      <div class="customer-review__info">
                        <h3 class="customer-review__name" v-text="review.name">Ahmad Fraz</h3>
                        <h5
                          class="customer-review__designation"
                          v-text="review.designation"
                        >Graphic Designer</h5>
                      </div>
                    </div>

                    <p class="customer-review__text" v-text="review.content"></p>
                  </div>
                </div>
              </template>
            </vueper-slide>
          </vueper-slides>
        </b-col>
      </b-row>
    </b-container>
  </section>
</template>

<script>
import { VueperSlides, VueperSlide } from "vueperslides";
import "vueperslides/dist/vueperslides.css";

export default {
  name: "CustomerReviews",
  components: { VueperSlides, VueperSlide },
  data() {
    return {
      reviews: [
        {
          name: "Ahmad Fraz",
          designation: "Manager",
          content:
            "I'm very glad I had the opportunity to visit this hotel. The stuff is very friendly and I will definetly visit the hotel again next year.",
          avatar: "review-boy.png"
        },
        {
          name: "Aliza Khan",
          designation: "Manager",
          content:
            "I'm very glad I had the opportunity to visit this hotel. The stuff is very friendly and I will definetly visit the hotel again next year.",
          avatar: "review-girl.png"
        },
        {
          name: "Ahmad Fraz",
          designation: "Manager",
          content:
            "I'm very glad I had the opportunity to visit this hotel. The stuff is very friendly and I will definetly visit the hotel again next year.",
          avatar: "review-boy.png"
        },
        {
          name: "Aliza Khan",
          designation: "Manager",
          content:
            "I'm very glad I had the opportunity to visit this hotel. The stuff is very friendly and I will definetly visit the hotel again next year.",
          avatar: "review-girl.png"
        },
        {
          name: "Ahmad Fraz",
          designation: "Manager",
          content:
            "I'm very glad I had the opportunity to visit this hotel. The stuff is very friendly and I will definetly visit the hotel again next year.",
          avatar: "review-boy.png"
        },
        {
          name: "Aliza Khan",
          designation: "Manager",
          content:
            "I'm very glad I had the opportunity to visit this hotel. The stuff is very friendly and I will definetly visit the hotel again next year.",
          avatar: "review-girl.png"
        }
      ]
    };
  }
};
</script>

<style lang="scss">
.reviews-section {
  padding: 50px 15px;
  background-color: #f8f8f8;
  background-image: url("../assets/Home/Icon-quote.png");
  background-repeat: no-repeat;
  background-position: 95% 10rem;
}

.vueperslide__content-wrapper {
  text-align: left !important;
}

.vueperslides__bullets {
  justify-content: flex-start !important;
}

.customer-review {
  &__head {
    display: flex;
    align-items: center;
  }

  &__avatar {
    height: 80px;
    width: 80px;
    border-radius: 50%;
    margin-right: 15px;
  }

  &__name {
    font-size: 23px;
    font-weight: 600;
    color: #3f475d;
  }

  &__designation {
    font-size: 14px;
    font-weight: 600;
    color: #000000;
    opacity: 0.5;
  }

  &__text {
    margin-top: 15px;
    font-size: 14px;
    font-weight: 500;
    color: #000000;
  }
}
</style>