<template>
  <div id="wrapper">
    <!-- Content Wrapper -->
    <Sidebar :notif="notif" />
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <Navbar :userdata="userinfo" />
        <main>
          <div class="container-fluid">
            <slot />
          </div>
        </main>
      </div>
      <Footer />
    </div>
  </div>
</template>
<script>
import Sidebar from "@/components/user/Sidebar";
import Navbar from "@/components/user/Navbar";
import Footer from "@/components/user/Footer";

export default {
  components: {
    Sidebar,
    Navbar,
    Footer,
  },
  props: ["userinfo", "notif"],
  methods: {
    handleLogout() {
      alert("Ini Sudah Logout");
    },
  },
};
</script>
<style>
body.modal-open {
  overflow: scroll !important;
}
</style>