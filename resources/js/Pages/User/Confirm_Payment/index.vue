<template>
  <Layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Confirm Payments</h1>
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
                        Unpaid
                        <b-badge v-if="counttab.unpaid > 0" variant="primary">{{
                          counttab.unpaid
                        }}</b-badge>
                      </template>
                    </b-tab>
                    <b-tab>
                      <template #title>
                        Paid
                        <b-badge v-if="counttab.paid > 0" variant="primary">{{
                          counttab.paid
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
                            <th scope="col">Document No</th>
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
                              <!-- {{ item.doc_no }} -->
                              <inertia-link :href="route(__detail, item.id)">
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
                              {{ item.latest_history.content }}
                            </td>
                            <td v-if="item.payment_at != null">
                              {{
                                item.payment_at | moment("dddd, MMMM Do YYYY")
                              }}
                            </td>
                            <td v-else>-</td>
                            <td>
                              <b-button-group>
                                <a
                                  target="_blank"
                                  class="btn btn-success"
                                  :href="route(__previewpdf, item.id)"
                                  >Preview PDF</a
                                >
                                <b-button
                                  v-if="item.payment_at == null"
                                  @click="
                                    actionConfirm(
                                      item.id,
                                      item.confirmed_payment_by
                                    )
                                  "
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
    "filters",
    "tab",
    "counttab",
    //"dataPosition",
  ],
  metaInfo: { title: "Confirming Payment" },
  data() {
    return {
      //   isCheched: false,
      buttonClicked: "",
      isLoadMemo: false,
      tabIndex: 0,
      idItemClicked: null,
      idConfirmedPayment: null,
      modalTitle: "",
      modalCaption: "",
      form: {
        search: this.filters.search,
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
  },
  beforeMount() {
    this.setLsTabMemo();
  },
  mounted() {},
  methods: {
    actionConfirm(id, idConfirmedPay) {
      //   this.buttonClicked = "approve";
      this.idItemClicked = id;
      this.idConfirmedPayment = idConfirmedPay;
      this.modalTitle = "Modal Confirming Payment";
      this.modalCaption =
        "Are you sure to confirm this memo payment has been paid?";

      this.$root.$emit("bv::show::modal", "modal-prevent-closing", "#btnShow");
    },
    // actionNext(id) {
    //   this.buttonClicked = "approve";
    //   this.idItemClicked = id;
    //   this.modalTitle = "Modal Acknowledge";
    //   this.modalCaption = "Are you sure to next?";

    //   this.$root.$emit("bv::show::modal", "modal-prevent-closing", "#btnShow");
    // },
    // actionRevisi(id) {
    //   this.buttonClicked = "revisi";
    //   this.idItemClicked = id;
    //   this.modalTitle = "Modal Revision";
    //   this.modalCaption = "Are you sure to revision?";

    //   this.$root.$emit("bv::show::modal", "modal-prevent-closing", "#btnShow");
    // },
    // actionReject(id) {
    //   this.buttonClicked = "reject";
    //   this.idItemClicked = id;
    //   this.modalTitle = "Modal Reject";
    //   this.modalCaption = "Are you sure to reject?";

    //   this.$root.$emit("bv::show::modal", "modal-prevent-closing", "#btnShow");
    // },
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
    // submitDelete(id) {
    //   // this.$inertia.delete(route(this.__destroy, id));
    // },
    // showMsgBoxDelete: function (id) {
    //   this.$bvModal
    //     .msgBoxConfirm(
    //       "Please confirm that you want to delete this reference approver.",
    //       {
    //         title: "Please Confirm",
    //         size: "sm",
    //         buttonSize: "sm",
    //         okVariant: "danger",
    //         okTitle: "YES",
    //         cancelTitle: "NO",
    //         footerClass: "p-2",
    //         hideHeaderClose: false,
    //         centered: true,
    //       }
    //     )
    //     .then((value) => {
    //       value && this.submitDelete(id);
    //     })
    //     .catch((err) => {
    //       // An error occurred
    //     });
    // },
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

      let param = { tab: this.tab[tabIndex] };
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

