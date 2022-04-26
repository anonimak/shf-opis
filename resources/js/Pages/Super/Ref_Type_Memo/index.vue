<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Reference Type Memo</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <div>
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
                    </div>
                  </div>
                  <b-tabs
                    content-class="mt-3"
                    align="center"
                    v-model="tabIndexStatus"
                    @activate-tab="activeTab"
                    small
                  >
                    <b-tab>
                      <template #title>
                        Active
                        <b-badge
                          v-if="countStatus.active > 0"
                          variant="primary"
                          >{{ countStatus.active }}</b-badge
                        >
                      </template>
                    </b-tab>
                    <b-tab>
                      <template #title>
                        Inactive
                        <b-badge
                          v-if="countStatus.inactive > 0"
                          variant="primary"
                          >{{ countStatus.inactive }}</b-badge
                        >
                      </template>
                    </b-tab>
                  </b-tabs>
                  <div class="col-lg-3 col-xs-12 mt-3">
                    <search v-model="form.search" @reset="reset" />
                  </div>
                  <!-- table news -->
                  <div class="table-responsive">
                    <b-overlay
                      :show="isLoad"
                      opacity="0.6"
                      spinner-small
                      spinner-variant="primary"
                    >
                      <table class="table mt-4">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Type Memo Name</th>
                            <th scope="col">Module Approver</th>
                            <th scope="col">Department</th>
                            <th scope="col">Branch</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            v-for="(item, index) in dataRefTypeMemo.data"
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
                              {{ item.name }}
                            </td>
                            <td>
                              {{
                                item.ref_module_approver
                                  ? item.ref_module_approver.name
                                  : "-"
                              }}
                            </td>
                            <td>
                              {{
                                item.department
                                  ? item.department.department_name
                                  : "-"
                              }}
                            </td>
                            <td>
                              {{ item.branch ? item.branch.branch_name : "-" }}
                            </td>
                            <td>
                              <b-button-group size="sm">
                                <inertia-link
                                  :href="route(__template, item.id)"
                                  class="btn btn-info"
                                  >template</inertia-link
                                >
                                <b-button
                                  href="#"
                                  variant="primary"
                                  @click="actionStatus(item.id, true)"
                                  v-if="!item.status"
                                  >active
                                </b-button>
                                <b-button
                                  href="#"
                                  variant="warning"
                                  @click="actionStatus(item.id, false)"
                                  v-else
                                  >inactive
                                </b-button>
                                <inertia-link
                                  :href="route(__edit, item.id)"
                                  class="btn btn-secondary"
                                  ><i class="fa fa-edit" aria-hidden="true"></i
                                ></inertia-link>
                                <b-button
                                  href="#"
                                  variant="danger"
                                  @click="showMsgBoxDelete(item.id)"
                                  ><i
                                    class="fa fa-trash-alt"
                                    aria-hidden="true"
                                  ></i
                                ></b-button>
                              </b-button-group>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </b-overlay>
                  </div>
                  <Pagination :links="dataRefTypeMemo.links" />
                </div>
              </div>
            </keep-alive>
          </b-card>
        </div>
      </div>
    </div>
  </layout>
</template>
<script>
import Layout from "@/Shared/SuperLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import Pagination from "@/components/Pagination";
import Search from "@/components/Search";
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";

export default {
  props: [
    "meta",
    "flash",
    "breadcrumbItems",
    "dataRefTypeMemo",
    "userinfo",
    "notif",
    "filters",
    "perPage",
    "status",
    "countStatus",
    "__create",
    "__edit",
    "__updateStatus",
    "__show",
    "__destroy",
    "__template",
    "__index",
  ],
  metaInfo: { title: "Admin Reference Type Memo" },
  data() {
    return {
      tabIndexStatus: 0,
      form: {
        search: this.filters.search,
      },
      isCheched: false,
      isLoad: false,
    };
  },
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    Pagination,
    Search,
  },
//   beforeMount() {
//     this.activeTab(this.tabIndexStatus);
//   },
  methods: {
    submitDelete(id) {
      this.$inertia.delete(route(this.__destroy, id));
    },
    submitDeleteAll(idx) {
      //   this.$inertia.delete(route("admin.post.news.delete-all", idx.join()));
    },
    showMsgBoxDelete: function (id) {
      this.$bvModal
        .msgBoxConfirm("Please confirm that you want to delete this branch.", {
          title: "Please Confirm",
          size: "sm",
          buttonSize: "sm",
          okVariant: "danger",
          okTitle: "YES",
          cancelTitle: "NO",
          footerClass: "p-2",
          hideHeaderClose: false,
          centered: true,
        })
        .then((value) => {
          value && this.submitDelete(id);
        })
        .catch((err) => {
          // An error occurred
        });
    },
    actionStatus: function (id, status_type) {
      this.form.status_type = status_type;
      this.$inertia.put(route(this.__updateStatus, id), this.form).then(() => {
        this.activeTab(this.tabIndexStatus);
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
    activeTab(tabIndexStatus) {
      this.tabIndexStatus = tabIndexStatus;
      this.isLoad = true;

      let param = { status: this.status[tabIndexStatus] };
      if (this.filters.page) {
        param.page = this.filters.page;
      }
      this.$inertia.replace(route(this.__index, param)).then(() => {
        this.isLoad = false;
      });
    },
  },
  watch: {
    form: {
      handler: throttle(function () {
        let query = this.form.search;
        this.$inertia.replace(
          this.route(
            this.__index,
            Object.keys(query).length
              ? { search: query, status: this.status[this.tabIndexStatus] }
              : { remember: "forget", status: this.status[this.tabIndexStatus] }
          )
        );
      }, 150),
      deep: true,
    },
  },
};
</script>
