<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Update Position</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <b-card no-body>
          <b-form id="form" @submit.prevent="submit">
            <b-card-body>
              <b-col col lg="5" md="auto">
                <b-form-group
                  id="input-group-title"
                  label="Message"
                  label-for="textarea"
                  :invalid-feedback="errors.msg ? errors.msg[0] : ''"
                  :state="errors.msg ? false : null"
                >
                  <b-form-textarea
                    id="textarea"
                    type="text"
                    name="msg"
                    placeholder="Maintenance Message"
                    v-model="form.msg"
                    :state="errors.msg ? false : null"
                    rows="3"
                    max-rows="6"
                    trim
                    required
                  ></b-form-textarea>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Status"
                  label-for="input-title"
                  :invalid-feedback="errors.status ? errors.status[0] : ''"
                  :state="errors.status ? false : null"
                >
                  <b-form-select
                    placeholder="-- Select Status Maintenance Message --"
                    :options="options"
                    v-model="form.status"
                  >
                  </b-form-select>
                </b-form-group>
                <b-form-group
                  id="input-group-title"
                  label="Type"
                  label-for="input-title"
                  :invalid-feedback="errors.type ? errors.type[0] : ''"
                  :state="errors.type ? false : null"
                >
                  <b-form-select
                    placeholder="-- Select Type Maintenance Message --"
                    :options="optiontypes"
                    v-model="form.type"
                  >
                  </b-form-select>
                </b-form-group>
              </b-col>
              <b-row align-h="center">
                <b-button-group>
                  <b-button type="submit" variant="primary">Submit</b-button>
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
    "notif",
    "breadcrumbItems",
    "errors",
    "dataMaintenance",
    "__update",
  ],
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
  },
  data() {
    return {
      submitState: false,
      form: {
        msg: "",
        status: null,
        type: null,
      },
      options: [
        {
          value: null,
          text: "--Please select an status maintenance message--",
        },
        { value: "hide", text: "Hide" },
        { value: "show", text: "Show" },
      ],
      optiontypes: [
        {
          value: null,
          text: "--Please select an type maintenance message--",
        },
        { value: "primary", text: "Primary" },
        { value: "secondary", text: "Secondary" },
        { value: "info", text: "Info" },
        { value: "success", text: "Success" },
        { value: "warning", text: "Warning" },
        { value: "danger", text: "Danger" },
      ],
    };
  },
  mounted() {
    this.fillForm();
  },
  methods: {
    fillForm() {
      this.form = { ...this.dataMaintenance };
    },
    submit() {
      if (!this.submitState) {
        this.submitState = true;
        this.$inertia
          .put(this.route(this.__update, this.form.id), this.form)
          .then(() => (this.submitState = false));
      }
    },
  },
};
</script>
