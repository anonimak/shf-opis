<template>
  <Layout>
    <flash-msg />
    <div class="card o-hidden border-0 shadow-lg">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h3 text-gray-900"><strong>LOGIN</strong></h1>
                <h4 class="mb-4">E-Memo SHF</h4>
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
                  >Login</b-button
                >
                <inertia-link
                  :href="route(__forgetPassword)"
                  class="float-right"
                  >forget password</inertia-link
                >
              </b-form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
import Layout from "@/Shared/LoginLayout"; //import layouts
import FlashMsg from "@/components/Alert";

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
    FlashMsg,
  },
  props: ["meta", "flash", "__forgetPassword"],
  mounted() {
    // check remember exist
    if (this.$ls.get("email")) {
      this.form.email = this.$ls.get("email");
    }
  },
  methods: {
    onSubmit() {
      if (this.form.remember) {
        this.$ls.set("email", this.form.email);
      }
      this.$inertia.post("/login", this.form).then(() => {
        this.form.password = "";
      });
    },
    onReset(e) {
      e.preventDefault();
    },
  },
};
</script>
