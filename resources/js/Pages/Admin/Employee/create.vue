<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Create New Employee</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <b-card no-body>
          <b-form id="form" @submit.prevent="submit">
            <b-card-body>
              <b-col col lg="6" md="auto">
                <b-form-group
                  id="input-group-title"
                  label="Employee Name:"
                  label-for="input-title"
                  :invalid-feedback="
                    errors.firstname ? errors.firstname[0] : ''
                  "
                  :state="errors.firstname ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="text"
                    name="firstname"
                    v-model="form.firstname"
                    placeholder="First Name"
                    :state="errors.firstname ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Employee Name:"
                  label-for="input-title"
                  :invalid-feedback="errors.lastname ? errors.lastname[0] : ''"
                  :state="errors.lastname ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="text"
                    name="lastname"
                    v-model="form.lastname"
                    placeholder="Last Name"
                    :state="errors.lastname ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Title:"
                  label-for="input-title"
                  :invalid-feedback="errors.title ? errors.title[0] : ''"
                  :state="errors.title ? false : null"
                >
                  <v-select
                    label="title_name"
                    placeholder="-- Select Title --"
                    :options="dataTitle"
                    v-model="form.title"
                    :reduce="(title) => title.id"
                    :required="!form.title"
                  ></v-select>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Gender:"
                  label-for="input-title"
                  :invalid-feedback="errors.gender ? errors.gender[0] : ''"
                  :state="errors.gender ? false : null"
                >
                  <b-form-select
                    v-model="form.gender"
                    :options="optGender"
                    :state="errors.gender ? false : null"
                  ></b-form-select>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="NIK:"
                  label-for="input-title"
                  :invalid-feedback="errors.nik ? errors.nik[0] : ''"
                  :state="errors.nik ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="text"
                    name="nik"
                    v-model="form.nik"
                    placeholder="NIK"
                    :state="errors.nik ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Branch Office:"
                  label-for="input-title"
                  :invalid-feedback="errors.branch ? errors.branch[0] : ''"
                  :state="errors.branch ? false : null"
                >
                  <v-select
                    label="branch_name"
                    placeholder="-- Select Branch Office --"
                    :options="dataBranch"
                    v-model="form.branch"
                    :reduce="(branch) => branch.id"
                    :required="!form.branch"
                  ></v-select>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Address:"
                  label-for="input-title"
                  :invalid-feedback="errors.address ? errors.address[0] : ''"
                  :state="errors.address ? false : null"
                >
                  <b-form-textarea
                    id="address"
                    v-model="form.address"
                    placeholder="Enter address"
                    rows="3"
                    max-rows="6"
                  ></b-form-textarea>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Address 2:"
                  label-for="input-title"
                  :invalid-feedback="
                    errors.address_two ? errors.address_two[0] : ''
                  "
                  :state="errors.address_two ? false : null"
                >
                  <b-form-textarea
                    id="address_two"
                    v-model="form.address_two"
                    placeholder="Enter address 2"
                    rows="3"
                    max-rows="6"
                  ></b-form-textarea>
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
                    placeholder="email"
                    :state="errors.email ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Email 2:"
                  label-for="input-title"
                  :invalid-feedback="errors.email2 ? errors.email2[0] : ''"
                  :state="errors.email2 ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="email"
                    name="email2"
                    v-model="form.email2"
                    placeholder="email2"
                    :state="errors.email2 ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Mobile:"
                  label-for="input-title"
                  :invalid-feedback="errors.mobile ? errors.mobile[0] : ''"
                  :state="errors.mobile ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="tel"
                    name="mobile"
                    placeholder="mobile"
                    v-model="form.mobile"
                    :state="errors.mobile ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Telp:"
                  label-for="input-title"
                  :invalid-feedback="errors.phone ? errors.phone[0] : ''"
                  :state="errors.phone ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="tel"
                    name="telp"
                    v-model="form.phone"
                    placeholder="telp"
                    :state="errors.phone ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Telp 2:"
                  label-for="input-title"
                  :invalid-feedback="
                    errors.phone_two ? errors.phone_two[0] : ''
                  "
                  :state="errors.phone_two ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="tel"
                    name="telp"
                    v-model="form.phone_two"
                    placeholder="telp 2"
                    :state="errors.phone_two ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Hire Date:"
                  label-for="input-title"
                  :invalid-feedback="errors.hired_at ? errors.hired_at[0] : ''"
                  :state="errors.hired_at ? false : null"
                >
                  <b-form-datepicker
                    id="example-datepicker"
                    v-model="form.hired_at"
                    placeholder="Hire Date"
                    :date-format-options="{
                      year: 'numeric',
                      month: 'numeric',
                      day: 'numeric',
                    }"
                    locale="id"
                    :state="errors.hired_at ? false : null"
                    class="mb-2"
                  ></b-form-datepicker>
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
import Layout from "@/Shared/AdminLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";

export default {
  props: [
    "_token",
    "userinfo",
    "notif",
    "breadcrumbItems",
    "dataBranch",
    "dataTitle",
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
      optGender: [
        {
          value: "L",
          text: "Male",
        },
        {
          value: "P",
          text: "Female",
        },
      ],
      form: {
        branch: null,
        firstname: "",
        lastname: "",
        gender: "L",
        nik: "",
        address: "",
        address_two: "",
        email: "",
        mobile: "",
        phone: "",
        phone_two: "",
        hired_at: null,
        terminated_at: null,
      },
    };
  },
  methods: {
    submit() {
      if (!this.submitState) {
        this.submitState = true;
        this.$inertia.post(this.route(this.__store), this.form);
      }
    },
  },
};
</script>
