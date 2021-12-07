<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Status Memo Branch</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <div>
          <b-card>
            <keep-alive>
              <div class="row">
                <div class="col-12">
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
                              {{ item.doc_no }}
                            </td>
                            <td>
                              {{ item.latest_history.content }}
                            </td>
                            <td>
                              <inertia-link
                                :href="route(__webpreview, item.id)"
                                class="btn btn-secondary btn-sm"
                              >
                                preview
                              </inertia-link>
                              <b-button
                                v-b-tooltip.hover
                                title="Lanjut PO"
                                href="#"
                                variant="primary"
                                class="btn btn-primary btn-sm"
                                @click="showModalProposePo(item.id)"
                                v-if="
                                  item.ref_table.with_po == 1 &&
                                  item.status == 'approve' &&
                                  item.status_po == 'edit'
                                "
                              >
                                Lanjut PO
                              </b-button>
                              <inertia-link
                                v-if="
                                  item.ref_table.with_po == 1 &&
                                  item.status == 'approve' &&
                                  item.status_po != 'edit'
                                "
                                :href="route(__webpreviewpo, item.id)"
                                v-b-tooltip.hover
                                title="Info PO"
                                class="btn btn-info btn-sm"
                              >
                                Info PO
                              </inertia-link>
                              <b-button
                                v-b-tooltip.hover
                                title="Lanjut Payment"
                                href="#"
                                variant="primary"
                                class="btn btn-primary btn-sm"
                                @click="showModal(item.id)"
                                v-if="
                                  item.ref_table.with_payment == 1 &&
                                  item.status == 'approve' &&
                                  item.status_payment == 'edit'
                                "
                                :disabled="item.status_payment != 'edit'"
                              >
                                Lanjut Payment
                              </b-button>
                              <inertia-link
                                v-if="
                                  item.ref_table.with_payment == 1 &&
                                  item.status == 'approve' &&
                                  item.status_payment != 'edit'
                                "
                                :href="route(__webpreviewpayment, item.id)"
                                v-b-tooltip.hover
                                title="Info Payment"
                                class="btn btn-info btn-sm"
                              >
                                Info Payment
                              </inertia-link>
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
    <ModalFormPayment
      :title="modalTitle"
      :indexMemo="idItemClicked"
      :proposeLink="__proposepayment"
      :errors="errors"
    />
  </layout>
</template>
<script>
import Layout from "@/Shared/UserLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import ModalFormPayment from "@/components/ModalFormPayment";
import ModalFormPo from "@/components/ModalFormPo";
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
    "errors",
    "filters",
    "perPage",
    "__proposepayment",
    "__webpreview",
    "__webpreviewpayment",
    "__index",
  ],
  metaInfo: { title: "Admin Reference Approve Page" },
  data() {
    return {
      tabIndex: 0,
      form: {
        search: this.filters.search,
      },
      isLoadMemo: false,
      isCheched: false,
      idItemClicked: null,
      idItemPOClicked: null,
      modalTitle: "",
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
    ModalFormPayment,
    ModalFormPo,
  },
  methods: {
    showModal(id) {
      this.idItemClicked = id;
      this.modalTitle = "Modal Payment";
      this.$root.$emit("bv::show::modal", "modal-propose-payment", "#btnShow");
      //this.$refs.modalPayment.show(item);
    },
    showModalProposePo(id) {
      // console.log("submit");
      // this.$inertia.put(route(this.__proposepo, id));
      this.idItemPOClicked = id;
      this.modalTitle = "Modal PO";

      this.$root.$emit(
        "bv::show::modal",
        "modal-propose-po",
        "#btnShowModalPO"
      );
      //this.$refs.modalPayment.show(item);
    },
    submitProposePayment(id) {
      console.log("submit");
      this.$inertia.put(route(this.__proposepayment, id));
    },
    showMsgBoxProposePayment: function (id) {
      this.$bvModal
        .msgBoxConfirm("Please confirm that you want to submit this Memo.", {
          title: "Please Confirm",
          size: "sm",
          buttonSize: "sm",
          okTitle: "YES",
          cancelTitle: "NO",
          footerClass: "p-2",
          hideHeaderClose: false,
          centered: true,
        })
        .then((value) => {
          value && this.submitProposePayment(id);
        })
        .catch((err) => {
          //console.log(err);
          // An error occurred
        });
    },
    reset() {
      this.form = mapValues(this.form, () => null);
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
