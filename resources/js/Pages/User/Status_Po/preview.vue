<template>
  <layout :userinfo="userinfo" :notif="notif">
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
                          v-if="dataMemo.status_po == 'submit'"
                          variant="info"
                          >On process approving</b-badge
                        >
                        <b-badge
                          v-if="dataMemo.status_po == 'approve'"
                          variant="success"
                          >Memo Approved</b-badge
                        >
                        <b-badge
                          v-if="dataMemo.status_po == 'reject'"
                          variant="danger"
                          >Memo Rejected</b-badge
                        >
                        <b-badge
                          v-if="dataMemo.status_po == 'revisi'"
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
                    <!-- <tr v-if="dataMemo.acknowledges.length > 0">
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
                    </tr> -->
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
                      <th>Approver Type</th>
                      <th>Status</th>
                      <th>Message</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(approver, index) in dataMemo.approvers_po"
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
                          approver.employee.emp_history.position.position_name
                        }}
                      </td>
                      <td>
                        {{ approver.type_approver }}
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
                      <td>
                        <p v-if="approver.msg">{{ approver.msg }}</p>
                        <span v-else>-</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div
                  class="card mb-4"
                  v-if="dataMemo && dataMemo.histories.length > 0"
                >
                  <div
                    class="
                      card-header
                      py-3
                      d-flex
                      flex-row
                      align-items-center
                      justify-content-between
                    "
                  >
                    <h6 class="m-0 font-weight-bold text-primary">History</h6>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="overflow-auto" style="height: 218px">
                      <timeline>
                        <timeline-item
                          v-for="(itemHistory, index) in dataMemo.histories"
                          :key="index"
                          :bg-color="timelinecolor[itemHistory.type]"
                        >
                          <strong>
                            {{ itemHistory.title }}
                            <span class="float-right">
                              <small class="text-muted">
                                <em>
                                  {{
                                    itemHistory.created_at
                                      | moment("D/M/YY,h:mm a")
                                  }}
                                </em>
                              </small>
                            </span>
                          </strong>
                          <p>
                            <small class="text-muted">{{
                              itemHistory.content
                            }}</small>
                          </p>
                        </timeline-item>
                      </timeline>
                    </div>
                  </div>
                </div>
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
                      <a
                        :href="attachment.name"
                        target="_blank"
                        rel="noopener noreferrer"
                      >
                        {{ attachment.real_name }}
                      </a>
                    </tr>
                  </tbody>
                </table>
              </b-col>
            </b-row>
          </b-card-body>
        </b-card>
      </div>
    </div>
  </layout>
</template>
<script>
import Layout from "@/Shared/UserLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import { Timeline, TimelineItem, TimelineTitle } from "vue-cute-timeline";

export default {
  props: [
    "userinfo",
    "notif",
    "breadcrumbItems",
    "dataMemo",
    "proposeEmployee",
    "memocost",
    "attachments",
  ],
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    Timeline,
    TimelineItem,
    TimelineTitle,
  },
  data() {
    return {
      timelinecolor: {
        success: "#1cc88a",
        info: "#36b9cc",
        danger: "#e74a3b",
        warning: "#f6c23e",
      },
    };
  },
};
</script>
