<template>
  <Layout>
    <flash-msg />
    <div class="card o-hidden border-0 shadow-lg">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col">
            <div class="p-5">
              <div class="text-center">
                <div class="col" v-if="dataMemo">
                  <h3 class="text-primary mb-4">
                    <strong>Memo Verified </strong> <i class="fa fa-check"></i>
                  </h3>
                  <div class="col">Document No : {{ dataMemo.doc_no }}</div>
                  <div class="col">
                    Status :
                    <span
                      v-if="dataMemo.status == 'submit'"
                      class="badge badge-info"
                      >On process approving</span
                    >
                    <span
                      v-if="dataMemo.status == 'approve'"
                      class="badge badge-success"
                      >Memo Approved</span
                    >
                    <span
                      v-if="dataMemo.status == 'reject'"
                      class="badge badge-danger"
                      >Memo Rejected</span
                    >
                    <span
                      v-if="dataMemo.status == 'revisi'"
                      class="badge badge-secondary"
                      >Memo Revised</span
                    >
                  </div>
                </div>
                <div class="col" v-else>
                  <h2 class="text-gray">
                    <strong>Memo does not exist</strong>
                    <i class="fa fa-times"></i>
                  </h2>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script>
import Layout from "@/Shared/LoginLayout"; //import layouts
import FlashMsg from "@/components/Alert";

export default {
  components: {
    Layout,
    FlashMsg,
  },
  props: ["dataMemo"],
};
</script>
