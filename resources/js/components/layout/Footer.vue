<template>
  <footer class="footer">
    <b-container>
      <b-row>
        <b-col md="3">
          <img src="../../assets/Home/footer-logo.png" alt="Logo" class="img-fluid footer__logo" />
        </b-col>
        <b-col md="6">
          <ul class="footer__menu">
            <li class="footer__menu-item">
              <router-link :to="{name: 'Home'}" class="footer__menu-link">Home</router-link>
            </li>
            <li class="footer__menu-item">
              <router-link :to="{name: 'Services'}" class="footer__menu-link">Services</router-link>
            </li>
            <li class="footer__menu-item">
              <router-link :to="{name: 'AboutUs'}" class="footer__menu-link">About US</router-link>
            </li>
            <!-- <li class="footer__menu-item">
              <router-link :to="{name: 'ContactUs'}" class="footer__menu-link">Contact Us</router-link>
            </li> -->
          </ul>
        </b-col>
        <b-col md="3">
          <div class="footer__social">
            <span class="footer__social-icon-box">
              <a href="#" target="_blank" class="footer__social-link" rel="noopener noreferrer">
                <i class="fab fa-facebook-f"></i>
              </a>
            </span>
            <span class="footer__social-icon-box">
              <a href="#" target="_blank" class="footer__social-link" rel="noopener noreferrer">
                <i class="fab fa-twitter"></i>
              </a>
            </span>
            <span class="footer__social-icon-box">
              <a href="#" target="_blank" class="footer__social-link" rel="noopener noreferrer">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </span>
          </div>
        </b-col>
      </b-row>

      <div class="footer__bottom text-center">
        <p class="footer__copyright">Copyright & Design by @Softech Visions</p>
      </div>
    </b-container>
  </footer>
</template>

<script>
export default {};
</script>

<style lang="scss">
.footer {
  padding-top: 5rem;
  background: #004120;
  min-height: 200px;
  color: #fff;

  &__menu {
    list-style: none;
    display: flex;
    justify-content: space-around;
    align-items: center;
    margin-bottom: 0;
    height: 100%;

    &-link {
      font: 500 1.6rem Poppins;
      color: #ffffff;
      &:hover {
        color: #ce9718;
      }
    }
  }

  &__social {
    display: flex;
    justify-content: center;
    align-items: center;

    &-icon-box {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 1px solid #9c9ca8;
      margin-right: 10px;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 1.5rem;
    }

    &-link {
      font: 500 1.6rem Poppins;
      color: #ffffff;
      &:hover {
        color: #ce9718;
      }
    }
  }

  &__bottom {
    border-top: 1px solid #ffffff;
    margin-top: 6rem;
    padding: 2rem;
  }

  &__copyright {
    text-align: center;
    font: 400 16px/22px Poppins;
    color: #ffffff;
    margin-bottom: 0;
    text-transform: capitalize;
  }
}
</style>