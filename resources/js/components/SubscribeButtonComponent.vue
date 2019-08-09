<template>
  <button :class="classes" @click="subscribe" v-text="this.active?'Unsubscribe':'Subscribe'"></button>
</template>


<script>
export default {
  props: ["status"],

  data() {
    return {
      active: this.status
    };
  },

  computed: {
    classes() {
      return ["btn", this.active ? "btn-primary" : "btn-outline-primary"];
    }
  },

  methods: {
    subscribe() {
      axios[this.active ? "delete" : "post"](
        location.pathname + "/subscription"
      );
      this.active = !this.active;
    }
  }
};
</script>
