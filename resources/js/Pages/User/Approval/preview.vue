<template>
  <layout :userinfo="userinfo">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Memo {{ dataMemo.doc_no }}</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <b-card no-body>
          <b-card-body>
            <b-row class="mb-2">
              <b-col col lg="12" md="12" class="mb-4">
                <b-button-group class="float-right">
                  <b-button
                    @click="actionApprove(dataMemo.id_approver)"
                    variant="info"
                    >Approve</b-button
                  >
                  <b-button
                    @click="actionRevisi(dataMemo.id_approver)"
                    variant="secondary"
                    >Revisi</b-button
                  >
                  <b-button
                    @click="actionReject(dataMemo.id_approver)"
                    variant="warning"
                    >Reject</b-button
                  >
                </b-button-group>
              </b-col>
              <b-col col lg="6" md="auto">
                <h5>Memo Information</h5>
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Proposed By</td>
                      <td>
                        {{
                          proposeEmployee.firstname +
                          " " +
                          proposeEmployee.lastname
                        }}
                      </td>
                    </tr>
                    <tr>
                      <td>Status</td>
                      <td>
                        <b-badge
                          v-if="dataMemo.status == 'submit'"
                          variant="info"
                          >On process approving</b-badge
                        >
                        <b-badge
                          v-if="dataMemo.status == 'approve'"
                          variant="success"
                          >Memo Approved</b-badge
                        >
                        <b-badge
                          v-if="dataMemo.status == 'reject'"
                          variant="danger"
                          >Memo Rejected</b-badge
                        >
                        <b-badge
                          v-if="dataMemo.status == 'revisi'"
                          variant="secondary"
                          >Memo Revisi</b-badge
                        >
                      </td>
                    </tr>
                    <tr>
                      <td>Department</td>
                      <td>
                        {{
                          proposeEmployee.emp_history.position.department
                            .department_name
                        }}
                      </td>
                    </tr>
                    <tr>
                      <td>Title</td>
                      <td>{{ dataMemo.title }}</td>
                    </tr>
                    <tr>
                      <td>Doc. No</td>
                      <td>{{ dataMemo.doc_no }}</td>
                    </tr>
                    <tr>
                      <td>Type</td>
                      <td>Approval</td>
                    </tr>
                    <tr v-if="dataMemo.acknowledges.length > 0">
                      <td>Acknowledge</td>
                      <td>
                        <span
                          v-for="(acknowledge, index) in dataMemo.acknowledges"
                          :key="index"
                        >
                          {{
                            acknowledge.employee.firstname +
                            " " +
                            acknowledge.employee.lastname
                          }}
                          <span v-if="index != dataMemo.acknowledges.length - 1"
                            >,{{ " " }}
                          </span>
                        </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </b-col>
              <b-col col lg="6" md="auto">
                <h5>Approver</h5>
                <table class="table table-bordered mb-2">
                  <thead class="thead-dark">
                    <tr>
                      <th>Level</th>
                      <th>Approver Name</th>
                      <th>Position</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(approver, index) in dataMemo.approvers"
                      :key="index"
                    >
                      <td>
                        {{ index + 1 }}
                      </td>
                      <td>
                        {{
                          approver.employee.firstname +
                          " " +
                          approver.employee.lastname
                        }}
                      </td>
                      <td>
                        {{
                          approver.employee.position_now.position.position_name
                        }}
                      </td>
                      <td>
                        <b-badge
                          v-if="approver.status == 'submit'"
                          variant="info"
                          >On Submit</b-badge
                        >
                        <b-badge
                          v-if="approver.status == 'approve'"
                          variant="success"
                          >Approved</b-badge
                        >
                        <b-badge
                          v-if="approver.status == 'reject'"
                          variant="danger"
                          >Rejected</b-badge
                        >
                        <b-badge
                          v-if="approver.status == 'revisi'"
                          variant="secondary"
                          >Revisi</b-badge
                        >
                      </td>
                    </tr>
                  </tbody>
                </table>
              </b-col>
            </b-row>
            <b-row
              v-if="dataMemo.background && dataMemo.background != '<p></p>'"
              class="mb-2"
            >
              <b-col>
                <h5>Background</h5>
                <div v-html="dataMemo.background"></div>
              </b-col>
            </b-row>
            <b-row
              v-if="dataMemo.information && dataMemo.information != '<p></p>'"
              class="mb-2"
            >
              <b-col>
                <h5>Information</h5>
                <div v-html="dataMemo.information"></div> </b-col
            ></b-row>
            <b-row
              v-if="dataMemo.conclusion && dataMemo.conclusion != '<p></p>'"
              class="mb-2"
            >
              <b-col>
                <h5>Conclusion</h5>
                <div v-html="dataMemo.conclusion"></div> </b-col
            ></b-row>
            <b-row v-if="memocost.length > 0" class="mb-2">
              <b-col>
                <h5>Cost/Expense</h5>
                <b-table bordered :items="memocost"></b-table> </b-col
            ></b-row>
            <b-row
              v-if="dataMemo.payment && dataMemo.payment != '<p></p>'"
              class="mb-2"
            >
              <b-col>
                <h5>Payment</h5>
                <div v-html="dataMemo.payment"></div>
              </b-col>
            </b-row>
            <b-row v-if="attachments.length > 0" class="mb-2">
              <b-col>
                <h5>Attachment</h5>
                <table class="table table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>file</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(attachment, index) in attachments" :key="index">
                      <td>{{ attachment.name }}</td>
                    </tr>
                  </tbody>
                </table>
              </b-col>
            </b-row>
          </b-card-body>
        </b-card>
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
  </layout>
</template>
<script>
import Layout from "@/Shared/UserLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import { Timeline, TimelineItem, TimelineTitle } from "vue-cute-timeline";
import ModalFormMemoApproval from "@/components/ModalFormMemoApproval";

export default {
  props: [
    "userinfo",
    "breadcrumbItems",
    "dataMemo",
    "proposeEmployee",
    "memocost",
    "attachments",
  ],
  metaInfo: { title: "Admin Reference Approve Page" },
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    Timeline,
    TimelineItem,
    TimelineTitle,
    ModalFormMemoApproval,
  },
  data() {
    return {
      timelinecolor: {
        success: "#1cc88a",
        info: "#36b9cc",
        danger: "#e74a3b",
        warning: "#f6c23e",
      },
      buttonClicked: "",
      idItemClicked: null,
      modalTitle: "",
      modalCaption: "",
    };
  },
  methods: {
    actionApprove(id) {
      this.buttonClicked = "approve";
      this.idItemClicked = id;
      this.modalTitle = "Modal Approve";
      this.modalCaption = "Are you sure to approve?";

      this.$root.$emit("bv::show::modal", "modal-prevent-closing", "#btnShow");
    },
    actionRevisi(id) {
      this.buttonClicked = "revisi";
      this.idItemClicked = id;
      this.modalTitle = "Modal Revisi";
      this.modalCaption = "Are you sure to revisi?";

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
