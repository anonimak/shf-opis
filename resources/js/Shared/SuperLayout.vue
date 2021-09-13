<template>
  <div id="wrapper">
    <!-- Content Wrapper -->
    <Sidebar />
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
import Sidebar from "@/components/super/Sidebar";
import Navbar from "@/components/super/Navbar";
import Footer from "@/components/super/Footer";

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
