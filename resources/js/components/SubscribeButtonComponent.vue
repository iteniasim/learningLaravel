<template>
  <div>
    <button :class="classes" @click="subscribe">Subscribe</button>
  </div>
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
      axios[this.active ? "delete" : "post"](location.pathname + "/subscribe");
      this.active = !this.active;
    }
  }
};
</script>
