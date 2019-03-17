<script>
import RepliesComponentVue from "../components/RepliesComponent.vue";

export default {
  props: ["initialRepliesCount"],

  components: {
    "replies-component": RepliesComponentVue
  },

  data() {
    return {
      repliesCount: this.initialRepliesCount
    };
  }
};
</script>
