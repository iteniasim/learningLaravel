<template>
  <div>
    <div v-if="signedIn">
      <div class="form-group">
        Body:
        <textarea name="body" id="body" class="form-control" rows="5" v-model="body" required></textarea>
      </div>

      <div class="d-flex justify-content-end">
        <div class="form-group">
          <button type="Submit" class="btn btn-primary" @click="addReply">Publish</button>
        </div>
      </div>
    </div>
    <p class="text-center" v-else>
      Please
      <a href="/login">sign in</a> to participate in this discussion.
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      body: ""
    };
  },

  methods: {
    addReply() {
      axios
        .post(location.pathname + "/replies", { body: this.body })
        .then(({ data }) => {
          this.body = "";
          flash("Your Reply Has Been Posted.");
          this.$emit("created", data);
        });
    }
  },

  computed: {
    signedIn() {
      return window.App.signedIn;
    }
  }
};
</script>
