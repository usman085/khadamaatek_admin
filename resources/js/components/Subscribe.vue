<template>
  <section class="subscribe-section">
    <b-container>
      <b-row>
        <b-col md="6">
          <h2 class="subscribe-section__title">Get notified about new amazing Services</h2>
        </b-col>
        <b-col md="5" class="align-self-center">
          <div class="subscribe-section__input-box">
            <input
              type="email"
              required
              class="form-control subscribe-section__input"
              placeholder="Email here"
            />
            <button class="btn btn-secondary subscribe-section__btn">Send</button>
          </div>
        </b-col>
      </b-row>
    </b-container>
  </section>
</template>

<script>
export default {};
</script>

<style lang="scss">
.subscribe-section {
  background: #ce9718;
  color: #fff;
  padding: 50px 15px;

  &__title {
    font: 500 34px/46px Poppins;
    color: #ffffff;
    text-transform: capitalize;
  }

  &__input-box {
    position: relative;
  }

  &__input {
    background: #ffffff;
    font: 400 14px/26px Poppins;
    color: #7c7c7c;
    border-radius: 40px;
    padding: 23px 15px;
    width: 100%;
  }

  &__btn {
    background: #004120 0% 0% no-repeat padding-box;
    border-radius: 40px;
    position: absolute;
    top: 5%;
    right: 1.5%;
    padding: 10px 4rem;
  }
}
</style>