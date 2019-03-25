<script>
import RepliesComponentVue from "../components/RepliesComponent.vue";
import SubscribeButtonComponentVue from "../components/SubscribeButtonComponent.vue";

export default {
  props: ["initialRepliesCount"],

  components: {
    "replies-component": RepliesComponentVue,
    "subscribe-button": SubscribeButtonComponentVue
  },

  data() {
    return {
      repliesCount: this.initialRepliesCount
    };
  }
};
</script>
