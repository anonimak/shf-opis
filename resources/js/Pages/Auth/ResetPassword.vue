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
                <h1 class="h3 text-gray-900">
                  <strong>Reset Password</strong>
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

                <b-form-group
                  id="input-group-2"
                  label-for="input-2"
                  :invalid-feedback="
                    $page.errors.password_confirmation
                      ? $page.errors.password_confirmation[0]
                      : ''
                  "
                  :state="$page.errors.password_confirmation ? false : null"
                >
                  <b-form-input
                    id="input-2"
                    type="password"
                    name="password_confirmation"
                    v-model="form.password_confirmation"
                    placeholder="Retype Password"
                    :state="$page.errors.password_confirmation ? false : null"
                  ></b-form-input>
                </b-form-group>

                <b-button class="btn-block" type="submit" variant="primary"
                  >Submit</b-button
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
        password_confirmation: "",
        token: "",
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
  props: ["meta", "flash", "__postUpdate", "token"],
  mounted() {
    this.form.token = this.token;
  },
  methods: {
    onSubmit() {
      this.$inertia.post(route(this.__postUpdate), this.form);
    },
    onReset(e) {
      e.preventDefault();
    },
  },
};
</script>
