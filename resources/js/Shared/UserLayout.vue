<template>
  <div id="wrapper">
    <!-- Content Wrapper -->
    <Sidebar v-if="!isMobile()" :notif="notif" />
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content" :style="isMobile() && { 'margin-bottom': '5rem' }">
        <Navbar :userdata="userinfo" />
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
    return {};
  },
  methods: {
    handleLogout() {
      alert("Ini Sudah Logout");
    },
  },
};
</script>
<<<<<<< HEAD
<style scoped>
</style>
=======
<style>
body.modal-open {
  overflow: scroll !important;
}
</style>
>>>>>>> c94259ecd89549f826a0420c30be3e0fa688e206
