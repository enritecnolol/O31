`<template>
    <card-panel>
        <template slot="body">
            <div class="card-body">
                <create-inventory-adjustments v-if="createForm" @closeForm="formStatus"/>
                <InventoryAdjustmentsView v-else @openForm="formStatus"/>
            </div>
        </template>
    </card-panel>
</template>

<script>
    import cardPanel from "../cardPanel";
    import createInventoryAdjustments from "./createInventoryAdjustments";
    import InventoryAdjustmentsView from "./InventoryAdjustmentsView";
    export default {
        components:{
            cardPanel,
            createInventoryAdjustments,
            InventoryAdjustmentsView
        },
        data()
        {
            return{
                createForm:false
            }
        },
        methods:{
            formStatus(val)
            {
                this.createForm = val;
            }
        }
    }
</script>

<style scoped>

</style>`