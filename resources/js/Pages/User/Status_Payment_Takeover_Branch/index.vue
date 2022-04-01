<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Status Payment Branch</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <b-container class="bv-example-row" style="max-width: 1700px; padding: 0">
      <b-row>
        <FormFilter
          :dataBranch="dataBranch"
          v-model="form.selectedBranch"
          @change="changeChecked"
        />
        <b-col :md="isMobile() ? 'auto' : null" class="mb-2">
          <div class="row">
            <div class="col-12">
              <div>
                <b-card>
                  <keep-alive>
                    <div class="row">
                      <div class="col-12">
                        <b-tabs
                          content-class="mt-3"
                          align="center"
                          v-model="tabIndex"
                          @activate-tab="activeTab"
                          small
                        >
                          <b-tab>
                            <template #title>
                              On Process
                              <b-badge
                                v-if="counttab.submit > 0"
                                variant="primary"
                                >{{ counttab.submit }}</b-badge
                              >
                            </template>
                          </b-tab>
                          <b-tab>
                            <template #title>
                              Approved
                              <b-badge
                                v-if="counttab.approve > 0"
                                variant="primary"
                                >{{ counttab.approve }}</b-badge
                              >
                            </template>
                          </b-tab>
                          <b-tab>
                            <template #title>
                              Rejected
                              <b-badge
                                v-if="counttab.reject > 0"
                                variant="primary"
                                >{{ counttab.reject }}</b-badge
                              >
                            </template>
                          </b-tab>
                          <b-tab>
                            <template #title>
                              Revised
                              <b-badge
                                v-if="counttab.revisi > 0"
                                variant="primary"
                                >{{ counttab.revisi }}</b-badge
                              >
                            </template>
                          </b-tab>
                        </b-tabs>
                        <div class="row"></div>
                        <div class="col-lg-3 col-xs-12 mt-3">
                          <search v-model="form.search" @reset="reset" />
                        </div>
                        <div class="table-responsive">
                          <b-overlay
                            :show="isLoadMemo"
                            opacity="0.6"
                            spinner-small
                            spinner-variant="primary"
                          >
                            <table class="table mt-4">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Title</th>
                                  <th scope="col">From</th>
                                  <th scope="col">Branch</th>
                                  <th scope="col">Document No</th>
                                  <th scope="col">Status</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody v-if="dataMemo.data != undefined">
                                <tr
                                  v-for="(item, index) in dataMemo.data"
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
                                    {{ item.title }}
                                  </td>
                                  <td>
                                    {{ item.firstname + " " + item.lastname }}
                                  </td>
                                  <td>
                                    {{ item.branch_name }}
                                  </td>
                                  <td>
                                    {{ item.doc_no }}
                                    <b-badge
                                      v-if="
                                        item.payment_at != null &&
                                        item.with_payment == true
                                      "
                                      variant="success"
                                    >
                                      Paid
                                    </b-badge>
                                    <b-badge
                                      v-if="
                                        item.payment_at == null &&
                                        item.with_payment == true
                                      "
                                      variant="warning"
                                    >
                                      Unpaid
                                    </b-badge>
                                  </td>
                                  <td>
                                    {{ item.content }}
                                  </td>
                                  <td>
                                    <div class="dropdown">
                                      <button
                                        class="btn btn-link"
                                        type="button"
                                        id="dropdownMenuButton"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                      >
                                        <i class="fas fa-ellipsis-v"></i>
                                      </button>
                                      <div
                                        class="dropdown-menu"
                                        aria-labelledby="dropdownMenuButton"
                                      >
                                        <inertia-link
                                          v-if="tabIndex == 3"
                                          :href="route(__editpayment, item.id)"
                                          class="dropdown-item"
                                        >
                                          Edit Payment
                                        </inertia-link>
                                        <inertia-link
                                          :href="route(__webpreview, item.id)"
                                          class="dropdown-item"
                                        >
                                          Preview
                                        </inertia-link>
                                        <a
                                          target="_blank"
                                          class="dropdown-item"
                                          v-on:click="
                                            openPDF(item.id, 1200, 650)
                                          "
                                          v-if="
                                            item.status_payment == 'approve' &&
                                            !isMobile()
                                          "
                                          >Preview PDF</a
                                        >
                                        <a
                                          target="_blank"
                                          class="dropdown-item"
                                          :href="route(__previewpdf, item.id)"
                                          v-if="
                                            item.status_payment == 'approve' &&
                                            isMobile()
                                          "
                                          >Preview PDF</a
                                        >
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </b-overlay>
                        </div>
                        <Pagination
                          v-if="dataMemo.links != undefined"
                          :links="dataMemo.links"
                        />
                      </div>
                    </div>
                  </keep-alive>
                </b-card>
              </div>
            </div>
          </div>
        </b-col>
      </b-row>
    </b-container>
  </layout>
