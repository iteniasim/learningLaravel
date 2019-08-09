<script>
import RepliesComponentVue from "../components/RepliesComponent.vue";
import SubscribeButtonComponentVue from "../components/SubscribeButtonComponent.vue";

export default {
  props: ["thread"],

  components: {
    "replies-component": RepliesComponentVue,
    "subscribe-button": SubscribeButtonComponentVue
  },

  data() {
    return {
      repliesCount: this.thread.replies_count,
      locked: this.thread.locked
    };
  },

  methods: {
    toggleLock() {
      axios.patch("/locked-threads/" + this.thread.id);
      this.locked = !this.locked;
    }
  }
};
</script>
