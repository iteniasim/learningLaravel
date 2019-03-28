<template>
  <li class="nav-item dropdown" v-if="notifications.length">
    <a class="nav-link" href="#" data-toggle="dropdown">
      <i class="material-icons">notification_important</i>
      <!-- notification -->
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
      <div v-for="notification in notifications" :key="notification.id">
        <a
          class="dropdown-item"
          :href="notification.data.link"
          v-text="notification.data.message"
          @click="markAsRead(notification)"
        ></a>
      </div>
    </div>
  </li>
</template>

<script>
export default {
  data() {
    return {
      notifications: false
    };
  },

  created() {
    axios
      .get("/profiles/" + window.App.user.name + "/notifications")
      .then(response => (this.notifications = response.data));
  },

  methods: {
    markAsRead(notification) {
      axios.delete(
        "/profiles/" +
          window.App.user.name +
          "/notifications/" +
          notification.id
      );
    }
  }
};
</script>
