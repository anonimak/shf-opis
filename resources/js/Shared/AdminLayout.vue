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
import Sidebar from "@/components/Sidebar";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";

export default {
  components: {
    Sidebar,
    Navbar,
    Footer,
  },
  props: ["userinfo"],
  methods: {
    handleLogout() {
      alert("Ini Sudah Logout");
    },
  },
};
</script>
