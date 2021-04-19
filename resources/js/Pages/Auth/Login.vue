<template>
  <Layout>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-6 d-none d-lg-block py-auto"></div>
          <div class="col-lg-6">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">
                  LOGIN
                </h1>
              </div>

              <b-form @submit.prevent="onSubmit" v-if="show">
                <b-form-group
                  id="input-group-1"
                  label-for="input-1"
                  :invalid-feedback="
                    $page.errors.email ? $page.errors.email[0] : ''
                  "
                  :state="$page.errors.email ? false : null"
                >
                  <b-form-input
                    id="input-1"
                    v-model="form.email"
                    type="email"
                    name="email"
                    placeholder="Enter email"
                    :state="$page.errors.email ? false : null"
                  ></b-form-input>
                </b-form-group>

                <b-form-group
                  id="input-group-2"
                  label-for="input-2"
                  :invalid-feedback="
                    $page.errors.password ? $page.errors.password[0] : ''
                  "
                  :state="$page.errors.password ? false : null"
                >
                  <b-form-input
                    id="input-2"
                    type="password"
                    name="password"
                    v-model="form.password"
                    placeholder="Password"
                    :state="$page.errors.password ? false : null"
                  ></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-4">
                  <b-form-checkbox value="true" v-model="form.remember"
                    >Remember Me</b-form-checkbox
                  >
                </b-form-group>

                <b-button class="btn-block" type="submit" variant="primary"
                  >Submit</b-button
                >

                <hr />
                <a href="index.html" class="btn btn-user btn-block">
                  <i class="fab fa-google fa-fw"></i> Login with Google
                </a>
                <a href="index.html" class="btn btn-user btn-block">
                  <i class="fab fa-facebook-f fa-fw"></i>
                  Login with Facebook
                </a>
              </b-form>

              <hr />
              <div class="text-center">
                <a class="small" href="forgot-password.html"
                  >Forgot Password?</a
                >
              </div>
              <div class="text-center">
                <a class="small" href="register.html">Create an Account!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
import Layout from "@/Shared/LoginLayout"; //import layouts

export default {
  metaInfo: { title: "Beranda" },
  data() {
    return {
      form: {
        email: "",
        password: "",
        remember: "",
      },
      show: true,
    };
  },
  computed: {
    state() {
      return this.form.email.length >= 4 ? true : false;
    },
  },
  components: {
    Layout,
  },
  props: ["meta"],
  methods: {
    onSubmit() {
      this.$inertia.post("/login", this.form);
    },
    onReset(e) {
      e.preventDefault();
    },
  },
};
</script>
