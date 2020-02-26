<template>
  <div class="container">
    <div class="card" style="margin-top:-30px;">
      <div class="loader" v-if="loading"></div>
      <create-estimate
        v-if="createForm"
        @loading="loadingStatus"
        @createFormStatus="createFormStatus"
        :data-edit="dataEdit"
      />
      <view-estimate
        v-else
        @loading="loadingStatus"
        @createFormStatus="createFormStatus"
        @dataEdit="searchDataEdit"
      />
    </div>
  </div>
</template>
<script>
import createEstimate from "./createEstimate";
import viewEstimate from "./viewEstimate";
export default {
  name: "estimate-card",
  components: { createEstimate, viewEstimate },
  data() {
    return {
      loading: false,
      createForm: false,
      dataEdit: null
    };
  },
  methods: {
    searchDataEdit(id) {
      this.loadingStatus(true);
      axios
        .get("/estimate/find", {
          params: {
            estimate_id: id
          }
        })
        .then(response => {
          this.dataEdit = response["data"];
          this.createForm = true;
        })
        .catch(error => {
          console.log(error);
        })
        .finally(() => {
          this.loadingStatus(false);
        });
    },
    loadingStatus(val) {
      this.loading = val;
    },
    createFormStatus(val) {
      this.createForm = val;
    },
    getUrlVars() {
      var vars = [],
        hash;
      var hashes = window.location.href
        .slice(window.location.href.indexOf("?") + 1)
        .split("&");
      for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split("=");
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
      }
      return vars;
    }
  },
  computed: {},
  created() {
    if (this.getUrlVars(window.location.href)["client"]) {
      this.createForm = true;
    }
  }
};
</script>
<style>
.createCustomer:hover {
  color: #0e3bbb !important;
}
input[type="number"] {
  text-align: right;
}

.loader {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url("../../../../../public/loading2.gif") 50% 50% no-repeat
    rgb(249, 249, 249);
  opacity: 0.8;
}
</style>