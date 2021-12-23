<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Create New Memo</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <b-card no-body>
          <b-form id="form" @submit.prevent="submit">
            <b-card-body>
              <b-row align-h="center" class="mb-2">
                <b-col col lg="6" md="auto">
                  <b-form-group
                    id="input-group-title"
                    label="Title Memo:"
                    label-for="input-title"
                    :invalid-feedback="errors.title ? errors.title[0] : ''"
                    :state="errors.title ? false : null"
                  >
                    <b-form-input
                      id="input-title"
                      type="text"
                      name="title"
                      v-model="form.title"
                      placeholder="Title Memo"
                      :state="errors.title ? false : null"
                      trim
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group
                    id="input-group-type-memo"
                    label="Type Memo:"
                    label-for="input-title"
                    :invalid-feedback="
                      errors.typememo ? errors.typememo[0] : ''
                    "
                    :state="errors.typememo ? false : null"
                  >
                    <v-select
                      placeholder="-- Select Type Memo --"
                      label="name"
                      :options="dataTypeMemo"
                      v-model="form.typememo"
                      :reduce="(typememo) => typememo.id"
                      :required="!form.typememo"
                    >
                      <template v-slot:option="option">
                        {{ option.name }}
                        <span
                          v-if="!option.id_department"
                          class="font-weight-bold font-italic"
                        >
                          (General Memo)</span
                        >
                      </template>
                    </v-select>
                  </b-form-group>
                </b-col>
              </b-row>
              <b-row align-h="center">
                <b-button-group>
                  <b-button type="submit" variant="primary" class="btn-lg"
                    >Create Memo</b-button
                  >
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
  metaInfo: { title: "Create New Memo" },
  props: [
    "_token",
    "userinfo",
    "notif",
    "breadcrumbItems",
    "dataTypeMemo",
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
        title: "",
        typememo: null,
      },
    };
  },
  methods: {
    getOptionLabel: (option) => {
      return option.id_department
        ? option.name
        : option.name + " -- General Memo";
    },
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