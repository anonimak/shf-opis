<template>
  <!-- Topbar -->
  <nav
    class="
      navbar navbar-expand navbar-light
      bg-white
      topbar
      mb-4
      static-top
      shadow
    "
    :class="isMobile() ? 'fixed-top' : 'static-top'"
  >
    <!-- Sidebar Toggle (Topbar) -->
    <button
      v-if="!isMobile()"
      id="sidebarToggleTop"
      class="btn btn-link d-md-none rounded-circle mr-3"
    >
      <i class="fa fa-bars"></i>
    </button>

    <inertia-link v-if="isMobile()" :href="'#'">
      <img src="/images/brand.png" alt="" height="24px" />
    </inertia-link>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
      <!-- Nav Item - Search Dropdown (Visible Only XS) -->
      <!-- <li class="nav-item dropdown no-arrow d-sm-none">
        <a
          class="nav-link dropdown-toggle"
          href="#"
          id="searchDropdown"
          role="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <i class="fas fa-search fa-fw"></i>
        </a>
        <div
          class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
          aria-labelledby="searchDropdown"
        >
          <form class="form-inline mr-auto w-100 navbar-search">
            <div class="input-group">
              <input
                type="text"
                class="form-control bg-light border-0 small"
                placeholder="Search for..."
                aria-label="Search"
                aria-describedby="basic-addon2"
              />
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> -->
      <li class="nav-item dropdown no-arrow">
        <a
          class="nav-link dropdown-toggle"
          href="#"
          id="notifDropdown"
          role="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="true"
        >
          <i class="fas fa-bell fa-fw"></i>
          <!-- Counter - Alerts -->
          <span
            v-if="notif.unreadNotification > 0"
            class="badge badge-danger badge-counter"
            >{{
              notif.unreadNotification > 10 ? "10+" : notif.unreadNotification
            }}</span
          >
        </a>
        <!-- Dropdown - User Information -->
        <div
          class="
            dropdown-list dropdown-menu dropdown-menu-right
            shadow
            animated--grow-in
          "
          aria-labelledby="notifDropdown"
        >
          <h6 class="dropdown-header">Notifications</h6>
          <div v-if="notif.notification.length > 0">
            <a
              class="dropdown-item d-flex"
              v-for="notification in notif.notification"
              :key="notification.id"
              href="#"
              @click="onClickNotification(notification)"
            >
              <div class="col px-0">
                <div class="row">
                  <div class="col">
                    <div
                      class="small"
                      :class="
                        !notification.read_at
                          ? [
                              `text-${notification.data.content.type}`,
                              ' font-weight-bold',
                            ]
                          : ['text-gray-500']
                      "
                    >
                      {{ notification.data.content.doc_no }}
                    </div>
                  </div>
                  <div class="col">
                    <div
                      class="small float-right"
                      :class="
                        !notification.read_at
                          ? 'text-gray-700'
                          : 'text-gray-400'
                      "
                    >
                      {{ notification.created_at | moment("D/M/YY,h:mm a") }}
                    </div>
                  </div>
                </div>
                <div class="row mb-1">
                  <div
                    class="col-12 font-weight-bold text-truncate"
                    :class="!notification.read_at ? '' : 'text-gray-500'"
                  >
                    {{ notification.data.content.caption }}
                  </div>
                </div>
                <span
                  :class="
                    !notification.read_at ? 'font-italic' : 'text-gray-500'
                  "
                  >{{ notification.data.content.subject }}</span
                >
              </div>
            </a>
            <!-- <inertia-link
              class="dropdown-item text-center small text-gray-500"
              href="#"
              >Show All Notifications</inertia-link
            > -->
          </div>
          <div v-else>
            <span class="dropdown-item text-gray-500 font-italic"
              >No notification found.</span
            >
            <!-- <inertia-link
              class="dropdown-item text-center small text-gray-500"
              href="#"
              >Show All Notifications</inertia-link
            > -->
          </div>
        </div>
      </li>

      <div class="topbar-divider d-none d-sm-block"></div>

      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a
          class="nav-link dropdown-toggle"
          href="#"
          id="userDropdown"
          role="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{
            userdata.name
          }}</span>
          <b-avatar
            variant="primary"
            icon="person-badge"
            size="2rem"
          ></b-avatar>
        </a>
        <!-- Dropdown - User Information -->
        <div
          class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
          aria-labelledby="userDropdown"
        >
          <inertia-link
            class="dropdown-item"
            :href="route('user.setting.changepassword.index')"
          >
            <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
            Change Password
          </inertia-link>
          <div class="dropdown-divider"></div>
          <button class="dropdown-item" @click="show = true">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </button>
        </div>
      </li>
    </ul>

    <b-modal
      v-model="show"
      title="Logout"
      centered
      header-bg-variant="primary"
      header-text-variant="light"
    >
      You will be log out
      <template v-slot:modal-footer>
        <b-button variant="secondary" @click="show = false"> Cancel </b-button>
        <b-link class="btn btn-primary" size="sm" :href="route('logout')">
          Log out
        </b-link>
      </template>
    </b-modal>
  </nav>
  <!-- End of Topbar -->
</template>
<script>
export default {
  props: ["userdata", "notif"],
  data() {
    return {
      show: false,
      alertstatus: null,
      messagestatus: null,
      // notifications: [],
      url_mark_read_notif: "user.api.notification.read",
    };
  },
  mounted() {
    // this.notifications = [...this.notif.notification];
  },
  methods: {
    onClickNotification(notification) {
      this.getMarkReadNotif(notification.id).then((result) => {
        if (!result.data.is_read) {
          this.notif.unreadNotification--;
          this.notif.notification = this.notif.notification.map((notif) => {
            if (notif.id === notification.id) {
              notif.read_at = moment().format();
            }
            return notif;
          });
        }
      });
      this.$inertia.replace(notification.data.url);
    },

    getMarkReadNotif: async function (id) {
      return axios.get(route(this.url_mark_read_notif, id)); //TODO: mark read notification
    },
  },
};
</script>
