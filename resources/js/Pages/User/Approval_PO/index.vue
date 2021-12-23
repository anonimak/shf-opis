<template>
  <Layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Approval PO</h1>
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
                    <!-- <b-tab>
                      <template #title>
                        Revised
                        <b-badge v-if="counttab.revisi > 0" variant="primary">{{
                          counttab.revisi
                        }}</b-badge>
                      </template>
                    </b-tab> -->
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
                            <!-- <th scope="col">Status</th> -->
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            v-for="(item, index) in dataMemoTabList.data"
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
                            </td>
                            <!-- <td>
                              {{ item.latest_history.content }}
                            </td> -->
                            <td>
                              <b-button-group
                                v-if="
                                  item.type_approver == 'approver' &&
                                  item.status_po == 'submit'
                                "
                              >
                                <a
                                  target="_blank"
                                  class="btn btn-success"
                                  :href="route(__previewpdf, item.id)"
                                  >Preview PDF</a
                                >
                                <b-button
                                  @click="actionApprove(item.id_approver)"
                                  variant="info"
                                  >Approve</b-button
                                >
                                <!-- <b-button
                                  @click="actionRevisi(item.id_approver)"
                                  variant="secondary"
                                  >Revision</b-button
                                > -->
                                <b-button
                                  @click="actionReject(item.id_approver)"
                                  variant="warning"
                                  >Reject</b-button
                                >
                              </b-button-group>
                              <b-button-group v-else>
                                <a
                                  target="_blank"
                                  class="btn btn-success"
                                  :href="route(__previewpdf, item.id)"
                                  >Preview PDF</a
                                >
                                <b-button
                                  @click="actionNext(item.id_approver)"
                                  variant="info"
                                  v-if="item.type_approver == 'acknowledge'"
                                  >Next</b-button
                                >
                              </b-button-group>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </b-overlay>
                  </div>
                  <Pagination
                    v-if="dataMemoTabList.links != undefined"
                    :links="dataMemoTabList.links"
                  />
                </div>
              </div>
            </keep-alive>
          </b-card>
        </div>
        <!-- <b-card v-if="dataMemo.length > 0">
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
                <div class="table-responsive">
                  <table class="table mt-4">
                    <thead>
                      <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Document No</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in dataMemo" :key="item.id">
                        <td>
                          {{ item.title }}
                        </td>
                        <td>
                          <inertia-link :href="route(__detail, item.id)">
                            {{ item.po_no }}
                          </inertia-link>
                        </td>
                        <td>
                          <b-button-group
                            v-if="item.type_approver == 'approver'"
                          >
                            <a
                              target="_blank"
                              class="btn btn-success"
                              :href="route(__previewpdf, item.id)"
                              >Preview PDF</a
                            >
                            <b-button
                              @click="actionApprove(item.id_approver)"
                              variant="info"
                              >Approve</b-button
                            >
                            <b-button
                              @click="actionReject(item.id_approver)"
                              variant="warning"
                              >Reject</b-button
                            >
                          </b-button-group>
                          <b-button-group v-else>
                            <a
                              target="_blank"
                              class="btn btn-success"
                              :href="route(__previewpdf, item.id)"
                              >Preview PDF</a
                            >
                            <b-button
                              @click="actionNext(item.id_approver)"
                              variant="info"
                              >Next</b-button
                            >
                          </b-button-group>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </keep-alive>
        </b-card>
        <div v-else class="my-5 text-center">
          <UndrawNoData primary-color="#858796" height="300px" />
          <h1 class="display-6 text-muted">No data approval</h1>
        </div> -->
      </div>
    </div>
    <modal-form-memo-approval
      :title="modalTitle"
      :caption="modalCaption"
      :variant="buttonClicked"
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
import ModalFormMemoApproval from "@/components/ModalFormMemoApproval";
import UndrawNoData from "vue-undraw/UndrawNoData";

export default {
  props: [
    "meta",
    "flash",
    "breadcrumbItems",
    // "dataMemo",
    "userinfo",
    "notif",
    "__approving",
    "__previewpdf",
    "__detail",
    "__index",
    "perPage",
    "dataMemoTabList",
    "filters",
    "tab",
    "counttab",
    "dataPosition",
  ],
  metaInfo: { title: "Approval PO" },
  data() {
    return {
      isCheched: false,
      buttonClicked: "",
      isLoadMemo: false,
      idItemClicked: null,
      modalTitle: "",
      modalCaption: "",
      tabIndex: 0,
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
    ModalFormMemoApproval,
    UndrawNoData,
  },
  beforeMount() {
    this.setLsTabMemo();
  },
  mounted() {},
  methods: {
    actionApprove(id) {
      this.buttonClicked = "approve";
      this.idItemClicked = id;
      this.modalTitle = "Modal Approve";
      this.modalCaption = "Are you sure to approve?";

      this.$root.$emit("bv::show::modal", "modal-prevent-closing", "#btnShow");
    },
    actionNext(id) {
      this.buttonClicked = "approve";
      this.idItemClicked = id;
      this.modalTitle = "Modal Acknowledge";
      this.modalCaption = "Are you sure to next?";

      this.$root.$emit("bv::show::modal", "modal-prevent-closing", "#btnShow");
    },
    actionReject(id) {
      this.buttonClicked = "reject";
      this.idItemClicked = id;
      this.modalTitle = "Modal Reject";
      this.modalCaption = "Are you sure to reject?";

      this.$root.$emit("bv::show::modal", "modal-prevent-closing", "#btnShow");
    },
    handleHidden() {
      this.buttonClicked = "";
      this.idItemClicked = null;
      this.modalTitle = "";
      this.modalCaption = "";
    },
    handleOk(item) {
      this.$inertia.put(route(this.__approving, item.id), item).then(() => {
        this.buttonClicked = "";
        this.idItemClicked = null;
        this.modalTitle = "";
        this.modalCaption = "";
      });
    },
    submitDelete(id) {
      // this.$inertia.delete(route(this.__destroy, id));
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
    reset() {
      this.form = mapValues(this.form, () => null);
    },
    setLsTabMemo() {
      this.isLoadMemo = true;
      // this.memo = { data: [], link: [] };
      if (this.$ls.get("tabIndexApprovalPO")) {
        this.tabIndex = this.$ls.get("tabIndexApprovalPO") - 1;
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
      this.$ls.set("tabIndexApprovalPO", this.tabIndex + 1, 60 * 60 * 1000);

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
