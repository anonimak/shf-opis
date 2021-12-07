<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Employee</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <b-card>
          <keep-alive>
            <div class="row">
              <div class="col-12">
                <div class="row">
                  <div class="col-12">
                    <inertia-link
                      :href="route(__create)"
                      class="btn btn-primary my-2 float-right"
                    >
                      <i class="fas fa-plus"></i>
                      Add</inertia-link
                    >
                    <b-button
                      variant="outline-primary float-right"
                      class="my-2 mr-2 btn-file"
                      ><i class="fas fa-file-import"></i> Import Excel<input
                        type="file"
                        ref="employeeFile"
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                        @change="onFileChange"
                    /></b-button>
                  </div>
                </div>
                <div class="col-lg-3 col-xs-12 mt-3">
                  <search v-model="form.search" @reset="reset" />
                </div>
                <!-- table news -->
                <table class="table mt-4">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Employee Name</th>
                      <th scope="col">Branch Office</th>
                      <th scope="col">NIK</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(item, index) in dataEmployees.data"
                      :key="item.id"
                    >
                      <th scope="row">
                        {{
                          (filters.page !== undefined
                            ? filters.page - 1
                            : 1 - 1) *
                            perPage +
                          index +
                          1
                        }}
                      </th>
                      <td>
                        {{ item.firstname + " " + item.lastname }}
                        <b-badge v-if="item.terminated_at" variant="danger"
                          >Terminated</b-badge
                        >
                      </td>
                      <td>
                        {{ item.branch.branch_name }}
                      </td>
                      <td>
                        {{ item.nik }}
                      </td>
                      <td>
                        <b-button-group size="sm">
                          <inertia-link
                            :href="route(__show, item.id)"
                            class="btn btn-primary"
                            ><i class="fa fa-search-plus" aria-hidden="true"></i
                          ></inertia-link>
                          <inertia-link
                            :href="route(__edit, item.id)"
                            class="btn btn-secondary"
                            ><i class="fa fa-edit" aria-hidden="true"></i
                          ></inertia-link>
                          <b-button
                            href="#"
                            variant="danger"
                            @click="showMsgBoxDelete(item.id)"
                            ><i class="fa fa-trash-alt" aria-hidden="true"></i
                          ></b-button>
                        </b-button-group>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <Pagination :links="dataEmployees.links" />
              </div>
            </div>
          </keep-alive>
        </b-card>
      </div>
    </div>
  </layout>
</template>
<script>
import Layout from "@/Shared/AdminLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import Pagination from "@/components/Pagination";
import Search from "@/components/Search";
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";

export default {
  props: [
    "dataEmployees",
    "flash",
    "breadcrumbItems",
    "userinfo",
    "notif",
    "filters",
    "perPage",
    "test",
    "__create",
    "__edit",
    "__show",
    "__destroy",
    "__index",
    "__importexcel",
  ],
  metaInfo: { title: "Admin Employee Page" },
  data() {
    return {
      tabIndexCfgHome: 0,
      form: {
        search: this.filters.search,
      },
      isCheched: false,
      submitState: false,
    };
  },
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    Pagination,
    Search,
  },
  methods: {
    submitDelete(id) {
      this.$inertia.delete(route(this.__destroy, id));
    },
    submitDeleteAll(idx) {
      //   this.$inertia.delete(route("admin.post.news.delete-all", idx.join()));
    },
    showMsgBoxDelete: function (id) {
      this.$bvModal
        .msgBoxConfirm(
          "Please confirm that you want to delete this employee.",
          {
            title: "Please Confirm",
            size: "sm",
            buttonSize: "sm",
            okVariant: "danger",
            okTitle: "YES",
            cancelTitle: "NO",
            footerClass: "p-2",
            hideHeaderClose: false,
            centered: true,
          }
        )
        .then((value) => {
          value && this.submitDelete(id);
        })
        .catch((err) => {
          // An error occurred
        });
    },
    showMsgBoxDeleteAll: function () {
      this.$bvModal
        .msgBoxConfirm(
          "Please confirm that you want to delete this checked post.",
          {
            title: "Please Confirm",
            size: "sm",
            buttonSize: "sm",
            okVariant: "danger",
            okTitle: "YES",
            cancelTitle: "NO",
            footerClass: "p-2",
            hideHeaderClose: false,
            centered: true,
          }
        )
        .then((value) => {
          // value && this.submitDeleteAll(this.selected);
        })
        .catch((err) => {
          // An error occurred
        });
    },
    uncheckAll: function () {
      // this.selected = []
    },
    reset() {
      this.form = mapValues(this.form, () => null);
    },
    onFileChange() {
      this.submitState = true;
      this.$page.flash.danger = null;
      let file = this.$refs.employeeFile.files[0];
      if (!file) {
        this.submitState = false;
        return;
      }
      //console.log(file.type);
      if (
        file.type !== "application/vnd.ms-excel" &&
        file.type !==
          "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
      ) {
        this.$page.flash.danger = "Excel file support only.";
        this.$refs.employeeFile.value = null;
        this.submitState = false;
        return;
      }
      var formData = new FormData();
      formData.append("file", file);
      this.$inertia.post(this.route(this.__importexcel), formData).then(() => {
        this.submitState = false;
        this.$refs.employeeFile.value = null;
      });
    },
  },
  watch: {
    form: {
      handler: throttle(function () {
        let query = pickBy(this.form);
        this.$inertia.replace(
          this.route(
            this.__index,
            Object.keys(query).length ? query : { remember: "forget" }
          )
        );
      }, 150),
      deep: true,
    },
  },
};
</script>
<style scoped>
.btn-file {
  position: relative;
  overflow: hidden;
}
.btn-file input[type="file"] {
  position: absolute;
  top: 0;
  right: 0;
  min-width: 100%;
  min-height: 100%;
  font-size: 100px;
  text-align: right;
  filter: alpha(opacity=0);
  opacity: 0;
  outline: none;
  cursor: inherit;
  display: block;
}
</style>
