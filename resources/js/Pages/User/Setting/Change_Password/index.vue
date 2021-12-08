<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Change Password</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <b-card no-body>
          <b-form id="form" @submit.prevent="submit">
            <b-card-body>
              <b-col col lg="3" md="auto">
                <b-form-group
                  id="input-group-title"
                  label="New Password:"
                  label-for="input-title"
                  :invalid-feedback="errors.password ? errors.password[0] : ''"
                  :state="errors.password ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="password"
                    name="password"
                    v-model="form.password"
                    placeholder="New Password"
                    :state="errors.password ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Confirm Password:"
                  label-for="input-title"
                  :invalid-feedback="
                    errors.password_confirmation
                      ? errors.password_confirmation[0]
                      : ''
                  "
                  :state="errors.password_confirmation ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="password"
                    name="password"
                    v-model="form.password_confirmation"
                    placeholder="Confirm Password"
                    :state="errors.password_confirmation ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
              </b-col>
              <b-row align-h="center">
                <b-button-group>
                  <b-button type="submit" variant="primary">Submit</b-button>
                  <b-button type="reset" variant="secondary">Reset</b-button>
                </b-button-group>
              </b-row>
            </b-card-body>
          </b-form>
        </b-card>
      </div>
    </div>
  </layout>
</template>
<script>
import Layout from "@/Shared/UserLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";

export default {
  props: [
    "_token",
    "userinfo",
    "notif",
    "breadcrumbItems",
    "errors",
    "__postUpdate",
  ],
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
  },
  data: () => {
    return {
      submitState: false,
      form: {
        password: "",
        password_confirmation: "",
      },
    };
  },
  methods: {
    submit() {
      if (!this.submitState) {
        this.submitState = true;
        this.$inertia
          .put(route(this.__postUpdate), this.form)
          .then(() => (this.submitState = false));
      }
    },
  },
};
</script>