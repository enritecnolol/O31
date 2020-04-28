<template>
    <card-panel>
        <template slot="body">
            <div class="card-body">
                <div class="loader" v-if="loading"></div>
                <create-expenses
                        @loadingStatus="loadingStatus"
                        @createFormStatus="createFormStatus"
                        :editData="editData"
                        v-if="createForm"/>
                <view-expenses
                        @loadingStatus="loadingStatus"
                        @createFormStatus="createFormStatus"
                        @EditData="DataToEdit"
                        v-else/>
            </div>
        </template>
    </card-panel>
</template>

<script>
    import cardPanel from "../cardPanel";
    import createExpenses from "./createExpenses";
    import viewExpenses from "./viewExpenses";
    export default {
        components:{cardPanel, createExpenses, viewExpenses},
        data()
        {
            return {
                loading:false,
                createForm:false,
                editData:null
            }
        },
        methods:{
            DataToEdit(item)
            {
              this.editData = item;
              this.createFormStatus(true);
            },
            loadingStatus(val)
            {
                this.loading = val
            },
            createFormStatus(val)
            {
                this.createForm = val;
                if(!this.createForm)
                {
                    this.editData = null
                }
            }
        }
    }
</script>

<style scoped>
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("../../../../../public/loading2.gif") 50% 50% no-repeat rgb(249,249,249);
        opacity: .8;
    }
</style>
