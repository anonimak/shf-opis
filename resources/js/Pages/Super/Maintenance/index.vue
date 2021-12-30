<template>
  <layout :userinfo="userinfo" :notif="notif">
    <flash-msg />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Reference Position</h1>
    </div>
    <breadcrumb :items="breadcrumbItems" />
    <div class="row">
      <div class="col-12">
        <div>
          <b-card>
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
                  <!-- table news -->
                  <table class="table mt-4">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Message</th>
                        <th scope="col">Status</th>
                        <th scope="col">Type</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(item, index) in dataMaintenance.data"
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
                          {{ item.msg }}
                        </td>
                        <td>
                          {{ item.status }}
                        </td>
                        <td>
                          <b-badge
                            pill
                            :variant="item.type"
                            class="text-capitalize"
                            >{{ item.type }}</b-badge
                          >
                        </td>
                        <td>
                          <b-button-group size="sm">
                            <inertia-link
                              :href="route(__edit, item.id)"
                              class="btn btn-secondary"
                              ><i class="fa fa-edit" aria-hidden="true"></i
                            ></inertia-link>
                            <b-button
                              href="#"
                              variant="danger"
                              @click="showMsgBoxDelete(item.id)"
                              ><i class="fa fa-trash-alt" aria-hidden="true"></i
                            ></b-button>
                          </b-button-group>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <Pagination :links="dataMaintenance.links" />
                </div>
              </div>
            </keep-alive>
          </b-card>
        </div>
      </div>
    </div>
  </layout>
</template>
<script>
import Layout from "@/Shared/SuperLayout"; //import layouts
import FlashMsg from "@/components/Alert";
import Breadcrumb from "@/components/Breadcrumb";
import Pagination from "@/components/Pagination";

export default {
  props: [
    "meta",
    "flash",
    "filters",
    "breadcrumbItems",
    "dataMaintenance",
    "userinfo",
    "notif",
    "perPage",
    "__create",
    "__edit",
    "__show",
    "__destroy",
    "__index",
  ],
  metaInfo: { title: "Admin Maintenance" },
  data() {
    return {
      //   tabIndexCfgHome: 0,
      //   form: {
      //     search: this.filters.search,
      //   },
      //   isCheched: false,
    };
  },
  components: {
    Layout,
    FlashMsg,
    Breadcrumb,
    Pagination,
  },
  methods: {
    submitDelete(id) {
      this.$inertia.delete(route(this.__destroy, id));
    },
    showMsgBoxDelete: function (id) {
      this.$bvModal
        .msgBoxConfirm(
          "Please confirm that you want to delete this maintenance message.",
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
  },
};
</script>
