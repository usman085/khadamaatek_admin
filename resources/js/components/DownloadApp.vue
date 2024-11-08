<template>
  <section class="download-section">
    <b-container>
      <b-row>
        <b-col md="6">
          <h5 class="download-section__top-heading">Our Application</h5>
          <h2 class="download-section__heading main-heading">
            Download app for Exciting
            <span class="main-heading__secondary">Services</span>
          </h2>

          <p
            class="download-section__text"
          >Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>

          <b-row class="mt-5">
            <b-col md="6">
              <a href="http://google.com" target="_blank" rel="noopener noreferrer">
                <img
                  src="../assets/Home/google-play-badg-2.png"
                  alt="download app"
                  class="img-fluid download-section__img"
                />
              </a>
            </b-col>
            <b-col md="6">
              <a href="http://google.com" target="_blank" rel="noopener noreferrer">
                <img
                  src="../assets/Home/appstore.png"
                  alt="download app"
                  class="img-fluid download-section__img"
                />
              </a>
            </b-col>
          </b-row>
        </b-col>
        <b-col md="6" class="text-center">
          <img
            src="../assets/Home/mobile-group.png"
            alt="download app"
            class="img-fluid download-section__img"
          />
        </b-col>
      </b-row>
    </b-container>
  </section>
</template>

<script>
export default {};
</script>

<style lang="scss">
.download-section {
  padding: 50px 15px;

  &__top-heading {
    font-size: 24px;
    letter-spacing: 0.23px;
    color: #004120;
    text-transform: uppercase;
  }

  &__text {
    font-size: 18px;
    color: #0000004d;
  }
}
</style>