</template>
<script>
import Layout from "@/Shared/UserLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import Pagination from "@/components/Pagination";
import Search from "@/components/Search";
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";
import FormFilter from "@/components/FormFilter";
import { Timeline, TimelineItem, TimelineTitle } from "vue-cute-timeline";
export default {
  props: [
    "meta",
    "flash",
    "breadcrumbItems",
    "dataMemo",
    "dataBranch",
    "userinfo",
    "notif",
    "filters",
    "perPage",
    "tab",
    "counttab",
    "__create",
    "__edit",
    "__show",
    "__destroy",
    "__indexpayment",
    "__webpreview",
    "__previewpdf",
    "__previewmemopdf",
    "__editpayment",
  ],
  metaInfo: { title: "Status Payment Takeover Branch" },
  data() {
    return {
      tabIndex: 0,
      form: {
        search: this.filters.search,
        selectedBranch: null,
      },
      // memo: { data: [], link: [] },
      isLoadMemo: false,
      isCheched: false,
    };
  },
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    Pagination,
    Search,
    Timeline,
    TimelineItem,
    TimelineTitle,
    FormFilter,
  },
  beforeMount() {
    this.setLsTabMemo();
  },
  methods: {
    changeChecked(branch) {
      this.form.selectedBranch = branch;
    },
    openPDF(id, popupWidth, popupHeight) {
      let left = (screen.width - popupWidth) / 2;
      let top = (screen.height - popupHeight) / 4;
      javascript: window.open(
        route(this.__previewpdf, id),
        "_blank",
        "resizeable=yes, width=" +
          popupWidth +
          ", height=" +
          popupHeight +
          ", top=" +
          top +
          ", left=" +
          left
      );
      return false;
    },
    submitDelete(id) {
      this.$inertia.delete(route(this.__destroy, id));
    },
    submitDeleteAll(idx) {
      //   this.$inertia.delete(route("admin.post.news.delete-all", idx.join()));
    },
    showMsgBoxDelete: function (id) {
      this.$bvModal
        .msgBoxConfirm(
          "Please confirm that you want to delete this reference approver.",
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
    setLsTabMemo() {
      this.isLoadMemo = true;
      // this.memo = { data: [], link: [] };
      if (this.$ls.get("tabIndexPaymentBranch")) {
        this.tabIndex = this.$ls.get("tabIndexPaymentBranch") - 1;
      }

      let param = { tab: this.tab[this.tabIndex] };
      if (this.filters.page) {
        param.page = this.filters.page;
      }

      this.$inertia.replace(route(this.__index, param)).then(() => {
        // this.memo = { ...this.dataMemo };
        this.isLoadMemo = false;
      });
    },
    activeTab(tabIndex) {
      this.tabIndex = tabIndex;
      this.isLoadMemo = true;
      // this.memo = { data: [], link: [] };
      this.$ls.set("tabIndexPaymentBranch", this.tabIndex + 1, 60 * 60 * 1000);
     let query = this.form.search;
      let branch = this.form.selectedBranch;
      if (!this.form.selectedBranch) {
        branch = "";
      }

       let param = { search: query, checkedBranch: branch, tab: this.tab[tabIndex] };
      if (this.filters.page) {
        param.page = this.filters.page;
      }
      this.$inertia.replace(route(this.__index, param)).then(() => {
        // this.memo = { ...this.dataMemo };
        this.isLoadMemo = false;
      });
    },
  },
  watch: {
    form: {
      handler: throttle(function () {
        let query = this.form.search;
        let branch = this.form.selectedBranch;
        if (!this.form.selectedBranch) {
          branch = "";
        }
        this.$inertia.replace(
          this.route(
            this.__indexpayment,
            query
              ? {
                  search: query,
                  checkedBranch: branch,
                  tab: this.tab[this.tabIndex],
                }
              : {
                  checkedBranch: branch,
                  remember: "forget",
                  tab: this.tab[this.tabIndex],
                }
          )
        );
      }, 150),
      deep: true,
    },
  },
};
</script>
