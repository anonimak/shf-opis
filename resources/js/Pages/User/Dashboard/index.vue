<template>
  <Layout :userinfo="userinfo">
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
        <template #header>Hello, {{ userinfo.name }}</template>

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
                      <b-badge v-if="dataMemo.status == 'submit'" variant="info"
                        >On process approving</b-badge
                      >
                      <b-badge
                        v-if="dataMemo.status == 'approve'"
                        variant="success"
                        >Memo Approved</b-badge
                      >
                      <b-badge
                        v-if="dataMemo.status == 'reject'"
                        variant="warning"
                        >Memo Rejected</b-badge
                      >
                      <b-badge
                        v-if="dataMemo.status == 'revisi'"
                        variant="secondary"
                        >Memo Revisi</b-badge
                      >
                    </td>
                  </tr>
                </tbody>
              </table>

              <inertia-link class="btn btn-secondary" :href="route(__allmemo)"
                >all memo</inertia-link
              >
            </div>
          </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
          <div class="card shadow mb-4">
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
              <h6 class="m-0 font-weight-bold text-primary">History Memo</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-pie pt-4 pb-2">
                <canvas id="myPieChart"></canvas>
              </div>
              <div class="mt-4 text-center small">
                <span class="mr-2">
                  <i class="fas fa-circle text-primary"></i>
                  Direct
                </span>
                <span class="mr-2">
                  <i class="fas fa-circle text-success"></i>
                  Social
                </span>
                <span class="mr-2">
                  <i class="fas fa-circle text-info"></i>
                  Referral
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </Layout>
</template>

<script>
import Layout from "@/Shared/UserLayout"; //import layouts

export default {
  metaInfo: { title: "Beranda" },
  data() {
    return {};
  },
  components: {
    Layout,
  },
  props: ["meta", "dataMemo", "userinfo", "__create", "__allmemo"],
  methods: {
    test: function () {
      alert("oke");
    },
  },
};
</script>
