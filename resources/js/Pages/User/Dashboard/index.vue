<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <!-- <a
          href="#"
          class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
          ><i class="fas fa-download fa-sm text-white-50"></i> Generate
          Report</a
        > -->
      </div>
      <b-jumbotron bg-variant="primary" text-variant="white">
        <template #header
          >Hello {{ userinfo.name }}
          <b-img
            right
            src="../images/test(300x300).png"
            alt="Right image"
          ></b-img>
        </template>

        <template #lead>
          Welcome to Sinarmas Hana Finance Memo Apps. Click button below to
          create new memo.</template
        >

        <hr class="my-4" />

        <p>
          <inertia-link
            class="btn btn-lg btn-outline-light"
            :href="route(__create)"
            >Create Memo</inertia-link
          >
        </p>
      </b-jumbotron>

      <!-- Content Row -->
      <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
          <div class="card shadow mb-4" v-if="dataMemo">
            <!-- Card Header - Dropdown -->
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
              <h6 class="m-0 font-weight-bold text-primary">
                Last Memo Status
              </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Document No</th>
                      <th>Proposed At</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ dataMemo.title }}</td>
                      <td>{{ dataMemo.doc_no }}</td>
                      <td>
                        {{
                          dataMemo.propose_at
                            | moment("dddd, MMMM Do YYYY, h:mm:ss a")
                        }}
                      </td>
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
                          >Memo Revised</b-badge
                        >
                        <p v-if="dataMemo.latest_history" class="text-muted">
                          <small>
                            <em>
                              {{ dataMemo.latest_history.title }}
                            </em>
                          </small>
                        </p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <inertia-link class="btn btn-secondary" :href="route(__allmemo)"
                >All memo</inertia-link
              >
            </div>
          </div>
        </div>

        <div class="col-xl-4 col-lg-5">
          <div
            class="card shadow mb-4"
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
              <h6 class="m-0 font-weight-bold text-primary">
                History Last Memo
              </h6>
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
                              itemHistory.created_at | moment("D/M/YY,h:mm a")
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
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </layout>
</template>

<script>
import Layout from "@/Shared/UserLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import { Timeline, TimelineItem, TimelineTitle } from "vue-cute-timeline";

export default {
  metaInfo: { title: "Dashboard" },
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
  components: {
    Layout,
    Timeline,
    TimelineItem,
    TimelineTitle,
    FlashMsg,
  },
  props: ["meta", "dataMemo", "userinfo", "notif", "__create", "__allmemo"],
};
</script>
