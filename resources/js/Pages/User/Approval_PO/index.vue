<template>
  <Layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Approval PO</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <b-card v-if="dataMemo.length > 0">
          <keep-alive>
            <div class="row">
              <div class="col-12">
                <div class="row">
                  <!-- <div class="col-12">
                      <inertia-link
                        :href="route(__create)"
                        class="btn btn-primary my-2 float-right"
                      >
                        <i class="fas fa-plus"></i>
                        Add</inertia-link
                      >
                    </div> -->
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
        </div>
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
import mapValues from "lodash/mapValues";
import ModalFormMemoApproval from "@/components/ModalFormMemoApproval";
import UndrawNoData from "vue-undraw/UndrawNoData";

export default {
  props: [
    "meta",
    "flash",
    "breadcrumbItems",
    "dataMemo",
    "userinfo",
    "notif",
    "__approving",
    "__previewpdf",
    "__detail",
    "__index",
  ],
  metaInfo: { title: "Admin Reference Approve Page" },
  data() {
    return {
      isCheched: false,
      buttonClicked: "",
      idItemClicked: null,
      modalTitle: "",
      modalCaption: "",
    };
  },
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    ModalFormMemoApproval,
    UndrawNoData,
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
  },
};
</script>
