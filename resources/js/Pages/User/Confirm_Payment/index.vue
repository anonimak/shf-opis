<template>
  <Layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Confirm Payments</h1>
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
                              Unpaid
                              <b-badge
                                v-if="counttab.unpaid > 0"
                                variant="primary"
                                >{{ counttab.unpaid }}</b-badge
                              >
                            </template>
                          </b-tab>
                          <b-tab>
                            <template #title>
                              Paid
                              <b-badge
                                v-if="counttab.paid > 0"
                                variant="primary"
                                >{{ counttab.paid }}</b-badge
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
                                  <th scope="col">Document No</th>
                                  <th scope="col">From</th>
                                  <th scope="col">Branch</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Payment At</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
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
                                    <inertia-link
                                      :href="route(__detail, item.id)"
                                    >
                                      {{ item.doc_no }}
                                    </inertia-link>
                                    <b-badge
                                      v-if="item.payment_at != null"
                                      variant="success"
                                    >
                                      Paid
                                    </b-badge>
                                    <b-badge
                                      v-if="item.payment_at == null"
                                      variant="warning"
                                    >
                                      Unpaid
                                    </b-badge>
                                  </td>
                                  <td>
                                    {{ item.firstname + " " + item.lastname }}
                                  </td>
                                  <td>
                                    {{ item.branch_name }}
                                  </td>
                                  <td>
                                    {{ item.content }}
                                  </td>
                                  <td v-if="item.payment_at != null">
                                    {{
                                      item.payment_at
                                        | moment("dddd, MMMM Do YYYY")
                                    }}
                                  </td>
                                  <td v-else>-</td>
                                  <td>
                                    <b-button-group>
                                      <a
                                        target="_blank"
                                        class="btn btn-success"
                                        v-on:click="openPDF(item.id, 1200, 650)"
                                        v-if="!isMobile()"
                                        >Preview PDF</a
                                      >
                                      <a
                                        target="_blank"
                                        class="btn btn-success"
                                        :href="route(__previewpdf, item.id)"
                                        v-if="isMobile()"
                                        >Preview PDF</a
                                      >
                                      <b-button
                                        v-if="item.payment_at == null"
                                        @click="actionConfirm(item)"
                                        variant="info"
                                      >
                                        Confirm Payment
                                      </b-button>
                                    </b-button-group>
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

    <modal-form-confirm-payment
      :title="modalTitle"
      :caption="modalCaption"
      :idConfirmedPayment="idConfirmedPayment"
      :idItemClicked="idItemClicked"
      @handleOk="handleOk"
      @handleHidden="handleHidden"
    />
  </Layout>
</template>
<script>
import Layout from "@/Shared/UserLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import Pagination from "@/components/Pagination";
import Search from "@/components/Search";
import { Timeline, TimelineItem, TimelineTitle } from "vue-cute-timeline";
import throttle from "lodash/throttle";
import mapValues from "lodash/mapValues";
import ModalFormConfirmPayment from "@/components/ModalFormConfirmPayment";
import UndrawNoData from "vue-undraw/UndrawNoData";
import FormFilter from "@/components/FormFilter";

export default {
  props: [
    "meta",
    "flash",
    "breadcrumbItems",
    "userinfo",
    "notif",
    "__confirming",
    "__previewpdf",
    "__detail",
    "__index",
    "perPage",
    "dataMemo",
    "dataBranch",
    "filters",
    "tab",
    "counttab",
  ],
  metaInfo: { title: "Confirming Payment" },
  data() {
    return {
      buttonClicked: "",
      isLoadMemo: false,
      tabIndex: 0,
      idItemClicked: null,
      idConfirmedPayment: null,
      modalTitle: "",
      modalCaption: "",
      form: {
        search: this.filters.search,
        selectedBranch: null,
      },
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
    UndrawNoData,
    ModalFormConfirmPayment,
    FormFilter,
  },
  beforeMount() {
    this.setLsTabMemo();
  },
  mounted() {},
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
    actionConfirm(item) {
      //   this.buttonClicked = "approve";
      this.idItemClicked = item.id;
      this.idConfirmedPayment = item.confirmed_payment_by;
      this.modalTitle = "Modal Confirming Payment";
      this.modalCaption = `<b>Title : ${item.title}</b> <br>`;
      this.modalCaption += `<b>Document No : ${item.doc_no}</b><br><br>`;
      this.modalCaption += `Are you sure to confirm this memo payment has been paid?`;

      this.$root.$emit("bv::show::modal", "modal-prevent-closing", "#btnShow");
    },

    handleHidden() {
      //   this.buttonClicked = "";
      this.idItemClicked = null;
      this.modalTitle = "";
      this.modalCaption = "";
    },
    handleOk(item) {
      this.$inertia
        .put(route(this.__confirming, [item.id, item.idConfirmedPayment]))
        .then(() => {
          // this.buttonClicked = "";
          this.idItemClicked = null;
          this.modalTitle = "";
          this.modalCaption = "";
        });
    },
    reset() {
      this.form = mapValues(this.form, () => null);
    },
    setLsTabMemo() {
      this.isLoadMemo = true;
      // this.memo = { data: [], link: [] };
      if (this.$ls.get("tabIndexConfirm")) {
        this.tabIndex = this.$ls.get("tabIndexConfirm") - 1;
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
      this.$ls.set("tabIndexConfirm", this.tabIndex + 1, 60 * 60 * 1000);
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
            this.__index,
            Object.keys(query || branch).length
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

