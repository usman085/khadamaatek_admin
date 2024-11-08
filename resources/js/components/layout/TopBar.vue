<template>
  <b-container fluid class="top-bar">
    <b-row>
      <b-col cols="12" md="6" offset-md="6" class="text-right">
        <p class="contact-detail">
          <i class="fas fa-mobile-alt contact-detail__icon"></i>
          340 - 123 - 4567
        </p>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {};
</script>

<style lang="scss">
.top-bar {
  & .contact-detail {
    min-height: 73px;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    background: white;
    position: relative;
    z-index: 1;
    margin-bottom: -6px;
    margin-bottom: -1rem;
    margin-right: -15px;
    padding-right: 78px;
    font: 500 22px/39px Poppins;
    letter-spacing: -0.5px;
    color: #cd9e33;

    &__icon {
      margin-right: 10px;
    }
  }
}
</style>