<template>
  <button type="Submit" :class="classes" @click="toggle">
    <span v-text="count"></span> favourites
  </button>
</template>


<script>
export default {
  props: ["reply"],

  data() {
    return {
      count: this.reply.favouritesCount,
      active: this.reply.isFavourited
    };
  },

  computed: {
    classes() {
      return ["btn", this.active ? "btn-success" : "btn-outline-success"];
    },
    endpoint() {
      return "/replies/" + this.reply.id + "/favourites";
    }
  },

  methods: {
    toggle() {
      this.active ? this.unfavourite() : this.favourite();
    },
    favourite() {
      axios.post(this.endpoint);
      this.active = true;
      this.count++;
    },
    unfavourite() {
      axios.delete(this.endpoint);
      this.active = false;
      this.count--;
    }
  }
};
</script>
