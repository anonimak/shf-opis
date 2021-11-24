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

                <b-button class="btn-block" type="submit" variant="primary"
                  >Send Password Reset Link</b-button
                >
                <inertia-link :href="route(__login)" class="float-right"
                  >Back to login</inertia-link
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
  props: ["flash", "__postEmail", "__login"],
  methods: {
    onSubmit() {
      this.$inertia.post(route(this.__postEmail), this.form);
    },
  },
};
</script>
