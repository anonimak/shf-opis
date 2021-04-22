<template>
  <layout :userinfo="userinfo">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Update Branch Office</h1>
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
                  label="Branch Office Name:"
                  label-for="input-title"
                  :invalid-feedback="errors.branch ? errors.branch[0] : ''"
                  :state="errors.branch ? false : null"
                >
                  <b-form-input
                    id="input-title"
                    type="text"
                    name="branch"
                    v-model="form.branch"
                    placeholder="Input title"
                    :state="errors.branch ? false : null"
                    trim
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                  id="checkbox-group-head"
                  label=""
                  label-for="checkbox-head"
                  :invalid-feedback="errors.isHead ? errors.isHead[0] : ''"
                  :state="errors.isHead ? false : null"
                >
                  <b-form-checkbox
                    id="checkbox-head"
                    v-model="form.isHead"
                    name="checkboxhead"
                    :value="1"
                    :unchecked-value="0"
                  >
                    Set as Head Office
                  </b-form-checkbox>
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
    "breadcrumbItems",
    "errors",
    "dataBranch",
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
      form: {},
    };
  },
  mounted() {
    this.fillForm();
  },
  methods: {
    fillForm() {
      this.form = { ...this.dataBranch };
    },
    submit() {
      if (!this.submitState) {
        this.submitState = true;
        this.$inertia.put(this.route(this.__update, this.form.id), this.form);
      }
    },
  },
};
</script>