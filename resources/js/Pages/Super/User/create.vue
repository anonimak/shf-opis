<template>
  <layout :userinfo="userinfo">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Create New User</h1>
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
                  label="User Name:"
                  label-for="input-title"
                  :invalid-feedback="errors.name ? errors.name[0] : ''"
                  :state="errors.name ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="text"
                    name="user"
                    v-model="form.name"
                    placeholder="User Name"
                    :state="errors.name ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Email:"
                  label-for="input-title"
                  :invalid-feedback="errors.email ? errors.email[0] : ''"
                  :state="errors.email ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="email"
                    name="email"
                    v-model="form.email"
                    placeholder="Email"
                    :state="errors.email ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Password:"
                  label-for="input-title"
                  :invalid-feedback="errors.password ? errors.password[0] : ''"
                  :state="errors.password ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="password"
                    name="password"
                    v-model="form.password"
                    placeholder="Password"
                    :state="errors.password ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Role:"
                  label-for="input-title"
                  :invalid-feedback="errors.role ? errors.role[0] : ''"
                  :state="errors.role ? false : null"
                >
                  <v-select
                    label="name"
                    placeholder="-- Select Role --"
                    :options="dataRoles"
                    v-model="form.role"
                    :reduce="(role) => role.id"
                    :required="!form.role"
                  ></v-select>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="NIK Employee:"
                  label-for="input-title"
                  :invalid-feedback="errors.employee ? errors.employee[0] : ''"
                  :state="errors.employee ? false : null"
                >
                  <v-select
                    placeholder="-- Select NIK --"
                    label="nik"
                    :options="dataEmployees"
                    v-model="form.employee"
                    :reduce="(employee) => employee.id"
                    :required="!form.employee"
                  >
                  </v-select>
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
import Layout from "@/Shared/SuperLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";

export default {
  props: [
    "_token",
    "userinfo",
    "breadcrumbItems",
    "dataRoles",
    "dataEmployees",
    "errors",
    "__store",
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
        name: "",
        email: "",
        password: "",
        role: null,
        employee: null,
      },
    };
  },
  methods: {
    submit() {
      if (!this.submitState) {
        this.submitState = true;
        this.$inertia
          .post(route(this.__store), this.form)
          .then(() => (this.submitState = false));
      }
    },
  },
};
</script>