<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Status PO</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
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
                        <b-badge v-if="counttab.submit > 0" variant="primary">{{
                          counttab.submit
                        }}</b-badge>
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
                        <b-badge v-if="counttab.reject > 0" variant="primary">{{
                          counttab.reject
                        }}</b-badge>
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
                              {{
                                item.proposeemployee.firstname +
                                " " +
                                item.proposeemployee.lastname
                              }}
                            </td>
                            <td>
                              {{
                                item.proposeemployee.position_now.branch
                                  .branch_name
                              }}
                            </td>
                            <td>
                              {{ item.po_no }}
                            </td>
                            <td>
                              {{ item.latest_history.content }}
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
                                    :href="route(__senddraft, item.id)"
                                    class="dropdown-item"
                                  >
                                    send to draft
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
                                    v-on:click="openPDF(item.id, 1200, 650)"
                                    v-if="
                                      item.status_po == 'approve' &&
                                      isMobile() == false
                                    "
                                    >Preview PDF</a
                                  >
                                  <a
                                    target="_blank"
                                    class="dropdown-item"
                                    :href="route(__previewpdf, item.id)"
                                    v-if="
                                      item.status_po == 'approve' &&
                                      isMobile() == true
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
import { Timeline, TimelineItem, TimelineTitle } from "vue-cute-timeline";
export default {
  props: [
    "meta",
    "flash",
    "breadcrumbItems",
    "dataMemo",
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
    "__senddraft",
  ],
  metaInfo: { title: "Status PO" },
  data() {
    return {
      tabIndex: 0,
      form: {
        search: this.filters.search,
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
  },
  beforeMount() {
    this.setLsTabMemo();
  },
  methods: {
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
      if (this.$ls.get("tabIndexPo")) {
        this.tabIndex = this.$ls.get("tabIndexPo") - 1;
      }
      let query = this.form.search;
      let param = { search: query, tab: this.tab[this.tabIndex] };
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
      this.$ls.set("tabIndexPo", this.tabIndex + 1, 60 * 60 * 1000);

      let param = { tab: this.tab[tabIndex] };
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
        this.$inertia.replace(
          this.route(
            this.__index,
            Object.keys(query).length
              ? { search: query, tab: this.tab[this.tabIndex] }
              : {
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
