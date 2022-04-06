<template>
  <div id="wrapper">
    <!-- Content Wrapper -->
    <Sidebar v-if="!isMobile()" :notif="notif" />
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content" :style="isMobile() && { 'margin-bottom': '5rem' }">
        <Navbar :userdata="userinfo" :notif="notif" />
        <BottomNavbar v-if="isMobile()" :notif="notif" />
        <main>
          <div
            class="container-fluid"
            :style="isMobile() && { 'margin-top': '6rem' }"
          >
            <slot />
          </div>
        </main>
      </div>
      <Footer v-if="!isMobile()" />
    </div>
  </div>
</template>
<script>
import Sidebar from "@/components/user/Sidebar";
import Navbar from "@/components/user/Navbar";
import BottomNavbar from "@/components/user/BottomNavbar";
import Footer from "@/components/user/Footer";

export default {
  components: {
    Sidebar,
    Navbar,
    BottomNavbar,
    Footer,
  },
  props: ["userinfo", "notif"],
  data() {
    return {
      sound: new Audio("/sound/notification.mp3"),
    };
  },
  methods: {
    handleLogout() {
      alert("Ini Sudah Logout");
    },
  },
  created() {
    window.Echo.private(`App.User.${this.userinfo.id}`).notification(
      (notification) => {
        switch (notification.type) {
          case "App\\Notifications\\ApprovalNotification":
            this.notif.unreadNotification++;
            this.sound.play();
            let notif = {
              created_at: moment().format(),
              data: {
                content: notification.content,
                url: notification.url,
              },
              id: notification.id,
              notifiable_id: this.userinfo.id,
              notifiable_type: "AppUser",
              read_at: null,
              type: "AppNotificationsApprovalNotification",
              updated_at: moment().format(),
            };
            // this.notif.notification = [...this.notif.notification, notif];
            this.notif.notification.unshift(notif);
            break;
        }
      }
    );
  },
};
</script>
<style>
body.modal-open {
  overflow: scroll !important;
}
</style>
